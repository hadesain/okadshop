<?php
$Args = array(
	'Select' => array(
		'ID' =>  _DB_PREFIX_.'carrier.id', 
		'name' =>  _DB_PREFIX_.'carrier.name', 
		'min_delay' => 'min_delay', 
		'max_delay' => 'max_delay',  
		'grade' => 'grade', 
		'max_width' => 'max_width', 
		'max_height' => 'max_height', 
		'max_depth' => 'max_depth',  
		'max_weight' => 'max_weight'
	),
	'From' => array( _DB_PREFIX_.'carrier'),

	'Join' => array(),
	'Module'=> array('shipping', l("Liste des Transports", "admin")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de Transport", "admin"),
		l("Délai Min", "admin"),
		l("Délai Max", "admin"),
		l("Vitesse (km)", "admin"),
		l("Largeur Max", "admin"),
		l("Hauteur Max", "admin"),
		l("Profondeur Max", "admin"),
		l("Poids Max", "admin"),
		l("Operations", "admin")
	),
	'Butons' =>	array(
		array( l("Ajouter un Transport", "admin"),'?module=shipping&action=add','add_nw','add button', l("Ajouter un Transport", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	