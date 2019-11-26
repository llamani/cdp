<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Scrumup | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/logo_only.png" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Scrum</b>Up</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Connectez-vous !</p>

            <form id="login-form">
                <div class="input-group mb-3">
                    <input id="username" type="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-8">
                        <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="d-flex justify-content-center">
                <div id="login-loader" class="loader spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div id="login-err-msg" class="err-msg alert alert-danger">
                Erreur de connexion
            </div>
            <p class="mb-0">
                <a href="register.php" class="text-center">Pas encore de compte ? Inscrivez-vous !</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- Modal -->
<div class="modal fade" id="modal-first-project" tabindex="-1" role="dialog" aria-labelledby="add-project-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créez votre premier projet !</h5>
            </div>
            <div class="modal-body">
                <form id="modal-form" class="form-signin">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name-project" placeholder="Nom" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" cols="60" id="desc-project" placeholder="Description" required></textarea><br>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-center">
                <div id="modal-loader" class="loader spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div id="modal-err-msg" class="err-msg alert alert-danger">
                Erreur de création
            </div>
            <div class="modal-footer">
                <button type="button" form="add-project" id="modal-submit" class="btn btn-primary" value="create">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<script defer src="js/utils.js"></script>

<script>
    $(document).ready(function () {
        $("#login-form").submit(function(e){
            e.preventDefault(e);
            auth();
        });
        $("#modal-submit").click(function(e){
            $("#modal-form").submit();
        });
        $("#modal-form").submit(function(e){
            e.preventDefault(e);
            addFirstProject();
        });
    });

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
                        if(response.length > 0) { //projets existants
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
                $("#modal-err-msg").fadeIn();
                $("#modal-loader").fadeOut();
            })
    }
</script>
</body>
</html>
