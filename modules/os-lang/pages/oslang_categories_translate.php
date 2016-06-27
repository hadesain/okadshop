<?php
/*============================================================*/
 //begin oslang_product_translate function
/*============================================================*/

function page_oslang_categories_translate(){
	global $hooks;
	$categories = $hooks->select('categories',array('*'));
	$langs = $hooks->select('langs',array('*'));
	$ajax_url = "../modules/os-lang/ajax/";
?>
<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-language"></i> <?= l('Traduire une categorie','oslang'); ?> 	
		</h3>
	</div>
	<div class="top-menu-button">
    <a href="#" type="button" class="btn btn-primary"><?= l('Liste des categories','oslang'); ?></a>
  </div>
</div><br>


<div class="panel panel-default">
	<form class="form-horizontal" id="oslang_categories_form" method="post" action="<?= $ajax_url ;?>product.php">
		<input type="hidden" name="action" value="" id="action"/>
		<div class="panel-heading"><?= l('Ajouter la traduction d\'une categorie','oslang'); ?></div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="based_product"><?= l('Nom Original du categorie','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="chosen getcategorytext" id="based_product" name="id_category"><!-- chosen -->
						<option value="" selected><?= l('Sélectionnez une categorie','oslang'); ?></option>
						<?php foreach ($categories as $key => $categorie) : ?>
			      	<option value="<?php echo $categorie['id'];?>">
			      		<?php echo $categorie['name'];?>
			      	</option>
			      <?php endforeach;?>
          </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="lang"><?= l('Langue','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="getcategorytext chosen" id="" name="code_lang"><!-- chosen -->
						<option value="" selected><?= l('Sélectionnez une Langue','oslang'); ?></option>
						<?php foreach ($langs as $key => $lang) : ?>
			      	<option value="<?php echo $lang['code'];?>">
			      		<?php echo $lang['name'];?>
			      	</option>
			      <?php endforeach;?>
          </select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label class="col-md-3 control-label" for="Name"><?= l('Nom','oslang'); ?></label>  
				<div class="col-md-4">
					<input id="Name" name="name" type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="description"><?= l('Description','oslang'); ?></label>
				<div class="col-md-8">      
					<textarea class="form-control summernote" name="description"></textarea>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#" class="btn btn-default"><?= l('Annuler','oslang'); ?></a>
			<span class="pull-right">
				<input type="submit" name="" class="btn btn-success" value="<?= l('Sauvegarder','oslang'); ?>">
			</span>
		</div><!--/ .panel-footer -->
	</form>
</div>


<script>
	$(document).ready(function(){
		//submit form
		$("form#oslang_categories_form").submit(function(event){
	    event.preventDefault();
	    $('#action').val('saveCategoriesTranslate');
	    submit_ajax_form("oslang_categories_form", function(data) {
	    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
	    	else if( data["msg"] ) os_message_notif( data["msg"] );
	    });
	    return false;

	  });

		//
		$("select.getcategorytext").change(function(){
			$('#action').val('getcategorytext');
			$('input[name="name"]').val('');
			$('textarea[name="description"]').code('');
			submit_ajax_form("oslang_categories_form", function(data) {
				if( data["result"] ){
					console.log();
					$('input[name="name"]').val(data['result']['name']);
					$('textarea[name="description"]').code(data['result']['description']);
				}
	    });
			return false;
		});

	});
</script>









<?php
/*============================================================*/
} //END 
/*============================================================*/