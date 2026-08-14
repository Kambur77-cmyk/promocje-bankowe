-- Utwórz bazę i tabelę users (Uruchom w phpMyAdmin)
CREATE DATABASE IF NOT EXISTS `zyskajnabank_app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'zyskajnabank_app'@'localhost' IDENTIFIED BY '123698745Kamil#1997Mnikami';
GRANT ALL PRIVILEGES ON `zyskajnabank_app`.* TO 'zyskajnabank_app'@'localhost';
FLUSH PRIVILEGES;

USE `zyskajnabank_app`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) DEFAULT NULL,
  `display_name` VARCHAR(255) DEFAULT NULL,
  `google_id` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
