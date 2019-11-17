<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ScrumUp | Inscription</title>
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
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Scrum</b>Up</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Inscription d'un nouvel utilisateur</p>

            <form>
                <div class="input-group mb-3">
                    <input id="full_name" type="text" class="form-control" placeholder="Full name" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control" placeholder="Email" required>
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
                <div class="input-group mb-3">
                    <input id="confirmPassword" type="password" class="form-control" placeholder="Confirmation password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-8">
                        <button type="submit" class="btn btn-primary btn-block">Confirmer</button>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-center">
                <div class="loader spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="err-msg alert alert-danger"></div>
            <a href="login.php" class="text-center">Déjà membre ? Connectez-vous !</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<script defer src="js/utils.js"></script>
<!--<script defer src="js/usersScript.js"></script>-->
<script>
    $(document).ready(function () {
        $("form").submit(function(e){
            e.preventDefault(e);
            createUser();
        });
    });

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
                    $(".err-msg").empty().append("Erreur de création de compte").fadeIn();
                    $(".spinner-border").fadeOut();
                })
        } else {
            $(".err-msg").empty().append("Le mot de passe n'est pas identique à la confirmation").fadeIn();
            $(".spinner-border").fadeOut();
        }
    }
</script>
</body>
</html>
