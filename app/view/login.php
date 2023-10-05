<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php
 
    if (isset($_SESSION['message'])) {
        echo '<p>' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']); // Supprimez le message après l'avoir affiché
    }
    ?>
    <form action="index.php?page=login" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
    <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php?page=login">Connexion</a></li>
                <li><a href="index.php?page=register">Inscription</a></li>
            </ul>
</body>
</html>
