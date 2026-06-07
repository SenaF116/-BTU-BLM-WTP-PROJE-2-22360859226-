<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';

function bakery_products(): array
{
    $stmt = db()->query('SELECT id, name, category, description, price FROM products WHERE is_available = 1 ORDER BY category, name');
    return $stmt->fetchAll();
}

function find_product(int $productId): ?array
{
    $stmt = db()->prepare('SELECT id, name, category, description, price FROM products WHERE id = ? AND is_available = 1');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    return $product ?: null;
}

function grouped_products(): array
{
    $groups = [];

    foreach (bakery_products() as $product) {
        $groups[$product['category']][] = $product;
    }

    return $groups;
}

function product_image_path(string $productName): string
{
    // Ürün kartlarında doğru görseli göstermek için ürün adına göre eşleştirme yapıyorum.
    $images = [
        'Lemon Pie' => 'assets/images/lemon-pie.jpg',
        'Limonlu Tart' => 'assets/images/lemon-pie.jpg',
        'Dairy-Free Croissant' => 'assets/images/dairy-free-croissant.jpg',
        'Süt Ürünsüz Kruvasan' => 'assets/images/dairy-free-croissant.jpg',
        'Mille Feuille' => 'assets/images/millefeuille.jpg',
        'Opera Cake' => 'assets/images/opera-cake.jpg',
        'Opera Pasta' => 'assets/images/opera-cake.jpg',
        'Carrot Cake' => 'assets/images/carrot-cake.jpg',
        'Havuçlu Kek' => 'assets/images/carrot-cake.jpg',
        'Banana Bread' => 'assets/images/banana-bread.jpg',
        'Muzlu Ekmek' => 'assets/images/banana-bread.jpg',
        'Vegan Chocolate Pie' => 'assets/images/vegan-choco-pie.jpg',
        'Vegan Çikolatalı Tart' => 'assets/images/vegan-choco-pie.jpg',
        'Madeleines' => 'assets/images/madeleine.jpg',
        'Breadsticks' => 'assets/images/breadstick.jpg',
        'Glutensiz Çubuk Ekmek' => 'assets/images/breadstick.jpg',
        'Gluten-Free Cake' => 'assets/images/gluten-free-cake.jpg',
        'Glutensiz Kek' => 'assets/images/gluten-free-cake.jpg',
        'Gluten-Free Almond Cookies' => 'assets/images/almond-cookies.jpg',
        'Glutensiz Bademli Kurabiye' => 'assets/images/almond-cookies.jpg',
    ];

    return $images[$productName] ?? 'assets/images/menu-background-bakery.jpg';
}
