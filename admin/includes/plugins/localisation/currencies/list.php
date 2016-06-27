<?php
$Args = array(
	'Select' => array(
		'id' => 'id', 
		'name' => 'name', 
		'iso_code' => 'iso_code', 
		'iso_code_num' => 'iso_code_num', 
		'sign' => 'sign', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'currencies'),
	'Module'=> array('currencies','Liste des Devises'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de Devise", "admin"),
		l("Code ISO", "admin"),
		l("N° de Code ISO", "admin"),
		l("Symbole", "admin"),
		l("statut", "admin"),
		l("Operations", "admin")
	),
	'Butons' =>	array(
		array( l("Ajouter un Devise", "admin"),'?module=currencies&action=add','add_nw','add button', l("Ajouter un Devise", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	