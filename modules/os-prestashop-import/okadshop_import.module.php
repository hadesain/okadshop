<?php  

require_once('php/function.php'); 

global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "Prestashop TO OkadShop",
	"description" => "Import From Prestashop to okadshop cms",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "administration",
	"version" => "1.0.0",
	"config" => "prestashop_import_settings"
);
$hooks->register_module('os-prestashop-import', $data);


function page_prestashop_import_settings(){
	global $hooks;
	$msg = "";
	$module_dir = dirname(__DIR__);
	if (isset($_POST['import_table_json']) && isset($_POST['website'])) {
		$website = $_POST['website'];
		if(import_table_json($website)){
			$msg = '<div class="alert alert-info" role="alert">Términé.</div>';
		}
	}
	if (isset($_POST['import_okadshop_file']) && isset($_FILES['okadshop_file']) && $_FILES['okadshop_file']['size']>0) {

		$prestashop_dir = dirname(__DIR__) .'/os-prestashop-import/php/prestashop/';
		//echo $prestashop_dir;
		rrmdir($prestashop_dir.'attachments');
		rrmdir($prestashop_dir.'category');
		rrmdir($prestashop_dir.'cms');
		rrmdir($prestashop_dir.'products');

		mkdir($prestashop_dir.'attachments', 777);
		mkdir($prestashop_dir.'category', 777);
		mkdir($prestashop_dir.'cms', 777);
		mkdir($prestashop_dir.'products', 777);

		$file_name = $_FILES['okadshop_file']['name'];

		$files = $_FILES['okadshop_file'];
		$uploadDir = "../modules/os-prestashop-import/";
		$extensions=array('zip');
		$res = $hooks->uploadFiles($files,$uploadDir,$extensions,1000);
		if ($res) {
			$zip = new ZipArchive;
			if ($zip->open($uploadDir.$file_name) === TRUE) {
			    $zip->extractTo($uploadDir.'php/prestashop/');
			    $zip->close();
			    $msg = '<div class="alert alert-info" role="alert">'.l('Términé','osprestashopimport').'.</div>';
			}else $msg = '<div class="alert alert-danger" role="alert">'.l('problème d\'extraction des fichiers','osprestashopimport').'.</div>';
		}else $msg = '<div class="alert alert-danger" role="alert">'.l('problème de téléchargement du fichier','osprestashopimport').'.</div>';
	}
	if (isset($_POST['import_table'])) {
			$importresult = prestashop_import_files();
			//$importresult = prestashop_import_table();
	}
	
	$output = "";
	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
							  <div class="top-menu padding0">
							    <div class="top-menu-title">
							      <h3><i class="fa fa-con" style="color: #002F86;"></i>  Prestashop Import</h3>
							    </div>
							  </div>';
	$output .= $msg;				  
	if (isset($importresult)) {
		if ($importresult) {
			$output .= '<div class="alert alert-info" role="alert">'.l('Importation Términé','osprestashopimport').'. <br> '.l('les Donnes imoprtée','osprestashopimport').':<br>';
			foreach ($importresult as $key => $value) {
				$output .=  '<b>'.$value.'</b><br>';
			}
			$output .= '</div>';
		}else{
			$output .= '<div class="alert alert-danger" role="alert">'.l('Erreur d\'Importation','osprestashopimport').'.</div>';
		}
	}
	$output .= '<div class="panel panel-default" style="margin-top:10px;">
							    <div class="panel-heading">
							      <h3 class="panel-title"><b style="color: #2F7DB2;">'.l('Etap','osprestashopimport').' 1 :</b>'.l('Importer le fichier','osprestashopimport').'  <span style="color: #2F7DB2;">okadshop_files.zip</span> :</h3>
							    </div>
							    <div class="panel-body">
							      <div class="form-group">
							        <label for="">'.l('Uploder le fichier','osprestashopimport').'</label>
							        <p><input class="form-control" type="file" name="okadshop_file" value="" /></p>
							      </div>
							      
							      <div class="form-group">
							        <input type="submit" class="btn btn-primary" class="form-control" name="import_okadshop_file" value="'.l('uploder','osprestashopimport').'"/>
							      </div>
							    </div>
							  </div>
							</form>
							<form method="POST" action=""  enctype="multipart/form-data">
							  <div class="panel panel-default" style="margin-top:10px;">
							    <div class="panel-heading">
							      <h3 class="panel-title"><b style="color: #2F7DB2;">'.l('Etap','osprestashopimport').' 2 :</b>'.l('Importaion vers','osprestashopimport').' OkadShop:</h3>
							    </div>
							    <div class="panel-body">
							    	<div class="alert alert-warning" role="alert">'.l('Continue seulement si la première étape est términé avec succès','osprestashopimport').'</div>
							    	<div class="form-group">
							        <p></p>
							        <label for="">
							        <input type="checkbox" required class="checkbox" style="display:inline-block"/> '.l('j\'accepte les condition','osprestashopimport').'.
							        </label>
							      </div>
							      <div class="form-group">
							        <input type="submit" class="btn btn-primary" class="form-control" name="import_table" value="'.l('Validé','osprestashopimport').'"/>
							      </div>
							    </div>
							  </div>
							</form>';
	echo $output;
}