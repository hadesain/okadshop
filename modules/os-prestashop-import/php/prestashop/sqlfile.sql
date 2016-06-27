

-- --------------------------------------------------------

--
-- Contenu de la table `om_product_associated`
--



-- --------------------------------------------------------

--
-- Contenu de la table `om_categories`
--

INSERT INTO `om_categories`(`id`, `name`, `permalink`, `cdate`, `udate`, `id_lang`, `parent`, `description`,position , meta_title,meta_description,meta_keywords) VALUES  
(1,'Root','root','2014-06-22 00:04:43','2014-06-22 00:04:43',1,0,'',0,'','',''), 
(2,'Home','home','2014-06-22 00:04:43','2014-06-22 00:04:43',1,1,'',0,'','',''), 
(12,'LED Panels','led-panels','2015-04-18 12:42:45','2015-05-02 18:39:45',1,2,'',1,'','',''), 
(13,'CNC Router','cnc-router','2015-04-18 13:45:29','2015-05-02 16:27:45',1,16,'',2,'','',''), 
(14,'CNC Laser','cnc-laser','2015-04-18 13:45:51','2015-05-02 16:29:14',1,16,'',3,'','',''), 
(15,'CNC Plasma','cnc-plasma','2015-04-18 13:46:16','2015-05-02 16:24:09',1,16,'',1,'','',''), 
(16,'CNC Machines','cnc-machines','2015-04-18 13:46:53','2015-05-02 18:37:59',1,2,'',2,'','',''), 
(17,'CNC accessoires','cnc-accessoires','2015-04-18 13:48:47','2015-05-02 16:31:01',1,16,'',4,'','',''), 
(18,'After sales services','after-sales-services','2015-04-18 13:50:00','2015-05-02 16:32:37',1,16,'',5,'','','');

UPDATE `categories` SET `image_cat` ='13.jpg' WHERE `id` = 13;
UPDATE `categories` SET `image_cat` ='14.jpg' WHERE `id` = 14;
UPDATE `categories` SET `image_cat` ='15.jpg' WHERE `id` = 15;
UPDATE `categories` SET `image_cat` ='17.jpg' WHERE `id` = 17;
UPDATE `categories` SET `image_cat` ='18.jpg' WHERE `id` = 18;
UPDATE `categories` SET `image_cat` ='ar.jpg' WHERE `id` = 0;
UPDATE `categories` SET `image_cat` ='en.jpg' WHERE `id` = 0;
UPDATE `categories` SET `image_cat` ='fr.jpg' WHERE `id` = 0;


-- --------------------------------------------------------

--
-- Contenu de la table `om_product_attachments`
--



-- --------------------------------------------------------

--
-- Contenu de la table `om_cms`
--

