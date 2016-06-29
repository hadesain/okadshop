<?php
if (!defined('_OS_VERSION_'))
  exit;


//register module infos
global $hooks;
$data = array(
	"name" => "User groups",
	"description" => "Display a Slideshows in home pag.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "administration",
	"version" => "1.0.0",
);
$hooks->register_module('usergroups', $data);


function usergroups_display(){

	$output = "";
	$output .='<div class="user-pro"><!-- Compte Pro -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong>Type de Compte</strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
			   					<label for="join-file">Choisir le type de compte <sup>*</sup></label>
			   					<select name="user-type">
			   						<option value="2">Professionnels</option>
			   						<option value="3">Créateurs d’entreprise</option>
			   					</select>
			   				</div>
			   				<div class="form-group">
							    <label for="join-file">Fichier joint <sup>*</sup></label>
							     <input type="file" class="form-control" name="user_type_file">
							 </div>
			   			</div>
			   		</div>	
				  </div>
				</div>
			</div>';
	echo $output;
}
add_hook('sec_register_form', 'superslider', 'usergroups_display', 'user groups display');
