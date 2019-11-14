<div class="container">
    <div class="col-sm-offset-4 col-sm-4 sign-up">
        <h2>Se connecter</h2>
        <form action="index.php" method="GET">
            <div class="form-group">
                <label for="surname">Login</label>
                <input type="text" class="form-control" id="login" placeholder="Identifiant" name="login">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password">
            </div>
            <button type="submit" class="btn btn-default">Connexion</button>
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </form>
        <div class="err-msg alert alert-danger" role="alert">Erreur durant la connexion. Réesayez.</div>
        <br />
        <a href="./index.php?page=signup">Pas encore de compte ? S'inscrire</a>
    </div>
</div>
<style>
    .err-msg {
        display: none;
        margin: 15px 0 15px 0;
    }
    .spinner-border {
        display: none;
    }
</style>
<script>
    $(document).ready(function () {
        $("form").submit(function(e){
            e.preventDefault(e);
            auth();
        });
    });

    function auth() {
        const username = $("#login").val();
        const password = $("#password").val();
        const data = JSON.stringify({
            username: username,
            password: password,
        });
        $(".err-msg").fadeOut();
        $(".spinner-border").fadeIn();

        sendAjax('/login_check', 'POST', data)
            .then(res => {
                localStorage.setItem("user_token", res.token);
                document.location.href="index.php?page=projects";
            })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
</script>
