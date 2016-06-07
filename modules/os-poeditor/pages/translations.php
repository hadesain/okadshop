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

function page_translations(){
  //get langs list
	global $common;
	$os_langs = $common->select('langs', array('id', 'code', 'name'));
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-list-alt"></i> <?=l("Traducstions", "poeditor");?></h3>
  </div>
</div><br>


<style>
.trans_table .form-control {
  width: 100%;
}
.panel-heading {
	border-bottom: 1px solid #ddd;
}
.t_success{
  border-color: #3c763d;
}
label{
  margin-top: 8px;
}
</style>


<div class="panel panel-default">
  <div class="panel-heading" style="display:flex;">

  <form class="form-inline col-sm-12 padding0">
  	<div class="form-group">
      <label class="form-label col-sm-3" for="langs"><?=l("Langue", "poeditor");?></label>
      <div class="col-sm-6">
    		<select id="langs" name="lang_code" class="form-control col-sm-3 pochosen" required>
    		<option value=""><?=l("Séléctionnez une Langue", "poeditor");?></option>
        <?php
        if( !empty($os_langs) )
        {
          foreach ($os_langs as $key => $lang) {
            echo '<option value="'.$lang['code'].'">'.$lang['name'].'</option>';
          }
        }
        ?>
        </select>
      </div>
  	</div>
  	<div class="form-group">
      <label class="form-label col-sm-3" for="langs"><?=l("Fichier", "poeditor");?></label>
      <div class="col-sm-6">
    		<select id="files" name="file_name" class="form-control pochosen" required>
      		<option value=""><?=l("Séléctionnez un Fichier", "poeditor");?></option>
      	</select>
      </div>     
  	</div>     
  	<div class="form-group left0">
  		<a class="btn btn-success" id="load_trans" style="margin-top:0px;"><?=l("Charger les traductions", "poeditor");?></a>
  	</div>     
  </div>
</form>
  <div class="panel-body">
  	<div class="table-responsive">
  		<table class="table bg-white table-bordered trans_table">
				<thead>
					<th><?=l("Texte original", "poeditor");?></th>
					<th><?=l("Traduction", "poeditor");?></th>
				</thead>
				<tbody>
				</tbody>
			</table>
  	</div>
  </div><!--/ .panel-body -->
  <div class="panel-footer">
  	<a id="reset_trans" class="btn btn-default"><i class="fa fa-undo"></i> <?=l("Annuler les modifications", "poeditor");?></a>
    <button class="btn btn-primary pull-right" id="save_trans" type="submit"><i class="fa fa-save"></i>&nbsp;<?=l("Sauvegarder les modifications", "poeditor");?></button>
  </div><!--/ .panel-footer -->
</div>


<script>
var ajax_url = "../modules/os-poeditor/ajax/";
$(document).ready(function(){

  $('.pochosen').chosen({width: "230px"});

	//datatable
	$('.trans_table').DataTable().clear().destroy();

	//load files
  $('#langs').on('change', function(){
  	var iso_code = $(this).find('option:selected').val();
  	$.ajax({
      type: "POST",
      data: {iso_code:iso_code},
      url: ajax_url + 'files.php',
      success: function(data){
      	$('#files option').not(':eq(0)').remove();
      	$("#files").append(data);
        $('#files.pochosen').chosen('destroy').chosen({width: "230px"});
      }
    });
  });

	//load trans
  $('#load_trans').on('click', function(){
  	var iso_code = $('select#langs').find('option:selected').val();
  	var file_name = $('select#files').find('option:selected').val();
    load_trans(iso_code, file_name);
  });

  //generate json
  $('.trans_table').on('change', 'input.msgstr', function(){
  	$(this).addClass('t_success');
    var msgid = $(this).closest('tr').find('td:eq(0)').text();
    var msgstr = $(this).val();
  });

  $('#save_trans').on('click', function(){
    var trans_data = {trans: []};
    //collect translations
    $('.trans_table input.t_success').each(function(){
      var msgid = $(this).closest('tr').find('td:eq(0)').text();
      var msgstr = $.trim( $(this).val() );
      if( msgid != "" ){
        trans_data.trans.push(
          {msgid:msgid, msgstr:msgstr}
        );
      }
    });
    //prepare entries
    var entries = JSON.stringify( trans_data ).replace(/\\/g, '');
    var lang_code = $('select#langs option:selected').val();
    var file_name = $('select#files option:selected').val();
    $.ajax({
      type: "POST",
      data: {entries:entries,lang_code:lang_code,file_name:file_name},
      url: ajax_url + 'update.php',
      success: function(data){
        $("input").removeClass("t_success");
        try {
          var response = $.parseJSON( data );
          if(typeof response =='object')
          {
            os_message_notif( response['msg'] );
          }
        }catch (e) {
          os_message_notif( "Une erreur est survenue, Veuillez actualiser la page.", "danger" );
        }
      }
    });
  });

  //reset_trans
  $('#reset_trans').on('click', function(){
    /*var choice = confirm("<?=l('Cette action sera annuler les modifications. Êtes-vous vraiment sûr ?', 'quotation');?>");
    if (choice == false) return;*/
    var iso_code = $('select#langs').find('option:selected').val();
    var file_name = $('select#files').find('option:selected').val();
    load_trans(iso_code, file_name);
    //$("input").removeClass("t_success");
  });

});


function load_trans(iso_code, file_name){
  $('#trans_data').val('');
  if( iso_code == "" || file_name == "" ){
    os_message_notif('<?=l("Veuillez Sélectionner une langue.", "poeditor");?>', 'warning');
    return false;     
  }
  $.ajax({
    type: "POST",
    data: {iso_code:iso_code, file_name:file_name},
    url: ajax_url + 'trans.php',
    success: function(data){
      $(".trans_table > tbody").find("tr").remove();
      $(".trans_table > tbody").append(data);
      $('.trans_table').DataTable();
    }
  });
}
</script>
<?php
}