<?php
if (!defined('_OS_VERSION_'))
  exit;

  
//register module infos
global $hooks;
$data = array(
	"name" => "bankwire",
	"description" => "Virement Bancaire.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "payments_gateways",
	"version" => "1.0.0",
);
$hooks->register_module('bankwire', $data);

function bankwire_install(){
	global $DB;
	$query = "DELETE FROM `"._DB_PREFIX_."payment_methodes` WHERE value = 'Virement bancaire'";
	$DB->query($query);
	
	$query = "INSERT INTO `"._DB_PREFIX_."payment_methodes` (`value`, `description`, `image`) VALUES ( 'Virement bancaire', 'Payer par virement bancaire', 'modules/bankwire/assets/images/bankwire.jpg');";
	$DB->query($query);
}
require_once 'php/function.php';

function front_bankwire_confirm(){
	include 'pages/bankwire_confirm.php';
}
function bankwire_paymentdisplay(){

	global $hooks;
	$output = "";
	$output .= '<form method="POST" action="'.WebSite.'front/bankwire_confirm"  enctype="multipart/form-data" id="bankwire_form">
								<input type="hidden" name="bankwire" />
								<p class="payment_module">
									<img src="../modules/bankwire/assets/images/bankwire.jpg" style="width:86px;height:49px;"/>
							    <a href="javascript:;" title="'.l('Payer par virement bancaire','bankwire').'" id="send_bankwire">
							       '.l('Payer par Virement Bancaire','bankwire').'
							    </a>
							  </p>
							</form>';
			
	echo $output;
	?>
	<script type="text/javascript" src="<?= WebSite ?>modules/bankwire/assets/js/script.js"></script>
	<?php
}
add_hook('sec_payment_list', 'bankwire', 'bankwire_paymentdisplay', 'bankwire payment display');

global $p_payments;
$p_payments->add( l("bankwire setting", "bankwire"), '?module=modules&slug=bankwire&page=bankwiresetting');
function page_bankwiresetting(){
	$msg = "";
	if (isset($_POST['validate_bankwire'])){
		$res = false;
		$res = bw_save_mete_value("bankwire_owner",$_POST['owner']);
		$res = bw_save_mete_value("bankwire_details",$_POST['details']);
		$res = bw_save_mete_value("bankwire_adresse",$_POST['adresse']);
		if ($res) {
			$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','bankwire').'</div>';
		}
	}

	$bankwire_owner = bw_select_mete_value("bankwire_owner");
	$bankwire_details = bw_select_mete_value("bankwire_details");
	$bankwire_adresse = bw_select_mete_value("bankwire_adresse");

	$output  = "";
	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
						<div class="top-menu padding0">
						  <div class="top-menu-title">
						    <h3><i class="fa fa-dollar"></i> '.l('Virement Bancaire','bankwire').' : '.l('Configuration','bankwire').'</h3>
						  </div>
						</div>
						<div class="panel panel-default" style="margin-top:10px;">
						  <div class="panel-heading">
						    <h3 class="panel-title">'.l('Contact detail','bankwire').'</h3>
						  </div>
						  <div class="panel-body">'.$msg .'
						    <div class="form-group">
									<label for="owner">'.l('Propriétaire du compte','bankwire').' </label>
									<p><input type="text" name="owner" value="'.$bankwire_owner.'"/></p>
								</div>
								<div class="form-group">
									<label for="details">'.l('details','bankwire').' </label>
									<p class="textarea">
							      <textarea cols="60" id="details" name="details" rows="3">'.$bankwire_details.'</textarea>
							    </p>
								</div>
								<div class="form-group">
									<label for="adresse">'.l('Adresse de la banque','bankwire').' </label>
									<p class="textarea">
							      <textarea cols="60" id="adresse" name="adresse" rows="3">'.$bankwire_adresse.'</textarea>
							    </p>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary add-product" name="validate_bankwire"/>
								</div>
						  </div>
						</div>
		          
						</form>';
	echo $output;
}