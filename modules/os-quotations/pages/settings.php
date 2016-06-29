<?php
//PAGE SETTING
function page_quote_settings(){
	$common = new OS_Common();
	$devis  = new OS_Devis();
  $errors = $success = array();
  $allowed_tags = allowed_tags();

	/**
   *=============================================================
   * INSERT POST DATA
   *=============================================================
   */
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['footer'])){

    //customer informations
    $setting_data = array(
      'footer' 		 => strip_tags($_POST['footer'], $allowed_tags),
      'conditions' => strip_tags($_POST['conditions'], $allowed_tags)
    );
    //upload footer_logo
    if( isset($_FILES['footer_logo']) && $_FILES['footer_logo']['size'][0] > 0 ){
      $file_name   = time() . '_' . $_FILES['footer_logo']['name'][0];
      $file_name   = md5($file_name);
      $uploadDir   = '../files/quotatonattachments/setting/';
      $extensions  = array('jpg', 'jpeg', 'png', 'gif');
      $file_target = $common->uploadDocument($_FILES['footer_logo'], $file_name, $uploadDir, $extensions);
      $attachement = str_replace( $uploadDir , '', $file_target[0] );
      if( $attachement != "" ) $setting_data['footer_logo'] = $attachement;
    }

    $exist = $common->select('quotation_setting', array('id'));
    if( $exist ){
      //update setting
      $common->update('quotation_setting', $setting_data, "WHERE id=".$exist[0]['id'] );
      array_push($success, l("Les paramètres ont été mise à jour.", "quotation"));
    }else{
    	//insert setting
      $id_setting = $common->save('quotation_setting', $setting_data);
      if($id_setting){
      	array_push($success, l("Les paramètres ont été sauvegarder avec success.", "quotation"));
      }
    }

  }

  //get settings
  $setting = $devis->get_settings();
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cog"></i> Reglages</h3>
  </div>
</div><br>

	<?php if(!empty($errors)) : ?>
		<div class="alert alert-warning">
			<h4>Une erreur est survenue !</h4>
			<ul>
			<?php foreach ($errors as $key => $error) : ?>
				<li><?=$error;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php elseif(!empty($success)) : ?>
		<div class="alert alert-success">
			<h4>Opération Effectué !</h4>
			<ul>
			<?php foreach ($success as $key => $value) : ?>
				<li><?=$value;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form class="form-horizontal col-sm-12 left0" method="post" action="" enctype="multipart/form-data" novalidate>
		<div class="panel panel-default">
			<div class="panel-heading"><?=l("Parametres de devis", "quotation");?></div>
			<div class="panel-body">

				<div class="form-group">
					<label class="col-md-2 control-label" for="footer"><?=l("Pied de page", "quotation");?></label>
					<div class="col-md-10">                     
						<textarea class="form-control summernote" name="footer" id="footer" placeholder="<?=l("Saisissez vos informations...", "quotation");?>"><?=(isset($setting['footer'])) ? $setting['footer'] : '';?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="filer_input"><?=l("Logo en tête et de pied de page", "quotation");?></label>  
					<div class="col-md-10">
						<div class="pull-left">
		        	<input type="file" name="footer_logo" id="filer_input">
		        	<?php if( $setting['footer_logo'] != "" ) : ?>
								<a target="_blank" href="<?php echo '../files/quotatonattachments/setting/'. $setting['footer_logo'];?>"><?php echo $setting['footer_logo'];?></a>
		          <?php endif; ?>
		        </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="conditions"><?=l("Conditions de vente", "quotation");?></label>
					<div class="col-md-10">                     
						<textarea class="form-control summernote" name="conditions" id="conditions"><?=(isset($setting['conditions'])) ? $setting['conditions'] : '';?></textarea>
					</div>
				</div>

			</div><!--/ .panel-body -->
			<div class="panel-footer">
				<button type="button" class="btn btn-default" onclick="window.location='?module=modules&slug=os-quotations&page=quotations';"><?=l("Annuler", "quotation");?></button>
				<input type="submit" name="<?= (isset($id_setting) && $id_setting > 0) ? 'update' : 'insert';?>" class="btn btn-default pull-right" value="<?=l("Sauvegarder et rester", "quotation");?>">
			</div><!--/ .panel-footer -->
		</div><!--/ .panel -->

	</form>



	

<?php
/*============================================================*/
} //END PAGE SETTING
/*============================================================*/