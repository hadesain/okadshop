<?php header('Content-Type: text/html; charset=utf-8');
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

//class des mails
require_once '../../classes/mails/mails.class.php';


//send statistiques email
$mails    = new Mails();
$sender   = "no-reply@okadshop.com";
$receiver = "contact@okadshop.com";
$subject  = "New Okadshop installation";
$content  = '<strong>First name : </strong>'. $user['first_name'] .'<br>';
$content .= '<strong>Last name : </strong>'. $user['last_name'] .'<br>';
$content .= '<strong>Email : </strong>'. $user['email'] .'<br>';
$content .= '<strong>ID lang : </strong>'. $user['id_lang'] .'<br>';
$content .= '<strong>ID gender : </strong>'. $user['id_gender'] .'<br>';
$content .= '<strong>Shop name : </strong>'. $shop['name'] .'<br>';
$content .= '<strong>Home url : </strong>'. $shop['home_url'] .'<br>';
$content .= '<strong>ID activity : </strong>'. $shop['activity'] .'<br>';
$content .= '<strong>Country : </strong>'. $shop['country'] .'<br>';
$content .= '<strong>Created Date : </strong>'. date('Y-m-d H:s:m') .'<br>';

$mails->SendFastMail($sender, $receiver, $subject, $content);