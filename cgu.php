<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Conditions générales d'utilisation</title>
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

	<center><br><br><p class="title">Conditions générales d'utilisation</p></center>

	<div class="contenu">
		<h2>Préambule</h2>
		<p>Les présentes conditions générales d'utilisation sont conclues entre :</p>
		<p>Le gérant du site internet, ci-après désigné « l’Éditeur » ;</p>
		<p>Toute personne souhaitant accéder au site et à ses services, ci-après appelé « l’Utilisateur ».</p>
		
		<h2>Article 1 - Principes</h2>
		<p>Les présentes conditions générales d'utilisation ont pour objet l'encadrement juridique de l’utilisation du site Piège Photographique connecté et de ses services.</p>
		<p>Le site Internet <a href="https://piegephoto.fr" target="_blank">piegephoto.fr</a> est un service de :</p>
		<p>L'entreprise individuelle Piège Photographique connecté</p>
		<p>Située 12 rue des Pluviers, 79700 Rorthais, France</p>
		<p>Email : <a href="mailto:bryan.drouet24@gmail.com">bryan.drouet24@gmail.com</a></p>
		<p>Téléphone : <a href="tel:+33647201798">+33 6 47 20 17 98</a></p>
		
		<h2>Article 2 - Évolution et durée des CGU</h2>
		<p>Les présentes conditions générales d'utilisation sont conclues pour une durée indéterminée. Le contrat produit ses effets à compter du début de l’utilisation du service.</p>
		<p>Le site Piège Photographique connecté se réserve le droit de modifier ces conditions générales à tout moment et sans justification.</p>
		
		<h2>Article 3 - Accès au site</h2>
		<p>Tout Utilisateur ayant accès à Internet peut accéder gratuitement au site Piège Photographique connecté. Les frais liés à l’accès (connexion internet, matériel informatique, etc.) sont à la charge de l’Utilisateur.</p>
		<p>Le site et ses services peuvent être interrompus pour maintenance sans obligation de préavis.</p>
		
		<h2>Article 4 - Responsabilités</h2>
		<p>L'Éditeur ne peut être tenu responsable en cas de panne ou d'interruption de fonctionnement empêchant l'accès au site.</p>
		<p>L'Utilisateur est responsable de son matériel et des mesures de sécurité prises contre les virus et autres menaces.</p>
		<p>L'Éditeur ne pourra être tenu responsable en cas de poursuites judiciaires à l’encontre de l'Utilisateur résultant de l'utilisation du site.</p>
		
		<h2>Article 5 - Propriété intellectuelle</h2>
		<p>Les documents, photographies, textes, logos, dessins et vidéos présents sur le site sont protégés par le Code de la propriété intellectuelle et restent la propriété exclusive de Piège Photographique connecté.</p>
		
		<h2>Article 6 - Liens hypertextes</h2>
		<p>Tout lien hypertexte vers le site doit être autorisé au préalable par l'Éditeur via l'adresse email : <a href="mailto:bryan.drouet24@gmail.com">bryan.drouet24@gmail.com</a>.</p>
		
		<h2>Article 7 - Protection des données personnelles</h2>
		<p>Les données personnelles collectées sont utilisées pour :</p>
		<li class="liste">Fournir et améliorer les services du site</li>
		<li class="liste">Assurer la sécurité des utilisateurs</li>
		<li class="liste">Proposer des communications commerciales</li>
		<p>Conformément au RGPD, l’Utilisateur dispose de droits sur ses données qu’il peut exercer en contactant <a href="mailto:bryan.drouet24@gmail.com">bryan.drouet24@gmail.com</a>.</p>
		
		<h2>Article 8 - Cookies</h2>
		<p>Le site Piège Photographique connecté peut collecter automatiquement certaines informations via les cookies. L'Utilisateur peut désactiver les cookies dans les paramètres de son navigateur.</p>
		
		<h2>Article 9 - Loi applicable</h2>
		<p>Les présentes conditions générales d'utilisation sont soumises au droit français. En cas de litige, la compétence revient aux tribunaux français.</p>
		<p>Génération des conditions générales d’utilisation par <a href="https://www.rocketlawyer.com/fr/fr/entreprise/utilisez-les-cgv-adaptees" target="_blank">Rocket Lawyer</a>.</p>
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
