<?php
// $Args = array(
// 	'Select' => array(
// 		'id' => _DB_PREFIX_.'contact.id',
// 		'name' => _DB_PREFIX_.'contact_trans.name', 
// 		'description' => _DB_PREFIX_.'contact_trans.description', 
// 		'email' => _DB_PREFIX_.'contact.email'
// 	),
// 	'From' => array( _DB_PREFIX_.'contact'),
// 	'Where' => array(_DB_PREFIX_.'contact_trans.id_lang','=',1), //array(_DB_PREFIX_.'contact_trans.id_lang'),
// 	'Join' => array(
// 		array( _DB_PREFIX_.'contact_trans', _DB_PREFIX_.'contact_trans.id_contact', _DB_PREFIX_.'contact.id', 'left'),
// 	),
// 	'Module'=> array('contacts', l("Contacts", "admin")),
// 	'Operations' => array('edit','delete'),
// 	'THead' => array(
// 		l("ID", "admin"), 
// 		l("Titre", "admin"), 
// 		l("Adresse Email", "admin"), 
// 		l("Description", "admin"),
// 		l("Actions", "admin")
// 	),
// 	'Files' => array(),
// 	'Butons' =>	array(
// 		array( l("Ajouter un Contact", "admin"),'?module=contacts&action=add','add_nw','add button', l("Ajouter un Contact", "admin"),'facebox','iconAdd'),
// 	),
// 	'UPLOADFIELDS' => array()
// 	);
// $Tables = new Tables();
// $DATATABLE = $Tables->GET($Args);



global $common;
global $_CONFIG;
$id_lang = $_CONFIG['id_lang'];
$contacts = $common->select(
  "contact c", 
  array("c.id", "c.email", "t.name", "t.description"), 
  "LEFT JOIN `"._DB_PREFIX_."contact_trans` t ON (t.`id_contact` = c.`id` AND t.`id_lang` = $id_lang) WHERE 1 ORDER BY c.`id` ASC"
);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-magic"></i> <?=l("Caractéristiques", "admin");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=contacts&amp;action=add" class="btn btn-primary"><?=l("Ajouter un contact", "admin");?></a>
  </div>
</div><br>

<div class="table-responsive">
  <table class="table table-bordered bg-white" id="datatable">
    <thead>
      <tr>
        <th><?=l("ID", "admin");?></th>
        <th><?=l("Titre", "admin");?></th>
        <th><?=l("Adresse e-mail", "admin");?></th>
        <th><?=l("Description", "admin");?></th>
        <th><?=l("Actions", "admin");?></th>
      </tr>
    </thead>
    <tbody>
    <?php if( !empty($contacts) ) : ?>
      <?php foreach ($contacts as $key => $c) : ?>
      <tr>
        <td><?=$c['id'];?></td>
        <td><?=$c['name'];?></td>
        <td><?=$c['email'];?></td>
        <td><?=$c['description'];?></td>
        <td>
          <div class="btn-group-action">
            <div class="btn-group">
              <a class="btn btn-default" href="?module=contacts&amp;action=edit&amp;id=<?=$c['id'];?>" title="<?=l("Modifier", "admin");?>"><i class="fa fa-pencil"></i> <?=l("Modifier", "admin");?></a>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="caret"></i>&nbsp;</button>
              <ul class="dropdown-menu">
                <li>
                  <a href="?module=contacts&action=delete&id=<?=$c['id'];?>" title="<?=l("Supprimer", "admin");?>"><i class="fa fa-trash"></i> <?=l("Supprimer", "admin");?></a>
                </li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>