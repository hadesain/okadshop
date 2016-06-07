<?php 
require_once '../../../config/bootstrap.php';
require_once 'function.php';
$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('addproducttoquotation')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   $idproduct = (isset($_POST['idproduct'])? $_POST['idproduct']:  (isset($_GET['idproduct'])? $_GET['idproduct']:null )) ;

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
   			default:
   				echo 0;
   				break;
   		}
   }

}
?>