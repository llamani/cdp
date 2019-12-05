function auth() {
    const username = $("#username").val();
    const password = $("#password").val();
    const data = JSON.stringify({
        username: username,
        password: password,
    });
    $("#login-err-msg").fadeOut();
    $("#login-loader").fadeIn();
    sendAjax('/login_check', 'POST', data)
        .then(res => {
            localStorage.removeItem("user_token");
            localStorage.removeItem("user_all_projects");
            localStorage.removeItem("user_current_project");
            localStorage.setItem("user_token", res.token);
            sendAjax('/api/projects')
                .then(response => {
                    console.log(response);
                    //projets existants
                    if(response.length > 0) {
                        localStorage.setItem('user_all_projects', JSON.stringify(response));
                        localStorage.setItem('user_current_project', JSON.stringify(response[0]))
                        document.location.href = "app.php";
                    } else {
                        $('#modal-first-project').modal({
                            show: true,
                            keyboard: false,
                            backdrop: false
                        });
                    }
                })
        })
        .catch(e => {
            console.error(e)
            $("#login-err-msg").fadeIn();
            $("#login-loader").fadeOut();
        })
}

function addFirstProject() {
    const nom = $("#name-project").val();
    const description = $("#desc-project").val();
    let jsonData = {
        "name": nom,
        "description": description,
        "users" : []
    };
    
    $("#modal-err-msg").fadeOut();
    $("#modal-loader").fadeIn();
    sendAjax("/api/project", 'POST', JSON.stringify(jsonData))
        .then(res => {
            console.log(res);
            const projects = [];
            projects.push(res);
            localStorage.setItem('user_all_projects', JSON.stringify(projects));
            localStorage.setItem('user_current_project', JSON.stringify(res));
            document.location.href = "app.php";
        })
        .catch(e => {
            console.error(e)
            $("#modal-err-msg").fadeIn();
            $("#modal-loader").fadeOut();
        })
}

function createUser(){
    const name= $("#full_name").val();
    const email= $("#email").val();
    const password= $("#password").val();
    const confirmPassword= $("#confirmPassword").val();
    
    $(".err-msg").fadeOut();
    $(".loader").fadeIn();
    if(password === confirmPassword) {
        let jsonData = {
            "name": name,
            "email": email,
            "password": password
        }
        sendAjax('/signup', 'POST', JSON.stringify(jsonData))
            .then(res => {
                console.log(res)
            })
            .catch(e => {
                console.error(e)
                $(".err-msg").empty().append("Erreur de création de compte").fadeIn();
                $(".spinner-border").fadeOut();
            })
    } else {
        $(".err-msg").empty().append("Le mot de passe n'est pas identique à la confirmation").fadeIn();
        $(".spinner-border").fadeOut();
    }
}
