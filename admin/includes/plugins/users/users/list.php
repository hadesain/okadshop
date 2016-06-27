<?php
$Args = array(
	'Select' => array(
		'id'=> _DB_PREFIX_.'users.id',
		'clt_number'=>'clt_number',
		'first_name'=>'first_name',
		'last_name'=>'last_name',
		'user_company' =>  _DB_PREFIX_.'user_company.company',
		'email'=>'email',
		'countries'=> _DB_PREFIX_.'countries.name',
		'mobile'=>'mobile',
		),
	'From' => array( _DB_PREFIX_.'users'),
	'Where' => array(),
	'Order' => 'FIELD( '._DB_PREFIX_.'users.active, "waiting", "actived") ASC',//= "waiting"users.active DESC
	'Join' => array(
		array( _DB_PREFIX_.'user_company', _DB_PREFIX_.'user_company.id_user', _DB_PREFIX_.'users.id', 'left'),
		array( _DB_PREFIX_.'countries', _DB_PREFIX_.'countries.id', _DB_PREFIX_.'users.id_country','inner'),
	),

	'Module'=> array('users', l("Gestion des clients", "admin")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Numéro", "admin"),
		l("Prénom", "admin"),
		l("Nom", "admin"),
		l("Société", "admin"),
		l("E-mail", "admin"),
		l("Pays", "admin"),
		l("Téléphone", "admin"),
		l("Operations", "admin")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l("Ajouter un Client", "admin"),'?module=users&action=add','add_nw','add button', l("Ajouter un Client", "admin"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	