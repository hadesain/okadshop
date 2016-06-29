<?php
global $common;
global $_CONFIG;
$id_lang = $_CONFIG['id_lang'];
$features = $common->select(
  "features f", 
  array("f.id", "t.name", "f.position"), 
  "LEFT JOIN `"._DB_PREFIX_."feature_trans` t ON (t.`id_feature` = f.`id` AND t.`id_lang` = $id_lang) WHERE 1 ORDER BY f.`position` ASC"
);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-magic"></i> <?=l("Caractéristiques", "admin");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=features&amp;action=add" class="btn btn-primary"><?=l("Ajouter une caractéristique", "admin");?></a>
    <a href="?module=feature_values&amp;action=add" class="btn btn-default"><?=l("Ajouter une valeur", "admin");?></a>
  </div>
</div><br>

<div class="table-responsive">
  <table class="table table-bordered bg-white" id="datatable">
    <thead>
      <tr>
        <th><?=l("ID", "admin");?></th>
        <th><?=l("Nom", "admin");?></th>
        <th><?=l("Valeurs", "admin");?></th>
        <th><?=l("Position", "admin");?></th>
        <th><?=l("Actions", "admin");?></th>
      </tr>
    </thead>
    <tbody>
    <?php if( !empty($features) ) : ?>
      <?php foreach ($features as $key => $feature) : ?>
      <tr>
        <td><?=$feature['id'];?></td>
        <td><?=$feature['name'];?></td>
        <td></td>
        <td><?=$feature['position'];?></td>
        <td>
          <div class="btn-group-action">
            <div class="btn-group">
              <a class="btn btn-default" href="?module=feature_values&amp;id_feature=<?=$feature['id'];?>" title="<?=l("Afficher", "admin");?>"><i class="fa fa-search-plus"></i> <?=l("Afficher", "admin");?></a>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="caret"></i>&nbsp;</button>
              <ul class="dropdown-menu">
                <li>
                  <a href="?module=features&amp;action=edit&amp;id=<?=$feature['id'];?>" title="<?=l("Modifier", "admin");?>"><i class="fa fa-pencil"></i> <?=l("Modifier", "admin");?></a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="?module=features&action=delete&id=<?=$feature['id'];?>" title="<?=l("Supprimer", "admin");?>"><i class="fa fa-trash"></i> <?=l("Supprimer", "admin");?></a>
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