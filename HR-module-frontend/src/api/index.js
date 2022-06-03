import axios from "axios";

const loginConfig = {
    baseURL : "localhost:84/api/v1",
    headers : {
        'Content-type': 'application/json'
    }
}

export const LoginAPIInstance = axios.create(loginConfig)

const apiConfig = {
    baseURL : "localhost:84/api/v1",
    headers : {
        'Content-type': 'application/json'
    }
}

export const ApiInstance = axios.create(apiConfig)  