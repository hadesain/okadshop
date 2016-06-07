<?php 
require_once '../../config/bootstrap.php';
$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('updateQtePrice_attributes','getcubyimg','getimgbycu')))
   $erreur=true;

   //récuperation des variables en POST ou GET
   $json = (isset($_POST['json'])? $_POST['json']:  (isset($_GET['json'])? $_GET['json']:null )) ;
   $product_id = (isset($_POST['product_id'])? $_POST['product_id']:  (isset($_GET['product_id'])? $_GET['product_id']:null )) ;
   $img_id = (isset($_POST['img_id'])? $_POST['img_id']:  (isset($_GET['img_id'])? $_GET['img_id']:null )) ;
   $cu = (isset($_POST['cu'])? $_POST['cu']:  (isset($_GET['cu'])? $_GET['cu']:null )) ;
   if (!$erreur){
      switch($action){
         case "updateQtePrice_attributes":
            $result = array();
            if ($json != null) {
               $json = json_decode($json);
               $product = new product();
               $tmp = $product->getDeclinaisonByCombinaison($json,$product_id);
               if ($tmp) {
                  $result = $tmp;
               }
            }
            echo json_encode($result);
            break;
         case 'getcubyimg':
            $result = array();
            if ($img_id != null && $product_id != null) {
               $product = new product();
               $tmp = $product->getcubyimg($img_id,$product_id);
               if ($tmp) {
                  $result = $tmp;
               }
            }
            echo json_encode($result);
            break;
         case 'getimgbycu':
            $result = array();
            if ($cu != null && $product_id != null) {
               $product = new product();
               $tmp = $product->getimgbycu($cu,$product_id);
               if ($tmp) {
                  $result = $tmp;
               }
            }
            echo json_encode($result);
            break;
         default:
            break;
      }
   }
    
}



 ?>