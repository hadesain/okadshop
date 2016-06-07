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


//register module infos
global $hooks;
$product_data = array(
	"name" => l("Products Fast Edit", "fast_edit"),
	"description" => l("Module permettant la modification rapide des caractéristiques produits.", "fast_edit"),
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "others",
	"version" => "1.0.0",
);
$hooks->register_module('os-fast-product-edit', $product_data);


//Register a custom menu page.
global $p_products;
$p_products->add( l("Édition rapide des produits", "fast_edit"), '?module=modules&slug=os-fast-product-edit&page=product-edit');
$p_products->add( l("Gestion de Nouveaté produit", "fast_edit"), '?module=modules&slug=os-fast-product-edit&page=new-product');


//LOAD PAGE BY CONDITION
if( isset($_GET['slug']) && $_GET['slug'] == 'os-fast-product-edit' ){
	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'product-edit' ){
			include 'pages/product-edit.php';
		}elseif( $_GET['page'] == 'new-product' ){
			include 'pages/new-product.php';
		}
	}
}
