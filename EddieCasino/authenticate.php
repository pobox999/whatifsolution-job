<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$cfg = app_config();
session_name((string)($cfg['session_name'] ?? 'eddiecasino_session'));
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$identifier = trim((string)($_POST['identifier'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($identifier === '' || $password === '') {
    header('Location: login.php?error=invalid');
    exit;
}

try {
    $pdo = db();
    $stmt = $pdo->prepare(
        'SELECT id, username, email, password_hash
         FROM users
         WHERE username = :identifier OR email = :identifier
         LIMIT 1'
    );
    $stmt->execute(['identifier' => $identifier]);
    $user = $stmt->fetch();

    if (!$user || !isset($user['password_hash']) || !password_verify($password, (string)$user['password_hash'])) {
        header('Location: login.php?error=invalid');
        exit;
    }

    // Prevent session fixation
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['username'] = (string)($user['username'] ?? '');

    header('Location: dashboard.php');
    exit;
} catch (Throwable $e) {
    // Avoid leaking details in the UI.
    header('Location: login.php?error=server');
    exit;
}

