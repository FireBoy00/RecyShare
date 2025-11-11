/**
 * Bootstrap Configuration
 * Sets up Axios HTTP client for making API requests to the backend.
 * Configures default headers for AJAX requests.
 * @author RecyShare Team
 */
import axios from 'axios';
window.axios = axios;

// Add CSRF token and identify requests as AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
