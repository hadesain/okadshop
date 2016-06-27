CREATE TABLE IF NOT EXISTS `{loyalty}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_loyalty_state` int NOT NULL,
  `id_customer` int NOT NULL,
  `id_quotation` int NOT NULL,
  `points` int NOT NULL,
  `cdate` DATE NOT NULL,
  `udate` DATE NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `{loyalty_state}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_lang` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `cdate` DATE NOT NULL,
  `udate` DATE NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `{loyalty_options}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_lang` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `cdate` DATE NOT NULL,
  `udate` DATE NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `{loyalty_customer}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_customer` varchar(255) NOT NULL,
  `points` varchar(255) NOT NULL,
  `id_loyalty_state` int NOT NULL,
  `cdate` DATE NOT NULL,
  `udate` DATE NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

DELETE FROM `{loyalty_state}`;

INSERT INTO `{loyalty_state}` (`id_lang`, `name`) VALUES
(1, 'En attente de validation'),
(1, 'Disponible'),
(1, 'Annulés'),
(1, 'Déjà convertis'),
(1, 'Non disponbile sur produits remisés');