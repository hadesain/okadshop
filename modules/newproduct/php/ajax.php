<?php 

include '../../../config/bootstrap.php';
$erreur = false;
global $hooks;
$return = array();

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('newproduct_settings')))
    $erreur=true;


   if (!$erreur) {
      switch ($action) {
        case 'newproduct_settings':
          if (empty($_POST['nbproduct'])) {
            $return['error'] = l("Veuillez remplire tous les champs","newproduct");
          }else{
            if (isset($_POST['active'])) {
              $active  = 1;
            }else
              $active = 0;

            $hooks->save_mete_value('newproduct_nbproduct',$_POST['nbproduct']);
            $hooks->save_mete_value('newproduct_active',$active);
            
            $return['msg'] = l('Bien enregistré.',"newproduct");   
          }
          echo json_encode($return);
          break;
        default:
          # code...
          break;
      }
   }

}
?>
