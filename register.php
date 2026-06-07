<?php
$pageTitle = 'Kayıt Ol';
$bodyClass = 'auth-page';
require_once __DIR__ . '/includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($name === '') {
        $errors[] = 'Ad soyad alanı boş bırakılamaz.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Geçerli bir e-posta adresi giriniz.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Şifre en az 6 karakter olmalıdır.';
    }

    if (!$errors) {
        $stmt = db()->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = 'Bu e-posta adresiyle daha önce kayıt yapılmış.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = db()->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, $passwordHash]);
            flash('Kayıt tamamlandı. Şimdi giriş yapabilirsiniz.');
            header('Location: login.php');
            exit;
        }
    }
}
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 fw-bold mb-4">Kayıt Ol</h1>
                        <?php if ($errors): ?>
                            <div class="alert alert-danger">
                                <?= e(implode(' ', $errors)) ?>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label" for="name">Ad Soyad</label>
                                <input class="form-control" type="text" id="name" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">E-posta</label>
                                <input class="form-control" type="email" id="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="password">Şifre</label>
                                <input class="form-control" type="password" id="password" name="password" required minlength="6">
                            </div>
                            <button class="btn btn-dark w-100" type="submit">Kayıt Ol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
