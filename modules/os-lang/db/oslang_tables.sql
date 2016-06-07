-- --------------------------------------------------------

--
-- Structure de la table `lang_product`
--

CREATE TABLE IF NOT EXISTS `{lang_product}` (
  `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY  ,
  `id_product` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `short_description` text,
  `long_description` text,
  `cdate` datetime DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Structure de la table `lang_category`
--

CREATE TABLE IF NOT EXISTS `{lang_category}` (
  `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY ,
  `id_category` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cdate` datetime DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Structure de la table `oslang_cms`
--

CREATE TABLE IF NOT EXISTS `{lang_cms}` (
  `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY  ,
  `id_cms` int(11) DEFAULT NULL,
  `id_lang` int(11) DEFAULT NULL,
  `code_lang` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `description` text,
  `content` text,
  `cdate` datetime DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;