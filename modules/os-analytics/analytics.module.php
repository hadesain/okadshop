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
  $common->save_mete_value('analytics_client_id', '');
}


//register scripts
global $common;
$common->os_inject_scripts( WebSite."modules/os-analytics/js/chart.min.js", 1);
$common->os_inject_scripts( WebSite."modules/os-analytics/js/moment.min.js", 2);
$common->os_inject_scripts( WebSite."modules/os-analytics/js/view-selector2.js", 3);
$common->os_inject_scripts( WebSite."modules/os-analytics/js/date-range-selector.js", 4);
$common->os_inject_scripts( WebSite."modules/os-analytics/js/active-users.js", 5);
$common->os_inject_scripts( WebSite."modules/os-analytics/js/os-analytics.js", 6);



//ga_this_last_week
function ga_this_last_week(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">This Week vs Last Week - By sessions.</div>
      <div class="panel-body">
        <div id="week-chart"></div>
        <div id="week-legendr"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_this_last_week', 'This Week vs Last Week - By sessions.');

//ga_this_last_year
function ga_this_last_year(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">This Year vs Last Year - By users.</div>
      <div class="panel-body">
        <div id="year-chart"></div>
        <div id="year-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_this_last_year', 'This Year vs Last Year - By users.');

//ga_top_browser
function ga_top_browser(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">Top Browsers - By pageview.</div>
      <div class="panel-body">
        <div id="navigators-chart"></div>
        <div id="navigators-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_top_browser', 'Top Browsers - By pageview.');

//ga_top_countries
function ga_top_countries(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">Top Countries by Sessions - Last 30 days.</div>
      <div class="panel-body">
        <div id="countries-chart"></div>
        <div id="countries-legend"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_top_countries', 'Top Countries by Sessions - Last 30 days.');

//ga_site_traffic
function ga_site_traffic(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">Site Traffic - Sessions vs. Users - last 30 days.</div>
      <div class="panel-body">
        <div id="siteTraffic"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_site_traffic', 'Site Traffic - Sessions vs. Users - last 30 days.');

//ga_most_popular
function ga_most_popular(){
  $html = '<div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading">Most Popular Pageviews - last 30 days.</div>
      <div class="panel-body">
        <div id="siteTraffic"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard','ga_most_popular', 'Most Popular Pageviews - last 30 days');

// <h3 id="view-name"></h3>


// <div id="embed-api-auth"></div>
// <div id="view-selector"></div>
// <div id="active-users"></div>

  // <!-- This Week vs Last Week - By sessions -->
  // <div id="week-chart"></div>
  // <div id="week-legendr"></div>

  // <!-- This Year vs Last Year - By users -->
  // <div id="year-chart"></div>
  // <div id="year-legend"></div>

  // <!-- Top Browsers - By pageview -->
  // <div id="navigators-chart"></div>
  // <div id="navigators-legend"></div>

  // <!-- Top Countries by Sessions - Last 30 days -->
  // <div id="countries-chart"></div>
  // <div id="countries-legend"></div>

// <!-- Toutes les données du site Web -->
// <div class="Titles-sub">Comparing sessions from <b id="date-rang"></b></div>
// <div id="sessions-chart"></div>
// <div id="sessions-range-selector"></div>

  // <hr>
  // <!-- Site Traffic - Sessions vs. Users - last 30 days -->
  // <div id="siteTraffic"></div>

  // <!-- Most Popular Demos/Tools - Pageviews - last 30 days -->
  // <div id="pageViews"></div>