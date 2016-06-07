CREATE TABLE IF NOT EXISTS `{contact_messages}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `from` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `id_directory` int(11) NOT NULL DEFAULT '1',
  `object` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `siret_tva` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `adresse2` varchar(100) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `id_country` int(11) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `attachement` varchar(100) NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `viewed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `vdate` datetime DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `{contact_directories}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(62) NOT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
);  

INSERT INTO `{contact_directories}` (`id`, `name`, `cdate`, `udate`) VALUES
(1, 'Boîte de réception', '2016-05-09 13:23:29', NULL),
(2, 'Messages envoyés', '2016-05-09 13:23:29', NULL),
(3, 'Corbeille', '2016-05-09 13:23:29', NULL),
(4, 'Spam', '2016-05-09 13:23:29', NULL),
(5, 'Brouillons', '2016-05-09 13:23:29', NULL),
(6, '2160', '2016-05-19 12:39:05', NULL);