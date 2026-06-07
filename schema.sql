CREATE DATABASE IF NOT EXISTS bakery_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bakery_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(60) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (id, name, category, description, price, is_available) VALUES
(1, 'Limonlu Tart', 'Süt Ürünsüz', 'Hafif ekşi limon kreması ve çıtır tart tabanı ile hazırlanır.', 220.00, 1),
(2, 'Süt Ürünsüz Kruvasan', 'Süt Ürünsüz', 'Kat kat açılan, süt ve tereyağı kullanılmadan yapılan kruvasan.', 180.00, 1),
(3, 'Mille Feuille', 'Süt Ürünsüz', 'İnce hamur katları ve hafif kremasıyla klasik bir pastane ürünü.', 260.00, 1),
(4, 'Opera Pasta', 'Süt Ürünsüz', 'Kahve ve çikolata aromalı, şık görünümlü özel pasta.', 290.00, 1),
(5, 'Havuçlu Kek', 'Vegan', 'Havuç, ceviz ve baharatlarla hazırlanan yumuşak vegan kek.', 210.00, 1),
(6, 'Muzlu Ekmek', 'Vegan', 'Muz aroması belirgin, kahve yanında iyi giden vegan dilim kek.', 170.00, 1),
(7, 'Vegan Çikolatalı Tart', 'Vegan', 'Yoğun çikolata dolgulu ve bitkisel içerikli tart.', 275.00, 1),
(8, 'Madeleines', 'Glutensiz', 'Küçük porsiyonlu, hafif dokulu glutensiz Fransız keki.', 160.00, 1),
(9, 'Glutensiz Çubuk Ekmek', 'Glutensiz', 'Atıştırmalık olarak sunulan çıtır glutensiz çubuk ekmekler.', 165.00, 1),
(10, 'Glutensiz Kek', 'Glutensiz', 'Glutensiz unla hazırlanan sade ve yumuşak pastane keki.', 300.00, 1),
(11, 'Glutensiz Bademli Kurabiye', 'Glutensiz', 'Badem aromalı, dışı hafif çıtır içi yumuşak kurabiye.', 190.00, 1)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    category = VALUES(category),
    description = VALUES(description),
    price = VALUES(price),
    is_available = VALUES(is_available);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    category VARCHAR(60) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    customer_phone VARCHAR(40) NOT NULL,
    delivery_address TEXT NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_orders_product FOREIGN KEY (product_id) REFERENCES products(id)
);
