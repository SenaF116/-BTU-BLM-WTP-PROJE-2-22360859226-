<?php
declare(strict_types=1);

$dbConfig = [
    'host' => 'localhost',
    'name' => 'bakery_db',
    'user' => 'root',
    'pass' => '',
];

$privateConfigPath = __DIR__ . '/config.private.php';

// Hosting bilgileri ayrı dosyada tutuluyor; böylece şifreler GitHub'a yüklenmez.
if (file_exists($privateConfigPath)) {
    $privateConfig = require $privateConfigPath;

    if (is_array($privateConfig)) {
        $dbConfig = array_merge($dbConfig, $privateConfig);
    }
}

define('DB_HOST', $dbConfig['host']);
define('DB_NAME', $dbConfig['name']);
define('DB_USER', $dbConfig['user']);
define('DB_PASS', $dbConfig['pass']);

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    return $pdo;
}
