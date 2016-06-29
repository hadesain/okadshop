<?php
//PAGE STATES
function page_quote_states(){
	$common = new OS_Common();
  $statuts = $common->select('quotation_status');
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-list"></i> <?=l("Statuts de devis", "quotation");?></h3>
  </div>
</div><br>


<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-list"></i> <?=l("Statuts de Desvis", "quotation");?>
		<a data-action="add" data-toggle="modal" data-target="#state_modal" class="btn add pull-right" title="ajouter une status"><i class="fa fa-plus"></i> <?=l("Ajouter une statut", "quotation");?></a>
	</div>

	<div class="panel-body">
		<table id="quote_states" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="50"><?=l("N°", "quotation");?></th>
					<th><?=l("Permalien de statut", "quotation");?></th>
					<th><?=l("Nom de Statut", "quotation");?></th>
					<th width="95"><?=l("Actions", "quotation");?></th>
				</tr>
			</thead>
			<tbody>
			<?php if( !empty($statuts) ) : ?>
				<?php foreach ($statuts as $key => $statut) : ?>
				<tr id="<?=$statut['id'];?>">
					<td>#<?=$statut['id'];?></td>
					<td><?=$statut['slug'];?></td>
					<td><?=$statut['name'];?></td>
					<td style="text-align:center;">
		      	<a data-action="edit" data-toggle="modal" data-target="#state_modal" class="btn btn-default" title="ajouter une status"><i class="fa fa-pencil"></i></a>
		      	<a href="javascript:;" class="btn btn-danger <?=($statut['id']>8) ? 'delete' : 'disabled';?>" title="Supprimer ce status"><i class="fa fa-trash"></i></a>
		      </td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	</div><!--/ .panel-body -->
</div><!--/ .panel -->



<div class="modal fade" id="state_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">  
    	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=l("Ajouter une Statut", "quotation");?></h4>
      </div>            
      <div class="modal-body">
      	<input type="hidden" id="state_id" value="0">
      	<div class="form-group">
		      <label class="control-label" for="state_slug"><?=l("Label de statut", "quotation");?></label>
		      <input type="text" id="state_slug" class="form-control" placeholder="">
		    </div>
		    <div class="form-group">
		      <label class="control-label" for="state_name"><?=l("Nom de statut", "quotation");?></label>
		      <input type="text" id="state_name" class="form-control" placeholder="">
		    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save"><?=l("Enregistrer et Fermer", "quotation");?></button>
      </div>
    </div>
  </div>
</div>


<script>
var ajax_url = "../modules/os-quotations/ajax/";
$(document).ready(function(){

	// do action on bootstrap modal open
  $('#state_modal').on('shown.bs.modal', function (e) {
  	$('#state_modal input').val('');
  	var action = $(e.relatedTarget).data('action');
  	if( action == "edit" ){
  		var tr = $(e.relatedTarget).closest('tr');
  		var id 	 = tr.find("td:eq(0)").text();
  		var slug = tr.find("td:eq(1)").text();
  		var name = tr.find("td:eq(2)").text();
  		$('#state_modal input#state_id').val(id);
  		$('#state_modal input#state_name').val(name);
  		$('#state_modal input#state_slug').val(slug);
      $('#state_modal input#state_slug').prop('disabled', true);
  	}
 	});

  $('#state_modal .save').on('click', function(){
		var id 	 = $('#state_modal input#state_id').val();
		var name = $('#state_modal input#state_name').val();
		var slug = $('#state_modal input#state_slug').val();
		if( name == "" || slug == "" ){
			os_message_notif( "<?=l('Veuillez remplir tous les champs SVP!', 'quotation');?>", "warning");
			return false;
		}
  	$.ajax({
      type: "POST",
      data: {id:id,name:name,slug:slug},
      url: ajax_url + 'update/states.php',
      success: function(data){
      	$('#state_modal').modal('toggle');
      	var message = $.parseJSON(data);
      	os_message_notif(message);
      	setTimeout(function(){
				  window.location.reload();
				}, 5000);
      }
    });
  });

  //delete state
  $('table#quote_states .delete').on('click', function(){
  	var choice = confirm("<?=l('Cette action supprime définitivement le statut de la base de donné. Êtes-vous vraiment sûr ?', 'quotation');?>");
		if (choice == false) return;
  	var id = $(this).closest('tr').attr('id');
  	$.ajax({
      type: "POST",
      data: {id:id},
      url: ajax_url + 'remove/state.php',
      success: function(data){
      	var message = $.parseJSON(data);
      	$('table#quote_states tbody tr#'+id).fadeOut(500, function() { 
      		$(this).remove(); 
      		os_message_notif(message);
      	});
      }
    });
  });

	//reload page after modale close
  $('#state_modal').on('hidden.bs.modal', function () {
   location.reload();
  });

});
</script>

<?php
} //END PAGE STATES