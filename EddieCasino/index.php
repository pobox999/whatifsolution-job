<?php
// Simple entrypoint: redirect to login or dashboard.
declare(strict_types=1);

session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

header('Location: login.php');
exit;
