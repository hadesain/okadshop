<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */

$Args = array(
	'Select' => array(
		'id'=>  _DB_PREFIX_.'products.id',
		'picture'=> "(select concat('../files/products/', "._DB_PREFIX_."products.id,'/dashboard-', "._DB_PREFIX_."products.id,'.jpg') from "._DB_PREFIX_."product_images where "._DB_PREFIX_."product_images.futured = 1 and "._DB_PREFIX_."product_images.id_product = "._DB_PREFIX_."products.id)",
		'name'=>  _DB_PREFIX_.'products.name',
		'buy_price'=>'buy_price',
		'sell_price'=>'sell_price',
		'qty'=>'qty',
		'active'=>'1',
		'langs'=>  _DB_PREFIX_.'langs.name'
	),
	'From' => array( _DB_PREFIX_.'products'),
	'Where' => array(
			//array(_DB_PREFIX_.'product_images.futured','=',1)
		),
	'Join' => array(
		array( _DB_PREFIX_.'users',  _DB_PREFIX_.'users.id',  _DB_PREFIX_.'products.id_user', 'left'),
		array( _DB_PREFIX_.'langs',  _DB_PREFIX_.'langs.id',  _DB_PREFIX_.'products.id_lang', 'left')
	),
	'Module'=> array('products', l('Gestion des Produits', "admin") ),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Image", "admin"),
		l("Nom de produit", "admin"),
		l("Prix d\'achat", "admin"),
		l("Prix de vente", "admin"),
		l("Quantité", "admin"),
		l("Statut", "admin"),
		l("Langue", "admin"),
		l("Operations", "admin"),
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l('Ajouter un Produit', "admin"),'?module=products&action=add','add_nw','add button', l('Ajouter un Produit', "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>

