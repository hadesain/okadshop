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

if (!defined('_OS_VERSION_'))
  exit;



//register module infos
global $hooks;
$analytics_data = array(
	"name" => l("Dashboard Analytics & Stats", "analytics"),
	"description" => l("Afficher les statistiques dans le tableau de bord.", "analytics"),
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "administration",
	"version" => "1.0.0",
  "config" => "analytics-config"
);
$hooks->register_module('os-analytics', $analytics_data);



//Register a custom menu page.
global $os_admin_menu;
$os_contact = $os_admin_menu->add('<i class="fa fa-bar-chart"></i>'.l("Google Analytics", "analytics"), '#');
$os_contact->add( l("Statistiques de Site", "analytics"), '?module=modules&slug=os-analytics&page=analytics');
$os_contact->add( l("Parametres", "analytics"), '?module=modules&slug=os-analytics&page=analytics-config');


/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'os-analytics' ){

  //we have a page in url !!!
  if( isset($_GET['page']) ){
    if( $_GET['page'] == 'analytics' ){
      include 'pages/analytics.php';
    }elseif( $_GET['page'] == 'analytics-config' ){
      include 'pages/analytics-config.php';
    }
  }

} //END CONDITIONS



function os_analytics_install(){
  //save_mete_value
  global $common;
  $common->save_mete_value('analytics_table_id', '');
  $common->save_mete_value('analytics_client_id', '');
}


//register scripts
if( defined('_OS_ADMIN_') && count($_GET) === 0 
  || isset($_GET['page']) && $_GET['page'] === "analytics"
  ){
  global $common;
  $common->os_inject_scripts( WebSite."modules/os-analytics/js/chart.min.js", 1);
  $common->os_inject_scripts( WebSite."modules/os-analytics/js/moment.min.js", 2);
  $common->os_inject_scripts( WebSite."modules/os-analytics/js/view-selector2.js", 3);
  //$common->os_inject_scripts( WebSite."modules/os-analytics/js/date-range-selector.js", 4);
  $common->os_inject_scripts( WebSite."modules/os-analytics/js/active-users.js", 5);
  $common->os_inject_scripts( WebSite."modules/os-analytics/js/os-analytics.js", 6);
  //set client and table id
  $table_id = $common->select_mete_value('analytics_table_id');
  $client_id = $common->select_mete_value('analytics_client_id');
  //append to body
  $doc = new DOMDocument();
  $doc->loadHTML('<html><body><input type="hidden" value="'.$table_id .'" id="table_id"><input type="hidden" value="'.$client_id.'" id="client_id"></body></html>');
  echo $doc->saveHTML();
}

//ga_this_last_week
function ga_this_last_week(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("Cette semaine vs la semaine dernière - Par sessions.", "analytics") .'</div>
      <div class="panel-body">
        <div id="week-chart"></div>
        <div id="week-legendr"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_this_last_week', l("Cette semaine vs la semaine dernière - Par sessions.", "analytics") );

//ga_this_last_year
function ga_this_last_year(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("Cette année vs année dernière - par les utilisateurs.", "analytics") .'</div>
      <div class="panel-body">
        <div id="year-chart"></div>
        <div id="year-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_this_last_year', l("Cette année vs année dernière - par les utilisateurs.", "analytics"));

//ga_top_browser
function ga_top_browser(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("Top Navigateurs - Par page vue.", "analytics") .'</div>
      <div class="panel-body">
        <div id="navigators-chart"></div>
        <div id="navigators-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_top_browser', l("Top Navigateurs - Par page vue.", "analytics"));

//ga_top_countries
function ga_top_countries(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("Principaux pays par Sessions - 30 derniers jours.", "analytics") .'</div>
      <div class="panel-body">
        <div id="countries-chart"></div>
        <div id="countries-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_top_countries', l("Principaux pays par Sessions - 30 derniers jours.", "analytics"));

//ga_site_traffic
function ga_site_traffic(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("Le trafic du site - Sessions vs Utilisateurs - 30 derniers jours.", "analytics") .'</div>
      <div class="panel-body">
        <div id="siteTraffic"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_site_traffic', l("Le trafic du site - Sessions vs Utilisateurs - 30 derniers jours.", "analytics"));

//ga_most_popular
function ga_most_popular(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">'. l("La plupart des Vues Popular page - 30 derniers jours.", "analytics") .'</div>
      <div class="panel-body">
        <div id="pageViews"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-analytics', 'ga_most_popular', l("La plupart des Vues Popular page - 30 derniers jours.", "analytics"));