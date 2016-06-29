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
$config_data = array(
	'name' => addslashes($_POST['name']),
	//'reference' => addslashes($_POST['reference']),
	'company' => addslashes($_POST['company']),
	'address_invoice' => addslashes($_POST['address_invoice']),
	'address_delivery' => addslashes($_POST['address_delivery']),
	'id_state' => intval($_POST['id_state']),
	'id_employee' => intval($_POST['id_employee']),
);
global $common;

if( $id_quotation < 1)
{
	$id_customer = intval($_POST['id_customer']);
	$config_data['id_customer'] = $id_customer;
	$insert = $common->save('quotations', $config_data);
	if( $insert ){
		$return['msg'] = "Le devis a été crée.";
		$return['id_quote'] = $insert;
		$return['id_customer'] = $id_customer;
		echo json_encode( $return );
	}
}else
{
	$update = $common->update('quotations', $config_data, 'WHERE id='.$id_quotation);
	if( $update ){
		$return['msg'] = l("La configuration a été mise a jour.", "quotation");
		echo json_encode( $return );
	}
}