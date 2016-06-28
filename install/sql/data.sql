--
-- Contenu de la table `addresses`
--

INSERT INTO `{addresses}` (`id`, `id_user`, `id_country`, `name`, `addresse`, `addresse2`, `firstname`, `company`, `lastname`, `city`, `codepostal`, `phone`, `mobile`, `ip`, `info`) VALUES
(1, 1, 5, 'Livraison', '10, rue rochel, france.', '', 'Okad', 'OkadShop', 'Shop', 'Paris', '10000', '', '+12398389920', '127.0.0.1 - ', '');

--
-- Contenu de la table `attributes`
--

INSERT INTO `{attributes}` (`id`, `id_lang`, `name`, `permalink`) VALUES
(1, 1, 'Portes', 'portes'),
(2, 1, 'Energie', 'energie'),
(3, 1, 'Boite', 'boite'),
(4, 1, 'CO2', 'co2');

--
-- Contenu de la table `attribute_values`
--

INSERT INTO `{attribute_values}` (`id`, `id_lang`, `id_attribute`, `name`, `permalink`) VALUES
(1, 1, 1, '2', '2'),
(2, 1, 1, '3', '3'),
(3, 1, 1, '5', '5'),
(4, 1, 2, 'Essence', 'essence'),
(5, 1, 2, 'Diesel', 'diesel'),
(6, 1, 2, 'Ess./Elec.', 'ess-elec'),
(7, 1, 2, 'Elec.', 'elec'),
(8, 1, 3, 'Mécanique', 'emcanique'),
(9, 1, 3, 'Auto', 'auto'),
(10, 1, 4, 'NC', 'nc'),
(11, 1, 4, '0 g/km', '0g-km'),
(12, 1, 4, '12 g/km', '12g-km'),
(13, 1, 4, '99 g/km', '99g-km'),
(14, 1, 4, '101 g/km', '101g-km'),
(15, 1, 4, '107 g/km', '107g-km'),
(16, 1, 4, '109 g/km', '109g-km'),
(17, 1, 4, '110 g/km', '110g-km'),
(18, 1, 4, '112 g/km', '112g-km'),
(19, 1, 4, '113 g/km', '113g-km'),
(20, 1, 4, '115 g/km', '115g-km'),
(21, 1, 4, '118 g/km', '118g-km'),
(22, 1, 4, '119 g/km', '119g-km'),
(23, 1, 4, '123 g/km', '123g-km'),
(24, 1, 4, '127 g/km', '127g-km'),
(25, 1, 4, '129 g/km', '129g-km'),
(26, 1, 4, '130 g/km', '130g-km'),
(27, 1, 4, '135 g/km', '135g-km'),
(28, 1, 4, '137 g/km', '137g-km'),
(29, 1, 4, '138 g/km', '138g-km'),
(30, 1, 4, '139 g/km', '139g-km'),
(31, 1, 4, '144 g/km', '144g-km'),
(32, 1, 4, '145 g/km', '145g-km'),
(33, 1, 4, '149 g/km', '149g-km'),
(34, 1, 4, '171 g/km', '171g-km'),
(35, 1, 4, '175 g/km', '175g-km'),
(36, 1, 4, '304 g/km', '304g-km'),
(37, 1, 4, '329 g/km', '329g-km'),
(38, 1, 4, '350 g/km', '350g-km');

--
-- Contenu de la table `carrier`
--

INSERT INTO `{carrier}` (`id`, `id_tax`, `name`, `type`, `description`, `min_delay`, `max_delay`, `grade`, `logo`, `url`, `shipping_handling`, `is_free`, `shipping_method`, `range_behavior`, `range_inf`, `range_sup`, `max_width`, `max_height`, `max_depth`, `max_weight`, `active`) VALUES
(1, 0, 'OkadShop', 'economic', 'Some usefull informations...', 2, 15, 10, '44b324909c046553e5aca2132e692625.png', 'http://okadshop.com', 0, 1, 0, 0, '0.00', '0.00', 0, 0, 0, '0.000000', 1);

--
-- Contenu de la table `categories`
--

INSERT INTO `{categories}` (`id`, `id_lang`, `name`, `description`, `image_cat`, `permalink`, `meta_title`, `meta_description`, `meta_keywords`, `hidden`, `parent`, `position`) VALUES
(1, 1, 'Accueil', '', '1.png', 'accueil', '', '', '', 0, 0, 0),
(2, 1, 'Renault', '', '2.png', 'renault', '', '', '', 0, 1, 0),
(3, 1, 'Peugeot', '', '3.png', 'peugeot', '', '', '', 0, 1, 0),
(4, 1, 'Dacia duster', '', '4.png', 'dacia-duster', '', '', '', 0, 1, 0),
(5, 1, 'Nissan', '', '5.png', 'nissan', '', '', '', 0, 1, 0),
(6, 1, 'Smart', '', '6.png', 'smart', '', '', '', 0, 1, 0),
(7, 1, 'Citroen', '', '7.png', 'citroen', '', '', '', 0, 1, 0),
(8, 1, 'Chevrolet', '', '8.png', 'chevrolet', '', '', '', 0, 1, 0),
(9, 1, 'BMW', '', '9.png', 'bmw', '', '', '', 0, 1, 0),
(10, 1, 'Ferrari', '', '10.png', 'ferrari', '', '', '', 0, 1, 0);

--
-- Contenu de la table `countries`
--

INSERT INTO `{countries}` (`id`, `name`, `id_zone`, `id_currency`, `id_lang`, `iso_code`, `call_prefix`, `active`, `contains_states`, `need_identification_number`, `need_zip_code`, `zip_code_format`, `display_tax_label`) VALUES
(1, 'Allemagne', 1, 1, 1, 'DE', 49, 1, 0, 0, 1, 'NNNNN', 0),
(2, 'Canada', 2, 1, 1, 'CA', 1, 1, 1, 0, 1, 'LNL NLN', 0),
(3, 'Chine', 3, 1, 1, 'CN', 86, 1, 0, 0, 1, 'NNNNNN', 0),
(4, 'Espagne', 1, 1, 1, 'ES', 34, 1, 0, 1, 1, 'NNNNN', 0),
(5, 'France', 1, 1, 1, 'FR', 33, 1, 0, 0, 1, 'NNNNN', 0),
(6, 'Italie', 1, 1, 1, 'IT', 39, 1, 1, 0, 1, 'NNNNN', 0),
(7, 'Japon', 3, 1, 1, 'JP', 81, 1, 1, 0, 1, 'NNN-NNNN', 0),
(8, 'Royaume-Uni', 1, 1, 1, 'GB', 44, 1, 0, 0, 1, '', 0),
(9, 'États-Unis', 2, 1, 1, 'US', 1, 1, 1, 0, 1, 'NNNNN', 0),
(10, 'Inde', 3, 1, 1, 'IN', 91, 1, 0, 0, 1, 'NNN NNN', 0);

