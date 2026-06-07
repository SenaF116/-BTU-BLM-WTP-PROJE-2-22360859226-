<?php
require_once __DIR__ . '/includes/auth.php';

$_SESSION = [];
session_destroy();
session_start();
flash('Çıkış yapıldı.');
header('Location: index.php');
exit;
