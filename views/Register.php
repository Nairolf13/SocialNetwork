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
                    <a href="/login">S'identifier</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home_main">
        <div id="container-login">
            <div class="form-container">
                <div id="formulaire_inscription">
                    <h2>Inscription</h2>
                    <form action="/register" method="POST">
                        <input type="hidden" name="postUser" value="1">
                        <label for="username">Nom d'utilisateur (Doit contenir 3 caractères minimum)</label><br>
                        <input type="text" id="username" name="username" required><br>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" required><br>
                        <label for="password">Mot de passe (Doit contenir au moins 8 caractères, dont une majuscule, un chiffre et un caractère spécial.) </label><br>
                        <input type="password" id="password" name="password" required><br>
                        <label for="confirm_password">Confirmer le mot de passe:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required><br>
                        <button type="submit">S'inscrire</button>
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