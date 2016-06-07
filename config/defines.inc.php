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

//set global
date_default_timezone_set('Africa/Casablanca');

//defines
define('APP','OkadShop CMS');
define('DS','/');
define('WSDIR', $server_dir[1].DS );
define('HOME_URL', $website_url );
define('WEBROOT',  $website_root );
define('ROOTPATH',  $website_root );
/*$l_sign = "";
if (isset($_SESSION['code_lang'])) {
	$l_sign = explode('_', $_SESSION['code_lang'])[0].'/';
}*/
define('WebSite', $website_url);

//Modules directory
define('DOMAIN', $website_root . 'languages/locale');
define("MODULES_PATH", $website_root . 'modules/');
define('THEME_DIR', 'themes/tesla/');
define('themeFolder', 'tesla');
//MAX  MEMORY SIZE
define("MAX_SIZE", ini_get('post_max_size'));

//defaults values
define("USER_ID", 1);
define("LANG_ID", 1);
define("CURRENCY", "€");

//front office
define('themeDir', $website_url . 'themes/tesla/');
//echo WebSite;

//global vars
$themeDir = $website_url.'themes/tesla/';

//front office
//get this from database
//define('WebSite', 'http://192.168.1.50:81/okadshop/');
//date_default_timezone_set('Africa/Casablanca');
//define('website_dir','okadshop');
//define('WSDIR',website_dir.'/');
//
//define("ROOTPATH",$_SERVER["DOCUMENT_ROOT"] . '/' . WSDIR);
//define("MODULES_PATH",$_SERVER["DOCUMENT_ROOT"] . '/'.WSDIR.'modules/');
//$themeDir = WebSite.'themes/'.themeFolder.'/';
//themeDir