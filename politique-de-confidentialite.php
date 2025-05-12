<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Politique de confidentialité</title>
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

	<center><br><br><p class="title">Politique de confidentialité</p></center>

	<div class="contenu">
		<p>Devant le développement des nouveaux outils de communication, il est nécessaire de porter une attention particulière à la protection de la vie privée. C’est pourquoi, nous nous engageons à respecter la confidentialité des renseignements personnels que nous collectons.</p>
		
		<h2>Collecte des renseignements personnels</h2>
		<li class="liste">Adresse électronique</li>
		<p>Les renseignements personnels que nous collectons sont recueillis au travers de formulaires et grâce à l’interactivité établie entre vous et notre site Web. Nous utilisons également, comme indiqué dans la section suivante, des fichiers témoins et/ou journaux pour réunir des informations vous concernant.</p>
		
		<h2>Formulaires et interactivité:</h2>
		<p>Vos renseignements personnels sont collectés par le biais de formulaire, à savoir :</p>
		<li class="liste">Formulaire d'inscription au site Web</li>
		<p>Nous utilisons les renseignements ainsi collectés pour les finalités suivantes :</p>
		<li class="liste">Contact</li>
		<p>Vos renseignements sont également collectés par le biais de l’interactivité pouvant s’établir entre vous et notre site Web et ce, de la façon suivante:</p>
		<p>Nous utilisons les renseignements ainsi collectés pour les finalités suivantes :</p>
		<li class="liste">Contact</li>
		
		<h2>Droit d’opposition et de retrait</h2>
		<p>Nous nous engageons à vous offrir un droit d’opposition et de retrait quant à vos renseignements personnels.</p>
		<p>Le droit d’opposition s’entend comme étant la possiblité offerte aux internautes de refuser que leurs renseignements personnels soient utilisées à certaines fins mentionnées lors de la collecte.</p>
		<p>Le droit de retrait s’entend comme étant la possiblité offerte aux internautes de demander à ce que leurs renseignements personnels ne figurent plus, par exemple, dans une liste de diffusion.</p>
		<p>Pour pouvoir exercer ces droits, vous pouvez :</p>
		<li class="liste">Code postal :  79700</li>
		<li class="liste">Courriel : <a href="mailto:bdrouet@saint-gab.com" target="_blank">bdrouet@saint-gab.com</a></li>
		<li class="liste">Téléphone : <a href="tel:+33647201798" target="_blank">+33647201798</a></li>
		
		<h2>Droit d’accès</h2>
		<p>Nous nous engageons à reconnaître un droit d’accès et de rectification aux personnes concernées désireuses de consulter, modifier, voire radier les informations les concernant.</p>
		<p>L’exercice de ce droit se fera :</p>
		<li class="liste">Code postal :  79700</li>
		<li class="liste">Courriel : <a href="mailto:bdrouet@saint-gab.com" target="_blank">bdrouet@saint-gab.com</a></li>
		<li class="liste">Téléphone : <a href="tel:+33647201798" target="_blank">+33647201798</a></li>
		
		<h2>Sécurité</h2>
		<p>Les renseignements personnels que nous collectons sont conservés dans un environnement sécurisé. Les personnes travaillant pour nous sont tenues de respecter la confidentialité de vos informations.</p>
		<p>Pour assurer la sécurité de vos renseignements personnels, nous avons recours aux mesures suivantes :</p>
		<li class="liste">Gestion des accès - personne autorisée</li>
		<li class="liste">Gestion des accès - personne concernée</li>
		<li class="liste">Logiciel de surveillance du réseau</li>
		<li class="liste">Sauvegarde informatique</li>
		<li class="liste">Identifiant / mot de passe</li>
		<li class="liste">Pare-feu</li>
		<p>Nous nous engageons à maintenir un haut degré de confidentialité en intégrant les dernières innovations technologiques permettant d’assurer la confidentialité de vos transactions. Toutefois, comme aucun mécanisme n’offre une sécurité maximale, une part de risque est toujours présente lorsque l’on utilise Internet pour transmettre des renseignements personnels.</p>
		
		<h2>Législation</h2>
		<p>Nous nous engageons à respecter les dispositions législatives énoncées dans :</p>
		<p>Législation: Nous nous engageons à respecter les dispositions législatives énoncées dans la loi n° 2004-575 du 21 juin 2004 pour la confiance en l'économie numérique (LCEN), ainsi que le Règlement Général sur la Protection des Données (RGPD) en matière de protection des données personnelles.</p>
		<p>Génération de politique de confidentialité par <a href="https://www.politiquedeconfidentialite.ca/" target="_blank">Politique de confidentialité</a>.</p>
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
