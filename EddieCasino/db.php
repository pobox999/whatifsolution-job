<?php
declare(strict_types=1);

function app_config(): array
{
    $base = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
    $local = __DIR__ . DIRECTORY_SEPARATOR . 'config.local.php';

    $config = require $base;
    if (file_exists($local)) {
        $localConfig = require $local;
        if (is_array($localConfig)) {
            $config = array_merge($config, $localConfig);
        }
    }

    return $config;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = app_config();
    $host = (string)($cfg['db_host'] ?? '127.0.0.1');
    $port = (int)($cfg['db_port'] ?? 3306);
    $name = (string)($cfg['db_name'] ?? '');
    $user = (string)($cfg['db_user'] ?? '');
    $pass = (string)($cfg['db_pass'] ?? '');

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

