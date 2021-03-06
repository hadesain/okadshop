<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
global $_CONFIG;
global $common;
$id_lang = $_CONFIG['id_lang'];
$features = $common->select("feature_trans", array('id_feature', 'name'), "WHERE id_lang=".$id_lang);
$value = $common->select("feature_value_trans", array('id_value', 'id_lang', 'value'), "WHERE id_lang=".$id_lang." AND id=$ID LIMIT 1");
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-pencil"></i> <?=l("Modifier la valeur", "admin");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="value_form" method="post" action="ajax/features/values/form/edit.php">
  <div class="panel-heading"><?=l("Valeur de caractéristique", "admin");?></div>
  <div class="panel-body">
  <input type="hidden" name="id_value" value="<?=$value[0]['id_value'];?>" id="id_value">

    <div class="form-group">
      <label class="control-label col-lg-3" for="id_feature"><?=l("Caractéristique *", "admin");?></label>
      <div class="col-sm-3">
        <select name="id_feature" id="id_feature" class="form-control" required>
          <?php
          if( !empty($features) )
          {
            foreach ($features as $key => $feature) {
              $selected = (isset($_GET['id_feature']) && $_GET['id_feature'] == $feature['id_feature']) ? "selected" : "";
              echo '<option value="'.$feature['id_feature'].'" '.$selected.'>'.$feature['name'].'</option>';
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="name"><?=l("Valeur *", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="value" id="value" value="<?=$value[0]['value'];?>" class="form-control" required autofocus>     
      </div>
      <div class="col-sm-2 left0" style="left:-4px;">
        <select name="id_lang" id="id_lang" class="form-control" style="width: auto;">
          <?php
          if( !empty($_CONFIG['lang_list']) )
          {
            foreach ($_CONFIG['lang_list'] as $key => $lang) {
              $selected = ($value[0]['id_lang'] == $lang['id']) ? "selected" : "";
              echo '<option value="'.$lang['id'].'" '.$selected.'>'.$lang['name'].'</option>';
            }
          }
          ?>
        </select>
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=feature_values&amp;id_feature=<?=$_GET['id_feature'];?>" class="btn btn-default"><?=l("Fermer", "admin");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder", "admin");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#value_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("value_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
      if( data.id_feature ){
        window.location = '?module=feature_values&id_feature='+data.id_feature;
      }
    });
    return false;
  });

  //id_lang
  $("#id_lang").on("change", function(){
    $.ajax({
      type: "POST",
      url: 'ajax/features/values/value-trans.php',
      data: {id_lang:$(this).val(), id_value:$("#id_value").val()},
      success: function(value){
        $("input#value").val(value);
      }
    });
  });

});
</script>