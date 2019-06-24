DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `icon` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `city` varchar(32) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `anuncios`;

CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `description` text,
  `price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `views` bigint(20) DEFAULT '0',
  `is_used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `category` (`category`),
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `favorites`;

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `anuncio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_anuncios_id_fk` (`anuncio`),
  KEY `favorites_users_id_fk` (`user`),
  CONSTRAINT `favorites_anuncios_id_fk` FOREIGN KEY (`anuncio`) REFERENCES `anuncios` (`id`),
  CONSTRAINT `favorites_users_id_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `photos`;

CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anuncio` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_anuncios_id_fk` (`anuncio`),
  CONSTRAINT `photos_anuncios_id_fk` FOREIGN KEY (`anuncio`) REFERENCES `anuncios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;