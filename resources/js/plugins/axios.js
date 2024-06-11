import axios from 'axios'
import router from '@/router'

const axiosIns = axios.create({
  baseURL: 'https://wave-plus.xyz', // New base URL
  headers: {
    common: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
  },
  withCredentials: true, // New withCredentials setting
})

// Get CSRF cookie

async function fetchCsrfCookie() {
  await axios.get("/sanctum/csrf-cookie")

}

fetchCsrfCookie()

// Add request interceptor to send the authorization header on each subsequent request after login
axiosIns.interceptors.request.use(config => {
  // Retrieve token from localStorage
  const token = localStorage.getItem('accessToken')

  // If token is found
  if (token) {
    // Get request headers and if headers is undefined assign blank object
    config.headers = config.headers || {}

    // Set authorization header
    // JSON.parse will convert token to string
    config.headers.Authorization = token ? `Bearer ${JSON.parse(token)}` : ''
  }

  // Return modified config
  return config
})

// Add response interceptor to handle 401 response
axiosIns.interceptors.response.use(
  response => {
    return response
  },
  error => {
    // Handle error
    if (error.response.status === 401) {
      // Logout user and redirect to login page
      // Remove "userData" from localStorage
      localStorage.removeItem('userData')

      // Remove "accessToken" from localStorage
      localStorage.removeItem('accessToken')

      // Redirect to login page
      router.push('/login')
    } else {
      return Promise.reject(error)
    }
  },
)

export default axiosIns
