<?php
$Args = array(
	'Select' => array(
		'ID'=>  _DB_PREFIX_.'tags.id' ,
		'Name'=>  _DB_PREFIX_.'tags.name',
		'langs'=>  _DB_PREFIX_.'langs.name'
	),/*,'Description'=>'','Displayed'=>''*/
	'From' => array(  _DB_PREFIX_.'tags'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs',  _DB_PREFIX_.'langs.id',  _DB_PREFIX_.'tags.id_lang')
	),//array('countries','countries.id','users.id_country')
	'Module'=> array('tags', l('Gestion des tags', "admin") ),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom", "admin"),
		l("Langue", "admin"),
		l("Actions", "admin")
	),
	'Files' => array(),
	'Butons' =>	array(
					array( l('Ajouter une tags', "admin"),'?module=tags&action=add','add_nw','add button', l('Ajouter une tags', "admin"),'facebox','iconAdd')
				),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>