<?php
$Args = array(
	'Select' => array(
		'id' => 'id', 
		'name' => 'name', 
		'code' => 'code', 
		'date_to' => 'date_to', 
		'minimum_amount' => 'minimum_amount', 
		'quantity' => 'quantity', 
		'reduction' => 'reduction', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'cart_rule'),
	'Module'=> array('cart','Règles panier'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom de la Règle", "admin"),
		l("Code promo", "admin"),
		l("Date d\'expiration", "admin"),
		l("Montant minimum", "admin"),
		l("Quantité disponible", "admin"),
		l("Réduction", "admin"),
		l("Statut", "admin"),
		l("Operations", "admin"),
	),
	'Butons' =>	array(
		array( l("Ajouter une Règle", "admin"),'?module=cart&action=add','add_nw','add button', l("Ajouter une Règle", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	