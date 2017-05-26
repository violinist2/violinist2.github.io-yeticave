-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.16 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5169
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных 195760-yeticave
CREATE DATABASE IF NOT EXISTS `195760-yeticave` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `195760-yeticave`;

-- Дамп структуры для таблица 195760-yeticave.bets
CREATE TABLE IF NOT EXISTS `bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bet_amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `date_betmade` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bets_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Ставки пользователей по лотам';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица 195760-yeticave.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` char(128) NOT NULL,
  `image` char(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Категории товаров';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица 195760-yeticave.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_add` datetime NOT NULL,
  `item_name` char(128) NOT NULL,
  `description` text NOT NULL,
  `image_path` char(128) NOT NULL,
  `price_start` int(11) NOT NULL,
  `date_end` datetime NOT NULL,
  `bet_step` int(11) NOT NULL,
  `favorites_count` int(11) DEFAULT NULL,
  `user_author_id` int(11) NOT NULL,
  `user_winner_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_name` (`item_name`),
  KEY `category_id` (`category_id`),
  KEY `user_winner_id` (`user_winner_id`),
  KEY `user_author_id` (`user_author_id`),
  CONSTRAINT `items_ibfk_3` FOREIGN KEY (`user_author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `items_ibfk_4` FOREIGN KEY (`user_winner_id`) REFERENCES `users` (`id`),
  CONSTRAINT `items_ibfk_5` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Лоты (товары) в продаже';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица 195760-yeticave.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_register` datetime NOT NULL,
  `email` char(128) NOT NULL,
  `username` char(128) NOT NULL,
  `password` char(64) NOT NULL,
  `avatar_path` char(128) DEFAULT NULL,
  `contacts` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Пользователи (аккаунты)';

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
