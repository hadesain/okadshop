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

include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//get posted data
$id_quotation = intval($_POST['id_quotation']);
if( $id_quotation < 1) return;
global $common;
$allowed_tags = allowed_tags();
$payment_choice = implode(",", $_POST['payment_choice']);

$terms_data = array(
	'total_letters' => addslashes($_POST['total_letters']),
	'payment_choice' => $payment_choice,
	'id_payment_method' => intval($_POST['id_payment_method']),
	'expiration_date' => addslashes($_POST['expiration_date']),
	'can_be_ordered' => intval($_POST['can_be_ordered']),
	'more_info' => strip_tags($_POST['more_info'], $allowed_tags)
);

$update = $common->update('quotations', $terms_data, 'WHERE id='.$id_quotation);
echo json_encode( l("Les conditions de vente ont été mise a jour.", "quotation") );