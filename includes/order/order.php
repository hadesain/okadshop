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

include '../../config/bootstrap.php';


$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('getOrder','getAdresse','getProductOrder')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   $order_id = (isset($_POST['order_id'])? $_POST['order_id']:  (isset($_GET['order_id'])? $_GET['order_id']:null )) ;
   $idadress = (isset($_POST['idadress'])? $_POST['idadress']:  (isset($_GET['idadress'])? $_GET['idadress']:null )) ;
   if (!$erreur) {
   		switch ($action) {
   			case 'getOrder':
               if (isset($_SESSION['user']) && $order_id != null) {
                  $condition = ' AND id_customer = '.$_SESSION['user'];
                  $res = getOrderById($order_id,$condition);
                  if ($res) {
                     echo json_encode($res);
                  } else echo 0;
               } else echo 0;
   				break;
   			case 'getAdresse':
               if (isset($_SESSION['user']) && $idadress != null) {
                 $res =  getUserAdresse($_SESSION['user'],$idadress);
                  if ($res) {
                     echo json_encode($res);
                     if (isset($_POST['setSession']) && !empty($_POST['setSession'])) {
                        $_SESSION[$_POST['setSession']] = $res['id'];
                     }
                  } else echo 0;
               }else echo 0;
               break;
            case 'getProductOrder':
               if ($order_id != null) {
                     $res =  getProductOrder($order_id);
                     if ($res) {
                     echo json_encode($res);
                  } else echo 0;
               }else echo 0;
               break;
   			default:
   				echo 0;
   				break;
   		}
   }

}
?>