<?php
//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "Category Panel",
	"description" => "Category Panel.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('categorypanel', $data);



function categorypanel_display(){
	global $hooks;
/*	$homeCat = getcategoryByName('Accueil');
	var_dump($homeCat);*/
	$output = "";
	$list = getPanelCatList(1,true,true);
	if (!$list || empty($list)) {
		return;
	}
	$output .= "<style type='text/css'>#panel-category>li{font-weight: 700;}</style>";
	$output .='<!-- Catégories panel -->
				<div class="panel">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.l("Catégories",'categorypanel').'</h3>
				  </div>
				  <div class="panel-body" style="">
				    <ul id="panel-category">'.$list.'</ul>
				  </div>
				</div>';/*padding: 5px;*/
	echo $output;
}
add_hook('sec_sidebar', 'categorypanel', 'categorypanel_display', 'Display category panel');

