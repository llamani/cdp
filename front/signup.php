<script defer src="js/usersScript.js"></script>
<div class="container">
    <div class="col-sm-offset-4 col-sm-4 sign-up">
        <h2>S'inscrire</h2>
        <form action="/" method="POST">
            <div class="form-group">
                <label for="surname">Nom:</label>
                <input type="text" class="form-control" id="name" placeholder="Nom" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Mot de passe" name="password">
            </div>
            <button type="button" class="btn btn-default" id="signup">Envoyer</button>
        </form>
        <br />
        <a href="./index.php?page=login">Déjà inscrit ? Se connecter</a>
    </div>
</div>
