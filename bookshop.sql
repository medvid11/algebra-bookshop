-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Računalo: 127.0.0.1
-- Vrijeme generiranja: Pro 22, 2016 u 05:55 
-- Verzija poslužitelja: 5.6.14
-- PHP verzija: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza podataka: `bookshop`
--

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Izbacivanje podataka za tablicu `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`) VALUES
(1, 'Oscar', 'Wilde'),
(2, 'Mark', 'Twain'),
(3, 'Suzanne', 'Collinssda'),
(4, 'Vladimir', 'Nabokov'),
(5, 'Douglas', 'Adams'),
(6, 'Mary', 'Shelley'),
(7, 'Lord Byron', NULL),
(9, 'Vladimir', 'Nazor'),
(10, 'Marko', 'Marulić');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `description` text,
  `price` decimal(6,2) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Izbacivanje podataka za tablicu `books`
--

INSERT INTO `books` (`id`, `title`, `category_id`, `description`, `price`, `date_created`) VALUES
(1, 'Slika Doriana Graya', 5, 'Slika stari umjesto glavnog lika, Doriana Graya.', '90.99', '2016-10-01 00:00:00'),
(2, 'Pustolovine Toma Sawyera', 5, 'Tom Sawyer i njegove pustolovine', '120.50', '2016-11-20 00:00:00'),
(3, 'Igre gladi', 2, 'Prva knjiga iz serijala Igre gladi, bla bla bla...', '110.00', '2016-12-02 18:20:19'),
(4, 'Igre gladi: Plamen', 1, 'Druga knjiga iz serijala Igre gladi.', '150.00', '2016-12-02 18:23:12'),
(7, 'Test knjiga', 1, 'Nova knjiga, remekdjelo', '100.00', '2016-12-20 18:35:23');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `book_authors`
--

CREATE TABLE IF NOT EXISTS `book_authors` (
  `book_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  KEY `fk_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Izbacivanje podataka za tablicu `book_authors`
--

INSERT INTO `book_authors` (`book_id`, `author_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 3),
(7, 7),
(7, 10);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Izbacivanje podataka za tablicu `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`) VALUES
(1, 'književnost', NULL),
(2, 'znanstvena fantastika', 1),
(4, 'kriminalistika', 1),
(5, 'klasična djela', NULL);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@algebra.hr');

--
-- Ograničenja za izbačene tablice
--

--
-- Ograničenja za tablicu `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ograničenja za tablicu `book_authors`
--
ALTER TABLE `book_authors`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON UPDATE CASCADE;

--
-- Ograničenja za tablicu `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
