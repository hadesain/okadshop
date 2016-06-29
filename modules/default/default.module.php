<?php
if (!defined('_OS_VERSION_'))
  exit;

//global vars
global $common;


/**
 * register module infos
 **/
global $hooks;
$module_data = array(
	"name" => l("Default Module", "default"),
	"description" => l("Module de démonstration.", "default"),
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
  "config" => "welcome"
);
$hooks->register_module('default', $module_data);



/**
 * Register a custom menu page.
 **/
global $os_admin_menu;
$default = $os_admin_menu->add('<i class="fa fa-puzzle-piece"></i>'.l("Default Module", "default"), '#');
  $default->add( l("Config Page", "default"), '?module=modules&slug=default&page=welcome');



/**
 * get current page content
 **/
$pages = array('welcome');
$common->get_module_page_content($pages);


/**
 * module install
 **/
function default_install(){
  global $common;
  $common->save_mete_value('default_welcome_message', 'Hello World!!');
}


/**
 * module uninstall
 **/
function default_uninstall(){
  global $common;
  $common->delete('meta_value', 'WHERE name="default_welcome_message"');
}


/**
 * register module styles and scripts
 **/
$common->os_inject_scripts( _BASE_URL_."modules/default/js/scripts.js", 1);
$common->os_inject_styles( _BASE_URL_."modules/default/css/styles.css", 1);


/**
 * register module hook
 **/
function welcome_message(){
  global $common;
  $message = $common->select_mete_value('default_welcome_message');

  $html = '<div class="panel panel-default">
      <div class="panel-heading">'. l("Default Module", "default") .'</div>
      <div class="panel-body">
        '.$message.'
      </div>
    </div>';
  print $html;
}
add_hook('sec_sidebar', 'default', 'welcome_message', l("Afficher un message de bienvenue dans le sidebar.", "default") );


