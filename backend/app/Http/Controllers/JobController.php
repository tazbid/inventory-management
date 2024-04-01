<?php

namespace App\Http\Controllers;

use App\Http\Services\GenerateTextService;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobDescription;
use DOMDocument;
use Illuminate\Support\Facades\Storage;


class JobController extends Controller
{
    protected $generateTextService;
    //constructor
    public function __construct(GenerateTextService $generateTextService) {
        $this->generateTextService = $generateTextService;
    }

    public function getJobsByAuthUser() {
        $jobDescriptions = JobDescription::where('user_id', auth()->user()->id)->get(['id', 'job_title']);
        return response()->json($jobDescriptions);
    }

    public function getJobById($id) {
        $jobDescription = JobDescription::find($id);
        $showApplyButton = $jobDescription->user_id === auth()->id() ? false : true;
        $showViewApplicationsButton = $jobDescription->user_id === auth()->id() ? true : false;
        return response()->json([
            'jobDescription' => $jobDescription,
            'show_apply_button' => $showApplyButton,
            'show_view_applications_button' => $showViewApplicationsButton
        ]);
    }

    public function getJobs() {
        $jobDescriptions = JobDescription::all(['id', 'job_title']);
        return response()->json($jobDescriptions);
    }

    public function applyForJob($id, Request $request) {
        //store resume in storage
        $resume = $request->file('resume');
        $filename = time() . '_' . $resume->getClientOriginalName();
        Storage::disk('local')->put('resumes/' . $filename, file_get_contents($resume));

        $jobDescription = JobDescription::find($id);
        $jobDescription->applicants()->attach(auth()->user()->id, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'resume' => $filename
        ]);

        return response()->json([
            'message' => 'Applied for job successfully'
        ]);

    }

    public function getJobApplicants($id) {
        $jobDescription = JobDescription::find($id);
        if($jobDescription->user_id !== auth()->id()){
            return response()->json([
                'message' => 'You are not authorized to view applicants for this job'
            ], 403);
        }
        $applicants = JobApplication::where('job_id', $id)->get();
        return response()->json($applicants);
    }

    public function getApplicationDetails($id) {
        $applicant = JobApplication::find($id);
        if($applicant->job->user_id !== auth()->id()){
            return response()->json([
                'message' => 'You are not authorized to view this application'
            ], 403);
        }
        return response()->json($applicant);
    }

    public function downloadResume($id) {
        $applicant = JobApplication::find($id);
        if($applicant->job->user_id !== auth()->id()){
            return response()->json([
                'message' => 'You are not authorized to download this resume'
            ], 403);
        }
        $fileUrl = Storage::disk('local')->url('resumes/' . $applicant->resume);

        return response()->json(['file_url' => $fileUrl]);
    }

    public function generateComparison($jobId){
        $job = JobDescription::find($jobId);
        $ch = curl_init();

        $jobTitleString = str_replace(' ', '%20', $job->job_title);

        curl_setopt($ch, CURLOPT_URL, 'https://app.scrapingbee.com/api/v1/?api_key=J4JZREY6NTTE62MZ24WYV3MSEH7W8YUMHEWMKPCBCCG6MH8N20LL7ZD9G8M9140DLGCJU3EK0HHSL1EX&url=https%3A%2F%2Fwww.indeed.com%2Fjobs%3Fq%3D'. $jobTitleString .'%26l%3DRemote%26from%3DsearchOnHP&extract_rules=%7B%20%20%22benefits%22%20%3A%20%7B%20%20%20%20%20%20%20%20%22selector%22%3A%20%22.css-1oelwk6%22%2C%20%20%20%20%20%20%20%20%22type%22%3A%20%22list%22%2C%20%20%20%20%7D%2C%22salaries%22%20%3A%20%7B%20%20%20%20%20%20%20%20%22selector%22%3A%20%22.salary-snippet-container%22%2C%20%20%20%20%20%20%20%20%22type%22%3A%20%22list%22%2C%20%20%20%20%7D%7D');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if (!$response) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

        curl_close($ch);
        $response = json_decode($response);

        $extractedSalaries = $response->salaries;
        $extractedBenefits = $response->benefits;
        $promt = "Compare the salary range of a job with the following salary range: " . $job->salary_range . " to the salary range of a job with all the extracted salaries from indeed.com " . json_encode($extractedSalaries) . " and the benefits of the job with all the extracted benefits from indeed.com " . json_encode($extractedBenefits) . " with the following job description: " . $job->job_description_html . ". Give me an overall rating in a scale from 1 to 100 and a overall_comparison_text based on salary, advantages, skills, experience, responsibilities, company culture and work-life balance (minimum 7 lines). Give me also a salary_comparison_text (minimum 7 lines) and a benefits_comparison_text (minimum 7 lines). Also rate the salary and benefits of the job with the extracted salaries and benefits from indeed.com in a scale from 1 to 100. Give it to me in json object format. The only keys are salary_comparison_text, benefits_comparison_text, overall_comparison_text, salary_rating, benefits_rating and overall_rating.";
        $maxTokens = 3000;

        $comparison = $this->generateTextService->generateTextFromOpenAI($promt, $maxTokens);
        return response()->json(json_decode($comparison));
    }

    public function checkTimer() {
        $lastJob = JobDescription::where('user_id', auth()->id())->latest()->firstOrFail();
        if (!$lastJob) {
            return response()->json([
                'message' => 'You can generate a comparison',
                'time_difference' => 1450
            ]);
        }
        $lastJobCreatedAt = $lastJob->created_at;
        $currentTime = now();
        $timeDifference = $currentTime->diffInMinutes($lastJobCreatedAt);
        if($timeDifference <= 1440){
            return response()->json([
                'message' => 'You can only generate a comparison once every 24 hours',
                'time_difference' => $timeDifference
            ]);
        } else {
            return response()->json([
                'message' => 'You can generate a comparison',
                'time_difference' => $timeDifference
            ]);
        }
    }
}
