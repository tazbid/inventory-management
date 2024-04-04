import axios_request from "../lib/axios";

export const getAllInventoryForUser = () => {
    return axios_request.get("inventory?page=1&limit=100");
}

export const createInventory = (data) => {
    return axios_request.post("inventory", data);
}

export const getInventoryById = (id) => {
    return axios_request.get(`inventory/${id}`);
}

//add item to inventory
export const addItemToInventory = (id, data) => {
    return axios_request.post(`inventory/${id}/details`, data);
}