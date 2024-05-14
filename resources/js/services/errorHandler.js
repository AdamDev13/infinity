import axios from 'axios'
import toast from './toast'
import router from "@/routes"

function errorResponseHandler(error) {
    // check for errorHandle config

    if (error.response.status === 401) {
        localStorage.removeItem('vuex');
        // router.next({ name: 'login' });
        window.location.href = "/login";
    }

    if (error.config.hasOwnProperty('errorHandle') && error.config.errorHandle === false) {
        return Promise.reject(error);
    }



    // if has response show the error
    if (error.response) {
        if (error.response && error.response.status === 422) {
            let validationErrors = error.response.data.errors;
            if (validationErrors instanceof  Array) {
                parseErrors(validationErrors);
            } else {
                for (var key of Object.keys(validationErrors)) {
                    parseErrors(validationErrors[key]);
                }
            }
        }
    }
}

function parseErrors(validationErrors){
    validationErrors.forEach((value, index) => {
        if (value instanceof Array) {
            value.forEach((error_message, index) => {
                toast.error(error_message.toString());
            });
        } else {
            toast.error(value.toString());

        }
    });
}


function successResponseHandler(response) {
    if (response.status === 200) {
        if (response.data.message) {
            toast.success(response.data.message.toString());
        }
    }
    return response;
}

// apply interceptor on response
axios.interceptors.response.use(
    successResponseHandler,
    errorResponseHandler
);

export default errorResponseHandler;
