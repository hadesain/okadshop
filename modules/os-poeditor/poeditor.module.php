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


//register module
global $hooks;
$poeditor_data = array(
	"name" => "PO Editor",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "others",
	"version" => "1.0.0",
);
$hooks->register_module('os-poeditor', $poeditor_data);

//add menu link
global $os_locale;
$os_locale->add( l("Traductions", "poeditor"), '?module=modules&slug=os-poeditor&page=translations');

$mpath = dirname(__DIR__) ."/os-poeditor/";

//LOAD PAGE BY CONDITION
if( isset($_GET['slug']) && $_GET['slug'] == 'os-poeditor' ){
	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'translations' ){
			include 'pages/translations.php';
		}
	}
} 