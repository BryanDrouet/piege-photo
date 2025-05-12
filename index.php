<?php
$uri = trim($_SERVER['REQUEST_URI'], '/');

if ($uri === 'Piège photo/dashboard') {
    include 'user/dashboard.php';
} elseif ($uri === 'Piège photo/auth') {
    include 'auth.php';
} else {
    http_response_code(404);
    include '404.php';
}
