<?php
$Args = array(
	'Select' => array(
		'id' => 'id' , 
		'name' => 'name', 
		'cdate' => 'cdate', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'manufacturers'),
	'Where' => array(),
	'Join' => array(),
	'Module'=> array('manufacturers', l('Gestion des Fabricants', "admin") ),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom", "admin"),
		l("Date de Création", "admin"),
		l("Activé", "admin"),
		l("Actions", "admin")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l('Ajouter un fabricant', "admin"),'?module=manufacturers&action=add','add_nw','add button', l('Ajouter un fabricant', "admin"),'facebox','iconAdd'),
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>