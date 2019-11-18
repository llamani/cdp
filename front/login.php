<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Scrumup | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

            <form>
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
                <div class="loader spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="err-msg alert alert-danger">
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

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<script defer src="js/utils.js"></script>

<script>
    $(document).ready(function () {
        $("form").submit(function(e){
            e.preventDefault(e);
            auth();
        });
    });

    function auth() {
        const username = $("#username").val();
        const password = $("#password").val();
        const data = JSON.stringify({
            username: username,
            password: password,
        });
        $(".err-msg").fadeOut();
        $(".loader").fadeIn();
        sendAjax('/login_check', 'POST', data)
            .then(res => {
                localStorage.removeItem("user_token");
                localStorage.removeItem("user_projects");
                localStorage.setItem("user_token", res.token);
                document.location.href="app.php";
            })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
</script>
</body>
</html>
