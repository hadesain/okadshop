<?php require_once 'php/function.php';

//register module infos
global $hooks;
$data = array(
	"name" => "mandatpostal",
	"description" => "mandat postal payments gateway.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "payments_gateways",
	"version" => "1.0.0",
	"config" => "mandatpostal_settings"
);
$hooks->register_module('os-mandatpostal', $data);

function os_mandatpostal_install(){
	global $DB;
	$query = "DELETE FROM `"._DB_PREFIX_."payment_methodes` WHERE value = 'Mandat Postal'";
	$DB->query($query);
	
	$query = "INSERT INTO `"._DB_PREFIX_."payment_methodes` (`value`, `description`, `image`) VALUES ( 'Mandat Postal', 'Payer par Mandat Postal', 'modules/os-mandatpostal/assets/images/mandatpostal.png');";
	$DB->query($query);
}
function mandatpostal_paymentdisplay(){
	$quotation_edit = _GET('quotation_edit'); 
	if (!$quotation_edit) {
		return;
	}

	/*$quotation =  getQuotationById($_SESSION['idquotation'],'',$_SESSION['user']);
	var_dump($quotation);
	if (!isset($quotation['total_devis'])) {
		return;
	}*/
	global $hooks;
	$quotation =  $hooks->get_quotation($quotation_edit,$_SESSION['user']);
	if (!isset($quotation['total'])) {
		return;
	}
	if ($quotation['status']['slug'] != 'quote_available') {
		return;
	}
	$output = "";
	/* <img alt="Payer par Mandat Postal" height="49" src="'.WebSite.'modules/os-mandatpostal/assets/images/mandatpostal.jpg" width="110">*/
	$output .= '<form method="POST" action=""  enctype="multipart/form-data" id="mandatpostal_form">
								<input type="hidden" name="mandatpostal" />
								<p class="payment_module">
							    <a href="javascript:;" title="'.l('Payer par Mandat Postal International','oslmandatpostal').'" id="send_mandatpostal">
							      '.l('Payer par Mandat Postal International','oslmandatpostal').'
							    </a>
							  </p>
							</form>';
	if (isset($_POST['mandatpostal'])) {
		$output .= '<div class="payment_detail">
						<form method="POST" action=""  enctype="multipart/form-data">
							<img alt="'.l('Payer par virement bancaire','oslmandatpostal').'" height="49" src="'.WebSite.'modules/os-mandatpostal/assets/images/mandatpostal.jpg" width="110"> '.l('Vous avez choisi de régler votre commande par Mandat Postal International.','oslmandatpostal').' 
							<div class="row">
								<div class="col-xs-12"><br><u>'.l('Veuillez trouver ci-dessous les informations nécessaires pour établir le transfert :','oslmandatpostal').'</u></div>
								<div class="col-xs-12">
								<br>
								<ul class="list-group">
								  <li class=""><b></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""><b>Montant du transfert :</b> '.$quotation['total']['tht'].' €</li>
								</ul>
								<br>'.l('Un email contenant ces informations vous a été envoyé.','oslmandatpostal').' 
								<br><br>
									<div class="alert alert-danger">
										'.l('Merci de nous communiquer votre confirmation pour le','oslmandatpostal').' '.$quotation['quotation']['expiration_date'].' '.l('au plus tard.','oslmandatpostal').'
									</div>
									<br><b>'.l('Votre commande sera enregistrée dès réception de votre transfert.','oslmandatpostal').'</b> <br>
									'.l('Dans l’attente, notre service client se tient à votre entière disposition pour toute question ou information complémentaire.','oslmandatpostal').'<br>
								</div>
							</div>
						</form>
					</div><br><br>';
		$output .= "<script>setTimeout(function(){ 
			$('html,body').animate({
	        scrollTop: $('.payment_detail').offset().top},
	        'slow');
		}, 1000);</script>";
	}

	echo $output;
	?>
	<script type="text/javascript" src="<?= WebSite ?>modules/os-mandatpostal/assets/js/script.js"></script>
	<?php
}
add_hook('sec_payment_list','mandatpostal_paymentdisplay');



function page_mandatpostal_settings(){
	$output = "";
	$msg = "";
	global $hooks;
	if (isset($_POST['validate_mandatpostal'])) {
		$hooks->save_mete_value('mandatpostal_owner',$_POST['mandatpostal_owner']);
		$hooks->save_mete_value('mandatpostal_detail',$_POST['mandatpostal_detail']);
		$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','oslmandatpostal').'</div>';
	}
	
	$mandatpostal_owner = $hooks->select_mete_value('mandatpostal_owner');
	$mandatpostal_detail = $hooks->select_mete_value('mandatpostal_detail');

	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
					<div class="top-menu padding0">
					  <div class="top-menu-title">
					    <h3><i class="fa fa-cog" style="color: #002F86;"></i> '.l('Mandat Postal','oslmandatpostal').'</h3>
					  </div>
					</div>
					<div class="panel panel-default" style="margin-top:10px;">
					  <div class="panel-heading">
					    <h3 class="panel-title">'.l('Mandat Postal DETAILS','oslmandatpostal').'</h3>
					  </div>
					  <div class="panel-body">'.$msg .'
					  	
					  	<div class="form-group">
							<label for="owner">'.l('Propriétaire','oslmandatpostal').'</label>
							<p><input class="form-control" type="text" name="mandatpostal_owner" value="'.$mandatpostal_owner .'"/></p>
						</div>
						<div class="form-group">
							<label for="owner">'.l('Détails','oslmandatpostal').'</label>
							<p>
							<textarea rows="3"  class="form-control" name="mandatpostal_detail" >'.$mandatpostal_detail .'</textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary save-setting" class="form-control" name="validate_mandatpostal" value="'.l('Enregistrer','oslmandatpostal').'"/>
						</div>
					  </div>
					</div>
	          
					</form>';
	echo $output;
}