INSERT INTO `om_cms` (id,`title`, `description`, `content`, `id_cmscat`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES  
(1, 'Delivery','Our terms and conditions of delivery','<h2>Shipments and returns</h2><h3>Your pack shipment</h3><p>Packages are generally dispatched within 2 days after receipt of payment and are shipped via UPS with tracking and drop-off without signature. If you prefer delivery by UPS Extra with required signature, an additional cost will be applied, so please contact us before choosing this method. Whichever shipment choice you make, we will provide you with a link to track your package online.</p><p>Shipping fees include handling and packing fees as well as postage costs. Handling fees are fixed, whereas transport fees vary according to total weight of the shipment. We advise you to group your items in one order. We cannot group two distinct orders placed separately, and shipping fees will apply to each of them. Your package will be dispatched at your own risk, but special care is taken to protect fragile objects.<br /><br />Boxes are amply sized and your items are well-protected.</p>',1,'conditions, delivery, delay, shipment, pack','delivery',1,now()), 
(2, 'Legal Notice','Legal notice','<h2>Legal</h2><h3>Credits</h3><p>Concept and production:</p><p>This Online store was created using <a href=\"http://www.prestashop.com\">Prestashop Shopping Cart Software</a>,check out PrestaShop\'s <a href=\"http://www.prestashop.com/blog/en/\">ecommerce blog</a> for news and advices about selling online and running your ecommerce website.</p>',1,'notice, legal, credits','legal-notice',1,now()), 
(3, 'Terms and conditions of use','Our terms and conditions of use','<h1 class=\"page-heading\">Terms and conditions of use</h1>
<h3 class=\"page-subheading\">Rule 1</h3>
<p class=\"bottom-indent\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<h3 class=\"page-subheading\">Rule 2</h3>
<p class=\"bottom-indent\">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>
<h3 class=\"page-subheading\">Rule 3</h3>
<p class=\"bottom-indent\">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>',1,'conditions, terms, use, sell','terms-and-conditions-of-use',1,now()), 
(4, 'About us','Learn more about us','<h1 class=\"page-heading bottom-indent\">About us</h1>



<h3 class=\"page-subheading\">Our company</h3>
<p><strong class=\"dark\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididun.</strong></p>
<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>
<ul class=\"list-1\">
<li>Top quality products</li>
<li>Best customer service</li>
<li>30-days money back guarantee</li>
</ul>




<h3 class=\"page-subheading\">Our team</h3>

<p><strong class=\"dark\">Lorem set sint occaecat cupidatat non </strong></p>
<p>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>




<h3 class=\"page-subheading\">Testimonials</h3>

<span class=\"before\">“</span>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.<span class=\"after\">”</span>

<p><strong class=\"dark\">Lorem ipsum dolor sit</strong></p>

<span class=\"before\">“</span>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod.<span class=\"after\">”</span>

<p><strong class=\"dark\">Ipsum dolor sit</strong></p>


',1,'about us, informations','about-us',1,now()), 
(5, 'Secure payment','Our secure payment mean','<h2>Secure payment</h2>
<h3>Our secure payment</h3><p>With SSL</p>
<h3>Using Visa/Mastercard/Paypal</h3><p>About this services</p>',1,'secure payment, ssl, visa, mastercard, paypal','secure-payment',1,now());

-- --------------------------------------------------------

--
-- Contenu de la table `om_product_declinaisons`
--



-- --------------------------------------------------------

--
-- Contenu de la table `om_declinaisons`
--



-- --------------------------------------------------------

--
-- Contenu de la table `om_product_attributes`
--



-- --------------------------------------------------------

--
-- Contenu de la table `om_attribute_values`
--

INSERT INTO `om_attribute_values` (`id`, `name`, `id_attribute` , `id_lang`) VALUES  
(1,'S',1 ,1), 
(2,'M',1 ,1), 
(3,'L',1 ,1), 
(4,'One size',1 ,1), 
(5,'Grey',3 ,1), 
(6,'Taupe',3 ,1), 
(7,'Beige',3 ,1), 
(8,'White',3 ,1), 
(9,'Off White',3 ,1), 
(10,'Red',3 ,1), 
(11,'Black',3 ,1), 
(12,'Camel',3 ,1), 
(13,'Orange',3 ,1), 
(14,'Blue',3 ,1), 
(15,'Green',3 ,1), 
(16,'Yellow',3 ,1), 
(17,'Brown',3 ,1), 
(18,'35',2 ,1), 
(19,'36',2 ,1), 
(20,'37',2 ,1), 
(21,'38',2 ,1), 
(22,'39',2 ,1), 
(23,'40',2 ,1), 
(24,'Pink',3 ,1);

-- --------------------------------------------------------

--
-- Contenu de la table `om_attributes`
--

INSERT INTO `om_attributes`(`id`, `name`, `id_lang`) VALUES  
(1,'Size',1), 
(2,'Shoes Size',1), 
(2,'Shoes Size',5), 
(3,'Color',1), 


-- --------------------------------------------------------

--
-- Contenu de la table `om_cms_categories`
--

INSERT INTO `om_cms_categories` (`id`, `title`, `description`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES  
(1,'Home','','','home',1,now()), 


-- --------------------------------------------------------

--
-- Contenu de la table `om_product_category`
--

INSERT INTO `om_product_category` (`id_product`, `id_category`, `cdate`) VALUES  
(12,2,now()), 
(13,2,now()), 
(14,2,now()), 
(15,2,now()), 
(16,2,now()), 
(17,2,now()), 
(18,2,now()), 
(19,2,now()), 
(20,2,now()), 
(21,2,now()), 
(22,2,now()), 
(12,12,now()), 
(13,12,now()), 
(14,12,now()), 
(15,12,now()), 
(17,13,now()), 
(18,13,now()), 
(19,13,now()), 
(20,14,now()), 
(21,14,now()), 
(22,14,now()), 
(16,15,now()), 
(16,16,now()), 
(17,16,now()), 
(18,16,now()), 
(19,16,now()), 
(20,16,now()), 
(21,16,now()), 
(22,16,now());

-- --------------------------------------------------------

--
-- Contenu de la table `om_products`
--

INSERT INTO `om_products` (`id`, `name`, `permalink`, `short_description`, `long_description`, `buy_price`, `sell_price`, `qty`, `ean13`, `upc`, `active`, `cdate`, `udate`, `id_lang`, `reference`,id_user,id_category_default,width,height, depth,weight,min_quantity,meta_title,meta_description,wholesale_per_qty,wholesale_price) VALUES  
(12,'Red LED Panels','led-panels','','',0.000000,20.000000,0,'0','',1,'2015-04-18 12:42:19','2016-03-09 17:26:37','1','LPR-1',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','1',0), 
(13,'Green LED Panels','green-led-panels','','',20.000000,20.000000,0,'0','',1,'2015-04-18 13:03:05','2015-10-27 11:53:45','1','LPG-1',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(14,'Blue LED Panels','blue-led-panels','','',0.000000,20.000000,0,'0','',1,'2015-04-18 14:07:58','2015-10-27 11:53:53','1','LPB-1',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(15,'White LED Panels','led-panels','','',0.000000,20.000000,0,'0','',1,'2015-04-18 14:57:36','2015-10-27 11:54:17','1','LPW-1',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','1',0), 
(16,'Cutting machine CNC plasma 1325','machine-de-decoupe-cnc-plasma-1325','','',0.000000,7000.000000,0,'0','',1,'2015-05-02 16:18:18','2015-10-27 11:56:14','1','CNC-P1325',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(17,'Cutting machine CNC router 1325','cutting-machine-cnc-plasma-1390','','',0.000000,105000.000000,0,'0','',1,'2015-05-02 16:40:58','2015-05-02 18:51:09','1','CNC-R1325',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(18,'Machine de découpe CNC router 6090','machine-de-decoupe-cnc-plasma-6090','','',0.000000,60000.000000,0,'0','',1,'2015-05-02 16:45:11','2015-05-02 18:51:25','1','CNC-R6090',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(19,'Cutting machine CNC router 1530','cutting-machine-cnc-plasma-1390','','',0.000000,120000.000000,0,'0','',1,'2015-05-02 17:10:27','2015-05-02 18:51:54','1','CNC-R1530',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(20,'Cutting machine CNC laser 6090','cutting-machine-cnc-router-1530','','',0.000000,60000.000000,0,'0','',1,'2015-05-02 17:44:28','2015-05-02 18:52:12','1','CNC-L6090',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(21,'Cutting machine CNC laser 1390','cutting-machine-cnc-router-1530','','',0.000000,85000.000000,0,'0','',1,'2015-05-02 17:52:24','2015-05-02 18:52:30','1','CNC-L1390',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0), 
(22,'Cutting machine CNC laser 1325','cutting-machine-cnc-router-1530','','',0.000000,11000.000000,0,'0','',1,'2015-05-02 17:59:34','2015-05-02 18:52:44','1','CNC-L1325',1,2,0.000000,0.000000,0.000000,0.000000,1,'','','',0);

-- --------------------------------------------------------

--
-- Contenu de la table `om_tags`
--

INSERT INTO `om_tags` (`id`,`name`,  `id_lang`, `cdate`) VALUES  
(1,'Morocco',1,now()), 
(2,'Maroc',1,now()), 
(3,'CNC cutting machine',1,now()), 
(4,'cnc cutting',1,now()), 
(5,'cnc 1325',1,now()), 
(6,'machine de découpe',1,now()), 
(7,'machine de découpe cnc',1,now()), 
(8,'cnc machine morocco',1,now()), 
(9,'cutting machine morocco',1,now()), 
(10,'cnc plasma 1390',1,now()), 
(11,'cnc plasma 1390 morocco',1,now()), 
(12,'cnc plasma morocco',1,now()), 
(13,'machine de découpe',4,now()), 
(14,'cnc plasma',4,now()), 
(15,'cnc maroc',4,now()), 
(16,'cncmorocco',4,now()), 
(17,'cnc plasma 1390',4,now()), 
(18,'maroc cnc',4,now()), 
(19,'morocco cnc',4,now()), 
(20,'cnc router',4,now()), 
(21,'cnc router 6090',4,now()), 
(22,'cnc router',1,now()), 
(23,'cnc router 1325',1,now()), 
(24,'cnc router morocco',1,now()), 
(25,'cnc router 1530',1,now()), 
(26,'cnc laser',1,now()), 
(27,'1325',1,now()), 
(28,'cnc laser 1325',1,now()), 
(29,'cnc laser',4,now()), 
(30,'laser 1325',4,now()), 
(31,'1325',4,now()), 
(32,'cnc laser 1325',4,now()), 
(33,'ألة تقطيع',5,now());

-- --------------------------------------------------------

--
-- Contenu de la table `om_product_tags`
--

INSERT INTO `om_product_tags` (`id_tag`, `id_product`, `cdate`) VALUES  
(1,16,now()), 
(2,16,now()), 
(3,16,now()), 
(4,16,now()), 
(5,16,now()), 
(5,22,now()), 
(6,16,now()), 
(7,16,now()), 
(8,16,now()), 
(9,16,now()), 
(22,17,now()), 
(22,19,now()), 
(23,17,now()), 
(24,17,now()), 
(24,19,now()), 
(25,19,now()), 
(26,20,now()), 
(26,21,now()), 
(26,22,now()), 
(27,22,now()), 
(28,22,now()), 
(13,18,now()), 
(15,18,now()), 
(16,18,now()), 
(18,18,now()), 
(19,18,now()), 
(20,18,now()), 
(21,18,now()), 
(29,22,now()), 
(30,22,now()), 
(31,22,now()), 
(32,22,now()), 
(33,16,now()), 
(33,17,now());

-- --------------------------------------------------------

--
-- Contenu de la table `om_lang`
--

INSERT INTO `om_langs`(`id`, `code`, `name`) VALUES  
(1,'en-us','English (English)'), 
(4,'fr-fr','Français (French)'), 
(5,'ar-sa','اللغة العربية (Arabic)');

-- --------------------------------------------------------

--
-- Contenu de la table `om_image`
--

INSERT INTO `om_product_images`(`name`, `position`, `id_product`, `cdate`,futured) VALUES  
('48.jpg',1,12,now(),1), 
('49.jpg',2,12,now(),0), 
('50.jpg',3,12,now(),0), 
('51.jpg',1,13,now(),1), 
('52.jpg',2,13,now(),0), 
('53.jpg',1,14,now(),1), 
('57.jpg',1,15,now(),1), 
('58.jpg',1,16,now(),1), 
('60.jpg',1,17,now(),1), 
('61.jpg',1,18,now(),1), 
('63.jpg',1,19,now(),1), 
('65.jpg',1,20,now(),1), 
('67.jpg',1,21,now(),1), 
('70.jpg',1,22,now(),1);