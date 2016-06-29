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
 * to license@okadshop.com so we can send you a copy.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    Moullablad <contact@moullablad.com>
 * @copyright 2016 Moullablad SARL
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
if (!defined('_OS_VERSION_'))
  exit;



$module_path = dirname(__DIR__) ."/os-featured-product/";

//register module infos
global $hooks;
$data = array(
	"name" => "featuredproduct",
	"description" => "featured product.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "billing_invoicing",
	"version" => "1.0.0",
	"config" => "featuredproduct_settings"
);
$hooks->register_module('os-featured-product', $data);


//Register a custom menu page.
/*global $os_admin_menu;
$os_lang = $os_admin_menu->add('<i class="fa fa-language"></i>OsLang', '?module=modules&slug=os-lang&page=oslang_product_translate');*/

function os_featured_product_install(){
	/*global $hooks;
	global $module_path;
	$file = $module_path .'db/oslang_tables.sql';
	$hooks->run_sql_file( $file );*/
}



/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'os-featured-product' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'featuredproduct_settings'){
			include 'pages/featuredproduct_settings.php';
		}
	}

/*============================================================*/
} //END CONDITIONS
/*============================================================*/