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


require_once('php/function.php'); 

$module_path = dirname(__DIR__);

global $hooks;
$data = array(
	"name" => "os-loyalty",
	"description" => "loyalty",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
	"config" => "loyalty-settings"
);
$hooks->register_module('os-loyalty', $data);

//Register a custom menu page.
global $os_customers;
global $p_customers;
$loyalty_p = $p_customers->add(l('Points de fidélité','osloyality'), '#');
$loyalty_p->add(l('Gestion des Points','osloyality'), '?module=modules&slug=os-loyalty&page=loyalty-points');
$loyalty_p->add(l('Paramètres','osloyality'), '?module=modules&slug=os-loyalty&page=loyalty-settings');
//$os_loyalty->add('Paramètres', '?module=modules&slug=os-loyalty&page=loyalty-settings');


function os_loyalty_install(){
	global $common;
	global $module_path;
	$file = $module_path .'/os-loyalty/db/loyalty_tables.sql';
	$common->run_sql_file( $file );
}


/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'os-loyalty' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'loyalty-settings' ){
			include 'pages/loyalty-settings.php';
		}elseif( $_GET['page'] == 'loyalty-points' ){
			include 'pages/loyalty-points.php';
		}
	}

} //END CONDITIONS