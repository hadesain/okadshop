<?php
$Args = array(
  'Select' => array(
    'id' => 'id',
    'name' => 'name',
    'short_name' => 'short_name',
    'code' => 'code',
    'active' => 'active',
  ),
  'From' => array( _DB_PREFIX_.'langs'),
  'Join' => array(),
  'Module'=> array('langs','Liste des Langues'),
  'Operations' => array('edit','delete'),
  'THead' => array(
    l("ID", "admin"),
    l("Nom", "admin"),
    l("Code ISO", "admin"),
    l("Code de langue", "admin"),
    l("Activé", "admin"),
    l("Operations", "admin")
  ),
  'Butons' => array(
    array( l("Ajouter une Langue", "admin"),'?module=langs&action=add','add_nw','add button',l("Ajouter une Langue", "admin"),'facebox','iconAdd')
  ),
  'UPLOADFIELDS' => array()
  );
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>
  