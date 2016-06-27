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
function ADD(){}
function EDIT($ID){}
function DELETE($ID)
{
  global $common;
  $common->delete('shop', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=stores"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//get shop infos
global $common;
$s = $common->select('shop');
$id_s = $s[0]['id'];
if( empty($s) ) return;
$countries = $common->select('countries', array('id', 'name'));
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-home"></i> <?=l("Coordonnées et magasins", "admin");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="s_form" method="post" action="ajax/stores/form.php">
  <div class="panel-heading"><?=l("Coordonnées", "admin");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_s" value="<?=(isset($id_s)) ? $id_s : '0';?>" id="id_s">
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Nom de la boutique *", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($s[0]['name'])) ? $s[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("meta description", "admin");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="meta_description" class="form-control" id="meta_description" placeholder=""><?=(isset($s[0]['meta_description'])) ? $s[0]['meta_description'] : "";?></textarea>   
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("meta keywords", "admin");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="meta_keywords" class="form-control" id="meta_keywords" placeholder=""><?=(isset($s[0]['meta_keywords'])) ? $s[0]['meta_keywords'] : "";?></textarea>   
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse e-mail de la boutique *", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="email" id="email" value="<?=(isset($s[0]['email'])) ? $s[0]['email'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Immatriculation", "admin");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="immatriculation" class="form-control" id="immatriculation" placeholder=""><?=(isset($s[0]['immatriculation'])) ? $s[0]['immatriculation'] : "";?></textarea>   
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse du magasin (ligne 1)", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="address1" id="address1" value="<?=(isset($s[0]['address1'])) ? $s[0]['address1'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse du magasin (ligne 2)", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="address2" id="address2" value="<?=(isset($s[0]['address2'])) ? $s[0]['address2'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Code postal", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="zip_code" id="zip_code" value="<?=(isset($s[0]['zip_code'])) ? $s[0]['zip_code'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Ville", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="city" id="city" value="<?=(isset($s[0]['city'])) ? $s[0]['city'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Pays", "admin");?></label>
      <div class="col-lg-4">
        <select name="id_country" class="form-control" id="id_country">
          <option value="0" style="font-weight: bold"><?=l("Sélectionnez un pays", "admin");?></option>
          <?php 
          if( !empty($countries) )
          {
            foreach ($countries as $key => $country) {
            	$selected = (isset($s[0]['id_country']) && $s[0]['id_country']==$country['id']) ? "selected" : "";
              echo '<option value="'.$country['id'].'" '. $selected .'>'. l( $country['name'], "admin" ) .'</option>';
            }
          } 
          ?>
        </select>    
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Téléphone", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="phone" id="phone" value="<?=(isset($s[0]['phone'])) ? $s[0]['phone'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Fax", "admin");?></label>
      <div class="col-lg-4">
        <input type="text" name="fax" id="fax" value="<?=(isset($s[0]['fax'])) ? $s[0]['fax'] : "";?>" class="form-control">
      </div>
    </div>

    

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=stores" class="btn btn-default"><?=l("Fermer", "admin");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "admin");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#s_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("s_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>