--
-- Structure de la table `quotations`
--
CREATE TABLE IF NOT EXISTS `{quotations}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_customer` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `id_payment_method` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `reference` varchar(15) NOT NULL,
  `company` varchar(32) DEFAULT NULL,
  `address_invoice` varchar(255) DEFAULT NULL,
  `address_delivery` varchar(255) DEFAULT NULL,
  `currency_sign` varchar(10) NOT NULL DEFAULT '€',
  `count_emails` int(11) NOT NULL DEFAULT '0',
  `payment_choice` varchar(255) NOT NULL,
  `loyalty_points` int(10) NOT NULL,
  `loyalty_state` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_value` decimal(20,2) DEFAULT '0.00',
  `global_discount` decimal(20,2) DEFAULT '0.00',
  `voucher_code` varchar(32) DEFAULT NULL,
  `voucher_value` decimal(20,2) DEFAULT '0.00',
  `voucher_type` tinyint(1) NOT NULL DEFAULT '0',
  `avoir` decimal(20,2) DEFAULT '0.00',
  `total_saved` decimal(20,2) DEFAULT '0.00',
  `total_letters` varchar(100) DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `can_be_ordered` int(10) unsigned DEFAULT '0',
  `more_info` text,
  `informations` text NOT NULL,
  `carrier_type` varchar(32) NOT NULL DEFAULT 'economic',
  `is_packing` tinyint(1) NOT NULL DEFAULT '0',
  `uby` int(11) NOT NULL,
  `cby` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `quotation_carrier`
--
CREATE TABLE IF NOT EXISTS `{quotation_carrier}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_quotation` int(10) unsigned NOT NULL,
  `id_carrier` int(10) unsigned NOT NULL,
  `carrier_name` varchar(32) DEFAULT NULL,
  `shipping_costs` decimal(20,2) NOT NULL DEFAULT '0.00',
  `min_delay` int(11) NOT NULL DEFAULT '0',
  `max_delay` int(11) NOT NULL DEFAULT '0',
  `delay_type` tinyint(1) NOT NULL DEFAULT '0',
  `min_prepa` int(11) NOT NULL DEFAULT '0',
  `max_prepa` int(11) NOT NULL DEFAULT '0',
  `prepa_type` tinyint(1) NOT NULL DEFAULT '0',
  `weight_including_packing` decimal(20,2) NOT NULL DEFAULT '0.00',
  `number_packages` int(11) NOT NULL DEFAULT '0',
  `more_info` text NOT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `quotation_detail`
--
CREATE TABLE IF NOT EXISTS `{quotation_detail}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_quotation` int(10) unsigned NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_declinaisons` int(10) DEFAULT NULL,
  `attributs` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_reference` varchar(32) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_ean13` varchar(13) DEFAULT NULL,
  `product_upc` varchar(12) DEFAULT NULL,
  `product_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_buyprice` decimal(20,2) NOT NULL DEFAULT '0.00',
  `product_discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_points` int(11) NOT NULL DEFAULT '0',
  `product_packing` int(11) NOT NULL DEFAULT '0',
  `product_quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `product_min_quantity` int(11) NOT NULL DEFAULT '1',
  `product_stock` int(11) NOT NULL DEFAULT '0',
  `product_weight` decimal(20,2) DEFAULT '0.00',
  `product_height` int(10) DEFAULT '0',
  `product_width` int(10) DEFAULT '0',
  `product_depth` int(10) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `quotation_messages`
--
CREATE TABLE IF NOT EXISTS `{quotation_messages}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_quotation` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `recipient_emails` text NOT NULL,
  `objet` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `attachement` varchar(80) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `vdate` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `quotation_setting`
--
CREATE TABLE IF NOT EXISTS `{quotation_setting}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `footer` text NOT NULL,
  `footer_logo` varchar(255) NOT NULL,
  `conditions` text NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Structure de la table `quotation_status`
--
CREATE TABLE IF NOT EXISTS `{quotation_status}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Contenu de la table `quotation_status`
--
INSERT INTO `{quotation_status}` (`id`, `name`, `slug`, `cdate`, `udate`) VALUES
(1, 'Devis en création', 'quote_creation', '0000-00-00 00:00:00', '2016-05-19 13:16:05'),
(2, 'Devis en étude', 'quote_study', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Devis disponible', 'quote_available', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'En attente du règlement', 'waiting_for_payment', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Commande enregistrée', 'order_registered', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Devis rejeté', 'quote_rejected', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Devis expiré', 'quote_expired', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Devis annulé', 'quote_canceled', '0000-00-00 00:00:00', '2016-05-19 13:11:05'),
(9, 'test', 'test', '2016-05-24 15:30:05', '0000-00-00 00:00:00'),
(10, 'test', 'test', '2016-06-03 12:35:06', '0000-00-00 00:00:00');