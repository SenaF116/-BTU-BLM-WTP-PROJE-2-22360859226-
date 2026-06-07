<?php
$pageTitle = 'Siparişlerim';
require_once __DIR__ . '/includes/header.php';
require_login();

$user = current_user();
$stmt = db()->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$user['id']]);
$orders = $stmt->fetchAll();
?>

<section class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1">Siparişlerim</h1>
                <p class="text-muted mb-0">Kaydettiğiniz siparişleri buradan görüntüleyebilir, düzenleyebilir veya silebilirsiniz.</p>
            </div>
            <a class="btn btn-dark" href="order.php">Yeni Sipariş</a>
        </div>

        <?php if (!$orders): ?>
            <div class="alert alert-info">Henüz sipariş bulunmuyor. Menüden bir ürün seçerek ilk siparişinizi verebilirsiniz.</div>
        <?php else: ?>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ürün</th>
                            <th>Kategori</th>
                            <th>Adet</th>
                            <th>Birim Fiyat</th>
                            <th>Toplam</th>
                            <th>Tarih</th>
                            <th class="text-end">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <strong><?= e($order['product_name']) ?></strong>
                                <?php if ($order['notes']): ?>
                                    <div class="small text-muted"><?= e($order['notes']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge category-pill"><?= e($order['category']) ?></span></td>
                            <td><?= (int) $order['quantity'] ?></td>
                            <td><?= number_format((float) $order['unit_price'], 0) ?> TL</td>
                            <td class="fw-bold"><?= number_format((float) $order['unit_price'] * (int) $order['quantity'], 0) ?> TL</td>
                            <td><?= e(date('d.m.Y H:i', strtotime($order['created_at']))) ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="order.php?id=<?= (int) $order['id'] ?>">Düzenle</a>
                                <form class="d-inline" method="post" action="delete_order.php" onsubmit="return confirm('Bu sipariş silinsin mi?');">
                                    <input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Sil</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
