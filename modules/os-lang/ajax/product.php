<?php 

include '../../../config/bootstrap.php';
$erreur = false;
global $hooks;
$return = array();

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('saveProductTranslate','getproducttext','search','saveCategoriesTranslate','getcategorytext','getcmstext','saveCmsTranslate')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   //$object = (isset($_POST['object'])? $_POST['object']:  (isset($_GET['object'])? $_GET['object']:null )) ;

   if (!$erreur) {
      switch ($action) {
        case 'saveProductTranslate':
          //echo $_POST['code_lang'];
          if (empty($_POST['id_product']) || empty($_POST['code_lang'])) {
            $return['error'] = l("Veuillez sélectionner le produit et la langue","oslang");
          }else{
            $condition = " WHERE id_product =".$_POST['id_product']." AND code_lang = '".$_POST['code_lang']."'";
            $oslang_product_item = $hooks->select('lang_product',array('*'),$condition);
            if ($oslang_product_item) {
              $data = array(
                "name" => $_POST['name'],
                "long_description" => $_POST['long_description'],
                "short_description" => $_POST['short_description'],
                "meta_title" => $_POST['meta_title'],
                "meta_description" => $_POST['meta_description'],
                "meta_keywords" => $_POST['meta_keywords']
              );
              $oslang_product_item = $hooks->update('lang_product',$data,$condition);
              $return['msg'] = l('La Traduction a été mise a jour.',"oslang");
            }else{
              $data = array(
                "id_product" => $_POST['id_product'],
                "code_lang" => $_POST['code_lang'],
                "name" => $_POST['name'],
                "long_description" => $_POST['long_description'],
                "short_description" => $_POST['short_description'],
                "meta_title" => $_POST['meta_title'],
                "meta_description" => $_POST['meta_description'],
                "meta_keywords" => $_POST['meta_keywords']
              );
              $oslang_product_item = $hooks->save('lang_product',$data);
              $return['msg'] = l('La Traduction a été bien ajouté.',"oslang");
            }
          }
          echo json_encode($return);
          break;
        case 'getproducttext':
          if (!empty($_POST['id_product']) && !empty($_POST['code_lang'])) {
            $condition = " WHERE id_product =".$_POST['id_product']." AND code_lang = '".$_POST['code_lang']."'";
            $oslang_product_item = $hooks->select('lang_product',array('*'),$condition);
            if (isset($oslang_product_item[0])) {
              $return['result'] = $oslang_product_item[0];
            }
          }
          echo json_encode($return);
          break;
        case 'search':
          if (!empty($_POST['search'])) {
            $name = strip_tags($_POST['search']);
            $name = addslashes($_POST['search']);
            $condition = " WHERE name LIKE '".$name."%' ORDER BY name ASC";
            $res = $hooks->select('products',array('id'),$condition);
            if (isset($res[0])) {
              $return['result'] = $res[0];
            }
          }
          echo json_encode($return);
          break;
        case 'saveCategoriesTranslate':
          if (empty($_POST['id_category']) || empty($_POST['code_lang'])) {
            $return['error'] = l("Veuillez sélectionner la categorie et la langue","oslang");
          }else{
            $condition = " WHERE id_category =".$_POST['id_category']." AND code_lang = '".$_POST['code_lang']."'";
            $oslang_product_item = $hooks->select('lang_category',array('*'),$condition);
            if ($oslang_product_item) {
              $data = array(
                "name" => $_POST['name'],
                "description" => $_POST['description']
              );
              $oslang_product_item = $hooks->update('lang_category',$data,$condition);
              $return['msg'] = l('La Traduction a été mise a jour.',"oslang");
            }else{
              $data = array(
                "id_category" => $_POST['id_category'],
                "code_lang" => $_POST['code_lang'],
                "name" => $_POST['name'],
                "description" => $_POST['description']
              );
              $oslang_product_item = $hooks->save('lang_category',$data);
              $return['msg'] = l('La Traduction a été bien ajouté.',"oslang");
            }
          }
          echo json_encode($return);
          break;
        case 'getcategorytext':
          if (!empty($_POST['id_category']) && !empty($_POST['code_lang'])) {
            $condition = " WHERE id_category =".$_POST['id_category']." AND code_lang = '".$_POST['code_lang']."'";
            $lang_category_item = $hooks->select('lang_category',array('*'),$condition);
            if (isset($lang_category_item[0])) {
              $return['result'] = $lang_category_item[0];
            }
          }
          echo json_encode($return);
          break;
        case 'getcmstext':
          if (!empty($_POST['id_cms']) && !empty($_POST['code_lang'])) {
            $condition = " WHERE id_cms =".$_POST['id_cms']." AND code_lang = '".$_POST['code_lang']."'";
            $oslang_cms_item = $hooks->select('lang_cms',array('*'),$condition);
            if (isset($oslang_cms_item[0])) {
              $return['result'] = $oslang_cms_item[0];
            }
          }
          echo json_encode($return);
          break;
        case 'saveCmsTranslate':
          if (empty($_POST['id_cms']) || empty($_POST['code_lang'])) {
            $return['error'] = l("Veuillez sélectionner la categorie et la langue","oslang");
          }else{
            $condition = " WHERE id_cms =".$_POST['id_cms']." AND code_lang = '".$_POST['code_lang']."'";
            $oslang_cms_item = $hooks->select('lang_cms',array('*'),$condition);
            if ($oslang_product_item) {
              $data = array(
                "title" => $_POST['title'],
                "description" => $_POST['description'],
                "content" => $_POST['content']
              );
              $oslang_cms_item = $hooks->update('lang_cms',$data,$condition);
              $return['msg'] = l('La Traduction a été mise a jour.',"oslang");
            }else{
              $data = array(
                "id_cms" => $_POST['id_cms'],
                "code_lang" => $_POST['code_lang'],
                "title" => $_POST['title'],
                "description" => $_POST['description'],
                "content" => $_POST['content']
              );
              $oslang_cms_item = $hooks->save('lang_cms',$data);
              $return['msg'] = l('La Traduction a été bien ajouté.',"oslang");
            }
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
