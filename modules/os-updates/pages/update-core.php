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
 * to license@okadshop.com so we can send you a copy.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    Moullablad <contact@moullablad.com>
 * @copyright 2016 Moullablad SARL
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

function page_update_core(){
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-refresh"></i> <?=l("Mise à jour", "os_updates");?></h3>
  </div>
</div><br>

<style>
.panel-subheading h4{
  margin: 5px 0px;
}
.panel-body {
    padding-top: 0px;
    min-height: 450px;
}
ul{
  list-style: inherit;padding-left: 30px;
}
.devider{
  position: absolute;
  border-left: 1px solid #A5245E;
  min-height: 185px;
}
</style>

<input type="hidden" id="err_msg" value="<?=l('Une erreur est survenue veuillez réessayer.','os_updates');?>">
<input type="hidden" id="current_version" value="<?=_OS_VERSION_;?>">
<div class="alert" id="alert"><strong></strong></div>

<div class="panel panel-default">
  <div class="panel-body">
    
    <div class="panel-subheading">
      <h4><?=l("Mises à jour de OkadShop", "os_updates");?></h4>
    </div>

    <div class="available hidden">

      <div class="col-sm-6 left0">
        <h4><?=l("Vous pouvez faire la mise à jour vers OkadShop automatiquement :", "os_updates");?></h4>
        <div class="row">
          <div class="col-sm-9 right0">
            <input type="text" value="" class="form-control" id="link">
            <small><?=l("* Changer le lien vers les ressources si besoin.", "os_updates");?></small>
          </div>
          <div class="col-sm-3">
            <a class="btn btn-success run_update"><i class="fa fa-refresh"></i> <?=l("Mettre à jour", "os_updates");?></a>
            <img src="../modules/os-updates/images/loading.gif" width="30" class="loading hidden">
          </div>
        </div>
        <br><br>
        <strong><u>OU</u></strong>
        <a href="" class="btn btn-primary up_link"><i class="fa fa-download"></i> <?=l("Télécharger la version", "os_updates");?> <span class="os_version"></span></a>
        <strong><?=l("complète et l'installer vous-même.", "os_updates");?></strong>
      </div>
      <div class="col-sm-1" style="width: 1px;">
        <div class="devider"></div>
      </div>
      <div class="col-sm-5 right0">
        <div class="alert alert-warning">
          <strong><?=l("Important.", "os_updates");?></strong>
          <p><?=l("Avant de faire une mise à jour, veillez à faire une souvegarde de base de données et de vos fichiers.", "os_updates");?></p>
        </div>
        <a class="btn btn-default backup_files"><i class="fa fa-save"></i> <?=l("Sauvegarder les fichiers", "os_updates");?></a>
        <img src="../modules/os-updates/images/loading.gif" width="30" class="backup_loading hidden">
        <p style="margin: 15px 0px 0px;"><?=l("* Vous trouver un ZIP avec la date d'aujourd'hui dans le dossier : ", "os_updates");?><b>[os-updates/backups]</b></p>
        <p><?=l("* Cela ne sauvegarde pas la base de données, vous devez le faire manuelement.", "os_updates");?></p>
      </div>

      <div class="col-sm-12 padding0">
        <br><br>
        <div class="panel-subheading">
          <h4><?=l("Informations de la nouvelle version", "os_updates");?></h4>
        </div>
        <div class="update_info"></div>
      </div><!-- col-sm-12 -->
    </div>

    <div class="no_updates">
      <h4><?=l("Aucune mises à jour disponible.", "os_updates");?></h4>
    </div>

  </div><!--/ .panel-body -->
</div>


<script>
var ajax_url = "../os-updates/includes/ajax/";
$(document).ready(function(){
  os_updates_infos();

  $("#alert").hide();

  $('.run_update').on('click', function(){
    $('.run_update').hide();
    $('.loading').removeClass('hidden');
    $.ajax({
      type: "POST",
      url: ajax_url + 'update-core.php',
      data: {version:$(".os_version").text(), link:$("input#link").val()},
      success: function(data){

        try {
          var obj = $.parseJSON( data );
          $('.loading').addClass('hidden');
          //show alert
          $("#alert").show();
          if( obj.success )
          {
            $("#alert").addClass("alert-success");
            $("#alert strong").text( obj.success );
          }else if( obj.success )
          {
            $("#alert").addClass("alert-warning");
            $("#alert strong").text( obj.error );
          }else{
            $("#alert").addClass("alert-warning");
            $("#alert strong").text( $("#err_msg").val() );
          }
          $('.run_update').show();
          $("#alert").fadeIn(500).delay(5000).fadeOut("slow");
        } catch (err) {
          $("#alert").addClass("alert-warning");
          $("#alert strong").text( $("#err_msg").val() );
          $("#alert").fadeIn(500).delay(5000).fadeOut("slow");
          $('.loading').addClass('hidden');
          $('.run_update').show();
        }

      }
    });
  });


  $('.backup_files').on('click', function(){
    $('.backup_files').addClass('disabled');
    $('.backup_loading').removeClass('hidden');
    $.ajax({
      type: "POST",
      url: ajax_url + 'backup.php',
      success: function(data){
        try {
          $("#alert").show();
          var obj = $.parseJSON( data );
          if( obj.success )
          {
            $("#alert").addClass("alert-success");
            $("#alert strong").text( obj.success );
          }else if( obj.error )
          {
            $("#alert").addClass("alert-warning");
            $("#alert strong").text( obj.error );
          }
          $("#alert").fadeIn(500).delay(5000).fadeOut("slow");
          $('.backup_files').removeClass('disabled');
          $('.backup_loading').addClass('hidden');

        } catch (err) {
          $("#alert").show().addClass("alert-warning");
          $("#alert strong").text( $("#err_msg").val() );
          $('.backup_files').removeClass('disabled');
          $('.backup_loading').addClass('hidden');
        }
      }
    });
  });


  



});

//os_updates_infos
function os_updates_infos() {
  $.getJSON( "http://updates.okadshop.com/index.php", function( data ) {
    var current_ver = $("#current_version").val();
    if( current_ver != data.version )
    {
      $(".available").removeClass('hidden');
      $(".no_updates").addClass('hidden');
      $(".update_info").html( data.infos );
      $(".os_version").text(data.version);
      $(".up_link").attr("href", data.link);
      $("input#link").val(data.link);
    }else{
      $(".available").addClass('hidden');
      $(".no_updates").removeClass('hidden');
    }
  });
}
</script>
<?php
}