import axios_request from "../lib/axios";

export const login = (payload) => {
  return axios_request.post("login", payload);
}

export const logout = () => {
  return axios_request.post("logout", {});
}

export const register = (payload) => {
  return axios_request.post("register", payload);
}

//login with google
export const getGoogleUrl = () => {
  return axios_request.get("auth/google/url");
}

export const googleCallback = (code) => {
  return axios_request.get(`auth/google/callback?code=${code}`);
}