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

try {
	$id_carrier = intval($_POST['id_carrier']);
	if($id_carrier < 1) return;

	global $DB;
	$query = "SELECT c.name as carrier_name, c.max_delay, t.rate as tax_percent
						FROM "._DB_PREFIX_."carrier c, "._DB_PREFIX_."taxes t WHERE c.id=$id_carrier AND c.id_tax= t.id";
  if($res = $DB->query($query)){
    $carrier = $res->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($carrier[0]);
  }
} catch (Exception $e) {
	exit;
}