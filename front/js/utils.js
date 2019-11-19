const API_URL = "http://localhost:8000";

function checkIsLoggedIn() {
    if(localStorage.getItem("user_token") !== null && localStorage.getItem("user_token") !== "" &&
        localStorage.getItem("user_all_projects") !== null && localStorage.getItem("user_all_projects") !== "") {
        sendAjax('/api/auth').then(res => {
            console.log(res);
        }).catch(err => {
            document.location = "login.php";
        })
    } else {
        document.location = "login.php";
    }
}

function displaySidebarProjects() {
    const projectSelected = JSON.parse(localStorage.getItem("user_current_project"));
    const all_projects = JSON.parse(localStorage.getItem("user_all_projects"));
    let sidebar = '';
    all_projects.forEach(project => {
        const classLink = project.id === projectSelected.id ? "nav-link active" : "nav-link";
        sidebar += '<li class="nav-item"><a href="#" onclick="switchCurrentProject(\''+ project.id + '\')" class="'+ classLink +'"><i class="far fa-circle nav-icon"></i><p>' + project.name + '</p></a></li>';
    });
    sidebar += '<li class="nav-item"><a href="app.php?page=projects" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Voir tous les projets</p></a></li>';

    $("#header-selected-project").empty().append(projectSelected.name.toUpperCase());
    $("#project-list-sidebar").empty().append(sidebar);
}

function switchCurrentProject(id) {
    const projectSelected = JSON.parse(localStorage.getItem("user_current_project"));
    const all_projects = JSON.parse(localStorage.getItem("user_all_projects"));
    if(id !== projectSelected.id) {
        const index = all_projects.findIndex(p => parseInt(p.id) === parseInt(id));
        if (index !== -1) {
            localStorage.setItem('user_current_project', JSON.stringify(all_projects[index]));
            location.reload();
        }
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
            }
        }
    });
}
