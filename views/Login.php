<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de donnée</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="asset/imgs/social.png" type="icon main">
</head>
<body>
    <header>
    <img id="logo" src="asset/imgs/social.png" alt="Logo">
        <h1>Social Network</h1>
        <nav>
            <ul>
                <li>
                    <button id="btn-connexion">S'identifier</button>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home_main">
        <div id="container-login">
            <div class="form-container">
                <div id="formulaire_connexion">
                    <h2>Connexion</h2>
                    <form action="/login" method="POST">
                        <input type="hidden" name="login" value="1">
                        <label for="username-co">Nom d'utilisateur:</label><br>
                        <input type="text" id="username-co" name="username" required><br>
                        <label for="password-co">Mot de passe:</label><br>
                        <input type="password" id="password-co" name="password" required><br>
                        <button type="submit" name="login" value="login">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="presentation">
            <h3></h3>
            <p></p>
        </div>
        <?php if (!empty($error)): ?>
            <div id="errorModal" class="modal-error">
                <div class="modal-content-error">
                    <span class="close">&times;</span>
                    <p id="errorMessage"><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <script src="../../js/script.js"></script>
</body>
</html>