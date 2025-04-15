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
    order_id INT AUTO_INCREMENT PRIMARY KEY, -- Clé primaire
    user_id INT,
    order_date DATE,
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