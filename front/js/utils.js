const API_URL = "http://localhost:8000";

function checkIsLoggedIn() {
    if(localStorage.getItem("user_token") !== null && localStorage.getItem("user_token") !== "") {
        sendAjax('/api/auth').then(res => {
            console.log(res);
        }).catch(err => {
            document.location = "login.php";
        })
    } else {
        document.location = "login.php";
    }
}

function redirecttToLogin() {
    if(document.location.pathname !== "/login.php" && document.location.pathname !== "/register.php") {
        document.location = "login.php";
    }
}

function logout() {
    localStorage.removeItem('user_token');
    localStorage.removeItem("user_projects");
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
                //redirecttToLogin();
            }
        }
    });
}
