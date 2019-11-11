<div class="container">
    <div class="col-sm-offset-4 col-sm-4 sign-up">
        <h2>Se connecter</h2>
        <form onsubmit="auth(); return false;">
            <div class="form-group">
                <label for="surname">Login</label>
                <input type="text" class="form-control" id="login" placeholder="Identifiant" name="login">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password">
            </div>
            <button type="submit" class="btn btn-default">Connexion</button>
        </form>
        <br />
        <a href="./index.php?page=signup">Pas encore de compte ? S'inscrire</a>
    </div>
</div>
<script>
    function auth() {
        $.ajax ( {
            url : "http://localhost:8000/login_check",
            method: "POST",
            data: {
                "login": "",
                "password": "",
            },
            crossDomain: true,
            success: function(data){
                alert("AJAX SUCCESS")
            },
            error: function(error){
                console.error(error);
            }
        });
        return false;
    }
</script>
