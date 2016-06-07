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

include '../../../config/bootstrap.php';


//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

$email = $_POST['email'];
$from = intval($_POST['from']);
if( $email == "" ) return;

global $common;
$user = new user();
$cm = $common->select('contact_messages', array('firstname', 'lastname', 'email', 'city', 'mobile', 'id_country'), "WHERE `email`='". $email ."' ORDER BY id DESC LIMIT 1");
if( !$cm ) return;

//prepare customer data
$customer['clt_number'] = $user->get_customer_number();
$customer['first_name'] = $cm[0]['firstname'];
$customer['last_name']  = $cm[0]['lastname'];
$customer['email'] 			= $cm[0]['email'];
$customer['password'] 	= md5( $cm[0]['lastname'] );
$customer['mobile'] 		= $cm[0]['mobile'];
$customer['city'] 			= $cm[0]['city'];
$customer['id_country'] = $cm[0]['id_country'];
$customer['user_type']  = "user";
$customer['id_gender']  = 1;
$customer['id_group'] 	= 2;
$customer['id_lang'] 	 	= 1;
$customer['active'] 		= 1;

//save new customer
$save = $common->save('users', $customer);
if( $save ) {

	$Mails    = new Mails();
  $Sender   = "no-reply@demo.com";
  $Receiver = $cm[0]['email'];
  $Subject  = "demo - Compte ouverte";
  $Content  = 'Bonjour '. $cm[0]['lastname'] .',<br><br>';
  $Content .= "Félicitation votre compte a été bien crée. <br>Nous vous remercions de vous être inscrit(e)";
  $sentmail = $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
  if( $sentmail ){
    echo "done";
  }

}