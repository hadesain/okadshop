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



include 'classes/contact.class.php';

$module_path = dirname(__DIR__);

//register module infos
global $hooks;
$data = array(
	"name" => l("Formulaire de Contact", "contact"),
	"description" => l("Afficher les emails envyé depuis le formulaire de contact.", "contact"),
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
	"config" => "contact_config"
);
$hooks->register_module('os-contact', $data);


//Register a custom menu page.
global $os_admin_menu;
$os_contact = $os_admin_menu->add('<i class="fa fa-envelope"></i>'.l("Formulaire de Contact", "contact"), '?module=modules&slug=os-contact&page=messages');
$os_contact->add( l("Liste des Messages", "contact"), '?module=modules&slug=os-contact&page=messages');
$os_contact->add( l("Paramètres de Messagerie", "contact"), '?module=modules&slug=os-contact&page=contact_config');



function os_contact_install(){
	global $common;
	global $module_path;
	$file = $module_path .'/os-contact/db/contact_tables.sql';
	$common->run_sql_file( $file );
}


/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'os-contact' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'messages' ){
			include 'pages/messages.php';
		}elseif( $_GET['page'] == 'view-message' ){
			include 'pages/view-message.php';
		}elseif( $_GET['page'] == 'contact_config' ){
			include 'pages/contact-config.php';
		}
	}

} //END CONDITIONS



function os_display_waiting_msgs(){
	global $common;
	$quotations_waiting = 0;
	$messages = $common->select('contact_messages', array('COUNT(id) as count'), "WHERE `from` <=> `id_sender` AND `viewed`=0");
	if( !empty($messages) ) $messages_waiting = $messages[0]['count'];
	$html .= '<li>
          <a href="?module=modules&slug=os-contact&page=messages">
            <i class="fa fa-envelope"></i>
            <span class="label label-danger">'. $messages_waiting .'</span>
          </a>
        </li>';
  print $html;
}
add_hook('sec_admin_bar', 'os-contact', 'os_display_waiting_msgs', 'Display waiting messages in admin Bar.');