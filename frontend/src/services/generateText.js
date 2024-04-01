import axios_request from "../lib/axios";

export const generateSkills = (jobTitle) => {
  return axios_request.post("generate/skills", jobTitle);
}

export const getCompanyWebsite = (companyName) => {
  return axios_request.post("get/company/website", companyName);
}

export const generateJobDescription = (payload) => {
  return axios_request.post("generate/job-description", { ...payload });
}

export const generateJobDescriptionForUser = (payload) => {
  return axios_request.post("user/generate/job-description", { ...payload });
}