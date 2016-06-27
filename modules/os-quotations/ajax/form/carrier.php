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
$id_quotation_carrier = intval($_POST['id_quotation_carrier']);
if( $id_quotation < 1 ) return;

global $common;
$allowed_tags = allowed_tags();

$carrier_data = array(
	'id_carrier' => intval($_POST['id_carrier']),
	'carrier_name' => addslashes($_POST['carrier_name']),
	'shipping_costs' => floatval($_POST['shipping_costs']),
	'min_delay' => intval($_POST['min_delay']),
	'max_delay' => intval($_POST['max_delay']),
	'delay_type' => intval($_POST['delay_type']),
	'min_prepa' => intval($_POST['min_prepa']),
	'max_prepa' => intval($_POST['max_prepa']),
	'prepa_type' => intval($_POST['prepa_type']),
	'weight_including_packing' => floatval($_POST['weight_including_packing']),
	'number_packages' => intval($_POST['number_packages']),
	'more_info' => strip_tags($_POST['more_info'], $allowed_tags)
);

if( $id_quotation_carrier < 1 ){
	$carrier_data['id_quotation'] = $id_quotation;
	$update = $common->save('quotation_carrier', $carrier_data);
	echo json_encode( l("Le transporteur été souvegarder avec success.", "quotation") );
}else{
	$update = $common->update('quotation_carrier', $carrier_data, 'WHERE id_quotation='.$id_quotation);
	echo json_encode( l("Le transporteur été mise a jour.", "quotation") );
}