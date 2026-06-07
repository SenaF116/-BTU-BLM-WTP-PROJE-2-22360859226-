<?php
$pageTitle = 'Sipariş Ver';
$bodyClass = 'order-page';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/products.php';

require_login();

$user = current_user();
$errors = [];
$editing = false;
$order = [
    'id' => null,
    'product_id' => (int) ($_GET['product_id'] ?? 1),
    'quantity' => 1,
    'customer_phone' => '',
    'delivery_address' => '',
    'notes' => '',
];

if (!empty($_GET['id'])) {
    $stmt = db()->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
    $stmt->execute([(int) $_GET['id'], $user['id']]);
    $existing = $stmt->fetch();

    if (!$existing) {
        flash('Sipariş bulunamadı.', 'warning');
        header('Location: orders.php');
        exit;
    }

    $editing = true;
    $order = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (int) ($_POST['product_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $phone = trim($_POST['customer_phone'] ?? '');
    $address = trim($_POST['delivery_address'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $product = find_product($productId);

    if (!$product) {
        $errors[] = 'Lütfen geçerli bir ürün seçiniz.';
    }
    if ($quantity < 1 || $quantity > 20) {
        $errors[] = 'Adet 1 ile 20 arasında olmalıdır.';
    }
    if ($phone === '') {
        $errors[] = 'Telefon numarası boş bırakılamaz.';
    }
    if ($address === '') {
        $errors[] = 'Teslimat adresi boş bırakılamaz.';
    }

    if (!$errors && $product) {
        $unitPrice = (float) $product['price'];

        if (!empty($_POST['order_id'])) {
            $stmt = db()->prepare(
                'UPDATE orders SET product_id = ?, product_name = ?, category = ?, quantity = ?, unit_price = ?, customer_phone = ?, delivery_address = ?, notes = ? WHERE id = ? AND user_id = ?'
            );
            $stmt->execute([$productId, $product['name'], $product['category'], $quantity, $unitPrice, $phone, $address, $notes, (int) $_POST['order_id'], $user['id']]);
            flash('Sipariş başarıyla güncellendi.');
        } else {
            $stmt = db()->prepare(
                'INSERT INTO orders (user_id, product_id, product_name, category, quantity, unit_price, customer_phone, delivery_address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$user['id'], $productId, $product['name'], $product['category'], $quantity, $unitPrice, $phone, $address, $notes]);
            flash('Sipariş başarıyla kaydedildi.');
        }

        header('Location: orders.php');
        exit;
    }

    $order = [
        'id' => $_POST['order_id'] ?? null,
        'product_id' => $productId,
        'quantity' => $quantity,
        'customer_phone' => $phone,
        'delivery_address' => $address,
        'notes' => $notes,
    ];
}
?>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 fw-bold mb-4"><?= $editing ? 'Siparişi Düzenle' : 'Sipariş Ver' ?></h1>
                        <?php if ($errors): ?>
                            <div class="alert alert-danger"><?= e(implode(' ', $errors)) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?= e((string) ($order['id'] ?? '')) ?>">
                            <div class="mb-3">
                                <label class="form-label" for="product_id">Ürün</label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <?php foreach (bakery_products() as $product): ?>
                                        <option value="<?= (int) $product['id'] ?>" <?= (int) $order['product_id'] === (int) $product['id'] ? 'selected' : '' ?>>
                                            <?= e($product['name']) ?> - <?= e($product['category']) ?> - <?= number_format((float) $product['price'], 0) ?> TL
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="quantity">Adet</label>
                                <input class="form-control" type="number" id="quantity" name="quantity" min="1" max="20" required value="<?= e((string) $order['quantity']) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="customer_phone">Telefon</label>
                                <input class="form-control" type="tel" id="customer_phone" name="customer_phone" required value="<?= e($order['customer_phone'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="delivery_address">Teslimat Adresi</label>
                                <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required><?= e($order['delivery_address'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="notes">Sipariş Notu</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"><?= e($order['notes'] ?? '') ?></textarea>
                            </div>
                            <button class="btn btn-dark" type="submit"><?= $editing ? 'Siparişi Güncelle' : 'Siparişi Kaydet' ?></button>
                            <a class="btn btn-outline-secondary" href="orders.php">Vazgeç</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="info-panel p-4 shadow-sm mb-4">
                    <h2 class="h4 fw-bold">İletişim Bilgileri</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0"><strong>İşletme Sahibi:</strong> Elif Yılmaz</li>
                        <li class="list-group-item px-0"><strong>Telefon:</strong> +90 555 218 34 90</li>
                        <li class="list-group-item px-0"><strong>E-posta:</strong> elif@moonrisebakery.test</li>
                        <li class="list-group-item px-0"><strong>Adres:</strong> Çınar Sokak No: 18, Moda, Kadıköy, İstanbul</li>
                    </ul>
                </div>
                <div class="info-panel p-4 shadow-sm">
                    <h2 class="h4 fw-bold">Çalışma Saatleri</h2>
                    <table class="table table-sm align-middle mb-0">
                        <tbody>
                            <tr><th>Pazartesi - Cuma</th><td>08:00 - 20:00</td></tr>
                            <tr><th>Cumartesi</th><td>09:00 - 21:00</td></tr>
                            <tr><th>Pazar</th><td>10:00 - 18:00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
