<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Nous découvrir</title>
	<link rel="icon" type="image/png" href="assets/icon.png">
	<link rel="stylesheet" href="style.css">
</head>

<div class="background-overlay"></div>

<body class="page">
	<ul class="navbar">
        <a class="inactive" href="home.php">Acceuil</a>
        <a class="active" href="discover-us.php">Nous découvrir</a>
        <a class="inactive" href="faq.php">F.A.Q.</a>

        <?php if (isset($_SESSION['username'])): ?>
			<a class="dashboard inactive" href="user/dashboard.php">Dashboard</a>
            <a class="account inactive right" href="user/account.php"><img class="user-icon" src="assets/whiteUser.svg" alt="Utilisateur"></a>
        <?php else: ?>
            <a class="account inactive" href="auth.php">Authentification</a>
        <?php endif; ?>
    </ul>

	<center><br><br><p class="title">Nous découvrir</p></center>

    <div class="contenu">
        <?php
            $article = file_get_contents("textesMarkDown/discover-us.md");
            require 'parsedown/Parsedown.php';
            $Parsedown = new Parsedown();
            echo $Parsedown->text($article);
        ?>
	</div>

	<script>
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            const installButton = document.getElementById('installButton');
            installButton.style.display = 'block';

            installButton.addEventListener('click', (event) => {
                event.preventDefault();
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log("L'utilisateur a accepté l'installation");
                    } else {
                        console.log("L'utilisateur a rejeté l'installation");
                    }
                    deferredPrompt = null;
                });
            });
        });
    </script>
</body>

<?php include 'footer.php'; ?>

</html>
