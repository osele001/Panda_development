-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 17 2014 г., 01:50
-- Версия сервера: 5.6.11
-- Версия PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `projectbd`
--
CREATE DATABASE IF NOT EXISTS `projectbd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projectbd`;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_amount` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `category` text NOT NULL,
  `price` int(11) NOT NULL,
  `describing` text NOT NULL,
  `sold_amount` int(11) NOT NULL DEFAULT '0',
  `store` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `describing`, `sold_amount`, `store`) VALUES
(1, 'Lenovo H530s', 'pc', 29990, 'The affordable and space-saving Lenovo H530s desktop PC combines 4th generation Intel® Core™ processors with an extensive multimedia and productivity feature set. Great for email, home entertainment and organizing photos, the H530s is the ideal PC for the entire family.', 0, 100),
(2, 'Lenovo ThinkCentre M83 Mini Tower Desktop', 'pc', 31990, 'Take your business computing performance to a new level, while benefiting from the enduring Lenovo virtues of stability and reliability. The energy-efficient, cool running ThinkCentre M83 mini tower is powered for productivity with 4th gen Intel® Core™ processors, advanced wireless, easy expansion, and more.', 0, 50),
(3, 'Lenovo ThinkPad S440 Ultrabook', 'laptops', 34990, 'Optimized for Windows 8, with new ThinkPad TrackPad which has 5-point click integration, OneLink technology for expanding ports and power, RapidCharge battery, impressive performance features like 4th generation Intel® Core™ i7 processors and powerful graphics options.', 0, 20),
(4, 'Lenovo G500', 'laptops', 24990, 'The versatile and affordable Lenovo G500 laptop PC combines a solid look and feel with the latest all-round features, and performance that will surpass your everyday needs.', 0, 30),
(5, 'Lenovo ThinkPad X240 Ultrabook', 'laptops', 37990, 'The 12.5" ThinkPad X240 Ultrabook™ is thin, light, built to last, and ready for business. Power Bridge technology lets you go ten or more hours without plugging in, vPro gives you the ultimate in manageability, and plenty of other features let you take your business on the road.', 0, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `ultra_secured_table_of_users`
--

CREATE TABLE IF NOT EXISTS `ultra_secured_table_of_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `last_login` text NOT NULL,
  `last_ip` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `ultra_secured_table_of_users`
--

INSERT INTO `ultra_secured_table_of_users` (`id`, `email`, `password`, `hash`, `last_login`, `last_ip`) VALUES
(2, 'matti@panda.ru', '38fe8951595f01a3c16f3d50ea0bcc53', 'f06b39444c3393427ba1404d698d7f3e', 'Monday 17th of March 2014 2:50:05', '::1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
