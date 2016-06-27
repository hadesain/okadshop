<?php
/*============================================================*/
 //begin newproduct_settings function
/*============================================================*/

function page_newproduct_settings(){
	global $hooks;
    $nbproduct = $hooks->select_mete_value('newproduct_nbproduct');
    $active = $hooks->select_mete_value('newproduct_active');
?>

<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-cog"></i> Futured products :<?= l('Page configuration','newproduct'); ?>
		</h3>
	</div>
	<div class="top-menu-button">
  </div>
</div><br>

<div class="panel panel-default">
	<form class="form-horizontal" id="newproduct_form" method="post" action="../modules/newproduct/php/ajax.php">
		<input type="hidden" name="action" value="" id="action"/>
		<div class="panel-heading"><?= l('Afficher les nouveaux produits dans la page d\'accueil','newproduct'); ?></div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 control-label" for="active"><b><?= l('activé','newproduct'); ?></b></label>  
				<div class="col-md-4">
					<input id="active" name="active" type="checkbox" class="form-control" value="" <?= ($active == '1') ? 'checked' : ''; ?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="nbproduct"><?= l('Le nombre des produits sur la page','newproduct'); ?></label>  
				<div class="col-md-4">
					<input id="nbproduct" name="nbproduct" type="number" min="0" class="form-control" value="<?=$nbproduct?>">
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#" class="btn btn-default"><?= l('Annuler','newproduct'); ?></a>
			<span class="pull-right">
				<input type="submit" name="" class="btn btn-success" value="<?= l('Sauvegarder','newproduct'); ?>">
			</span>
		</div><!--/ .panel-footer -->
	</form>
</div>

<script>
	$(document).ready(function(){
		//submit form
		$("form#newproduct_form").submit(function(event){
		    event.preventDefault();
		    $('#action').val('newproduct_settings');
		    submit_ajax_form("newproduct_form", function(data) {
		    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
		    	else if( data["msg"] ) os_message_notif( data["msg"] );
		    });
		    return false;
		});
	});
</script>


<?php
/*============================================================*/
} //END 
/*============================================================*/