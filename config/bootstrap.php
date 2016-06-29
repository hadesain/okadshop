<?php
session_start();
//get project directory
$server_dir = explode('/', $_SERVER['REQUEST_URI']);
//config and defines
require_once 'config.inc.php';
$website_root = $_SERVER['DOCUMENT_ROOT']._BASE_URL_;
//$website_url  = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']._BASE_URL_;
$website_url  = 'http://'.$_SERVER['HTTP_HOST']._BASE_URL_;
require_once 'defines.inc.php';

//database class
require_once $website_root.'classes/db/db.class.php';
//class de cummon
require_once $website_root.'classes/common/common.class.php';

// Database insatnce
$DB = Database::getInstance(); 
// OS_Common insatnce
$common = new OS_Common();

//orders class
require_once $website_root.'classes/orders/orders.class.php';
//class des mails
require_once $website_root.'classes/mails/mails.class.php';
require_once $website_root.'classes/mails/PHPMailer/class.phpmailer.php';
//class de pdf
require_once $website_root.'classes/mpdf/mpdf.php';
//class table and forms
//require_once $website_root.'classes/forms/forms.class.php';
require_once $website_root.'classes/tables/tables.class.php';
//class browser for all browsers
//require_once $website_root.'classes/browser/Browser.php';
//class user and passwords
require_once $website_root.'classes/users/passwords.class.php';
require_once $website_root.'classes/users/users.class.php';
//class upload and resizer
require_once $website_root.'classes/jquery-filer/class.uploader.php';
require_once $website_root.'classes/image-workshop/ImageWorkshop.php';
require_once $website_root.'classes/resizer/resize.class.php';
//class de securite
require_once $website_root.'classes/dates/dates.class.php';
//products class
require_once $website_root.'classes/products/products.class.php';
//carrier class
require_once $website_root.'classes/carrier/carrier.class.php';
//Dynamic Menu Builder for Bootstrap 3
require_once $website_root.'classes/admin_menu/item.class.php';
require_once $website_root.'classes/admin_menu/link.class.php';
require_once $website_root.'classes/admin_menu/menu.class.php';
//class de modules
require_once $website_root.'classes/modules/modules.class.php';
require_once $website_root.'classes/modules/hooks.class.php';
require_once $website_root.'languages/gettext/gettext.inc';
require_once $website_root.'languages/i18n.php';
require_once $website_root.'classes/modules/init.php';

//feature class
require_once $website_root.'classes/features/features.class.php';

//front office classes
require_once $website_root.'classes/common.class.php';
require_once $website_root.'functions/geofunction.php';
require_once $website_root.'classes/account.class.php';
require_once $website_root.'classes/user.class.php';
require_once $website_root.'functions/functions.php';
//class de securite
require_once $website_root.'classes/security.class.php';
require_once $website_root.'classes/product.class.php';
require_once $website_root.'classes/pagination.class.php';
require_once $website_root.'classes/general.class.php';
include_once $website_root.'functions/fonctions-panier.php';
require_once $website_root.'classes/captcha/simple-php-captcha.php';





$CART = null;
if (creationPanier() && !isVerrouille())
{
	$CART = $_SESSION['panier'];
}

//change this to page404.php
$pageError = '<h1><i class="fa fa-exclamation-triangle"></i> Page Introvable</h1>';


//global vars
$defaul_currency = $common->select('currencies', array('sign'), "WHERE default_currency=1");
$defaul_currency = (isset($defaul_currency[0]['sign'])) ? $defaul_currency[0]['sign'] : "$";
$defaul_lang = $common->select('langs', array('id'), "WHERE default_lang=1 LIMIT 1");
$defaul_lang = (isset($defaul_lang[0]['id'])) ? $defaul_lang[0]['id'] : "0";
//current lang
$current_lang = $common->select('langs', array('id'), "WHERE code='". $os_lang ."' LIMIT 1");
$current_lang = (isset($current_lang[0]['id'])) ? $current_lang[0]['id'] : "0";
//langs list
$os_langs = $common->select('langs', array('id', 'code', 'name'), "WHERE active=1");


//defaults values
define("USER_ID", $_SESSION['admin']);
define("LANG_ID", $defaul_lang);
define("CURRENCY", $defaul_currency);

//os config
$_CONFIG = array(
	"lang_list" => $os_langs,
	"id_lang" 	=> $current_lang,
	"lang" 			=> $defaul_lang,
	"currency"  => $defaul_currency
);
