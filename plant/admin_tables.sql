-- Create database if not exists
CREATE DATABASE IF NOT EXISTS plants_nursery;
USE plants_nursery;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    shipping_address TEXT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password, email, full_name) 
VALUES ('admin', 'admin123', 'admin@plantsnursery.com', 'Administrator');

-- Insert sample products
INSERT INTO products (name, description, category, price, stock, image_url) VALUES
('Monstera Deliciosa', 'Beautiful indoor plant with large, glossy leaves', 'Indoor Plants', 699.00, 50, 'product1.jpg'),
('Snake Plant', 'Low maintenance indoor plant with upright leaves', 'Indoor Plants', 799.00, 75, 'product2.jpg'),
('Peace Lily', 'Elegant flowering plant with white blooms', 'Indoor Plants', 849.00, 30, 'product3.jpg'),
('Bonsai Tree', 'Miniature tree perfect for indoor decoration', 'Bonsai', 999.00, 20, 'product4.jpg'),
('Cactus Collection', 'Set of 3 different cactus plants', 'Cactus', 599.00, 40, 'product5.jpg');

-- Insert sample users
INSERT INTO users (name, email, password, phone, address) VALUES
('John Doe', 'john@example.com', 'password123', '9876543210', '123 Main St, Mumbai'),
('Jane Smith', 'jane@example.com', 'password123', '9876543211', '456 Park Ave, Mumbai'),
('Mike Johnson', 'mike@example.com', 'password123', '9876543212', '789 Oak St, Mumbai');

-- Insert sample orders
INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, shipping_address, amount, payment_method, status) VALUES
(1, 'John Doe', 'john@example.com', '9876543210', '123 Main St, Mumbai', 150.00, 'UPI', 'completed'),
(2, 'Jane Smith', 'jane@example.com', '9876543211', '456 Park Ave, Mumbai', 200.00, 'Credit Card', 'pending'),
(3, 'Mike Johnson', 'mike@example.com', '9876543212', '789 Oak St, Mumbai', 175.00, 'Net Banking', 'processing');

-- Insert sample order items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 699.00),
(2, 2, 1, 799.00),
(3, 3, 1, 849.00); 