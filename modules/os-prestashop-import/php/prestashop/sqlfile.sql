

-- --------------------------------------------------------

--
-- Contenu de la table `product_associated`
--



-- --------------------------------------------------------

--
-- Contenu de la table `categories`
--

INSERT INTO `categories`(`id`, `name`, `permalink`, `cdate`, `udate`, `id_lang`, `parent`, `description`,position , meta_title,meta_description,meta_keywords) VALUES  
(1,'Racine','racine','2016-06-02 11:03:34','2016-06-02 11:03:34',1,0,'',0,'','',''), 
(2,'Accueil','accueil','2016-06-02 11:03:34','2016-06-02 11:03:34',1,1,'',0,'','',''), 
(3,'Femmes','femmes','2016-06-02 11:04:11','2016-06-02 11:04:11',1,2,'<p><strong>Vous trouverez ici toutes les collections mode pour femmes.</strong></p>
<p>Cette catégorie regroupe tous les basiques de votre garde-robe et bien plus encore :</p>
<p>chaussures, accessoires, T-shirts imprimés, robes élégantes et jeans pour femmes !</p>',0,'','',''), 
(4,'Tops','tops','2016-06-02 11:04:12','2016-06-02 11:04:12',1,3,'<p>Choisissez parmi une large sélection de T-shirts à manches courtes, longues ou 3/4, de tops, de débardeurs, de chemisiers et bien plus encore.</p>
<p>Trouvez la coupe qui vous va le mieux !</p>',0,'','',''), 
(5,'T-shirts','t-shirts','2016-06-02 11:04:13','2016-06-02 11:04:13',1,4,'<p>Les must have de votre garde-robe : découvrez les divers modèles ainsi que les différentes</p>
<p>coupes et couleurs de notre collection !</p>',0,'','',''), 
(6,'Tops','top','2016-06-02 11:04:13','2016-06-02 11:04:13',1,4,'Choisissez le top qui vous va le mieux, parmi une large sélection.',0,'','',''), 
(7,'Chemisiers','chemisiers','2016-06-02 11:04:14','2016-06-02 11:04:14',1,4,'Coordonnez vos accessoires à vos chemisiers préférés, pour un look parfait.',0,'','',''), 
(8,'Robes','robes','2016-06-02 11:04:15','2016-06-02 11:04:15',1,3,'<p>Trouvez votre nouvelle pièce préférée parmi une large sélection de robes décontractées, d\'été et de soirée !</p>
<p>Nous avons des robes pour tous les styles et toutes les occasions.</p>',0,'','',''), 
(9,'Robes décontractées','robes-decontractees','2016-06-02 11:04:16','2016-06-02 11:04:16',1,8,'<p>Vous cherchez une robe pour la vie de tous les jours ? Découvrez</p>
<p>notre sélection de robes et trouvez celle qui vous convient.</p>',0,'','',''), 
(10,'Robes de soirée','robes-soiree','2016-06-02 11:04:16','2016-06-02 11:04:16',1,8,'Trouvez la robe parfaite pour une soirée inoubliable !',0,'','',''), 
(11,'Robes d\'été','robes-ete','2016-06-02 11:04:16','2016-06-02 11:04:16',1,8,'Courte, longue, en soie ou imprimée, trouvez votre robe d\'été idéale !',0,'','','');

UPDATE `categories` SET `image_cat` ='10.jpg' WHERE `id` = 10;
UPDATE `categories` SET `image_cat` ='11.jpg' WHERE `id` = 11;
UPDATE `categories` SET `image_cat` ='3.jpg' WHERE `id` = 3;
UPDATE `categories` SET `image_cat` ='4.jpg' WHERE `id` = 4;
UPDATE `categories` SET `image_cat` ='5.jpg' WHERE `id` = 5;
UPDATE `categories` SET `image_cat` ='6.jpg' WHERE `id` = 6;
UPDATE `categories` SET `image_cat` ='7.jpg' WHERE `id` = 7;
UPDATE `categories` SET `image_cat` ='8.jpg' WHERE `id` = 8;
UPDATE `categories` SET `image_cat` ='9.jpg' WHERE `id` = 9;
UPDATE `categories` SET `image_cat` ='fr.jpg' WHERE `id` = 0;


-- --------------------------------------------------------

--
-- Contenu de la table `product_attachments`
--



-- --------------------------------------------------------

--
-- Contenu de la table `cms`
--

INSERT INTO `cms` (id,`title`, `description`, `content`, `id_cmscat`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES  
(1, 'Livraison','Nos conditions de livraison','<h2>Expéditions et retours</h2><h3>Expédition de votre colis</h3><p>Les colis sont généralement expédiés dans un délai de 2 jours après réception du paiement. Ils sont expédiés via UPS avec un numéro de suivi et remis sans signature. Les colis peuvent également être expédiés via UPS Extra et remis contre signature. Veuillez nous contacter avant de choisir ce mode de livraison, car il induit des frais supplémentaires. Quel que soit le mode de livraison choisi, nous vous envoyons un lien pour suivre votre colis en ligne.</p><p>Les frais d\'expédition incluent les frais de préparation et d\'emballage ainsi que les frais de port. Les frais de préparation sont fixes, tandis que les frais de transport varient selon le poids total du colis. Nous vous recommandons de regrouper tous vos articles dans une seule commande. Nous ne pouvons regrouper deux commandes placées séparément et des frais d\'expédition s\'appliquent à chacune d\'entre elles. Votre colis est expédié à vos propres risques, mais une attention particulière est portée aux objets fragiles.<br /><br />Les dimensions des boîtes sont appropriées et vos articles sont correctement protégés.</p>',1,'conditions, livraison, délais, expédition, colis','livraison',1,now()), 
(2, 'Mentions légales','Mentions légales','<h2>Mentions légales</h2><h3>Crédits</h3><p>Conception et production :</p><p>cette boutique en ligne a été créée à l\'aide du <a href=\"http://www.prestashop.com\">logiciel PrestaShop. </a>Rendez-vous sur le <a href=\"http://www.prestashop.com/blog/en/\">blog e-commerce de PrestaShop</a> pour vous tenir au courant des dernières actualités et obtenir des conseils sur la vente en ligne et la gestion d\'un site d\'e-commerce.</p>',1,'mentions, légales, crédits','mentions-legales',1,now()), 
(3, 'Conditions d\'utilisation','Nos conditions d\'utilisation','<h1 class=\"page-heading\">Conditions d\'utilisation</h1>
<h3 class=\"page-subheading\">Règle n° 1</h3>
<p class=\"bottom-indent\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<h3 class=\"page-subheading\">Règle n° 2</h3>
<p class=\"bottom-indent\">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>
<h3 class=\"page-subheading\">Règle n° 3</h3>
<p class=\"bottom-indent\">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>',1,'conditions, utilisation, vente','conditions-utilisation',1,now()), 
(4, 'A propos','En savoir plus sur notre entreprise','<h1 class=\"page-heading bottom-indent\">A propos</h1>



<h3 class=\"page-subheading\">Notre entreprise</h3>
<p><strong class=\"dark\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididun.</strong></p>
<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>
<ul class=\"list-1\">
<li>Produits haute qualité</li>
<li>Service client inégalé</li>
<li>Remboursement garanti pendant 30 jours</li>
</ul>




<h3 class=\"page-subheading\">Notre équipe</h3>

<p><strong class=\"dark\">Lorem set sint occaecat cupidatat non </strong></p>
<p>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>




<h3 class=\"page-subheading\">Témoignages</h3>

<span class=\"before\">“</span>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.<span class=\"after\">”</span>

<p><strong class=\"dark\">Lorem ipsum dolor sit</strong></p>

<span class=\"before\">“</span>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod.<span class=\"after\">”</span>

<p><strong class=\"dark\">Ipsum dolor sit</strong></p>


',1,'à propos, informations','a-propos',1,now()), 
(5, 'Paiement sécurisé','Notre méthode de paiement sécurisé','<h2>Paiement sécurisé</h2>
<h3>Notre paiement sécurisé</h3><p>Avec SSL</p>
<h3>Avec Visa/Mastercard/Paypal</h3><p>A propos de ce service</p>',1,'paiement sécurisé, ssl, visa, mastercard, paypal','paiement-securise',1,now());

-- --------------------------------------------------------

--
-- Contenu de la table `product_declinaisons`
--

INSERT INTO `product_declinaisons` (`id_declinaison`, `id_attribute`, `id_value`) VALUES   
(1,1,1), 
(2,1,1), 
(7,1,1), 
(8,1,1), 
(13,1,1), 
(16,1,1), 
(19,1,1), 
(20,1,1), 
(21,1,1), 
(22,1,1), 
(31,1,1), 
(34,1,1), 
(37,1,1), 
(40,1,1), 
(43,1,1), 
(3,1,2), 
(4,1,2), 
(9,1,2), 
(10,1,2), 
(14,1,2), 
(17,1,2), 
(23,1,2), 
(24,1,2), 
(25,1,2), 
(26,1,2), 
(32,1,2), 
(35,1,2), 
(38,1,2), 
(41,1,2), 
(44,1,2), 
(5,1,3), 
(6,1,3), 
(11,1,3), 
(12,1,3), 
(15,1,3), 
(18,1,3), 
(27,1,3), 
(28,1,3), 
(29,1,3), 
(30,1,3), 
(33,1,3), 
(36,1,3), 
(39,1,3), 
(42,1,3), 
(45,1,3), 
(16,3,7), 
(17,3,7), 
(18,3,7), 
(8,3,8), 
(10,3,8), 
(12,3,8), 
(40,3,8), 
(41,3,8), 
(42,3,8), 
(7,3,11), 
(9,3,11), 
(11,3,11), 
(22,3,11), 
(26,3,11), 
(30,3,11), 
(1,3,13), 
(3,3,13), 
(5,3,13), 
(13,3,13), 
(14,3,13), 
(15,3,13), 
(21,3,13), 
(25,3,13), 
(29,3,13), 
(2,3,14), 
(4,3,14), 
(6,3,14), 
(20,3,14), 
(24,3,14), 
(28,3,14), 
(37,3,15), 
(38,3,15), 
(39,3,15), 
(19,3,16), 
(23,3,16), 
(27,3,16), 
(31,3,16), 
(32,3,16), 
(33,3,16), 
(34,3,16), 
(35,3,16), 
(36,3,16), 
(43,3,24), 
(44,3,24), 
(45,3,24);

-- --------------------------------------------------------

--
-- Contenu de la table `declinaisons`
--

INSERT INTO `declinaisons` (`id`, `id_product`,  `reference`) VALUES  
(1,1,''), 
(2,1,''), 
(3,1,''), 
(4,1,''), 
(5,1,''), 
(6,1,''), 
(7,2,''), 
(8,2,''), 
(9,2,''), 
(10,2,''), 
(11,2,''), 
(12,2,''), 
(13,3,''), 
(14,3,''), 
(15,3,''), 
(16,4,''), 
(17,4,''), 
(18,4,''), 
(19,5,''), 
(20,5,''), 
(21,5,''), 
(22,5,''), 
(23,5,''), 
(24,5,''), 
(25,5,''), 
(26,5,''), 
(27,5,''), 
(28,5,''), 
(29,5,''), 
(30,5,''), 
(31,6,''), 
(32,6,''), 
(33,6,''), 
(34,7,''), 
(35,7,''), 
(36,7,''), 
(37,7,''), 
(38,7,''), 
(39,7,''), 
(40,6,''), 
(41,6,''), 
(42,6,''), 
(43,4,''), 
(44,4,''), 
(45,4,'');
UPDATE `declinaisons` d SET cu = (SELECT GROUP_CONCAT(concat(pd.`id_attribute`,':',pd.`id_value`) SEPARATOR  ',' ) as cu FROM `product_declinaisons` pd WHERE pd.`id_declinaison` = d.id);



-- --------------------------------------------------------

--
-- Contenu de la table `product_attributes`
--



-- --------------------------------------------------------

--
-- Contenu de la table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `name`, `id_attribute` , `id_lang`) VALUES  
(18,'35',2 ,1), 
(19,'36',2 ,1), 
(20,'37',2 ,1), 
(21,'38',2 ,1), 
(22,'39',2 ,1), 
(23,'40',2 ,1), 
(7,'Beige',3 ,1), 
(8,'Blanc',3 ,1), 
(9,'Blanc cassé',3 ,1), 
(14,'Bleu',3 ,1), 
(12,'Camel',3 ,1), 
(5,'Gris',3 ,1), 
(16,'Jaune',3 ,1), 
(3,'L',1 ,1), 
(2,'M',1 ,1), 
(17,'Marron',3 ,1), 
(11,'Noir',3 ,1), 
(13,'Orange',3 ,1), 
(24,'Rose',3 ,1), 
(10,'Rouge',3 ,1), 
(1,'S',1 ,1), 
(4,'Taille unique',1 ,1), 
(6,'Taupe',3 ,1), 
(15,'Vert',3 ,1);

-- --------------------------------------------------------

--
-- Contenu de la table `attributes`
--

INSERT INTO `attributes`(`id`, `name`, `id_lang`) VALUES  
(1,'Taille',1), 
(2,'Pointure',1), 
(3,'Couleur',1);

-- --------------------------------------------------------

--
-- Contenu de la table `cms_categories`
--

INSERT INTO `cms_categories` (`id`, `title`, `description`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES  
(1,'Accueil','','','accueil',1,now());

-- --------------------------------------------------------

--
-- Contenu de la table `product_category`
--

INSERT INTO `product_category` (`id_product`, `id_category`, `cdate`) VALUES  
(1,2,now()), 
(2,2,now()), 
(3,2,now()), 
(4,2,now()), 
(5,2,now()), 
(6,2,now()), 
(7,2,now()), 
(1,3,now()), 
(2,3,now()), 
(3,3,now()), 
(4,3,now()), 
(5,3,now()), 
(6,3,now()), 
(7,3,now()), 
(1,4,now()), 
(2,4,now()), 
(1,5,now()), 
(2,7,now()), 
(3,8,now()), 
(4,8,now()), 
(5,8,now()), 
(6,8,now()), 
(7,8,now()), 
(3,9,now()), 
(4,10,now()), 
(5,11,now()), 
(6,11,now()), 
(7,11,now());

-- --------------------------------------------------------

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `name`, `permalink`, `short_description`, `long_description`, `buy_price`, `sell_price`, `qty`, `ean13`, `upc`, `active`, `cdate`, `udate`, `id_lang`, `reference`,id_user,id_category_default,width,height, depth,weight,min_quantity,meta_title,meta_description,wholesale_per_qty,wholesale_price) VALUES  
(1,'T-shirt délavé à manches courtes','t-shirt-delave-manches-courtes','<p>T-shirt délavé à manches courtes et col rond. Matière douce et extensible pour un confort inégalé. Pour un look estival, portez-le avec un chapeau de paille !</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',4.950000,16.510000,0,'0','',1,'2016-06-02 11:04:17','2016-06-02 11:04:17','1','demo_1',1,5,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(2,'Chemisier','chemisier','<p>Chemisier à manches courtes drapées, pour un style féminin et élégant.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',8.100000,26.999852,0,'0','',1,'2016-06-02 11:04:18','2016-06-02 11:04:18','1','demo_2',1,7,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(3,'Robe imprimée','robe-imprimee','<p>Robe imprimée 100 % coton. Haut rayé noir et blanc et bas composé d\'une jupe patineuse taille haute.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',7.800000,25.999852,0,'0','',1,'2016-06-02 11:04:18','2016-06-02 11:04:18','1','demo_3',1,9,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(4,'Robe imprimée','robe-imprimee','<p>Robe de soirée imprimée à manches droites et volants, avec fine ceinture noire à la taille.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',15.300000,50.994153,0,'0','',1,'2016-06-02 11:04:18','2016-06-02 11:04:18','1','demo_4',1,10,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(5,'Robe d\'été imprimée','robe-ete-imprimee','<p>Longue robe imprimée à fines bretelles réglables. Décolleté en V et armature sous la poitrine. Volants au bas de la robe.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',9.150000,30.506321,0,'0','',1,'2016-06-02 11:04:19','2016-06-02 11:04:19','1','demo_5',1,11,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(6,'Robe d\'été imprimée','robe-ete-imprimee','<p>Robe en mousseline sans manches, longueur genoux. Décolleté en V avec élastique sous la poitrine.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',9.150000,30.502569,0,'0','',1,'2016-06-02 11:04:19','2016-06-02 11:04:19','1','demo_6',1,11,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(7,'Robe en mousseline imprimée','robe-mousseline-imprimee','<p>Robe en mousseline imprimée à bretelles, longueur genoux. Profond décolleté en V.</p>','<p>Fashion propose des vêtements de qualité depuis 2010. La marque propose une gamme féminine composée d\'élégants vêtements à coordonner et de robes originales et offre désormais une collection complète de prêt-à-porter, regroupant toutes les pièces qu\'une femme doit avoir dans sa garde-robe. Fashion se distingue avec des looks à la fois cool, simples et rafraîchissants, alliant élégance et chic, pour un style reconnaissable entre mille. Chacune des magnifiques pièces de la collection est fabriquée avec le plus grand soin en Italie. Fashion enrichit son offre avec une gamme d\'accessoires incluant chaussures, chapeaux, ceintures et bien plus encore !</p>',6.150000,20.501236,0,'0','',1,'2016-06-02 11:04:19','2016-06-02 11:04:19','1','demo_7',1,11,0.000000,0.000000,0.000000,0.000000,1,'','','',0);

-- --------------------------------------------------------

--
-- Contenu de la table `tags`
--



-- --------------------------------------------------------

--
-- Contenu de la table `product_tags`
--



-- --------------------------------------------------------

--
-- Contenu de la table `lang`
--

INSERT INTO `langs`(`id`, `code`, `name`) VALUES  
(1,'fr-fr','Français (French)');

-- --------------------------------------------------------

--
-- Contenu de la table `image`
--

INSERT INTO `product_images`(`name`, `position`, `id_product`, `cdate`,futured) VALUES  
('1.jpg',1,1,now(),1), 
('2.jpg',2,1,now(),0), 
('3.jpg',3,1,now(),0), 
('4.jpg',4,1,now(),0), 
('5.jpg',1,2,now(),0), 
('6.jpg',2,2,now(),0), 
('7.jpg',3,2,now(),1), 
('8.jpg',1,3,now(),1), 
('9.jpg',2,3,now(),0), 
('10.jpg',1,4,now(),1), 
('11.jpg',2,4,now(),0), 
('12.jpg',1,5,now(),1), 
('13.jpg',2,5,now(),0), 
('14.jpg',3,5,now(),0), 
('15.jpg',4,5,now(),0), 
('16.jpg',1,6,now(),1), 
('17.jpg',2,6,now(),0), 
('18.jpg',3,6,now(),0), 
('19.jpg',4,6,now(),0), 
('20.jpg',1,7,now(),1), 
('21.jpg',2,7,now(),0), 
('22.jpg',3,7,now(),0), 
('23.jpg',4,7,now(),0);