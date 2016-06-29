<?php
if (!defined('_OS_VERSION_'))
  exit;


require_once('php/function.php'); 

//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "PayPal Express",
	"description" => "PayPal Express.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "payments_gateways",
	"version" => "1.0.0",
	"config" => "paypalsetting"
);
$hooks->register_module('paypalexpress', $data);


function paypalexpress_install(){
	  global $DB;
		  $query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."paypal_module` (
		  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		  `TOKEN` varchar(255) NOT NULL,
		  `BILLINGAGREEMENTACCEPTEDSTATUS` varchar(255) NOT NULL,
		  `TIMESTAMP` varchar(255) NOT NULL,
		  `CORRELATIONID` varchar(255) NOT NULL,
		  `ACK` varchar(255) NOT NULL,
		  `VERSION` varchar(255) NOT NULL,
		  `BUILD` varchar(255) NOT NULL,
		  `EMAIL` varchar(255) NOT NULL,
		  `PAYERID` varchar(255) NOT NULL,
		  `PAYERSTATUS` varchar(255) NOT NULL,
		  `FIRSTNAME` varchar(255) NOT NULL,
		  `LASTNAME` varchar(255) NOT NULL,
		  `COUNTRYCODE` varchar(255) NOT NULL,
		  `CUSTOM` varchar(255) NOT NULL,
		  `cdate` DATE NOT NULL,
		  `udate` DATE NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$DB->query($query);

	$query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."paypalexpress_setting` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	  `username` varchar(255) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `signature` varchar(255) NOT NULL,
	  `cdate` DATE NOT NULL,
		`udate` DATE NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$DB->query($query);
	
	$query = "DELETE FROM `"._DB_PREFIX_."payment_methodes` WHERE value = 'PayPal'";
	$DB->query($query);

	$query = "INSERT INTO `"._DB_PREFIX_."payment_methodes` (`value`, `description`, `image`) VALUES ( 'PayPal', 'Payer par PayPal', 'modules/paypalexpress/assets/images/paypal.png');";
	$DB->query($query);


	$query = "INSERT INTO `"._DB_PREFIX_."paypalexpress_setting` (`id`, `username`, `password`, `signature`) VALUES (NULL, '', '', '');";
	$DB->query($query);

}


function paypal_paymentdisplay(){
	$output = "";
	global $hooks;
	/*$quotation_edit = _GET('quotation_edit'); 
	if (!$quotation_edit) {
		//echo "<script type='text/javascript'>window.location = '".WebSite."';</script>";
		return;
	}*/

	//$quotation =  getQuotationById($_SESSION['idquotation'],'',$_SESSION['user']);
	/*$quotation =  $hooks->get_quotation($quotation_edit,$_SESSION['user']);
	if (!isset($quotation['total'])) {
		return;
	}
	if ($quotation['total']['tht'] >= 500 || $quotation['status']['slug'] != 'quote_available') {
		return;
	}*/
	/*
	<img alt="Payer par paypal" height="49" src="'.WebSite.'modules/paypalexpress/assets/images/paypal-cb.png" width="110">
	<img alt="Payer par paypal" height="49" src="'.WebSite.'modules/paypalexpress/assets/images/paypal.png" width="110">
	*/
	/*$output .= '<form method="POST" action="'.WebSite.'modules/paypalexpress/paypal.php"  enctype="multipart/form-data" id="paypal_form1">
								<input type="hidden" name="paypal" />
								<input type="hidden" name="totalPayment" value="'.$quotation['total']['tht'].'"/>
								<input type="hidden" name="idquotation" value="'.$quotation['quotation']['id'].'"/>
								<p class="payment_module">
							    <a href="javascript:;" title="'.l('Payer par paypal','paypalexpress').'" id="send_paypal1">
							       '.l('Payer par Carte Bancaire (jusqu’à 500€ de commande) ','paypalexpress').'
							    </a>
							  </p>
							</form>';*/
	$output .= '<form method="POST" action="'.WebSite.'modules/paypalexpress/paypal.php"  enctype="multipart/form-data" id="paypal_form2">
								<input type="hidden" name="paypal" />
								<input type="hidden" name="totalPayment" value=""/>
								<input type="hidden" name="idquotation" value=""/>
								<p class="payment_module">
								<img src="../modules/paypalexpress/assets/images/paypal.png" style="width:86px;height:49px;"/>
							    <a href="javascript:;" title="Payer par paypal" id="send_paypal2">
							       '.l('Payer par paypal','paypalexpress').'
							    </a>
							  </p>
							</form>';

	echo $output;
	?>
	<script type="text/javascript" src="<?= WebSite ?>modules/paypalexpress/assets/js/script.js"></script>
	<?php
}
add_hook('sec_payment_list', 'paypalexpress', 'paypal_paymentdisplay', 'Display paypal payment');


global $p_payments;
$p_payments->add( l("paypal setting", "paypalexpress"), '?module=modules&slug=paypalexpress&page=paypalsetting');
function page_paypalsetting(){
	$msg = "";
	if (isset($_POST['validate_paypalexpress'])){
		$res = false;
		$res = updatePaypalSetting($_POST['username'],$_POST['password'],$_POST['signature']);
		if ($res) {
			$msg =  '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','paypalexpress').'</div>';
		}
	}

	/* = select_mete_value("paypalexpress_username");
	$paypalexpress_password = select_mete_value("paypalexpress_password");
	$paypalexpress_signature = select_mete_value("paypalexpress_signature");*/
	$paypalexpress_option = getPaypalOption();
	if (!$paypalexpress_option) {/* || empty($paypalexpress_option)*/
		return;
	}

	$output  = "";
	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
						<div class="top-menu padding0">
						  <div class="top-menu-title">
						    <h3><i class="fa fa-paypal" style="color: #002F86;"></i> PayPal Expresse : '.l('Configuration','paypalexpress').'</h3>
						  </div>
						</div>
						<div class="panel panel-default" style="margin-top:10px;">
						  <div class="panel-heading">
						    <h3 class="panel-title">'.l('Account Détails à Partir de','paypalexpress').' PayPal</h3>
						  </div>
						  <div class="panel-body">'.$msg .'
						    <div class="form-group">
									<label for="owner">Username</label>
									<p><input type="text" name="username" value="'.$paypalexpress_option['username'].'"/></p>
								</div>
								<div class="form-group">
									<label for="owner">Password</label>
									<p><input type="text" name="password" value="'.$paypalexpress_option['password'].'"/></p>
								</div>
								<div class="form-group">
									<label for="owner">Signature</label>
									<p><input type="text" name="signature" value="'.$paypalexpress_option['signature'].'"/></p>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary add-product" name="validate_paypalexpress"/>
								</div>
						  </div>
						</div>
		          
						</form>';
	echo $output;
}


