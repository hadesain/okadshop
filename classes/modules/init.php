<?php
// Hooks instance
$hooks = new Hooks();

// set multiple hooks to which module developers can assign functions
$hooks->set_hooks( $hooks->get_modules_sections() );

//default admin menu links
//you can add your custom links via modules
$os_admin_menu = new Menu;
$dashboard = $os_admin_menu->add('<i class="fa fa-dashboard"></i>'. l("Tableau de bord", "admin"), './index.php');

$os_products = $os_admin_menu->add('<i class="fa fa-book"></i>'. l("Catalogue", "admin"), '?module=products');
	$os_products->add( l("Produits", "admin"), '?module=products');
	$os_products->add( l("Catégories", "admin"), '?module=categories');
	$os_products->add( l("Fabricants", "admin"), '?module=manufacturers');
	$os_products->add( l("Attributs des produits", "admin"), '?module=attributes');
	$os_products->add( l("Valeurs des produits", "admin"), '?module=values');
	$os_products->add( l("Caractéristiques", "admin"), '?module=features');
	$os_products->add( l("Mots clés (Tags)", "admin"), '?module=tags');

$os_orders = $os_admin_menu->add('<i class="fa fa-credit-card"></i>'. l("Commandes", "admin"), '?module=orders');
	$os_orders->add( l("Commandes", "admin"), '?module=orders');
	$os_orders->add( l("Factures", "admin"), '?module=invoices');

$os_customers = $os_admin_menu->add('<i class="fa fa-users"></i>'. l("Clients", "admin"), '?module=users');
	$os_customers->add( l("Clients", "admin"), '?module=users');
	//$os_customers->add('Adresses', '?module=addresses');
	$os_customers->add( l("Groups", "admin"), '?module=groups');
	$os_customers->add( l("Contacts", "admin"), '?module=contacts');

$os_cart_rule = $os_admin_menu->add('<i class="fa fa-tags"></i>'. l("Promotions", "admin"), '?module=cart');
	$os_cart_rule->add( l("Règles panier", "admin"), '?module=cart');

$os_shipping = $os_admin_menu->add('<i class="fa fa-truck"></i>'. l("Livraison", "admin"), '?module=shipping');
	$os_shipping->add( l("Transporteurs", "admin"), '?module=shipping');
	$os_shipping->add( l("Ajouter un transport", "admin"), '?module=shipping&action=add');

$os_locale = $os_admin_menu->add('<i class="fa fa-globe"></i>'. l("Localisation", "admin"), '?module=countries');
	$os_locale->add( l("Langues", "admin"), '?module=langs');
  $os_locale->add( l("Pays", "admin"), '?module=countries');
	$os_locale->add( l("Devises", "admin"), '?module=currencies');
	$os_locale->add( l("Zones", "admin"), '?module=zones');
	$os_locale->add( l("Taxes", "admin"), '?module=taxes');
	$os_locale->add( l("Règles de taxes", "admin"), '?module=taxes_rules_group');

$os_preferences = $os_admin_menu->add('<i class="fa fa-cog"></i>'. l("Préférences", "admin"), '#');
	$os_preferences->add( l("Coordonnées et magasins", "admin"), '?module=stores' );
  $p_products = $os_preferences->add( l("Produits", "admin"), '#');
    $p_products->add( l("Ventes flash", "admin"), '?module=quick_sales' );
  $p_customers = $os_preferences->add( l("Clients", "admin"), '#');
    //$p_customers->add( l("Ventes flash", "admin"), '?module=quick_sales' );
  $p_payments = $os_preferences->add( l("Payments", "admin"), '#');
  $p_cms = $os_preferences->add( l("CMS", "admin"), '#');
    $p_cms->add( l("Pages", "admin"), '?module=cms');
    $p_cms->add( l("Catégories", "admin"), '?module=cms_categories');
  $p_theme = $os_preferences->add( l("Thèmes", "admin"), '#');
  $p_seo_url = $os_preferences->add( l("SEO & URL", "admin"), '?module=seo_url');

$os_modules = $os_admin_menu->add('<i class="fa fa-plug"></i>'. l("Modules et Services", "admin"), '?module=modules');
	$os_modules->add( l("Gestion des Modules", "admin"), '?module=modules');
	$os_modules->add( l("Positions", "admin"), '?module=modules&page=positions');

// load modules from folder, this method will load all *.module.php
$load_modules = $hooks->load_active_modules();

// register new hook from module files
function add_hook($where, $module="", $function, $description=""){
	global $hooks;
	$hooks->add_hook($where, $module, $function, $description);
}

// execute_section_hooks
function execute_section_hooks( $section ) {
	global $hooks;
  if ( $hooks->hooks_exist( $section ) ) {
    return $hooks->execute_hooks( $section );
  }
}

// allowed html tags method
function allowed_tags() {
  return '<img><strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre><iframe><script><div>';
}

// print menu items
function print_menu_items($items) {
	// Starting from items at root level
	if( !is_array($items) ) $items = $items->roots();
	// loop items
	$menu = '';
  $i = 1;
	foreach( $items as $item ) {
    $class = ( $item->hasChildren() ) ? 'class="dropdown-submenu"' : '';
		//$sub_id = ( $item->hasChildren() ) ? 'id="sub_'.$i.'"' : '';
		$menu .= '<li '. $class .'>';
		$menu .= '<a tabindex="-1" href="'. $item->link->get_url() .'">'.$item->link->get_text().'</a>';
		if( $item->hasChildren() ){
			$menu .= '<ul class="dropdown-menu">'. print_menu_items( $item->children() ) .'</ul>';
		}
		$menu .= '</li>';
    $i++;
	}
	return $menu;
}

//get cron job
function get_cron_job($name){
	global $common;
  $cron_job = $common->select('cron_job', array('name', 'cron_date', 'cron_time', 'active'), "WHERE name='". $name ."'");
  if( $cron_job[0] ) return $cron_job[0];
  return false;
}

//register cron job
function register_cron_job($name, $cron_date="", $cron_time, $active){
  if( empty($name) || empty($cron_time) || empty($active) ) return false;
  global $common;
  $cron_data = array('name' => $name, 'cron_date' => $cron_date, 'cron_time' => $cron_time, 'active' => $active);
  $id_cron 	 = $common->save('cron_job', $cron_data);
  if( $id_cron ) return $id_cron;
  return false;
}

//update cron job
function update_cron_job($name, $active, $cron_date="", $cron_time=""){
  if( empty($name) || $active < 0 || $active > 1 ) return false;
  $cron_data = array('active' => $active);
  if( $cron_data != "" ) $cron_data['cron_date'] = $cron_date;
  if( $cron_time != "" ) $cron_data['cron_time'] = $cron_time;
  global $common;
  $id_cron = $common->update('cron_job', $cron_data, "WHERE name='". $name ."'");
  if( $id_cron ) return $id_cron;
  return false;
}

//print styles
function os_header(){
	global $common;
	return $common->os_render_styles();
}

//print javascript
function os_footer(){
	global $common;
	return $common->os_render_scripts();
}

//return to dashboard
function go_dashboard(){
	$admin_dir = get_admin_dir();
	return _BASE_URL_. $admin_dir ."/index.php";
}

//get admin directory
function get_admin_dir(){
	global $common;
	return $common->get_admin_directory_name();
}