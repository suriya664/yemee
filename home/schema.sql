-- Database Schema for Mesmaa Homepage Clone

CREATE DATABASE IF NOT EXISTS `mesmaa_clone`;
USE `mesmaa_clone`;

-- 1. Navigation Table (Supports Dropdowns)
CREATE TABLE IF NOT EXISTS `navigation` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(255) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    `parent_id` INT DEFAULT NULL,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`parent_id`) REFERENCES `navigation`(`id`) ON DELETE CASCADE
);

-- 2. Banners Table (Hero Section)
CREATE TABLE IF NOT EXISTS `banners` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `image_url` VARCHAR(255) NOT NULL,
    `heading` VARCHAR(255),
    `subheading` VARCHAR(255),
    `button_text` VARCHAR(50),
    `button_url` VARCHAR(255)
);

-- 3. Products Table
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100),
    `is_bestseller` TINYINT(1) DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active'
);

-- 4. Footer Links Table
CREATE TABLE IF NOT EXISTS `footer_links` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255) NOT NULL,
    `column_name` VARCHAR(50) NOT NULL -- e.g., 'Links', 'Connect', 'Legal'
);

-- ==========================================
-- SAMPLE DATA INSERTION
-- ==========================================

-- Navigation Data
INSERT INTO `navigation` (`id`, `label`, `url`, `parent_id`, `sort_order`) VALUES
(1, 'READY TO SHIP', '/ready-to-ship', NULL, 1),
(2, 'Women', '/women', NULL, 2),
(3, 'Kids', '/kids', NULL, 3),
(4, 'Combos', '/combos', NULL, 4),
(5, 'Gift Cards', '/gift-cards', NULL, 5);

INSERT INTO `navigation` (`label`, `url`, `parent_id`, `sort_order`) VALUES
('Bridal Wear', '/bridal', 2, 1),
('Gowns', '/gowns', 2, 2),
('Anarkali', '/anarkali', 2, 3),
('Sarees', '/sarees', 2, 4),
('Girls', '/girls', 3, 1),
('Boys', '/boys', 3, 2);

-- Banners Data
INSERT INTO `banners` (`image_url`, `heading`, `subheading`, `button_text`, `button_url`) VALUES
('assets/images/hero-main.jpg', 'New Collection', 'Discover the elegance of tradition.', 'Shop Now', '/new-collection'),
('assets/images/hero-virtual.jpg', 'Book An Appointment', 'For Virtual Shopping Experience', 'Book Now', '/virtual-shopping');

-- Products Data
INSERT INTO `products` (`name`, `price`, `image_url`, `category`, `is_bestseller`) VALUES
('Sunflower Yellow White Anarkali', 12000.00, 'assets/images/p1.jpg', 'Anarkali', 1),
('White Teal Green Mirror Worked Kurti', 4500.00, 'assets/images/p2.jpg', 'Kurti', 1),
('Rani Pink Mustard Yellow Kurti', 4800.00, 'assets/images/p3.jpg', 'Kurti', 1),
('Green White Mirror Worked Kurti', 4600.00, 'assets/images/p4.jpg', 'Kurti', 0),
('Pastel Pink Mirror Worked Kurti', 5200.00, 'assets/images/p5.jpg', 'Kurti', 0),
('Prussian Blue Dress', 8500.00, 'assets/images/p6.jpg', 'Dresses', 1);

-- Footer Links Data
INSERT INTO `footer_links` (`title`, `link`, `column_name`) VALUES
('Terms & Conditions', '/terms', 'Links'),
('Shipping Policy', '/shipping', 'Links'),
('Privacy Policy', '/privacy', 'Links'),
('Contact Us', '/contact', 'Links'),
('Instagram', '#', 'Connect'),
('Youtube', '#', 'Connect'),
('Facebook', '#', 'Connect'),
('Pinterest', '#', 'Connect');
