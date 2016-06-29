<?php
if (!defined('_OS_VERSION_'))
  exit;

  
//register module infos
global $hooks;
$data = array(
	"name" => "Account Panel",
	"description" => "Account Panel.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('accountpanel', $data);


function accountpanel_display(){

	$output = "";

	/*if(isConnected()){
	 		$output .= '<div class="panel"><!-- Mon compte panel -->
				    <div class="panel-heading">
				      <h3 class="panel-title">Mon compte</h3>
				    </div>
				    <div class="panel-body">
				      <ul>
				      <li><a href="'.WebSite.'account/quotation">Mes devis</a></li>
				        <li><a href="'.WebSite.'account/history">Mes commandes</a></li>
				        <li><a href="'.WebSite.'account/invoices">Mes factures</a></li>
				        <li><a href="'.WebSite.'account/addresses">Mes adresses</a></li>
				        <li><a href="'.WebSite.'account/identity">Mes données personnelles</a></li>
				        <li><a href="'.WebSite.'account/discount">Mes bons de réductions</a></li>
				        <li><a href="'.WebSite.'account/loyalty-program">Mes points de fidélité</a></li>
				      </ul>
				      <p class="logout"><a href="'.WebSite.'account/logout" title="Déconnexion">Déconnexion</a></p>
				    </div>
				  </div>';
	}*/
	if(!isConnected()){
		$output .= '<div class="panel"><!-- Mon compte panel -->
				    <div class="panel-heading">
				      <h3 class="panel-title">'.l("identifiez vous","accountpanel").'</h3>
				    </div>
				    <div class="panel-body">
				      <form role="form" method="POST" action="'.WebSite.'account/login">
							  <div class="form-group">
							    <label for="exampleInputEmail1">'.l("Adresse e-mail","accountpanel").'</label>
							    <input type="email" class="form-control" style="border-radius:0px" name="email" required>
							  </div>
							  <div class="form-group">
							    <label for="exampleInputPassword1">'.l("Mot de passe","accountpanel").'</label>
							    <input type="password" class="form-control" style="border-radius:0px" name="password" required>
							  </div>
							  <p class="submit-btn">
							  	<button type="submit" class="btn btn-sm btn-default" name="submitlogin">'.l("Identifiez-vous","accountpanel").'</button>
							  </p>	  
							</form>
				    </div>
				  </div>';
	}
	echo $output;
}
add_hook('sec_sidebar', 'accountpanel', 'accountpanel_display', 'display account panel');
