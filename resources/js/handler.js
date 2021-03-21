var networkErr = () => {
    clog("is a network");
};

var handle = error => {
    if (!error.response) {
        notyf.error({
            message:
                "Unable to fetch messages, please check your internet connection and retry",
            duration: 5000
        });
    } else {
        switch (error.response.status) {
            case 401:
                handleAuth();
                break;
            case 403:
                handleForbidden();
                break;
            case 404:
                handleNotFound();
                break;

            default:
                break;
        }
        handleServerError();
    }
};

const handleAuth = () => {
    doLogin();
    notyf.error({
        message: "Authentication failed. Please login and try again",
        duration: 5000
    });
};

const handleForbidden = () => {
    // doLogin();
    notyf.error({
        message: "Forbidden. Please login and try again",
        duration: 5000
    });
};

const handleNotFound = () => {
    // doLogin();
    notyf.error({
        message: "Not found. Please login and try again",
        duration: 5000
    });
};

export default {
    handle,
    networkErr
};
