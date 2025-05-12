<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Veuillez remplir tous les champs.";
        header("Location: auth.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect.";
        header("Location: auth.php");
        exit;
    }

    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];

    echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chargement...</title>
    <link rel="icon" type="image/png" href="assets/icon.png">
    <link rel="stylesheet" href="style.css">
    <script>
        setTimeout(function() {
            window.location.href = "user/dashboard.php";
        }, 2000);
    </script>
</head>
<body class="charge">
    <div class="background-overlay"></div>
    <div id="loader-container" class="fade-in">
        <div id="loader"></div>
        <p id="loading-text" style="font-size: 30px;">Chargement<span class="dots"></span></p>
    </div>
    <script>
        window.addEventListener("load", function () {
            const loaderContainer = document.querySelector("#loader-container");
            loaderContainer.classList.add("visible");
        });
    </script>
</body>
</html>';
    exit;
}
?>
