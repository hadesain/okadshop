-- --------------------------------------------------------

--
-- Structure de la table `lang_product`
--

CREATE TABLE IF NOT EXISTS `{lang_product}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_product` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `short_description` text,
  `long_description` text,
  `meta_title` text,
  `meta_description ` text,
  `meta_keywords` text,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `lang_category`
--

CREATE TABLE IF NOT EXISTS `{lang_category}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_category` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `meta_title` text,
  `meta_description ` text,
  `meta_keywords` text,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;



--
-- Structure de la table `oslang_cms`
--

CREATE TABLE IF NOT EXISTS `{lang_cms}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_cms` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `description` text,
  `content` text,
  `meta_title` text,
  `meta_description ` text,
  `meta_keywords` text,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;