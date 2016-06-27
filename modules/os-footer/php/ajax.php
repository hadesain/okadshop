<?php 
require_once '../../../config/bootstrap.php';
require_once 'function.php';
$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('delete_footer_link')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   $id_link = (isset($_POST['id_link'])? $_POST['id_link']:  (isset($_GET['id_link'])? $_GET['id_link']:null )) ;
   

   if (!$erreur) {
   		switch ($action) {
   			case 'delete_footer_link':
               if ($id_link != null) {
                  $res = deleteLinkById($id_link);
                  if ($res) {
                     echo 1;
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