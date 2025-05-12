<?php
session_start();
require_once '../db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: ../auth.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="../assets/icon.png">
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    .modal-content{
        padding: 0px;
    }
</style>

<div class="background-overlay"></div>

<body class="page">
    <ul class="navbar">
        <a class="inactive" href="../home.php">Acceuil</a>
		<a class="inactive" href="../discover-us.php">Nous découvrir</a>
        <a class="inactive" href="../faq.php">F.A.Q.</a>

        <?php if (isset($_SESSION['username'])): ?>
			<a class="dashboard active" href="dashboard.php">Dashboard</a>
            <a class="account inactive right" href="account.php"><img class="user-icon" src="../assets/whiteUser.svg" alt="Utilisateur"></a>
        <?php else: ?>
            <a class="account inactive" href="../auth.php">Authentification</a>
        <?php endif; ?>
    </ul>

    <br><br><p class="title">Nos derniers clichés</p>

    <?php
        $path = '../cliches/';
        $directories = array_filter(glob($path . '*'), 'is_dir');
    
        if (count($directories) > 0) {
            usort($directories, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
            $lastFolder = basename($directories[0]);
            $image1 = "$path$lastFolder/1.jpg";
            $image2 = "$path$lastFolder/2.jpg";
            $image3 = "$path$lastFolder/3.jpg";
        } else {
            $lastFolder = "Aucun dossier trouvé";
        }
    ?>

    <center>
        <?php
        if ($lastFolder == "Aucun dossier trouvé") {
            echo '<div class="error-message">Aucun dossier trouvé.</div>';
        } else {
            echo '<p>' . htmlspecialchars($lastFolder) . '</p>';
        }
        ?>
    </center>

    <center>
        <div class="image-container contenu">
            <img class="cliches" src="<?php echo htmlspecialchars($image1, ENT_QUOTES); ?>" alt="Caméra 1" title="Caméra 1">
            <img class="cliches" src="<?php echo htmlspecialchars($image2, ENT_QUOTES); ?>" alt="Caméra 2" title="Caméra 2">
            <img class="cliches" src="<?php echo htmlspecialchars($image3, ENT_QUOTES); ?>" alt="Caméra 3" title="Caméra 3">
        </div>
    </center>
    
    <div id="imageModal" class="modal">
        <span class="close-modal">&times;</span>
        <div class="modal-content-wrapper">
            <center>
                <img class="modal-content" id="img01" alt="Image en grand">
                <a id="downloadLink" href="#" download>
                    <button class="download-btn" style="width:190px">Télécharger l'image</button>
                </a>
            </center>
            <a class="prev" style="cursor: pointer;">&#10094;</a>
            <a class="next" style="cursor: pointer;">&#10095;</a>
        </div>
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

<script>
    const images = Array.from(document.querySelectorAll('.cliches'));
    let currentImageIndex = 0;

    function openModal(index) {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('img01');
        const downloadLink = document.getElementById('downloadLink');

        currentImageIndex = index;
        modal.style.display = 'flex';
        modal.classList.add('show');

        const selectedImage = images[currentImageIndex];
        modalContent.src = selectedImage.src;

        const fileName = selectedImage.src.split('/').pop();
        const folderDate = '<?php echo $lastFolder; ?>';
        const formattedFolderDate = folderDate.replace(/_/g, ' ');
        const prefixedFileName = formattedFolderDate + "_•_" + fileName;

        downloadLink.href = selectedImage.src;
        downloadLink.download = prefixedFileName;
    }

    images.forEach((image, index) => {
        image.addEventListener('click', () => openModal(index));
    });

    document.querySelectorAll('.cliches').forEach(function(image) {
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
            const prefixedFileName = formattedFolderDate + "_•_" + fileName;  // Ajouter _ entre la date et le nom du fichier

            downloadLink.href = this.src;
            downloadLink.download = prefixedFileName;  // Préfixe avec date et heure ajoutés ici
        });
    });

    document.querySelector('.close-modal').addEventListener('click', function() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show');
        setTimeout(function() {
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }, 300);
    });

    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            const modal = this;
            modal.classList.remove('show');
            setTimeout(function() {
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }, 300);
        }
    });

    document.querySelector('.prev').addEventListener('click', function(event) {
        event.stopPropagation();
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        openModal(currentImageIndex);
    });

    document.querySelector('.next').addEventListener('click', function(event) {
        event.stopPropagation();
        currentImageIndex = (currentImageIndex + 1) % images.length;
        openModal(currentImageIndex);
    });
</script>

</html>
