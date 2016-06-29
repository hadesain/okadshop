<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'rate' => 'rate'),
	'From' => array( _DB_PREFIX_.'taxes'),
	'Module'=> array('taxes', l("Liste des Taxes", "admin")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Taxe Label", "admin"),
		l("Valeur de taxe (%", "admin"),
		l("Operations", "admin"),
	),
	'Butons' =>	array(
		array( l("Ajouter une taxe", "admin"),'?module=taxes&action=add','add_nw','add button', l("Ajouter une taxe", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	