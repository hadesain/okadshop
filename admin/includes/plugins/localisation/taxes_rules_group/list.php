<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'active' => 'active'),
	'From' => array( _DB_PREFIX_.'taxes_rules_group'),
	'Module'=> array('taxes_rules_group','Liste des règles de taxe'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de groupe", "admin"),
		l("Statut", "admin"),
		l("Operations", "admin"),
	),
	'Butons' =>	array(
		array( l("Ajouter une règle de taxe", "admin"),'?module=taxes_rules_group&action=add','add_nw','add button', l("Ajouter une règle de taxe", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	