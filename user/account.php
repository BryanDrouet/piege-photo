<?php
session_start();
require_once '../db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_account'])) {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_new_password'];

    // Récupération de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($currentPassword, $user['password'])) {
        $errors[] = "Mot de passe actuel incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        // Mise à jour du mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);

        header("Location: account.php?message=motdepasse_modifie");
        exit();
    }
}

if (isset($_POST['delete_account'])) {
    $userId = $_SESSION['user_id'];
    $password = $_POST['confirm_delete_password'];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);

        session_destroy();
        header("Location: ../auth.php?message=compte_supprimé");
        exit();
    } else {
        $errors[] = "Mot de passe incorrect pour la suppression du compte.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier votre compte</title>
    <link rel="icon" type="image/png" href="../assets/icon.png">
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    form {
        position: relative;
        top: 0%;
        left: 0%;
        transform: none;
    }

    .form-container{
        margin-top: 70px;
    }

    label {
        margin-top:10px;
    }

    label.username {
        margin-top:0px;
    }
</style>

<body class="page">
    <ul class="navbar">
        <a class="inactive" href="../home.php">Acceuil</a>
        <a class="inactive" href="../discover-us.php">Nous découvrir</a>
        <a class="inactive" href="../faq.php">F.A.Q.</a>

        <?php if (isset($_SESSION['username'])): ?>
            <a class="dashboard inactive" href="dashboard.php">Dashboard</a>
            <a class="account active right" href="account.php"><img class="user-icon" src="../assets/whiteUser.svg" alt="Utilisateur"></a>
        <?php else: ?>
            <a class="account inactive" href="../auth.php">Authentification</a>
        <?php endif; ?>
    </ul>

    <div class="contenu">
        <center>
            <br><br><p class="title">Modifier votre compte</p>
            <button onclick="confirmLogout()">Se déconnecter</button>
            <button onclick="openDeleteAccountModal()">Supprimer son compte</button>
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p style="color:red"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-container">
                <form action="" method="post">
                    <p style="font-size: 25px ; color:#000" class="title">Modifier votre mot de passe</p>
                    <div>
                    <label for="username">Nom d'utilisateur<span style="color:#ff0000">*</span></label><br>
                        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" value="<?= htmlspecialchars($user['username']) ?>" required/>
                    </div>
                    <div>
                        <label for="email">Email<span style="color:#ff0000">*</span></label><br>
                        <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required/>
                    </div>
                    <div>
                        <label for="password">Mot de passe actuel<span style="color:#ff0000">*</span></label><br>
                        <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="*****" required autocomplete="off"/>
                            <button type="button" class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')" tabindex="-1">
                                <img id="toggleIcon1" class="see-password" src="../assets/notSee.svg" alt="Afficher le mot de passe">
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="new_password">Nouveau mot de passe<span style="color:#ff0000">*</span></label><br>
                        <div class="password-container">
                            <input type="password" id="new_password" name="new_password" placeholder="*****" required autocomplete="off"/>
                            <button type="button" class="toggle-password" onclick="togglePassword('new_password', 'toggleIcon2')" tabindex="-1">
                                <img id="toggleIcon2" class="see-password" src="../assets/notSee.svg" alt="Afficher le mot de passe">
                            </button>
                        </div>
                    </div>
                    <div>
                    <label for="confirm_password">Confirmer le nouveau mot de passe<span style="color:#ff0000">*</span></label><br>
                        <div class="password-container">
                            <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="*****" autocomplete="off"/>
                            <button type="button" class="toggle-password" onclick="togglePassword('confirm_new_password', 'toggleIcon3')" tabindex="-1">
                                <img id="toggleIcon3" class="see-password" src="../assets/notSee.svg" alt="Afficher le mot de passe">
                            </button>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit">Mettre à jour</button>
                    </div>
                </form>
            </div>

            <div id="deleteAccountModal" style="display:none" class="delete-account-modal">
                <div class="delete-account-modal-content">
                    <h2>Supprimer votre compte</h2>
                    <p>Entrez votre mot de passe pour confirmer la suppression de votre compte :</p>
                    <form method="post" action="account.php">
                        <input type="password" name="confirm_delete_password" placeholder="Mot de passe" required style="width:100%; padding:8px; margin-bottom:10px;"><br>
                        <button type="submit" name="delete_account" style="background:#ff3838; color:white; padding:10px 20px;">Confirmer la suppression</button>
                        <button type="button" onclick="closeDeleteAccountModal()" style="margin-left:10px;">Annuler</button>
                    </form>
                </div>
            </div>
        </center>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordField = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.src = "../assets/see.svg";  // Changer l'image pour afficher le mot de passe
            } else {
                passwordField.type = "password";
                toggleIcon.src = "../assets/notSee.svg";  // Changer l'image pour masquer le mot de passe
            }
        }

        function openDeleteAccountModal() {
            const modal = document.getElementById("deleteAccountModal");
            modal.style.display = "flex";
            setTimeout(() => {
                modal.classList.add("show");
            }, 10); // petit délai pour que la transition prenne
        }

        function closeDeleteAccountModal() {
            const modal = document.getElementById("deleteAccountModal");
            modal.classList.remove("show");
            setTimeout(() => {
                modal.style.display = "none";
            }, 300); // délai = durée de la transition
        }

        function confirmLogout() {
            if (confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
                window.location.href = "../logout.php";
            }
        }
    </script>
</body>

<?php include 'footer.php'; ?>

</html>
