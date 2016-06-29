<?php 
if(!file_exists('config/config.inc.php'))
{
 header('location:install/index.php');
}

require_once 'config/bootstrap.php';

//check if we request admin directory
global $common;
$admin_dir = $common->get_admin_directory_name();
if( isset($_GET['Module']) && $_GET['Module'] == $admin_dir ){
	echo '<script>window.location.href="'._BASE_URL_. $admin_dir ."/index.php".'"</script>';
	exit;
}

require_once 'includes/cart/cart.php';

$account = new account();
$product = new product();
/*$selling_rule = selling_rule();
$cart = array();
$cart['selling_rule'] = $selling_rule;
switch ($selling_rule) {
	case 'quotation':
		$cart['info']['title'] = l("Mon devis", "okadshop");
		$cart['active'] = true;
		break;
	case 'cart':
		$cart['info']['title'] = l("Panier", "okadshop");
		$cart['active'] = true;
		break;
	default:
		$cart['info']['title'] = "";
		$cart['active'] = false;
		break;
}*/
//var_dump($_GET);
require_once THEME_DIR.'/header.php';
if (isset($_GET['Module']) && !empty($_GET['Module'])) {
	$Module = $_GET['Module'];
	switch ($Module) {
		case 'front':
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				$function = 'front_'.$_GET['ID'];
				if(function_exists($function)){
					$function();
				}else echo $pageError;
			}else echo $pageError;
			break;
		case 'contact':
			$contact_file =  THEME_DIR.'/modules/pages/contact.php';
			if (file_exists($contact_file)) {
				require_once $contact_file;
			}else echo $pageError;
			break;
		case 'sitemap':
			$sitemap_file =  THEME_DIR.'/modules/pages/sitemap.php';
			if (file_exists($sitemap_file)) {
				require_once $sitemap_file;
			}else echo $pageError;
			break;
		case 'account':
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				$Page = $_GET['ID'];
				switch ($Page) {
					case 'register':
						$resultregister = $account->register();//check register submit
						require_once THEME_DIR.'/modules/account/register.php';
						break;
					case 'login':
						$loginresult = $account->login();//check login submit
						require_once THEME_DIR.'/modules/account/login.php';
						break;
					case 'logout':
						$account->logout();
						break;
					case 'password':
						require_once THEME_DIR.'/modules/account/password.php';
						break;
					case 'history':
						require_once THEME_DIR.'/modules/account/history.php';
						break;
					case 'quotation':
						require_once THEME_DIR.'/modules/account/quotation.php';
						break;
					case 'invoices':
						require_once THEME_DIR.'/modules/account/invoices.php';
						break;
					case 'order-follow':
						require_once THEME_DIR.'/modules/account/order-follow.php';
						break;	
					case 'order-slip':
						require_once THEME_DIR.'/modules/account/order-slip.php';
						break;
					case 'addresses':
						require_once THEME_DIR.'/modules/account/addresses.php';
						break;
					case 'identity':
						require_once THEME_DIR.'/modules/account/identity.php';
						break;	
					case 'discount':
						require_once THEME_DIR.'/modules/account/discount.php';
						break;
					case 'loyalty-program':
						require_once THEME_DIR.'/modules/account/loyalty-program.php';
						break;
					case 'referralprogram-program':
						require_once THEME_DIR.'/modules/account/referralprogram-program.php';
						break;
					case 'myalerts':
						require_once THEME_DIR.'/modules/account/myalerts.php';
						break;
					case 'adresse':
						require_once THEME_DIR.'/modules/account/adresse.php';
						break;	
					default:
						echo $pageError;
						break;
				}
			}else
				require_once THEME_DIR.'/modules/account/account.php';
			break;
		case 'product':
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				$productdetail = $product->getProductIdFromLink($_GET['ID']);
				if ($productdetail) {
					require_once THEME_DIR.'/modules/product/product.php';
				}else echo $pageError;
			} else echo $pageError;
			break;
		case 'category':
			require_once THEME_DIR.'/modules/product/category.php';
			break;
		case 'order':
			require_once THEME_DIR.'/modules/order/order.php';
			break;
		case 'cart':
			goConnected();
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				switch ($_GET['ID']) {
					case 'adresse':
						require_once THEME_DIR.'/modules/order/adresse.php';
						break;
					case 'livraison':
						require_once THEME_DIR.'/modules/order/livraison.php';
						break;
					case 'capture':
						require_once THEME_DIR.'/modules/order/capture.php';
						break;
					case 'paiement':
						if (isset($_GET['ID2']) && !empty($_GET['ID2'])) {
							switch ($_GET['ID2']) {
								case 'cheque':
									require_once THEME_DIR.'/modules/order/cheque.php';
									break;
								default:
									echo $pageError;
									break;
							}
						}else{
							require_once THEME_DIR.'/modules/order/paiement.php';
						}
						
						break;
					case 'order-confirmation':
						require_once THEME_DIR.'/modules/order/order-confirmation.php';
						break;
					default:
						echo $pageError;
						break;
				}
				
			}else{
				require_once THEME_DIR.'/modules/order/cart.php';
			}
			break;
		case 'cms': 
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				if ($_GET['ID'] == "sitemap") {
					$cms_file =  THEME_DIR.'/modules/pages/'.$_GET['ID'].'.php';
					if (file_exists($cms_file)) {
						require_once $cms_file;
					}else echo $pageError;
				}else if ($_GET['ID'] == "contact") {
					$cms_file =  THEME_DIR.'/modules/pages/'.$_GET['ID'].'.php';
					if (file_exists($cms_file)) {
						require_once $cms_file;
					}else echo $pageError;
				}else{
					$cms_id = $_GET['ID'];
					require_once THEME_DIR.'/modules/cms/cms.php';
				}
			}
			break;
		case 'search':
			require_once THEME_DIR.'/modules/search/search.php';
			break;
		case 'views':
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				$dir = THEME_DIR.'/views/'.$_GET['ID'].'.php';
				if (file_exists($dir)) {
					require_once $dir;
				}else
					echo $pageError;
			}
			else
				echo $pageError;
			break;
		default:
			echo $pageError;
			break;
	}
}
else{
	require_once THEME_DIR.'/index.php';
}

require_once THEME_DIR.'/footer.php';
?>