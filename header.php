<?php
require_once __DIR__ . '/auth.php';
$user = current_user();
$pageTitle = $pageTitle ?? 'Moonrise Pastanesi';
$bodyClass = $bodyClass ?? '';
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/styles.css?v=20260608a" rel="stylesheet">
</head>
<body class="<?= e($bodyClass) ?>">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><span class="brand-mark">&#9790;</span> Moonrise Bakery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>" href="products.php">Ürünler</a></li>
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'order.php' ? 'active' : '' ?>" href="order.php">Sipariş Ver</a></li>
                <?php if ($user): ?>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Siparişlerim</a></li>
                    <li class="nav-item"><span class="badge text-bg-light border"><?= e($user['name']) ?></span></li>
                    <li class="nav-item"><a class="btn btn-outline-dark btn-sm" href="logout.php">Çıkış</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-outline-bakery btn-sm" href="login.php">Giriş</a></li>
                    <li class="nav-item"><a class="btn btn-bakery btn-sm" href="register.php">Kayıt Ol</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main>
<?php if ($flash = flash()): ?>
    <div class="container mt-4">
        <div class="alert alert-<?= e($flash['type']) ?> mb-0" role="alert"><?= e($flash['message']) ?></div>
    </div>
<?php endif; ?>
