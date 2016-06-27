<?php
//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "os-configuration",
	"description" => "os-configuration",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "others",
	"version" => "1.0.0",
	"config" => "configuration_settings"
);
$hooks->register_module('os-configuration', $data);

function os_configuration_install(){
	global $DB;
		  $query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."configuration` (
		  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		  `name` varchar(255) NOT NULL,
		  `value` varchar(255) NOT NULL,
		  `more` varchar(255) NOT NULL,
		  `cdate` DATE NOT NULL,
		  `udate` DATE NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$DB->query($query);
}



global $p_theme;
$p_theme->add( l('Personalisation','configuration') , '?module=modules&slug=os-configuration&page=configuration_settings');


function page_configuration_settings(){
	$output = "";
	$msg = "";
	global $hooks;
	$logo_src = WebSite."themes/".themeFolder."/images/logo.png";
	$favicon = WebSite."themes/".themeFolder."/images/favicon.png";



	if ($_POST['validate_setting']) {

		if (isset($_FILES['logo']) && $_FILES['logo']['size']>0) {
			$allowed =  array('gif','png' ,'jpg');
			$filename = $_FILES['logo']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed) ) {
				$uploaddir = "../themes/".themeFolder."/images/";
				$uploadfile = $uploaddir . "logo.png";
				if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
					$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','configuration').'</div>';
				}
			}
		}

		if (isset($_FILES['favicon']) && $_FILES['favicon']['size']>0) {
			$allowed =  array('gif','png' ,'jpg');
			$filename = $_FILES['favicon']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed) ) {
				$uploaddir = "../themes/".themeFolder."/images/";
				$uploadfile = $uploaddir . "favicon.png";
				if (move_uploaded_file($_FILES['favicon']['tmp_name'], $uploadfile)) {
					$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','configuration').'</div>';
				}
			}
		}

		if (isset($_POST['vacances'])) {
			$hooks->save_mete_value("shop_is_vacance","1");
		}else{
			$hooks->save_mete_value("shop_is_vacance","0");
		}
		$hooks->save_mete_value("shop_is_vacance_return_date",$_POST['vacances_date']);
		$hooks->save_mete_value("panel_live",$_POST['panel_live']);
		$hooks->save_mete_value("website_title",$_POST['website_title']);
		$hooks->save_mete_value("displayPrice",$_POST['displayPrice']);
		$hooks->save_mete_value("selling_rule",$_POST['selling_rule']);
		$hooks->save_mete_value("top_header_description",$_POST['top_header_description']);
	}
	$vacances = $hooks->select_mete_value("shop_is_vacance");
	if ($vacances == '1') {
		$vacances = "checked";
	}else{
		$vacances = "";
	}
	$vacances_date = $hooks->select_mete_value("shop_is_vacance_return_date");
	$panel_live = $hooks->select_mete_value("panel_live");
	$website_title = $hooks->select_mete_value("website_title");
	$displayPrice = $hooks->select_mete_value("displayPrice");
	$selling_rule = $hooks->select_mete_value("selling_rule");
	$top_header_description = $hooks->select_mete_value("top_header_description");

	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
					<div class="top-menu padding0">
					  <div class="top-menu-title">
					    <h3><i class="fa fa-cog" style="color: #002F86;"></i> '.l('settings','configuration').'</h3>
					  </div>
					</div>
					<div class="panel panel-default" style="margin-top:10px;">
					  <div class="panel-heading">
					    <h3 class="panel-title"></h3>
					  </div>
					  <div class="panel-body">'.$msg .'

					  <div class="alert alert-success">Rafraicher la page après le changement de logo</div>
					  	
					  	<div class="form-group">
							<label for="owner">'.l('Logo de site','configuration').'</label>
							<p><input class="form-control" type="file" name="logo" value=""/></p>
							<img class="form-control" alt="" src="'.$logo_src.'" style="width:180px;height:50px;">
						</div>
						<div class="form-group">
							<label for="owner">'.l('favicon','configuration').'</label>
							<p><input class="form-control" type="file" name="favicon" value=""/></p>
							<img class="" alt="" src="'.$favicon.'">
						</div>
						<div class="form-group">
				          <label class="control-label" for="website_title">'.l('Title de site','configuration').'</label>  
				          <p>
				            <input name="website_title" type="text" class="form-control" id="website_title" value="'.$website_title.'">
				          </p>
				        </div>
				        <div class="form-group">
				          <label class="control-label" for="displayPrice">'.l('Affichier le Prix dans Votre Boutique','configuration').'</label>  
				          <p>
				            <select name="displayPrice">
				            	<option value="no">'.l('Non','configuration').'</option>
				            	<option value="yes">'.l('Oui','configuration').'</option>
				            	<option value="connected">'.l('seulement si connecté','configuration').'</option>
				            </select>
				          </p>
				        </div>
				        <div class="form-group">
				          <label class="control-label" for="selling_rule">'.l('Règle de vente','configuration').'</label>  
				          <p>
				            <select name="selling_rule">
				            	<option value="cart">'.l('Avec panier classique','configuration').'</option>
				            	<option value="quotation">'.l('Demande de devis','configuration').'</option>
				            	<option value="off">'.l('désactiver la vente','configuration').'</option>
				            </select>
				          </p>
				        </div>
						<div class="form-group">
							<label for="owner">'.l('Mode "Vacances"','configuration').'</label>
							<p><input class="form-control" type="checkbox" name="vacances" '.$vacances.'/></p>
						</div>
						<div class="form-group">
				          <label class="control-label" for="vacances_date">'.l('Date de Retour','configuration').'</label>  
				          <p>
				            <input name="vacances_date" type="text" class="form-control datepicker" id="vacances_date" value="'.$vacances_date.'">
				          </p>
				        </div>
				        <div class="form-group">
				          <label class="control-label" for="panel_live">'.l('Période de vie de panier (min).','configuration').'</label>  
				          <p>
				            <input name="panel_live" type="text" class="form-control" id="panel_live" value="'.$panel_live.'">
				          </p>
				        </div>
				        <div class="form-group">
				          <label class="control-label" for="top_header_description">'.l('top header description : .','configuration').'</label>  
				          <p>
				            <input name="top_header_description" type="text" class="form-control" id="top_header_description" value="'.$top_header_description.'">
				          </p>
				        </div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary save-setting" class="form-control" name="validate_setting" value="'.l('Enregistrer','configuration').'"/>
						</div>
					  </div>
					</div>
	          
					</form>';
	echo $output;
	echo '<script type="text/javascript">
		$(document).ready(function(){
			$("[name=vacances]").bootstrapSwitch();
			$("[name=displayPrice]").val("'.$displayPrice.'");
			$("[name=selling_rule]").val("'.$selling_rule.'");
		});
	</script>';
}

