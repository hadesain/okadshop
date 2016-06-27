<?php
$Args = array(
	'Select' => array(
		'ID'=>'id',
		'Name'=>'name', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'users_groups'),
	'Where' => array(),
	'Module'=> array('groups', l("Gestion des groups", "admin")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"), 
		l("Nom de Groupe", "admin"), 
		l("Activé", "admin"), 
		l("Actions", "admin")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l("Ajouter une groupe", "admin"),'?module=groups&action=add','add_nw','add button', l("Ajouter une groupe", "admin"),'facebox','iconAdd'),
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>