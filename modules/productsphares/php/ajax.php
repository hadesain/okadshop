<?php 
require_once '../../../config/bootstrap.php';
require_once 'function.php';
$erreur = false;
global $hooks;
$return = array();
$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('addproducttoquotation','delete_home_product','saveProductHome')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   $idproduct = (isset($_POST['idproduct'])? $_POST['idproduct']:  (isset($_GET['idproduct'])? $_GET['idproduct']:null )) ;
   $idproduct_delete = (isset($_POST['idproduct_delete'])? $_POST['idproduct_delete']:  (isset($_GET['idproduct_delete'])? $_GET['idproduct_delete']:null )) ;

   if (!$erreur) {
   		switch ($action) {
   			case 'addproducttoquotation':
               if (isset($_SESSION['user']) && $idproduct != null) {
                  $res = addProductToQuotation($idproduct,$condition,$_SESSION['user']);
                  if ($res) {
                     echo json_encode($res);
                  } else echo 0;
               } else echo 0;
   				break;
            case 'delete_home_product':
               if ($idproduct_delete != null) {
                 $res = $hooks->delete('home_product',' WHERE id_product = '.$idproduct_delete);
                // var_dump($res);
                 if ($res) $return["msg"] = "Bien Supprimé";
               }
               if (!isset($return["msg"])) {
                  $return["error"] = "Non supprimé!!";
               }
               echo json_encode($return);
               break;
            case 'saveProductHome':
               if (empty($_POST['id_product'])) {
                   $return["error"] = "Sélectionnez un produit";
               }else{
                  $tmp =  $hooks->select('home_product',array('*'),' WHERE id_product = '.$_POST['id_product']);
                  if ($tmp) {
                     $return["error"] = "Produit deja ajouté";
                  }else{
                     $data = array(
                        "id_product" => $_POST['id_product'],
                        "position" => 1
                     );
                     $res = $hooks->save('home_product',$data);
                     if ($res) $return["msg"] = "Bien Ajouté";
                     if (!isset($return["msg"])) {
                        $return["error"] = "Non Ajouté!!";
                     }
                  }
               }
               echo json_encode($return);
               break;
   			default:
   				//echo 0;
   				break;
   		}
   }

}
?>