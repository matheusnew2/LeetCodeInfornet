import axios from 'axios';

let protocol = window.location.protocol;
let host = window.location.host;
const http = axios.create({
  baseURL: window.location.origin+'/api',
  withCredentials:true,
  headers: {    
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

export default http;