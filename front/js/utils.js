const API_URL = "http://localhost:8000";

function redirecttToLogin() {
    document.location = "index.php?page=login";
}

function logout() {
    localStorage.removeItem('user_token');
    redirecttToLogin();
}

function sendAjax(url, method = 'GET', data = null) {
    const token = localStorage.getItem('user_token');
    return $.ajax({
        url: API_URL + url,
        headers: {
            'Authorization': `Bearer ${token}`,
        },
        contentType: 'application/json',
        method: method,
        data: data,
        error: function (err) {
            console.error(err.statusText);
            if(err.status === 401) {
                console.error(err.responseJSON.message);
                redirecttToLogin();
            }
        }
    });
}