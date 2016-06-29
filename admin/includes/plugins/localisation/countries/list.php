<?php
$Args = array(
	'Select' => array(
		'ID' => _DB_PREFIX_.'countries.id', 
		'name' => _DB_PREFIX_.'countries.name', 
		'zones'=> _DB_PREFIX_.'zones.name', 
		'langs'=> _DB_PREFIX_.'langs.name', 
		'iso_code' => 'iso_code', 
		'active' => _DB_PREFIX_.'countries.active', 
		'zip_code_format' => 'zip_code_format'
	),
	'From' => array( _DB_PREFIX_.'countries'),
	'Join' => array(
		array( _DB_PREFIX_.'zones', _DB_PREFIX_.'zones.id', _DB_PREFIX_.'countries.id_zone'),
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'langs.id', _DB_PREFIX_.'countries.id_lang'),
	),
	'Module'=> array('countries','Liste des Pays'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de Pays", "admin"),
		l("Zone", "admin"),
		l("Langue", "admin"),
		l("Code ISO", "admin"),
		l("Statut", "admin"),
		l("Format de CP", "admin"),
		l("Operations", "admin")
	),
	'Butons' =>	array(
		array( l("Ajouter une Pays", "admin"),'?module=countries&action=add','add_nw','add button',l("Ajouter une Pays", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	