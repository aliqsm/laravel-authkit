import axios from 'axios';

// ------------------------------------------
// Axios Instance
// ------------------------------------------
const client = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});


// ------------------------------------------
// API Request
// ------------------------------------------
export default async function api({ endpoint, method = 'POST', data = null, callback = null, onError = null }) {
    try {
        const response = await client({
            url: endpoint,
            method,
            [method.toUpperCase() === 'GET' ? 'params' : 'data']: data,
        });

        callback?.(response.data, response);

    } catch (error) {
        onError?.(error.response?.data, error.response);
    }
}