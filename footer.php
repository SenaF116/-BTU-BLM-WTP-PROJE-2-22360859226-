<?php
?>
</main>
<?php if (($bodyClass ?? '') === 'home-page'): ?>
    <footer class="home-footer">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-md-4 d-flex align-items-center gap-3">
                    <span class="footer-heart">&#9829;</span>
                    <span>&copy; <?= date('Y') ?> Moonrise Bakery</span>
                </div>
                <div class="col-md-5">
                    <div class="footer-features">
                        <span>&#10087; Glutensiz Seçenekler</span>
                        <span>&#10087; Süt Ürünsüz Tatlılar</span>
                        <span>&#10087; Vegan Lezzetler</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-socials">
                        <span>IG</span>
                        <span>FB</span>
                        <span>Mail</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php else: ?>
    <footer class="border-top bg-white py-4 mt-5">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 small text-muted">
            <span>&copy; <?= date('Y') ?> Moonrise Bakery</span>
            <span>Taze ekmekler, glutensiz ve vegan pastane ürünleri.</span>
        </div>
    </footer>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
