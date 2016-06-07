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


//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

include '../../../config/bootstrap.php';

//Prévoir module relance de bienvenue après X jours de l’ouverture de compte
$cron = get_cron_job('cron_welcome');
if( isset($cron) && $cron['active'] == "1"){
	$current_time = date('H:i');
	$cron_time 		= date('H:i', strtotime( $cron['cron_time'] ) );
	if( $current_time == $cron_time ){

		global $common;
		global $DB;
		$meta_value = $common->select_mete_value('relance_bienvenue');
		$query = "SELECT u.last_name, u.email, g.name as gender 
							FROM "._DB_PREFIX_."users u, "._DB_PREFIX_."gender g 
							WHERE u.cdate > DATE_SUB(NOW(), INTERVAL $meta_value DAY)
							AND u.id_gender=g.id";
		if($rows = $DB->query($query)){
		  $customers = $rows->fetchAll(PDO::FETCH_ASSOC);
		  if( !empty($customers) ){
		  	$headers  = "From: Maroc Artisana < no-reply@maroc-artiza.com>\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				$Sender 	= "no-reply@maroc-artiza.com";
				foreach ($customers as $key => $customer) {
		  		$Receiver = $customer['email'];
			    $Subject 	= "Maroc Artisana - Bienvenue";
			    $Content  = 'Bonjour '. $customer['gender'] .' '. $customer['last_name'] .',<br><br>';
			    $Content .= 'Merci d\'avoir inscrit sur la boutique Maroc Artisanat en ligne.<br>';
			    $Content .= 'Consulter nos promotions sur cette page : /views/promos.<br><br>';//'.5.'
		    	$Content .= 'Cordialement.';
					mail($Receiver,$Subject,$Content,$headers);
		  	}
		  }
		  echo "emails was sent.";
		}

	}
}