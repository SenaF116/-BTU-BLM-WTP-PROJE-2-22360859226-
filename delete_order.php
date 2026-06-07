<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: orders.php');
    exit;
}

$user = current_user();
$stmt = db()->prepare('DELETE FROM orders WHERE id = ? AND user_id = ?');
$stmt->execute([(int) ($_POST['id'] ?? 0), $user['id']]);

flash('Sipariş silindi.');
header('Location: orders.php');
exit;
