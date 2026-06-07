<?php
$pageTitle = 'Ürünler ve Fiyatlar';
$bodyClass = 'menu-page';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/products.php';
?>

<section class="menu-showcase py-5">
    <div class="container">
        <div class="menu-heading text-center mx-auto mb-5">
            <p class="hero-kicker">Menü</p>
            <h1>Ürünler ve Fiyatlar</h1>
            <a class="btn btn-dark mt-3" href="order.php">Sipariş Ver</a>
        </div>

        <?php foreach (grouped_products() as $category => $products): ?>
            <div class="mb-5">
                <div class="text-center mb-4">
                    <h2 class="menu-category mb-0"><?= e($category) ?></h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-6 col-xl-3">
                            <div class="card product-card menu-card border-0 shadow-sm">
                                <img class="product-photo" src="<?= e(product_image_path($product['name'])) ?>" alt="<?= e($product['name']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <h3 class="h5 card-title"><?= e($product['name']) ?></h3>
                                    <p class="card-text text-muted flex-grow-1"><?= e($product['description']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <strong class="h5 price mb-0"><?= number_format((float) $product['price'], 0) ?> TL</strong>
                                        <a class="btn btn-sm btn-dark" href="order.php?product_id=<?= (int) $product['id'] ?>">Seç</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
