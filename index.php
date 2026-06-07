<?php
$pageTitle = 'Moonrise Pastanesi';
$bodyClass = 'home-page';
require_once __DIR__ . '/includes/header.php';
?>

<section class="classic-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-xl-6">
                <div class="hero-text-panel">
                    <p class="hero-kicker">Özel Üretim Pastane</p>
                    <h1>Moonrise Bakery</h1>
                    <div class="hero-divider"></div>
                    <p class="hero-copy">Taze ekmekler, glutensiz seçenekler, süt ürünsüz tatlılar ve vegan lezzetler.</p>
                    <div class="hero-actions d-flex gap-3 flex-wrap">
                        <a class="btn btn-bakery btn-lg" href="products.php">Menüyü Gör</a>
                        <a class="btn btn-outline-bakery btn-lg" href="order.php">Sipariş Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
