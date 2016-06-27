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

$id = intval($_POST['id']);
$name = addslashes($_POST['name']);
$slug = addslashes($_POST['slug']);
if($name == "" || $slug  == "") return;

global $common;
if( $id < 1 ){
	$insert = $common->save("quotation_status", array('name' => $name, 'slug' => $slug));
	if( $insert ){
		echo json_encode( l("Le statut a été ajouter avec success.", "quotation") );	
	}
}else{
	$update = $common->update("quotation_status", array('name' => $name), "WHERE id=".$id);
	if( $update ){
		echo json_encode( l("Le statut a été mise a jour.", "quotation") );	
	}
}