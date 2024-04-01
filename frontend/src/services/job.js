import axios_request from "../lib/axios";

export const getAllJobsForUser = () => {
    return axios_request.get("user/jobs");
}

export const getJobById = (jobId) => {
    return axios_request.get(`job/${jobId}`);
}

//get all jobs
export const getAllJobs = () => {
    return axios_request.get("jobs");
}

//apply for a job
export const applyForJob = (jobId, data) => {
    return axios_request.post(`job/apply/${jobId}`, data);
}

//get all applications for a job
export const getAllApplications = (jobId) => {
    return axios_request.get(`job/${jobId}/applications`);
}

//get application details
export const getApplicationDetails = (applicationId) => {
    return axios_request.get(`application/${applicationId}`);
}

//download resume
export const downloadResume = (url) => {
    return axios_request.get(url);
}

//get comparison
export const getComparison = (jobId) => {
    return axios_request.get(`generate/comparison/${jobId}`);
}

//check timer 
export const checkTimer = () => {
    return axios_request.get("job/check/timer");
}