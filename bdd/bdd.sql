CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY, 
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    mail VARCHAR(255),
    password VARCHAR(255),
    register_date DATE,
    is_admin BOOLEAN 
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(255),
    price DECIMAL(10, 2),
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(255)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATE,
    number_product INT,
    total_price DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY, 
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

INSERT INTO products (name, price, description, image, category) VALUES
-- Outils
('Brouette renforcée', 89.99, 'Brouette à châssis renforcé, idéale pour transporter de lourdes charges dans le jardin.', 'brouette.jpg', 'Outils'),
('Pulvérisateur à pression 5L', 29.50, 'Pulvérisateur manuel pour traitements phytosanitaires ou arrosage léger.', 'pulverisateur.jpg', 'Outils'),
('Taille-haie électrique 600W', 74.90, 'Taille-haie léger et maniable, parfait pour les haies de taille moyenne.', 'taillehaie.jpg', 'Outils'),
('Tondeuse thermique 150cc', 199.00, 'Tondeuse puissante à moteur thermique, convient aux grandes surfaces de pelouse.', 'tondeuse.jpg', 'Outils'),

-- Bacs
('Bac à compost 300L', 59.99, 'Bac à compost robuste et ventilé pour transformer vos déchets verts en engrais naturel.', 'composteur.jpg', 'Bacs'),
('Bac de plantation rectangulaire 100L', 39.90, 'Bac en plastique recyclé, idéal pour les cultures urbaines ou les balcons.', 'composteur.jpg', 'Bacs'),
('Bac à réserve d’eau 80L', 45.00, 'Bac auto-arrosant pour plantes nécessitant un arrosage régulier.', 'composteur.jpg', 'Bacs'),

-- Graines
('Graines de gazon rustique 1kg', 12.50, 'Mélange de graines idéal pour terrains piétinés et zones ensoleillées ou mi-ombre.', 'grainesgazon.jpg', 'Graines'),
('Graines de tomates anciennes', 3.20, 'Sachet de graines de variétés anciennes de tomates savoureuses.', 'grainesgazon.jpg', 'Graines'),
('Graines de carottes bio', 2.90, 'Semences issues de l’agriculture biologique pour une culture saine et durable.', 'grainesgazon.jpg', 'Graines');