--
-- Contenu de la table `currencies`
--

INSERT INTO `{currencies}` (`id`, `name`, `iso_code`, `iso_code_num`, `sign`, `default_currency`, `active`) VALUES
(1, 'Euro', 'EUR', '978', '&euro;', 0, 1),
(2, 'Dolar', 'USD', '978', '&#36;', 0, 1);

--
-- Contenu de la table `declinaisons`
--

INSERT INTO `{declinaisons}` (`id`, `id_product`, `cu`, `reference`, `ean13`, `upc`, `buy_price`, `sell_price`, `price_impact`, `price`, `weight_impact`, `weight`, `unit_impact`, `unity`, `quantity`, `min_quantity`, `available_date`, `default_dec`, `images`) VALUES
(1, 1001, NULL, '16V 75 AUTHENTIQUE 5P', NULL, NULL, 0, '13700', 0, NULL, 0, NULL, 0, NULL, 12, 1, NULL, 1, '1,2'),
(2, 1002, NULL, 'HDI 90 4CV 99G ACTIVE 5P', NULL, NULL, 0, '17950', 0, NULL, 0, NULL, 0, NULL, 15, 3, NULL, 1, '4,6'),
(3, 1003, NULL, 'TCE 125 4X4 AMBIANCE E6', NULL, NULL, 0, '16700', 0, NULL, 0, NULL, 0, NULL, 3, 1, NULL, 1, '8,9'),
(4, 1017, '1:1,2:4,3:9,4:17', '', '', '', 0, '12000', 0, 0, 0, 0, 0, 0, 20, 2, '2016-06-27', 0, ''),
(5, 1017, '1:3,2:5,3:9,4:27', '', '', '', 0, '30000', 0, 0, 0, 0, 0, 0, 2, 1, '2016-06-20', NULL, '');

--
-- Contenu de la table `gender`
--

INSERT INTO `{gender}` (`id`, `id_lang`, `name`) VALUES
(1, 1, 'Mr'),
(2, 1, 'Mme');

--
-- Contenu de la table `home_product`
--

INSERT INTO `{home_product}` (`id`, `id_product`, `position`) VALUES
(1, 1001, 1),
(2, 1002, 1),
(3, 1003, 1),
(4, 1004, 1),
(5, 1005, 1),
(6, 1007, 1),
(7, 1017, 1),
(8, 1013, 1);

--
-- Contenu de la table `langs`
--

INSERT INTO `{langs}` (`id`, `code`, `name`, `short_name`, `direction`, `date_format`, `datetime_format`, `default_lang`, `active`) VALUES
(1, 'fr_FR', 'Français', 'FR', 0, 'd/m/Y', 'd/m/Y H:i:s', 1, 1),
(2, 'en_US', 'English', 'EN', 0, 'd/m/Y', 'd/m/Y H:i:s', 0, 1);

--
-- Contenu de la table `loyalty_state`
--

INSERT INTO `{loyalty_state}` (`id`, `id_lang`, `name`) VALUES
(1, 1, 'En attente de validation'),
(2, 1, 'Disponible'),
(3, 1, 'Annulés'),
(4, 1, 'Déjà convertis'),
(5, 1, 'Non disponbile sur produits remisés');

--
-- Contenu de la table `meta_value`
--

INSERT INTO `{meta_value}` (`id`, `name`, `value`) VALUES
(1, 'quick_sales', ''),
(2, 'os_quick_sales_active', '0'),
(3, 'bankwire_details', 'Your bankwire acount details.'),
(4, 'bankwire_adresse', 'Your bank adresse for bankwire.'),
(5, 'newproduct_nbproduct', '12'),
(6, 'newproduct_active', '1'),
(7, 'mandatpostal_owner', 'OkadSop'),
(8, 'mandatpostal_detail', 'Your Mondat postal details here...'),
(9, 'western_owner', 'OkadShop'),
(10, 'western_detail', 'Your Western Union details here...'),
(11, 'shop_is_vacance', '0'),
(12, 'shop_is_vacance_return_date', ''),
(13, 'panel_live', ''),
(14, 'website_title', 'OkadShop CMS'),
(15, 'displayPrice', 'yes'),
(16, 'selling_rule', 'cart'),
(17, 'top_header_description', 'OkadShop Ecommerce CMS'),
(21, 'superslider_description', 'Mercedes-Benz AMG Classe E'),
(22, 'bankwire_owner', 'OkadShop');

--
-- Contenu de la table `modules`
--

