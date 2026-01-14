<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$cfg = app_config();
session_name((string)($cfg['session_name'] ?? 'eddiecasino_session'));
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = (string)($_GET['error'] ?? '');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; background: #0b1220; color: #e6eaf2; margin: 0; }
        .wrap { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .card { width: 100%; max-width: 420px; background: #111a2e; border: 1px solid #1f2a44; border-radius: 16px; padding: 22px; box-shadow: 0 12px 30px rgba(0,0,0,.35); }
        h1 { margin: 0 0 6px; font-size: 22px; }
        p { margin: 0 0 18px; color: #a9b3c8; font-size: 14px; }
        label { display:block; font-size: 13px; margin: 12px 0 6px; color:#c8d1e6; }
        input { width: 100%; padding: 12px 12px; border-radius: 10px; border: 1px solid #2a3658; background: #0c1426; color:#e6eaf2; outline: none; }
        input:focus { border-color: #4c74ff; box-shadow: 0 0 0 3px rgba(76,116,255,.15); }
        button { margin-top: 16px; width: 100%; padding: 12px 14px; border-radius: 10px; border: 0; background: #4c74ff; color: white; font-weight: 600; cursor:pointer; }
        button:hover { background: #3f65ea; }
        .error { margin: 12px 0 0; background: rgba(255, 77, 77, .10); border: 1px solid rgba(255, 77, 77, .35); color: #ffb3b3; padding: 10px 12px; border-radius: 12px; font-size: 13px; }
        .hint { margin-top: 14px; font-size: 12px; color:#a9b3c8; }
        code { background: rgba(255,255,255,.06); padding: 2px 6px; border-radius: 8px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Sign in</h1>
        <p>Use your username or email.</p>

        <form method="post" action="authenticate.php" autocomplete="on">
            <label for="identifier">Username / Email</label>
            <input id="identifier" name="identifier" type="text" required />

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required />

            <button type="submit">Login</button>
        </form>

        <?php if ($error === 'invalid'): ?>
            <div class="error">Invalid username/email or password.</div>
        <?php elseif ($error === 'server'): ?>
            <div class="error">Server error. Check DB connection/settings.</div>
        <?php endif; ?>

        <div class="hint">
            Configure DB in <code>EddieCasino/config.local.php</code>. Example schema in <code>EddieCasino/schema.sql</code>.
        </div>
    </div>
</div>
</body>
</html>

