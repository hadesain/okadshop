<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'active' => 'active'),
	'From' => array( _DB_PREFIX_.'zones'),
	'Module'=> array('zones','Liste des Zones'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de la zone", "admin"),
		l("Statut", "admin"),
		l("Operations", "admin"),
	),
	'Butons' =>	array(
		array( l("Ajouter une Zone", "admin"),'?module=zones&action=add','add_nw','add button', l("Ajouter une Zone", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	