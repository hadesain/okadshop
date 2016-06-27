<?php
//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "Link Panel",
	"description" => "Link Panel.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('linkpanel', $data);


function linkpanel_display(){
	$output = "";

	global $hooks;
	$cms = $hooks->select('cms');
	$output .='<!-- informations panel -->
			<div class="panel">
			  <div class="panel-heading">
			    <h3 class="panel-title">'.l("Informations",'linkpanel').'</h3>
			  </div>
			  <div class="panel-body">
			    <ul>';
			    if( !empty($cms) )
			    {
				    foreach ($cms as $key => $value) {
				    	$output .=' <li><a href="'.WebSite.'cms/'.$value['id'].'" title="'.$value['title'].'">'.$value['title'].'</a></li>';
				    }
			    }
				/*$output .='
				      <li><a href="<?= WebSite; ?>cms/59" title="">'.l('Tarifs & Remises','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/55">'.l('Paiement sécurisé','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/51">'.l('Transport & Taxes','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/53">'.l('Conditions d\'utilisation','linkpanel').'</a></li>';*/
/*
	if(isConnected()){
		$output .='
				      <li><a href="'.WebSite.'cms/56">'.l('Demander un devis','linkpanel').'</a></li>
				      <li><a href="<?= WebSite; ?>cms/59" title="">'.l('Tarifs & Remises','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/55">'.l('Paiement sécurisé','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/51">'.l('Transport & Taxes','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/53">'.l('Conditions d\'utilisation','linkpanel').'</a></li>';
	}else{
		$output .='
							<li><a href="'.WebSite.'cms/53">'.l('Conditions d\'utilisation','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/56">'.l('Demander un devis','linkpanel').'</a></li>
				      <li><a href="'.WebSite.'cms/contact">'.l('Contactez-nous','linkpanel').'</a></li>';
	}     
*/


	$output .=' </ul>
			  </div>
			</div>';
	
	echo $output;
}
add_hook('sec_sidebar', 'categorypanel', 'linkpanel_display', 'Display link panel');