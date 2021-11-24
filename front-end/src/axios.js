import axios from "axios";

axios.defaults.baseURL = 'http://localhost:3000/';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
// axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'X-Requested-With';
// axios.defaults.headers.common['Accept'] = 'application/json'
// axios.defaults.headers.common['Content-Type'] = 'application/json'
// axios.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET, POST, PUT, DELETE, OPTIONS'
axios.defaults.headers.common['Authorization']='Bearer'+' '+localStorage.getItem('token');

