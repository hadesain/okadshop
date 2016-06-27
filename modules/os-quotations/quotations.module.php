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

include 'classes/devis.class.php';

$module_path = dirname(__DIR__) ."/os-quotations/";

//register module infos
global $hooks;
$data = array(
	"name" => l("Devis sur mesure", "quotation"),
	"description" => l("Créer des Devis sur mesure.", "quotation"),
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "billing_invoicing",
	"version" => "1.0.0",
	"config" => "quote_settings"
);
$hooks->register_module('os-quotations', $data);

//Register a custom menu page.
global $os_admin_menu;
global $os_orders;
$os_quote = $os_admin_menu->add('<i class="fa fa-pencil-square-o"></i>'. l('Gestion des Devis', "quotation"), '?module=modules&slug=os-quotations&page=quotations');
$os_quote->add( l('Liste des Devis', "quotation"), '?module=modules&slug=os-quotations&page=quotations');
$os_quote->add( l('Ajouter un Devis', "quotation"), '?module=modules&slug=os-quotations&page=quote');
$os_quote->add( l('Devis abandonnés', "quotation"), '?module=modules&slug=os-quotations&page=quote-abandoned');
$os_quote->add( l('Paramètres de devis', "quotation"), '?module=modules&slug=os-quotations&page=quote_settings');
$os_quote->add( l('Statuts de devis', "quotation"), '?module=modules&slug=os-quotations&page=quote_states');

function os_quotations_install(){
	global $common;
	global $module_path;
	$file = $module_path .'db/quotation_tables.sql';
	$common->run_sql_file( $file );
}


//Back to quotations list
function back_to_quotations(){
	$quotations = 'index.php?module=modules&slug=os-quotations&page=quotations';
	return header('Location: '.$quotations);
}

/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'os-quotations' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'quote' || $_GET['page'] == 'quote' && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0 ){
			include 'pages/quote.php';
		}elseif( $_GET['page'] == 'quotations' ){
			include 'pages/quotations.php';
		}elseif( $_GET['page'] == 'quote_settings' ){
			include 'pages/settings.php';
		}elseif( $_GET['page'] == 'quote-abandoned' ){
			include 'pages/quote-abandoned.php';
		}elseif( $_GET['page'] == 'quote_states' ){
			include 'pages/quote-states.php';
		}
	}

/*============================================================*/
} //END CONDITIONS
/*============================================================*/



function os_display_waiting_quote(){
	global $common;
	$quotations_waiting = 0;
	$quotations = $common->select('quotations', array('COUNT(id) as count'), "WHERE id_state=1");
	if( !empty($quotations) ) $quotations_waiting = $quotations[0]['count'];
	$html .= '<li>
          <a href="?module=modules&slug=os-quotations&page=quotations">
            <i class="fa fa-pencil-square-o"></i>
            <span class="label label-danger">'. $quotations_waiting .'</span>
          </a>
        </li>';
  print $html;
}
add_hook('sec_admin_bar', 'os-quotations', 'os_display_waiting_quote', 'Display waiting quotations in admin Bar.');




//Relance devis abandonné
/*$cron = get_cron_job('abandoned_quote');
if( $cron['active'] == "1"){
	$current_time = date('H:i');
	$cron_time 		= date('H:i', strtotime( $cron['cron_time'] ) );
	if( $current_time == $cron_time ){
		global $DB;
		$query = "SELECT q.id as id_quote, q.reference, qs.name as state, u.last_name, u.email
					 		FROM quotations q, quotation_status qs, users u 
					 		WHERE q.id_state IN (3,4) AND q.id_state=qs.id AND u.id=q.id_customer";
		if($rows = $DB->query($query)){
		  $quotes = $rows->fetchAll(PDO::FETCH_ASSOC);
		  if( !empty($quotes) ){
		  	//$Mails		= new Mails();
		  	$headers  = "From: OkadShop < no-reply@okadshop.com>\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				$Sender 	= "no-reply@okadshop.com";
				$Subject 	= "OkadShop - Devis abandonné";

				foreach ($quotes as $key => $quote) {
		  		$Receiver = $quote['email'];
			    $Content  = 'Bonjour '. $quote['last_name'] .',<br><br>';
			    $Content .= 'Le devis N°'. $quote['id_quote'] .' avec le référence ['. $quote['reference'] .'] est abandonné.<br>';
			    $Content .= 'Le statut est : '. $quote['state'] .'<br><br>';
		    	$Content .= 'Cordialement.';
		    	//$sentmail = $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
		    	mail($Receiver,$Subject,$Content,$headers);
		  	}
		  }
		}
		//disable cron state
		update_cron_job('abandoned_quote', 0);
	}
}*/
