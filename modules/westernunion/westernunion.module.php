<?php require_once 'php/function.php';

//register module infos
global $hooks;
$data = array(
	"name" => "Western union",
	"description" => "Western union payments gateway.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "payments_gateways",
	"version" => "1.0.0",
	"config" => "westernunion_settings"
);
$hooks->register_module('westernunion', $data);

function westernunion_install(){
	global $DB;
	$query = "DELETE FROM `"._DB_PREFIX_."payment_methodes` WHERE value = 'Western Union'";
	$DB->query($query);
	
	$query = "INSERT INTO `"._DB_PREFIX_."payment_methodes` (`value`, `description`, `image`) VALUES ( 'Western Union', 'Payer par Western Union', 'modules/westernunion/assets/images/western.png');";
	$DB->query($query);
}
function western_paymentdisplay(){
	$quotation_edit = _GET('quotation_edit'); 
	if (!$quotation_edit) {
		return;
	}

	/*$quotation =  getQuotationById($_SESSION['idquotation'],'',$_SESSION['user']);
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
	/*<img alt="Payer par Western Union" height="49" src="'.WebSite.'modules/westernunion/assets/images/western.png" width="110">*/
	$output .= '<form method="POST" action=""  enctype="multipart/form-data" id="western_form">
								<input type="hidden" name="western" />
								<p class="payment_module">
							    <a href="javascript:;" title="" id="send_western">
							       '.l('Payer par','westernunion').' Western Union 
							    </a>
							  </p>
							</form>';
	if (isset($_POST['western'])) {
		$output .= '<div class="payment_detail">
						<form method="POST" action=""  enctype="multipart/form-data">
							<img alt="Payer par virement bancaire" height="49" src="'.WebSite.'modules/westernunion/assets/images/western.png" width="110"> '.l('Vous avez choisi de régler votre commande par','westernunion').' Western Union. 
							<div class="row">
								<div class="col-xs-12"><br><u>'.l('Veuillez trouver ci-dessous les informations nécessaires pour établir le transfert','westernunion').' :</u></div>
								<div class="col-xs-12">
								<br>
								<ul class="list-group">
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""></li>
								  <li class=""><b>Montant du transfert :</b> '.$quotation['total']['tht'].' €</li>
								</ul>
								<br>'.l('Un email contenant ces informations vous a été envoyé','westernunion').'. 
								<br><br>
									<div class="alert alert-danger">
										'.l('Merci de nous communiquer votre confirmation pour le','westernunion').' '.$quotation['quotation']['expiration_date'].' '.l('au plus tard','westernunion').'.
									</div>
									<br><b>'.l('Votre commande sera enregistrée dès réception de votre transfert','westernunion').'.</b> <br>
									'.l('Dans l’attente, notre service client se tient à votre entière disposition pour toute question ou information complémentaire','westernunion').'.<br>
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
	<script type="text/javascript" src="<?= WebSite ?>modules/westernunion/assets/js/script.js"></script>
	<?php
}
add_hook('sec_payment_list','western_paymentdisplay');

function page_westernunion_settings(){
	$output = "";
	$msg = "";
	global $hooks;
	if (isset($_POST['validate_western'])) {
		$hooks->save_mete_value('western_owner',$_POST['western_owner']);
		$hooks->save_mete_value('western_detail',$_POST['western_detail']);
		$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','westernunion').'</div>';
	}
	
	$western_owner = $hooks->select_mete_value('western_owner');
	$western_detail = $hooks->select_mete_value('western_detail');

	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
					<div class="top-menu padding0">
					  <div class="top-menu-title">
					    <h3><i class="fa fa-cog" style="color: #002F86;"></i> Western Union</h3>
					  </div>
					</div>
					<div class="panel panel-default" style="margin-top:10px;">
					  <div class="panel-heading">
					    <h3 class="panel-title">Western Union '.l('DETAILS','westernunion').'</h3>
					  </div>
					  <div class="panel-body">'.$msg .'
					  	
					  	<div class="form-group">
							<label for="owner">'.l('Propriétaire','westernunion').'</label>
							<p><input class="form-control" type="text" name="western_owner" value="'.$western_owner .'"/></p>
						</div>
						<div class="form-group">
							<label for="owner">'.l('Détails','westernunion').'</label>
							<p>
							<textarea rows="3"  class="form-control" name="western_detail" >'.$western_detail .'</textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary save-setting" class="form-control" name="validate_western" value="'.l('Enregistrer','westernunion').'"/>
						</div>
					  </div>
					</div>
	          
					</form>';
	echo $output;
}