INSERT INTO `{modules}` (`id`, `is_config`, `id_category`, `name`, `slug`, `description`, `version`, `author`, `website`, `location`, `position`, `status`, `active`) VALUES
(1, 0, 9, 'Account Panel', 'accountpanel', 'Account Panel.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(2, 0, 13, 'bankwire', 'bankwire', 'Virement Bancaire.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(3, 0, 1, 'Cart Panel', 'cartpanel', 'Cart Panel.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(4, 0, 9, 'Category Panel', 'categorypanel', 'Category Panel.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(5, 0, 9, 'Link Panel', 'linkpanel', 'Link Panel.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(6, 0, 9, 'Futured products', 'newproduct', 'Futured products.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(7, 0, 20, 'os-configuration', 'os-configuration', 'os-configuration', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(8, 0, 1, 'Dashboard Manager', 'os-dashboard', 'Gestion de tableau de bord.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(9, 0, 19, 'featuredproduct', 'os-featured-product', 'featured product.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(10, 0, 19, 'oslang', 'os-lang', 'Multi lang.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(11, 0, 13, 'mandatpostal', 'os-mandatpostal', 'mandat postal payments gateway.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(12, 0, 1, 'Updates Manager', 'os-updates', 'Mise à jour de CMS.', '1.0.0', 'Soft High Tech', 'http://softhightech.com', NULL, 0, 0, 1),
(13, 0, 13, 'PayPal Express', 'paypalexpress', 'PayPal Express.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(14, 0, 9, 'Products phares', 'productsphares', 'Products phares.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(15, 0, 13, 'Western union', 'westernunion', 'Western union payments gateway.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(16, 0, 18, 'Super Slider', 'superslider', 'Display a Slideshows in home pag.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(17, 0, 1, 'User groups', 'usergroups', 'Display a Slideshows in home pag.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(18, 0, 9, 'os-loyalty', 'os-loyalty', 'loyalty', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1),
(19, 0, 9, 'Products viewed', 'productviewed', 'Products viewed.', '1.0.0', 'Moullablad', 'http://moullablad.com', NULL, 0, 0, 1);

--
-- Contenu de la table `modules_categories`
--

INSERT INTO `{modules_categories}` (`id`, `name`, `slug`) VALUES
(1, 'Administration', 'administration'),
(2, 'Advertising and Marketing', 'advertising_marketing'),
(3, 'Analytics and Stats', 'analytics_stats'),
(4, 'Checkout', 'checkout'),
(5, 'Comparison site &amp; Feed management', 'smart_shopping'),
(6, 'Dashboard', 'dashboard'),
(7, 'Emailing &amp; SMS', 'emailing'),
(8, 'Export', 'export'),
(9, 'Front office Feature', 'front_office_features'),
(10, 'Marketplace', 'market_place'),
(11, 'Merchandising', 'merchandizing'),
(12, 'Migration Tools', 'migration_tools'),
(13, 'Payments and Gateways', 'payments_gateways'),
(14, 'Pricing and Promotion', 'pricing_promotion'),
(15, 'Quick / Bulk update', 'quick_bulk_update'),
(16, 'SEO', 'seo'),
(17, 'Shipping and Logistics', 'shipping_logistics'),
(18, 'Slideshows', 'slideshows'),
(19, 'Taxes &amp; Invoicing', 'billing_invoicing'),
(20, 'Other Modules', 'others');

--
-- Contenu de la table `modules_sections`
--

INSERT INTO `{modules_sections}` (`id`, `id_section`, `id_module`, `hook_function`, `description`, `position`, `active`) VALUES
(1, 5, 1, 'accountpanel_display', 'display account panel', 3, 1),
(2, 14, 2, 'bankwire_paymentdisplay', 'bankwire payment display', 1, 1),
(3, 5, 3, 'cartpanel_display', 'display cart panel', 2, 1),
(4, 5, 4, 'categorypanel_display', 'Display category panel', 1, 1),
(5, 4, 6, 'newproduct_displayProduct', 'Futured products display', 1, 1),
(6, 5, 6, 'newproduct_display', 'Display Futured products', 4, 1),
(7, 21, 8, 'orders_invoices_this_month', 'Devis, Commandes et Factures pour ce mois.', 1, 1),
(8, 21, 8, 'total_orders_invoices', 'Total de Devis, Commandes et Factures pour ce mois.', 2, 1),
(9, 14, 11, 'mandatpostal_paymentdisplay', 'Mandat postal payment display', 2, 1),
(10, 14, 13, 'paypal_paymentdisplay', 'Display paypal payment', 3, 1),
(11, 4, 14, 'productsphares_displayProduct', 'Products phares display', 2, 1),
(12, 14, 15, 'western_paymentdisplay', 'western payment display', 4, 1),
(13, 2, 16, 'superslider_displayFront', 'super slider display Front', 1, 1),
(14, 5, 19, 'productviewed_display', 'Display viewed products', 5, 1),
(15, 11, 19, 'productviewed_productdisplay', 'Display last viewed products', 1, 1);

--
-- Contenu de la table `payment_methodes`
--

INSERT INTO `{payment_methodes}` (`id`, `value`, `description`, `image`) VALUES
(1, 'Virement bancaire', 'Payer par virement bancaire', 'modules/bankwire/assets/images/bankwire.jpg'),
(2, 'Mandat Postal', 'Payer par Mandat Postal', 'modules/os-mandatpostal/assets/images/mandatpostal.png'),
(3, 'PayPal', 'Payer par PayPal', 'modules/paypalexpress/assets/images/paypal.png'),
(4, 'Western Union', 'Payer par Western Union', 'modules/westernunion/assets/images/western.png');

--
-- Contenu de la table `paypalexpress_setting`
--

INSERT INTO `{paypalexpress_setting}` (`id`, `username`, `password`, `signature`) VALUES
(1, 'OkadShop', 'okadshop', 'okadshop');

--
-- Contenu de la table `products`
--

INSERT INTO `{products}` (`id`, `id_user`, `id_lang`, `id_tax`, `id_category_default`, `name`, `reference`, `upc`, `ean13`, `type`, `permalink`, `short_description`, `long_description`, `meta_title`, `meta_description`, `meta_keywords`, `link_rewrite`, `product_condition`, `buy_price`, `sell_price`, `packing_price`, `wholesale_price`, `wholesale_per_qty`, `discount`, `discount_type`, `width`, `height`, `depth`, `weight`, `qty`, `min_quantity`, `loyalty_points`, `active`) VALUES
(1001, 1, 1, NULL, 2, 'Renault clio 3 de 2013', '16V 75 ALIZE 3P', NULL, NULL, 0, 'renault-clio-3-de-2013', 'La Clio 3 retrouve de son pétillant. De légères retouches esthétiques, des coloris inédits et un GPS défiant toute concurrence. Le tout axé autour d’une gamme enrichie. Assez pour reconquérir son titre de véhicule le plus vendu ?', 'Bientôt 20 ans d’existence et près de 10 millions d’exemplaires vendus pour le best seller de Renault. La Clio est donc un modèle stratégique pour Renault. C’est d’autant plus vrai dans le contexte actuel où ce sont les petites qui soutiennent les ventes des généralistes. Donc à manipuler avec précautions. Sans entrer dans les détails, la Clio a perdu son titre de véhicule le plus vendu, au début de l''année 2009. La Peugeot 207 truste depuis le premier trimestre la première marche du podium avec 32 449 exemplaires contre 31 713 pour la Clio. Autrement dit, une avance très serrée.', NULL, NULL, '', '', '', '0.00', '10090.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 50, 1, 0, 1),
(1002, 1, 1, NULL, 3, 'Peugeot 207', '1.6 HDI 90 4CV 99G ACTIVE 5P', NULL, NULL, 0, 'peugeot-207-de-2016-1', 'Après vous avoir révélé les premières photos officielles de la Peugeot 207, Caradisiac a pu tester les qualités routières de la polyvalente sur les routes de Majorque. La nouvelle lionne a-t-elle les ressources nécessaires pour chasser sur les terres de la Renault Clio 3 ?', 'Lorsque Peugeot a levé le voile sur la Peugeot 207, nous n''avions qu''une hâte, tester la nouvelle lionne sur route. Sur le papier tous les ingrédients étaient réunis pour proposer une recette digne de ce nom. Et nous n’avons pas été déçu par le résultat. Comme l’a promis son patron, Frédéric St Geours, la dernière du carré d’As de Peugeot (107, 1007, 206 et 207) promet de faire « au moins aussi bien » en terme de vente que sa devancière. Autrement dit 500 000 exemplaires dès la première année pleine. En parallèle Peugeot continuera de commercialiser sa 206 en Europe et à l’étranger. Cette dernière sera proposée comme compromis entre la 107 et la 207 en Europe et comme offre principal à l’étranger. La série du « 2 » semble porter chance à Peugeot puisque la 206 a remonté les ventes du constructeur dans ce segment de 85 % entre 1998 et 2005. Souhaitons la même réussite à la 207.', NULL, NULL, '', '', '', '0.00', '17950.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 12, 1, 0, 1),
(1003, 1, 1, NULL, 4, 'Dacia duster (2) 1.2 tce 125 4x4 ambiance e6', '1.2 TCE 125 4X4 AMBIANCE E6', NULL, NULL, 0, 'dacia-duster-de-2016-1', 'Le Duster vient de franchir la barre du million d’exemplaires vendus dans le monde. Rien ne semble arrêter l’ascension du 4x4 de Dacia. Boudé par la clientèle au profit de son grand frère (110 ch), le dCi 90 est-il un choix judicieux ?', 'Le phénomène Duster n’en finit pas. Le 4x4 produit en Roumanie vient de passer le cap du million d’exemplaires à travers le monde sous les badges Dacia et Renault. Cette success story repose sur la simplicité, la robustesse et des tarifs ajustés au millimètre. En France, la version la plus vendue (à hauteur de 80%) est la dCi 110 (deux roues motrices). Elle présente l’avantage d’être neutre au malus et d’offrir l’agrément nécessaire sur nos routes. Juste en-dessous, ce sont les moteurs essence qui soutiennent les ventes, notamment avec la version GPL qui séduit la Russie et l’Inde et le récent Tce qui plaît à l’Europe malgré son malus (500 €).', NULL, NULL, '', '', '', '0.00', '16700.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 32, 1, 0, 1),
(1004, 1, 1, NULL, 6, 'Smart fortwo 2 cabrio de 2016', 'CABRIO 55KW SALES&CARE', NULL, NULL, 0, 'smart-fortwo-2-cabrio-de-2016-1', 'La Smart Fortwo vit ses dernières heures de commercialisation. La micro citadine sera remplacée dès la fin de l’année par une version conçue en collaboration avec Renault. Le plus petit cabriolet du marché est-il encore dans le coup ?', 'La Forwto est la voiture de prédilection des citadins. Compactes, légère et robuste, la production allemande vit une carrière plus que satisfaisante. A ce jour plus d’un million et demi d’exemplaires ont trouvé preneurs à travers le monde. Née en 1998 et renouvelée en 2006, la petite allemande sera remplacée dès 2015 au catalogue de Smart. Cette fois-ci, la marque du groupe Mercedes s’est associée au français Renault pour le développement de cette troisième génération. Ainsi la prochaine Fortwo partagera ses dessous avec la Twingo 3. L’architecture est quasiment la même qu’à l’heure actuelle pour la Smart : gabarit très compact, moteur arrière et propulsion. Pour la Twingo c’est une révolution.', NULL, NULL, '', '', '', '0.00', '22500.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 43, 1, 0, 1),
(1005, 1, 1, NULL, 3, 'Peugeot 308 cc de 2015', 'CC 1.6 E-HDI 112 FAP SPORT PACK ', NULL, NULL, 0, 'peugeot-308-cc-de-2015-1', 'Peugeot a capitalisé sur son expérience dans le domaine du cabriolet pour bâtir un véhicule axé grand tourisme. Une ballade sur la riviera, décapoté par 8°C nous a laissé une chaude impression. Cette lionne apprivoisée n’a qu’une idée en tête : chouchouter ses passagers.', 'Le cabriolet n’est plus une inconnue pour le constructeur français qui a produit à ce jour plus de 636 600 véhicules découvrables. On pense bien sur à l’énorme succès de la petite 206 CC qui a su démocratiser le segment ainsi qu''aux bons résultats enregistrés par la 307 CC qui s’est écoulée, à ce jour, à plus de 175 000 exemplaires. C’est donc, avec un solide bagage le constructeur du Lion s’est attaqué à la conception de la 308 version découvrable.', NULL, NULL, '', '', '', '0.00', '30850.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 54, 1, 0, 1),
(1006, 1, 1, NULL, 5, 'Nissan juke de 2016', '1.2 DIG-T 115 ACENTA', NULL, NULL, 0, 'nissan-juke-de-2016-1', 'Le Juke restylé a été présenté il y a 6 mois. Après un essai complet qui s''est plus précisément appesanti sur la version diesel 1.5 dCi 110, l''heure est venue de vous faire partager nos impressions sur le moteur essence de milieu de gamme. Un 1.2 DIG-T 115 ch qui nous a séduits sous le capot de la Pulsar. Bis repetita avec le Juke ?', 'Le Juke est un hit dans la gamme Nissan. Deuxième meilleure vente derrière le best-seller Qashqai, il s''est vendu en version avant restylage à plus de 60 000 exemplaires en France, et on le voit à tous les coins de rue. C''est d''ailleurs à la gent féminine qu''il plaît le plus, même si on n''aurait pas parié là-dessus à son lancement, vu son look de véhicule sorti tout droit d''un manga japonais.', NULL, NULL, '', '', '', '0.00', '19450.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 62, 1, 0, 1),
(1007, 1, 1, NULL, 7, 'Citroen c4 (2e generation) de 2016', '1.2 PURETECH 110 FEEL', NULL, NULL, 0, 'citroen-c4-(2e-generation)-de-2016-1', 'Citroën n’a pas cassé la tirelire pour le restylage de la C4. Hormis quelques évolutions cosmétiques mineures et l’arrivée d’un nouveau bloc essence, la compacte française a juste vu son gros moteur diesel gagner en couple et en sobriété. Cette version BlueHdi 150, qui fait office de haut de gamme, tient-elle la corde face à la concurrence ?', 'Distancée par ses principales concurrentes, les Volkswagen Golf et Peugeot 308, en France mais surtout en Europe, la Citroën C4 a eu droit à un restylage qui donne l’impression que Citroën n’y croit plus : de nouveaux projecteurs et des feux arrière avec effet 3D à LED et c’est tout ! Dommage, car compte tenu du talent des designers de l’ADN (centre de style PSA), la compacte aurait pu moderniser ses lignes vieillottes. À l’intérieur, même tendance. Le dessin du cockpit, identique à celui de la DS4, n’est plus vraiment dans l’air du temps et l’interface multimédia, qui devient tactile, n’est pas une référence en matière d’avancement technologique. Elle a au moins permis de libérer la console de quelques touches. La C4 reçoit également de nouveaux équipements tels que l’accès et le démarrage mains-libres (option : 400 €) avec un bouton « Start » situé entre les sièges avant. L’habitabilité est correcte pour la catégorie mais c’est surtout son coffre (410 litres) qui s’impose comme l’un des plus vastes de la catégorie.', NULL, NULL, '', '', '', '0.00', '21450.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 13, 1, 0, 1),
(1008, 1, 1, NULL, 2, 'Renault laguna 3 de 2015', '1.5 DCI 110 BOSE EDITION ECO2', NULL, NULL, 0, 'renault-laguna-3-de-2015-1', 'Sous des atours perfectibles, la Laguna 3 sortie en 2007 cachait des qualités dynamiques intéressantes malheureusement passées inaperçues. Renault tente de corriger le tir avec cette Phase 2 qui se veut un peu plus attrayante et encore plus efficace grâce notamment à la généralisation du système 4Control. Ce véritable remodelage de la face suffira-t-il à faire de la Laguna une auto que l’on achète par désir plus que par raison ?', 'Avec 24.000 ventes en 2010, la Laguna 3 ne répond pas aux attentes de Renault. Les mises au chômage technique du personnel de l’usine de Sandouville où elle est fabriquée l’attestent, les volumes ne sont pas suffisants pour assurer l’équilibre économique. Mais tout n’est pas imputable à l’auto car c’est le segment M2 tout entier qui est sinistré en France et plus largement en Europe. De 32% de parts de marché en 1998, les immatriculations des véhicules de cette catégorie se sont contractées pour ne représenter plus que 13% du volume total des ventes en Europe. En France, La Laguna est tout de même deuxième meilleure vente derrière la Citroën C5 et si l’on considère  les seules ventes aux particuliers, elle devient alors leader. Certes, son placement prix agressif permet de compenser un physique qui n’a jamais été son principal atout surtout face aux concurrentes que sont la C5, la Ford Mondéo ou encore l’Opel Insignia.', NULL, NULL, '', '', '', '0.00', '30100.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 32, 1, 0, 1),
(1009, 1, 1, NULL, 5, 'Nissan qashqai de 2015', '1.5 DCI 110 6CV ACENTA', NULL, NULL, 0, 'nissan-qashqai-de-2015-1', 'La star de Nissan profite de la synergie de groupe et reçoit le nouveau dCi 130 de Renault. Un moteur qui combine la sobriété du 110 ch et l’agrément du 150 ch. Le tout pour des émissions en nette diminution. Le Qashqai va pouvoir vivre une fin de carrière sereine.', 'Nissan met à jour son best-seller en profitant du tout nouveau 1.6 dCi mis au point par Renault. Une nouveauté bienvenue pour le crossover japonais qui voit la concurrence se renouveler massivement : Kia Sportage, Volkswagen Tiguan, etc. Le pionnier des crossover troque donc son 2.0 dCi 150 ch (uniquement disponible en 4x4 BVA) contre le tout nouveau 1.6 dCi 130 ch. Un moteur conçu par Renault dans le but de réduire les taux d’émissions et de consommation. Dénommée « Energy », cette nouvelle génération de moteur regroupe les dernières innovations en matière de downsizing : augmentation du nombre de soupapes (de 8 à 16 soupapes), apparition d’un Stop & Start avec récupération de l’énergie au freinage, etc.', NULL, NULL, '', '', '', '0.00', '26840.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 55, 1, 0, 1),
(1010, 1, 1, NULL, 3, 'Peugeot 207 cc de 2015', '1.6 HDI 112 FAP FELINE', NULL, NULL, 0, 'peugeot-207-cc-de-2015-1', 'Adieu 206, bonjour 207. Le premier coupé cabriolet du Lion tirera sa révérence à la fin du mois pour laisser sa place à la 207 CC, sur laquelle Peugeot fonde beaucoup d’espoirs. Caradisiac a testé la 207 CC sous le climat capricieux de l’Andalousie.', 'Le cabriolet est plus qu’un simple effet de mode chez Peugeot. C’est un savoir-faire datant de près d’un siècle. La 402 Eclipse fût le premier modèle découvrable de la marque et ce… en 1932. Avec plus de 360 000 exemplaires produits, la 206 CC est le coupé cabriolet le plus vendu au monde. La relève sera certainement difficile. Difficile mais pas impossible, car la berline s’est déjà écoulée à plus de 300 000 exemplaires monde, en 2006. Les objectifs pour l’année en cours (500 000) témoignent de la confiance que Peugeot mise sur son nouveau modèle. Le coupé cabriolet du Lion devrait suivre la tendance. Car rappelons que la 207 était la première voiture vendue en France à la fin de l’année en France.', NULL, NULL, '', '', '', '0.00', '27550.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 78, 1, 0, 1),
(1011, 1, 1, NULL, 8, 'Chevrolet camaro 5 de 2015', 'COUPE 6.2 V8 405 BVA', NULL, NULL, 0, 'chevrolet-camaro-5-de-2015-1', 'Référence en matière de sportives abordables, le coupé Nissan 370Z, voit arriver une concurrente de choix. La mythique Chevrolet Camaro. Un V8, 400 ch et surtout un tarif sous les 40 000 €. Laquelle va remporter la mise ?', 'La Chevrolet Camaro comme la Nissan 370Z sont issues toutes deux d''une lignée de sportives abordables remontant à la fin des années 60 : la première génération de la pony car a été commercialisée en 1966 pour venir concurrencer la Ford Mustang, tandis que la S30, appelée Fairlady Z au Japon et 240Z aux États-Unis a vu le jour en 1969, et semble directement inspirée esthétiquement par la Jaguar Type E. Ces deux coupés propulsion utilisaient cependant des recettes mécaniques bien différentes : les versions de pointe de la Camaro ont toujours fait confiance au bon vieux V8 16 soupapes à arbre à came central et forte cylindrée dont la principale modification sera l''abandon du carburateur pour l''injection à la troisième génération des années 80. La cinquième génération, la toute dernière, se distingue cependant cette année avec une version à compresseur, la ZL1. Du côté de chez Nissan, on restera fidèle au 6 cylindres dans tous ses états : en ligne de 2,4l à 2,8l pour la première génération, 2,8l atmosphérique ou suralimenté pour la seconde (la S130), en V, 3,0l, atmosphérique ou suralimenté pour la troisième (Nissan 300ZX Z31), en V, 3,0l, atmosphérique et double turbo pour la quatrième (Nissan 300ZX Z32) avant de revenir à l''atmosphérique exclusif à partir de la Z33 (350Z 3,5l) puis la Z34 (370Z 3,7l).', NULL, NULL, '', '', '', '0.00', '45000.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 90, 1, 0, 1),
(1012, 1, 1, NULL, 7, 'Citroen c3 picasso de 2016', 'PURETECH 110 CONFORT', NULL, NULL, 0, 'citroen-c3-picasso-1', 'Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu’ici leader sur le marché des minispaces, s’organise… timidement. Que vaut la version restylée face aux alternatives de plus en plus originales ?', 'Depuis son arrivée en 2009, le C3 Picasso a su relancer un segment en déclin. Habitable, fonctionnel et surtout sexy, le minispace de Citroën a trouvé le stimulus qui manquait aux Renault Modus, Nissan Note et consorts. Aujourd’hui, la situation est tout autre. Le Français est sérieusement attaqué par une concurrence qui rivalise d’originalité : le Ford B-Max et son ouverture ininterrompue, l’Opel Meriva et ses portes antagonistes ou le Kia Venga et ses 7 ans de garantie. Difficile alors de rester dans la course sans innover. Pourtant c’est le cas…', NULL, NULL, '', '', '', '0.00', '19350.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 120, 1, 0, 1),
(1013, 1, 1, NULL, 7, 'Citroen e-mehari de 2016', 'E-MEHARI', NULL, NULL, 0, 'citroen-e-mehari-de-2016-1', 'Vous aviez pris l''habitude de retrouver pour chacun de nos essais importants une sélection d''alternatives en occasion. Désormais, vous retrouverez mensuellement, regroupé en un seul article, les alternatives possibles en seconde main pour les essais réalisés le mois écoulé. Afin de les mettre en lumière.', 'En ce mois de mars, pour une fois fidèle à la tradition, avec ses giboulées, son temps changeant, sa grêle et ses températures jouant au yoyo, nous avons réalisé 7 essais importants, de grosses nouveautés, de modèles restylés ou de variantes de carrosserie inédites. Pour chacun d''eux, voici les alternatives possibles et crédibles en occasion.', NULL, NULL, '', '', '', '0.00', '25000.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 12, 1, 0, 1),
(1014, 1, 1, NULL, 7, 'Citroen c3 picasso de 2016', 'PURETECH 110 CONFORT', NULL, NULL, 0, 'citroen-c3-picasso-de-2016-1', 'Rejoint par une concurrence aux dents longues, le C3 Picasso, jusqu’ici leader sur le marché des minispaces, s’organise… timidement. Que vaut la version restylée face aux alternatives de plus en plus originales ?', 'Depuis son arrivée en 2009, le C3 Picasso a su relancer un segment en déclin. Habitable, fonctionnel et surtout sexy, le minispace de Citroën a trouvé le stimulus qui manquait aux Renault Modus, Nissan Note et consorts. Aujourd’hui, la situation est tout autre. Le Français est sérieusement attaqué par une concurrence qui rivalise d’originalité : le Ford B-Max et son ouverture ininterrompue, l’Opel Meriva et ses portes antagonistes ou le Kia Venga et ses 7 ans de garantie. Difficile alors de rester dans la course sans innover. Pourtant c’est le cas…', NULL, NULL, '', '', '', '0.00', '19350.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 5, 1, 0, 1),
(1015, 1, 1, NULL, 9, 'Bmw i3', '60 AH ATELIER', NULL, NULL, 0, 'bmw-i3-1', 'Tout au long du développement de la i3, BMW a généreusement impliqué la presse automobile mondiale en l''invitant fréquemment ces dernières années pour constater l''évolution du projet et même lui donner le volant de certains prototypes.', 'C''est cependant à double tranchant pour le constructeur bavarois puisque cela a créé une véritable attente dans la profession, et de cette attente sont nées, forcément, autant d''exigences. Maintenant qu''elle va faire son entrée dans les concessions le 14 novembre prochain, est-elle finalement à la hauteur de nos espérances ?', NULL, NULL, '', '', '', '0.00', '35790.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 3, 1, 0, 1),
(1016, 1, 1, NULL, 10, 'Ferrari 458', 'SPECIALE DCT', NULL, NULL, 0, 'ferrari-458-1', 'Ferrari a souvent pour habitude de décliner ses séries spéciales et très sportives en découvrable. Ce fut notamment le cas avec la 458 Speciale et ses 605 ch tirés du V8 atmosphérique sur la 458 Speciale « A », pour « Aperta ».', 'Ceux qui aiment les cabriolets violents chez Ferrari doivent souvent s''armer de patience lors de la sortie d''un nouveau produit puisque cette déclinaison est souvent la dernière à arriver. La 458, sortie en 2009, a accouché plus tard d''une variante plus musclée « Speciale » et lors des derniers mois de commercialisation de la gamme 458, Ferrari a lancé dans le grand bain la 458 Speciale « A », pour « Aperta », qui signifie « ouverte ».', NULL, NULL, '', '', '', '0.00', '204172.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 92, 1, 0, 1),
(1017, 1, 1, 0, 10, 'Ferrari gtc4lusso de 2016', 'FERRARI GTC4 LUSSO', '', '', 0, 'ferrari-gtc4lusso-de-2016-1', 'Ferrari lance ce printemps la GTC4Lusso, qui se présente comme une évolution assez profonde de la formidable FF. Caradisiac a pu découvrir l''auto à Paris au Grand Palais, à la veille du départ du Tour Auto 2016.', 'Ferrari va bien, merci pour lui. Au premier trimestre, le constructeur italien a battu son record historique de ventes avec 1 882 voitures écoulées (+15% par rapport à 2015), pour un bénéfice net de 78 millions (+19%). C’est dans ce contexte qu’il lance la GTC4 Lusso, modèle dévoilé en première mondiale au salon de Genève au mois de mars dernier, appelé à remplacer la FF lancée en 2011.', '', '', '', 'ferrari-gtc4lusso-de-2016-1', 'new', '0.00', '266196.00', '0.00', '0.00', 1, '0.00', 0, '0.00', '0.00', '0.00', '0.00', 37, 1, 0, 1);


--
-- Contenu de la table `product_associated`
--

INSERT INTO `{product_associated}` (`id`, `id_product`, `associated_with`) VALUES
(1, 1001, 1008),
(2, 1008, 1001),
(3, 1002, 1005),
(4, 1002, 1010),
(5, 1005, 1002),
(6, 1005, 1010),
(7, 1006, 1009),
(8, 1007, 1012),
(9, 1007, 1013),
(10, 1007, 1014),
(11, 1012, 1007),
(12, 1012, 1013),
(13, 1012, 1014),
(14, 1013, 1007),
(15, 1013, 1012),
(16, 1013, 1014),
(17, 1014, 1007),
(18, 1014, 1012),
(19, 1014, 1013),
(20, 1009, 1006),
(21, 1010, 1002),
(22, 1010, 1005),
(23, 1016, 1017),
(24, 1017, 1016);

--
-- Contenu de la table `product_category`
--

INSERT INTO `{product_category}` (`id`, `id_product`, `id_category`) VALUES
(1, 1001, 2),
(2, 1002, 3),
(3, 1003, 4),
(4, 1004, 6),
(5, 1005, 3),
(6, 1006, 5),
(7, 1007, 7),
(8, 1008, 2),
(9, 1009, 5),
(10, 1010, 3),
(11, 1011, 8),
(12, 1012, 7),
(13, 1013, 7),
(14, 1014, 7),
(15, 1015, 9),
(16, 1016, 10),
(17, 1017, 10);

--
-- Contenu de la table `product_declinaisons`
--

INSERT INTO `{product_declinaisons}` (`id`, `id_declinaison`, `id_attribute`, `id_value`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 4),
(3, 1, 3, 8),
(4, 1, 4, 24),
(5, 2, 1, 3),
(6, 2, 2, 5),
(7, 2, 3, 8),
(8, 2, 4, 13),
(9, 3, 1, 3),
(10, 3, 2, 5),
(11, 3, 3, 8),
(12, 3, 4, 32),
(13, 4, 1, 1),
(14, 4, 2, 4),
(15, 4, 3, 9),
(16, 4, 4, 17),
(17, 5, 1, 3),
(18, 5, 2, 5),
(19, 5, 3, 9),
(20, 5, 4, 27);

--
-- Contenu de la table `product_images`
--

INSERT INTO `{product_images}` (`id`, `id_product`, `name`, `position`, `futured`) VALUES
(1, 1001, 'renault-clio-3-1.jpg', 0, 1),
(2, 1001, 'renault-clio-3-2.jpg', 0, 0),
(3, 1001, 'renault-clio-3-3.jpg', 0, 0),
(4, 1002, 'peugeot-207-de-2016-1.jpg', 0, 1),
(5, 1002, 'peugeot-207-de-2016-2.jpg', 0, 0),
(6, 1002, 'peugeot-207-de-2016-3.jpg', 0, 0),
(7, 1003, 'dacia-duster-de-2016-1.jpg', 0, 1),
(8, 1003, 'dacia-duster-de-2016-2.jpg', 0, 0),
(9, 1003, 'dacia-duster-de-2016-3.jpg', 0, 0),
(10, 1004, 'smart-fortwo-2-cabrio-de-2016-1.jpg', 0, 1),
(11, 1004, 'smart-fortwo-2-cabrio-de-2016-2.jpg', 0, 0),
(12, 1004, 'smart-fortwo-2-cabrio-de-2016-3.jpg', 0, 0),
(13, 1005, 'peugeot-308-cc-de-2015-1.jpg', 0, 1),
(14, 1005, 'peugeot-308-cc-de-2015-2.jpg', 0, 0),
(15, 1005, 'peugeot-308-cc-de-2015-3.jpg', 0, 0),
(16, 1006, 'nissan-juke-de-2016-1.jpg', 0, 1),
(17, 1006, 'nissan-juke-de-2016-2.jpg', 0, 0),
(18, 1006, 'nissan-juke-de-2016-3.jpg', 0, 0),
(19, 1007, 'citroen-c4-(2e-generation)-de-2016-1.jpg', 0, 1),
(20, 1007, 'citroen-c4-(2e-generation)-de-2016-2.jpg', 0, 0),
(21, 1007, 'citroen-c4-(2e-generation)-de-2016-3.jpg', 0, 0),
(22, 1008, 'renault-laguna-3-de-2015-1.jpg', 0, 1),
(23, 1008, 'renault-laguna-3-de-2015-2.jpg', 0, 0),
(24, 1008, 'renault-laguna-3-de-2015-3.jpg', 0, 0),
(25, 1009, 'nissan-qashqai-de-2015-1.jpg', 0, 1),
(26, 1009, 'nissan-qashqai-de-2015-2.jpg', 0, 0),
(27, 1009, 'nissan-qashqai-de-2015-3.jpg', 0, 0),
(28, 1010, 'peugeot-207-cc-de-2015-1.jpg', 0, 1),
(29, 1010, 'peugeot-207-cc-de-2015-2.jpg', 0, 0),
(30, 1010, 'peugeot-207-cc-de-2015-3.jpg', 0, 0),
(31, 1011, 'chevrolet-camaro-5-de-2015-1.jpg', 0, 1),
(32, 1011, 'chevrolet-camaro-5-de-2015-2.jpg', 0, 0),
(33, 1011, 'chevrolet-camaro-5-de-2015-3.jpg', 0, 0),
(34, 1012, 'citroen-c3-picasso-1.jpg', 0, 1),
(35, 1012, 'citroen-c3-picasso-2.jpg', 0, 0),
(36, 1012, 'citroen-c3-picasso-3.jpg', 0, 0),
(37, 1013, 'citroen-e-mehari-de-2016-1.jpg', 0, 1),
(38, 1013, 'citroen-e-mehari-de-2016-2.jpg', 0, 0),
(39, 1013, 'citroen-e-mehari-de-2016-3.jpg', 0, 0),
(40, 1014, 'citroen-c3-picasso-de-2016-1.jpg', 0, 1),
(41, 1014, 'citroen-c3-picasso-de-2016-2.jpg', 0, 0),
(42, 1014, 'citroen-c3-picasso-de-2016-3.jpg', 0, 0),
(43, 1015, 'bmw-i3-1.jpg', 0, 1),
(44, 1015, 'bmw-i3-2.jpg', 0, 0),
(45, 1015, 'bmw-i3-3.jpg', 0, 0),
(46, 1016, 'ferrari-458-1.jpg', 0, 1),
(47, 1016, 'ferrari-458-2.jpg', 0, 0),
(48, 1016, 'ferrari-458-3.jpg', 0, 0),
(49, 1017, 'ferrari-gtc4lusso-de-2016-1.jpg', 0, 1),
(50, 1017, 'ferrari-gtc4lusso-de-2016-2.jpg', 0, 0),
(51, 1017, 'ferrari-gtc4lusso-de-2016-3.jpg', 0, 0);


--
-- Contenu de la table `sections`
--

INSERT INTO `{sections}` (`id`, `name`, `slug`) VALUES
(1, 'Section Admin Bar', 'sec_admin_bar'),
(2, 'Section Home Center', 'sec_home_center'),
(3, 'Section Front Footer', 'sec_front_footer'),
(4, 'section home center buttom', 'sec_home_center_buttom'),
(5, 'section sidebar', 'sec_sidebar'),
(6, 'sec_product_button', 'sec_product_button'),
(7, 'sec_cart', 'sec_cart'),
(8, 'sec_payment', 'sec_payment'),
(9, 'sec_carrierfront', 'sec_carrierfront'),
(10, 'sec_history', 'sec_history'),
(11, 'sec_top_product', 'sec_top_product'),
(12, 'sec_register_form', 'sec_register_form'),
(13, 'sec_order_page', 'sec_order_page'),
(14, 'sec_payment_list', 'sec_payment_list'),
(15, 'sec_footer_link', 'sec_footer_link'),
(16, 'sec_category_page', 'sec_category_page'),
(17, 'sec_footercompany', 'sec_footercompany'),
(18, 'sec_footerblocks', 'sec_footerblocks'),
(19, 'sec_payment_top_list', 'sec_payment_top_list'),
(20, 'sec_capture', 'sec_capture'),
(21, 'Dashboard modules', 'sec_dashboard');


--
-- Contenu de la table `shop_activity`
--

INSERT INTO `{shop_activity}` (`id`, `name`) VALUES
(1, 'Alimentation et gastronomie'),
(2, 'Animaux'),
(3, 'Articles pour bébé'),
(4, 'Arts et culture'),
(5, 'Auto et moto'),
(6, 'Bijouterie'),
(7, 'Chaussures et accessoires'),
(8, 'Fleurs, cadeaux et artisanat'),
(9, 'Hifi, photo et vidéo'),
(10, 'Informatique et logiciels'),
(11, 'Lingerie et Adulte'),
(12, 'Maison et jardin'),
(13, 'Mode et accessoires'),
(14, 'Santé et beauté'),
(15, 'Services'),
(16, 'Sports et loisirs'),
(17, 'Téléchargement'),
(18, 'Télé©phonie et communication'),
(19, 'Voyage et tourisme'),
(20, 'électromÃ©nager'),
(21, 'Autre activité ...');

--
-- Contenu de la table `superslider_images`
--

INSERT INTO `{superslider_images}` (`id`, `file_name`) VALUES
(2, '1466731914-0.jpg'),
(3, '1466731979-0.jpg'),
(4, '1466732042-0.jpg');


--
-- Contenu de la table `users_groups`
--

INSERT INTO `{users_groups}` (`id`, `name`, `slug`, `active`) VALUES
(1, 'Professionnels', 'professionnels', 1),
(2, 'Particulières', 'particulieres', 1);

--
-- Contenu de la table `zones`
--

INSERT INTO `{zones}` (`id`, `name`, `active`) VALUES
(1, 'Europe', 1),
(2, 'North America', 1),
(3, 'Asia', 1),
(4, 'Africa', 1),
(5, 'Oceania', 1),
(6, 'South America', 1),
(7, 'Europe (non-EU)', 1),
(8, 'Central America/Antilla', 1);

--
-- Contenu de la table `carrier_zones`
--

INSERT INTO `{carrier_zones}` (`id`, `id_carrier`, `id_zone`, `fees`, `active`) VALUES
(1, 1, 1, '0.00', 1),
(2, 1, 2, '0.00', 1),
(3, 1, 3, '0.00', 1),
(4, 1, 4, '0.00', 1),
(5, 1, 5, '0.00', 1),
(6, 1, 6, '0.00', 1),
(7, 1, 7, '0.00', 1),
(8, 1, 8, '0.00', 1);