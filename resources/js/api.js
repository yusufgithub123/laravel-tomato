// resources/js/api.js
import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  timeout: 10000,
});

// Request interceptor
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Response interceptor
api.interceptors.response.use(response => response, error => {
  if (error.response.status === 401) {
    // Handle unauthorized
    window.location.href = '/login';
  }
  return Promise.reject(error);
});

export default api;