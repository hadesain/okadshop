<?php
//bienvenue-setting
function page_analytics_config(){

	global $common;

	if ( isset($_POST['save']) && !empty($_POST['client_id']) )
	{
		$common->save_mete_value('analytics_table_id', $_POST['table_id']);
		$common->save_mete_value('analytics_client_id', $_POST['client_id']);
	}
	//get data
	$client_id = $common->select_mete_value('analytics_client_id');
	$table_id = $common->select_mete_value('analytics_table_id');
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-bar-chart"></i> <?=l("Configuration de Google Analytics", "analytics");?></h3>
  </div>
</div><br>

	<div class="panel panel-default tab-pane fade in active" id="Product">
	<form class="form-horizontal" method="post" action="">
		<div class="panel-heading"><?=l("Configuration", "analytics");?></div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-md-3 control-label" for="client_id"><?=l("Client ID", "analytics");?></label>  
				<div class="col-sm-4">
					<input type="text" name="client_id" class="form-control" id="client_id" value="<?=$client_id;?>" required>
					<small></small>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="table_id"><?=l("Table ID", "analytics");?></label>  
				<div class="col-sm-4">
					<input type="text" name="table_id" class="form-control" id="table_id" value="<?=$table_id;?>" required>
					<small></small>
				</div>
			</div>


		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-danger" onclick="window.location='/';"><?=l("Annuler", "analytics");?></button>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?=l("Sauvegarder", "analytics");?></button>
		</div><!--/ .panel-footer -->
	</form>
	</div><!--/ .panel -->

<?php
}