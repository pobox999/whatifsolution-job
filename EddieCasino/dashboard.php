<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$cfg = app_config();
session_name((string)($cfg['session_name'] ?? 'eddiecasino_session'));
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = (string)($_SESSION['username'] ?? 'User');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background: #0b1220; color: #e6eaf2; margin: 0; }
        .wrap { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .card { width: 100%; max-width: 640px; background: #111a2e; border: 1px solid #1f2a44; border-radius: 16px; padding: 22px; }
        h1 { margin: 0 0 10px; font-size: 22px; }
        p { margin: 0 0 14px; color: #a9b3c8; }
        a.btn { display:inline-block; padding: 10px 12px; border-radius: 10px; background: #243053; color: #e6eaf2; text-decoration: none; border: 1px solid #2a3658; }
        a.btn:hover { border-color: #4c74ff; }
        code { background: rgba(255,255,255,.06); padding: 2px 6px; border-radius: 8px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></h1>
        <p>You’re logged in (session-protected page).</p>
        <p>Your user id is <code><?php echo (int)$_SESSION['user_id']; ?></code>.</p>
        <a class="btn" href="logout.php">Logout</a>
    </div>
</div>
</body>
</html>

