<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>404 - Page non trouvée</title>
    <link rel="icon" type="image/png" href="/assets/icon.png">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <div class="background-overlay"></div>
    <div class="error-container">
        <span class="go-back-arrow" onclick="history.back()">←</span>
        <h1 class="error-title">404</h1>
        <p class="error-message">La page que vous recherchez est introuvable.</p>
        <p><a href="/home.php" class="go-home">Retour à la page d'accueil</a></p>
    </div>
</body>

</html>
