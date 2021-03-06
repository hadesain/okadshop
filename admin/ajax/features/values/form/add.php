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

include '../../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//prepare vars
$id_lang = intval($_POST['id_lang']);
$id_feature = intval($_POST['id_feature']);
$value = $_POST['value'];
if( $id_lang < 1 || $id_feature < 1 || $value == "" ) return;

//prepare data
global $common;
global $_CONFIG;


//save feature
$id_value = $common->save("feature_value", array("id_feature" => $id_feature));
//add feature trans
if( $id_value ){
	foreach ($_CONFIG['lang_list'] as $key => $lang) {
		$common->save("feature_value_trans", array("id_value" => $id_value, "id_lang" => $lang['id'], "value" => $value));
	}
}
$return['id_feature'] = $id_feature;
$return['msg'] = l("La valeur a été bien enregistrer.", "admin");
echo json_encode( $return );