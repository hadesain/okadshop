<?php 
$bienvenue_slug = "os-relance-bienvenue";

//register module infos
global $hooks;
$bienvenue_info = array(
	"name" => l("Relance de bienvenue", "relance_b"),
	"description" => l("Prévoir module relance de bienvenue après X jours de l’ouverture de compte.", "relance_b"),
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "emailing",
	"version" => "1.0.0",
	"config" => "bienvenue-setting"
);
$hooks->register_module($bienvenue_slug, $bienvenue_info);

//Register a custom menu page.
global $p_customers;
$p_customers->add( l("Relance de bienvenue", "relance_b"), '?module=modules&slug='.$bienvenue_slug.'&page=bienvenue-setting');


function os_relance_bienvenue_install(){
	//save_mete_value
	global $common;
	$common->save_mete_value('relance_bienvenue', '1');
	//register_cron_job
	register_cron_job('cron_welcome', '', '7:00:00', '1');
}


//bienvenue-setting
function page_bienvenue_setting(){

	global $common;

	if ( isset($_POST['save']) && !empty($_POST['days']) && !empty($_POST['cron_welcome']) )
	{
		$common->save_mete_value('relance_bienvenue', $_POST['days']);
		//update cron
		//$cron_time = date('H:i:s', $_POST['cron_welcome']);
		$update = update_cron_job('cron_welcome', 1, "", $_POST['cron_welcome']);	
	}

	$meta_value = $common->select_mete_value('relance_bienvenue');
	$cron = get_cron_job('cron_welcome');
	$cron_welcome = date('H:i', strtotime( $cron['cron_time'] ) );
?>

<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-envelope"></i> <?=l("Relance de bienvenue", "relance_b");?></h3>
  </div>
</div><br>

	<div class="panel panel-default tab-pane fade in active" id="Product">
	<form class="form-horizontal" method="post" action="">
		<div class="panel-heading"><?=l("Relance de bienvenue", "relance_b");?></div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-md-3 control-label" for="days"><?=l("Nombre des jours", "relance_b");?></label>  
				<div class="col-sm-4">
					<div class="input-group">
						<input type="number" step="1" min="1" name="days" class="form-control" id="days" value="<?=( isset($meta_value) ) ? $meta_value : '1';?>" placeholder="1" required>
						<span class="input-group-addon"><?=l("Jours", "relance_b");?></span>
					</div>
					<small><?=l("Envoyer un mail aux clients ouvrire le compte depuis X jours", "relance_b");?></small>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="cron_welcome"><?=l("Dans cette Heurs", "relance_b");?></label>  
				<div class="col-sm-4">
					<input type="time" step="1" min="1" name="cron_welcome" class="form-control" id="cron_welcome" value="<?=$cron_welcome;?>" required>
					<small><?=l("Le module s'exécute à chaque jour dans le temps indiquer.", "relance_b");?></small>
				</div>
			</div>
		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-danger" onclick="window.location='/';"><?=l("Annuler", "relance_b");?></button>
			<button type="submit" name="save" class="btn btn-primary pull-right"><?=l("Sauvegarder", "relance_b");?></button>
		</div><!--/ .panel-footer -->
	</form>
	</div><!--/ .panel -->

<?php
}