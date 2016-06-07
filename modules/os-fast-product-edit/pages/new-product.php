<?php
//bienvenue-setting
function page_new_product(){

	global $common;

	if ( isset($_POST['save']) && !empty($_POST['duration']) )
	{
		$common->save_mete_value('new_product_duration', $_POST['duration']);
	}

	$meta_value = $common->select_mete_value('new_product_duration');?>

<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-bar-gift"></i> <?=l("Produits Nouveaux", "fast_edit");?></h3>
  </div>
</div><br>

	<div class="panel panel-default tab-pane fade in active" id="Product">
	<form class="form-horizontal" method="post" action="">
		<div class="panel-heading"><?=l("Produits Nouveaux", "fast_edit");?></div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-md-3 control-label" for="duration"><?=l("Nombre des jours", "fast_edit");?></label>  
				<div class="col-sm-4">
					<input type="number" step="1" min="1" name="duration" class="form-control" id="duration" value="<?=$meta_value;?>" required>
					<small><?=l("Nombre des jours pour que le produit doit être nouveau a partir de sa date de création", "fast_edit");?></small>
				</div>
			</div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-danger" onclick="window.location='/';"><?=l("Annuler", "fast_edit");?></button>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?=l("Sauvegarder", "fast_edit");?></button>
		</div><!--/ .panel-footer -->
	</form>
	</div><!--/ .panel -->

<?php
}