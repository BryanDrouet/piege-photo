<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Piège Photographique connecté</title>
	<link rel="icon" type="image/png" href="assets/icon.png">
	<link rel="stylesheet" href="style.css">
</head>

<div class="background-overlay"></div>

<body style="padding:0" class="page">
	<ul class="navbar">
        <a class="active" href="home.php">Acceuil</a>
        <a class="inactive" href="discover-us.php">Nous découvrir</a>
        <a class="inactive" href="faq.php">F.A.Q.</a>

        <?php if (isset($_SESSION['username'])): ?>
            <a class="dashboard inactive" href="user/dashboard.php">Dashboard</a>
            <a class="account inactive right" href="user/account.php"><img class="user-icon" src="assets/whiteUser.svg" alt="Utilisateur"></a>
        <?php else: ?>
            <a class="account inactive" href="auth.php">Authentification</a>
        <?php endif; ?>
    </ul>

	<div style="top:0 ; height:100vh; background: rgb(255,120,120);
	background: linear-gradient(52deg, rgba(255,120,120,1) 0%, rgba(253,29,29,1) 50%, rgba(159,0,0,1) 100%, rgba(159,0,0,0) 100%);
	background-size: cover; width:100%">
	    <center><h1 class="title" style="font-size: 75px ; color:#fff ; display: flex ; justify-content: center ; align-items: center ; height: 100vh; max-width: 70%">Le Piège Photographique Connecté</h1></center>
	    
	    <div class="scroll-arrow" onclick="scrollToNext()">
	        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
	            <polyline points="6 9 12 15 18 9"/>
	        </svg>
	    </div>
	</div>

	<div class="contenu" id="next-section" style="text-align: center; list-style: none;">
    <br><br><h1 class="title" style="padding-top:50px">Notre deuxième revue de projet</h1>
        <p>Notre deuxième revue de projet approche ! Nous passerons :</p>
        <p style="margin-bottom:0px"><strong>Bryan :</strong> 14 mai 2025 à 11h</p>
        <p style="margin:0px"><strong>Lucien :</strong> 16 mai 2025 à 14h50</p>
        <p style="margin-top:0px"><strong>Nathan :</strong> 16 mai 2025 à 15h20</p>
        <p>Retrouvez les différentes revues de : <a href="documents/revueProjet2Bryan.pdf" target="_blank">Bryan,</a> Lucien & Nathan</p>
        <img title="1ère Image de la Diapo de la Revue de Projet 2" alt="1ère Image de la Diapo de la Revue de Projet 2" src="assets/RP2_spoiler.png" class="homeSpoiler">

        <div id="imageModal" class="modal">
            <span class="close-modal">&times;</span>
            <div class="modal-content-wrapper">
                <center>
                    <img class="modal-content" id="img01" alt="Image en grand">
                    <a id="downloadLink" href="#" download>
                        <button class="download-btn" style="width:190px">Télécharger l'image</button>
                    </a>
                </center>
            </div>
        </div>

        <br><br><h1 class="title" style="padding-top:50px">Notre première revue de projet</h1>
        <p>Retrouvez notre toute première revue de projet <a href="documents/revueProjet1.pdf" target="_blank">juste ici.</a></p>
        <img title="1ère Image de la Diapo de la Revue de Projet 1" alt="1ère Image de la Diapo de la Revue de Projet 1" src="assets/RP1_spoiler.png" class="homeSpoiler">
    </div>

    <script>
        document.querySelectorAll('.homeSpoiler').forEach(function(image) {
            image.addEventListener('click', function() {
                const modal = document.getElementById('imageModal');
                const modalContent = document.querySelector('.modal-content');
                const downloadLink = document.getElementById('downloadLink');
                
                modal.style.display = 'flex';
                modal.classList.add('show');
                modalContent.src = this.src;

                const fileName = this.src.split('/').pop();  // Récupère le nom du fichier, par exemple "1.jpg"
                const folderDate = '<?php echo $lastFolder; ?>';  // Supposons que $lastFolder est sous forme "Lundi 4 Décembre 2025 • 12h38"
                const formattedFolderDate = folderDate.replace(/_/g, ' ');  // Remplacer les espaces par des underscores et '•' par '_'
                const prefixedFileName = formattedFolderDate + fileName;  // Ajouter _ entre la date et le nom du fichier

                downloadLink.href = this.src;
                downloadLink.download = prefixedFileName;  // Préfixe avec date et heure ajoutés ici
            });
        });

        const modal = document.getElementById('imageModal');
        const closeBtn = document.querySelector('.close-modal');

        function showModal() {
            modal.style.display = 'flex';
            requestAnimationFrame(() => {
                modal.classList.add('show');
                document.body.classList.add('modal-open');
            }, 20);
        }

        function hideModal() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }, 300);
        }

        closeBtn.addEventListener('click', hideModal);
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });

        document.querySelector('.close-modal').addEventListener('click', function() {
            const modal = document.getElementById('imageModal');
            hideModal(modal);
        });

        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal(this);
            }
        });
    
        function scrollToNext() {
            document.getElementById("next-section").scrollIntoView({ behavior: "smooth" });
        }
        
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            const installLink = document.getElementById('installLink');
            installLink.style.display = 'block';

            installLink.addEventListener('click', (event) => {
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
