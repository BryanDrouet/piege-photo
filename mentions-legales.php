<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Mentions Légales</title>
	<link rel="icon" type="image/png" href="assets/icon.png">
	<link rel="stylesheet" href="style.css">
</head>

<div class="background-overlay"></div>

<body class="page">
    <ul class="navbar">
        <a class="inactive" href="home.php">Acceuil</a>
		<a class="inactive" href="discover-us.php">Nous découvrir</a>
        <a class="inactive" href="faq.php">F.A.Q.</a>

        <?php if (isset($_SESSION['username'])): ?>
			<a class="dashboard inactive" href="user/dashboard.php">Dashboard</a>
            <a class="account inactive right" href="user/account.php"><img class="user-icon" src="assets/whiteUser.svg" alt="Utilisateur"></a>
        <?php else: ?>
            <a class="account inactive" href="auth.php">Authentification</a>
        <?php endif; ?>
    </ul>

	<center><br><br><p class="title">Mentions Légales</p></center>

	<div class="contenu">
        <p>Conformément aux dispositions de la <a href="https://www.legifrance.gouv.fr/loda/id/JORFTEXT000000801164" target="_blank">loi n° 2004-575 du 21 juin 2004</a> pour la confiance en l'économie numérique, il est précisé aux utilisateurs du site Piège Photographique connecté l'identité des différents intervenants dans le cadre de sa réalisation et de son suivi.</p>
        
		<h2>Edition du site</h2>
        <p>Le présent site, accessible à l’URL <a href="https://piegephoto.fr/" target="_blank">piegephoto.fr</a> (le « Site »), est édité par :</p>
        <p>Bryan Drouet, résidant 12 Rue des Pluviers, 79700 Rorthais, de nationalité Française (France), né(e) le 24/07/2007,</p>
        
		<h2>Hébergement</h2>
        <p>Le Site est hébergé par la société <a href="https://3dplant.fr/" target="_blank">FabLab L’Entrepôt</a>, situé 21 Rue de la Poterie, 79700 Mauléon, (contact téléphonique ou email : <a href="tel:+33647201798">+33647201798</a>).</p>
        
		<h2>Directeur de publication</h2>
        <p>Le Directeur de la publication du Site est Bryan Drouet.</p>
        
		<h2>Nous contacter</h2>
        <li class="liste">Par téléphone : <a href="tel:+33647201798" target="_blank">+33647201798</a></li>
        <li class="liste">Par email : <a href="mailto:bdrouet@saint-gab.com" target="_blank">bdrouet@saint-gab.com</a></li>
        <li class="liste">Par courrier : 12 rue des Pluviers, 79700 Rorthais</li>
        <p>Génération des mentions légales par <a href="https://www.legalstart.fr/" target="_blank">Legalstart</a>.</p>
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
