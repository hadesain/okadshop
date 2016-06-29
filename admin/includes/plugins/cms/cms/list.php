<?php
$Args = array(
	'Select' => array(
				'id'=> _DB_PREFIX_.'cms.id',
				'title'=> _DB_PREFIX_.'cms.title',
				'description'=> 'SUBSTRING('._DB_PREFIX_.'cms.description,1,50)',
				'category'=> _DB_PREFIX_.'cms_categories.title',
				'lang'=> _DB_PREFIX_.'langs.name'
		  ),
	'From' => array( _DB_PREFIX_.'cms'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'cms.id_lang', _DB_PREFIX_.'langs.id'),
		array( _DB_PREFIX_.'cms_categories', _DB_PREFIX_.'cms.id_cmscat', _DB_PREFIX_.'cms_categories.id')
	),
	'Module'=> array('cms','Gestion de CMS'),
	'Operations' => array('edit','delete'),
	'THead' => array('ID','Title','Description','Category','language','Operations'),
	'Butons' =>	array(
		array('Ajouter une page','?module=cms&action=add','add_nw','add button','Ajouter une page','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
	