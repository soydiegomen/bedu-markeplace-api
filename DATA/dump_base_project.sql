#Script para crear BD
CREATE DATABASE bedumarketplace_db;
CREATE USER 'bedumarketplace_dbu'@'localhost' IDENTIFIED BY 'gNjAG3WGqcrMw2V8';
GRANT ALL PRIVILEGES ON bedumarketplace_db.* TO 'bedumarketplace_dbu'@'localhost';
FLUSH PRIVILEGES;


#Crea la tabla de productos
CREATE TABLE `products` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('GENERAL','COURSE') NOT NULL DEFAULT 'GENERAL',
  `SKU` varchar(50) DEFAULT NULL,
  `sale_price` decimal(13,2) NOT NULL,
  `list_price` decimal(13,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `fecha_fin` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`product_id`)
);

CREATE TABLE `orders` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('PENDING','PAID') NOT NULL DEFAULT 'PENDING',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `payment_date` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
);

CREATE TABLE `order_products` (
  `order_product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `unit_price` decimal(13,2) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`order_product_id`),
  KEY `fk_order_products_orders` (`order_id`),
  CONSTRAINT `fk_order_products_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  KEY `fk_order_products_products` (`product_id`),
  CONSTRAINT `fk_order_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);