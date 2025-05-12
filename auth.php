<?php
session_start();
require_once 'db.php';

$mode = $_GET['mode'] ?? 'login';
$errors = [];
$validation_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'login';
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if ($mode === 'signup') {
        if (empty($username) || empty($password) || empty($email)) {
            $errors[] = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresse email invalide.";
        } else {
            // Vérifier si l'email est déjà utilisé
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = "Cet email est déjà utilisé.";
            } else {
                // Vérifier si le nom d'utilisateur est déjà pris
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $errors[] = "Ce nom d'utilisateur est déjà pris.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                    if ($stmt->execute([$username, $hashedPassword, $email])) {
                        $_SESSION['user_email'] = $email;
                        header("Location: user/dashboard.php");
                        exit;
                    } else {
                        $errors[] = "Erreur lors de l'inscription.";
                    }
                }
            }
        }
    } elseif ($mode === 'login') {
        if (empty($username) || empty($password)) {
            $errors[] = "Veuillez remplir tous les champs.";
        } else {
            // Connexion par pseudo
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                header("Location: user/dashboard.php");
                exit;
            } else {
                $errors[] = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
    <link rel="icon" type="image/png" href="assets/icon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth">

    <div class="background-overlay"></div>
    
    <div class="form-container">
        <form action="auth.php" method="post">
            <div>
                <a class="go-back-arrow" onclick="history.back()">←</a>
                <a class="go-home2" onclick="window.location.href='home.php'">🏠︎</a>
            </div>

            <p class="title" id="formTitle"><?= $mode === 'signup' ? "Inscription" : "Connexion"; ?></p>

            <input type="hidden" name="mode" id="formMode" value="<?= htmlspecialchars($mode); ?>">

            <ul class="log">
                <li>
                    <label for="username">Nom d'utilisateur<span style="color:#ff0000">*</span></label><br>
                    <input type="text" id="username" name="username" placeholder="Exemple" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autocomplete="on"/>
                </li>
                <li id="emailField" style="<?= $mode === 'signup' ? '' : 'display:none;' ?>">
                    <label for="email">Email<span style="color:#ff0000">*</span></label><br>
                    <input type="email" id="email" name="email" placeholder="exemple@exemple.fr" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
                </li>
                <li>
                    <label for="password">Mot de passe<span style="color:#ff0000">*</span></label><br>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="*****" required autocomplete="current-password" oninput="validatePassword()"/>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')" tabindex="-1">
                            <img id="toggleIcon1" class="see-password" src="assets/notSee.svg" alt="Afficher le mot de passe">
                        </button>
                    </div>

                    <!-- Afficher les critères uniquement si nous sommes en mode 'signup' -->
                    <?php if (isset($mode) && $mode === 'signup'): ?>
                    <ul id="passwordCriteria" style="display: block;">
                        <li id="minLength" class="invalid">Min 5 caractères</li>
                        <li id="hasUpper" class="invalid">Une majuscule</li>
                        <li id="hasLower" class="invalid">Une minuscule</li>
                        <li id="hasNumber" class="invalid">Un chiffre</li>
                        <li id="hasSpecial" class="invalid">Un caractère spécial</li>
                    </ul>
                    <?php else: ?>
                    <ul id="passwordCriteria" style="display: none;">
                        <li id="minLength" class="invalid">Min 5 caractères</li>
                        <li id="hasUpper" class="invalid">Une majuscule</li>
                        <li id="hasLower" class="invalid">Une minuscule</li>
                        <li id="hasNumber" class="invalid">Un chiffre</li>
                        <li id="hasSpecial" class="invalid">Un caractère spécial</li>
                    </ul>
                    <?php endif; ?>
                </li>
            </ul>

            <?php if (!empty($errors)): ?>
                <p class="error" style="color: red;"><?= implode('<br>', $errors); ?></p>
            <?php endif; ?>
            <?php if (!empty($validation_message)): ?>
                <p style="color: green;"><?= $validation_message; ?></p>
            <?php endif; ?>

            <div class="button">
                <button type="submit" id="submitButton"><?= $mode === 'signup' ? "S'inscrire" : "Se connecter"; ?></button><br>
                <button class="secondary" type="button" id="switchMode">
                    <?= $mode === 'signup' ? "Se connecter" : "S'inscrire"; ?>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('switchMode').addEventListener('click', function() {
            const modeInput = document.getElementById('formMode');
            const title = document.getElementById('formTitle');
            const submitButton = document.getElementById('submitButton');
            const emailField = document.getElementById('emailField');
            const passwordCriteria = document.getElementById('passwordCriteria');
            const switchButton = document.getElementById('switchMode');
            const passwordInput = document.getElementById('password');
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');

            passwordInput.value = '';
            usernameInput.value = '';
            emailInput.value = '';

            if (modeInput.value === 'login') {
                modeInput.value = 'signup';
                title.textContent = "Inscription";
                submitButton.textContent = "S'inscrire";
                switchButton.textContent = "Se connecter";
                emailField.style.display = 'block';

                if (passwordCriteria) {
                    passwordCriteria.style.display = 'block';
                }
            } else {
                modeInput.value = 'login';
                title.textContent = "Connexion";
                submitButton.textContent = "Se connecter";
                switchButton.textContent = "S'inscrire";
                emailField.style.display = 'none';

                if (passwordCriteria) {
                    passwordCriteria.style.display = 'none';
                }
            }
        });

        function togglePassword(inputId, iconId) {
            const passwordField = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.src = "assets/see.svg";  // Changer l'image pour afficher le mot de passe
            } else {
                passwordField.type = "password";
                toggleIcon.src = "assets/notSee.svg";  // Changer l'image pour masquer le mot de passe
            }
        }

        	
        function validatePassword() {
            const password = document.getElementById('password').value;
            
            const minLength = document.getElementById('minLength');
            const hasUpper = document.getElementById('hasUpper');
            const hasLower = document.getElementById('hasLower');
            const hasNumber = document.getElementById('hasNumber');
            const hasSpecial = document.getElementById('hasSpecial');
            
            minLength.classList.toggle('valid', password.length >= 5);
            minLength.classList.toggle('invalid', password.length < 5);
            
            hasUpper.classList.toggle('valid', /[A-Z]/.test(password));
            hasUpper.classList.toggle('invalid', !/[A-Z]/.test(password));
            
            hasLower.classList.toggle('valid', /[a-z]/.test(password));
            hasLower.classList.toggle('invalid', !/[a-z]/.test(password));
            
            hasNumber.classList.toggle('valid', /\d/.test(password));
            hasNumber.classList.toggle('invalid', !/\d/.test(password));
            
            hasSpecial.classList.toggle('valid', /[!@#$%^&*(),.?":{}|<>[\]~;_/\\+=\-`$&|^°°¥§¨*'<>°´¨¶•†®©¬©®‰≤≥±†µ℗℠≠∞∑−÷×≤≥÷⋆⟨⟩!¢∆✓ℱ∗⟨⟩≡≢⌘✘✗✠✦✧⋯✸✂⇨⊛⋚⌣⋰⇔⇐⇑⇒]/.test(password));
            hasSpecial.classList.toggle('invalid', !/[!@#$%^&*(),.?":{}|<>[\]~;_/\\+=\-`$&|^°°¥§¨*'<>°´¨¶•†®©¬©®‰≤≥±†µ℗℠≠∞∑−÷×≤≥÷⋆⟨⟩!¢∆✓ℱ∗⟨⟩≡≢⌘✘✗✠✦✧⋯✸✂⇨⊛⋚⌣⋰⇔⇐⇑⇒]/.test(password));
        }
    </script>
</body>
</html>

