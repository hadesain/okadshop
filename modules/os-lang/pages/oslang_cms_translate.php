<?php
/*============================================================*/
 //begin oslang_product_translate function
/*============================================================*/

function page_oslang_cms_translate(){
	global $hooks;
	$cms = $hooks->select('cms',array('*'));
	$langs = $hooks->select('langs',array('*'));
	$ajax_url = "../modules/os-lang/ajax/";
?>
<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-language"></i> <?= l('Traduire une Page','oslang'); ?>
		</h3>
	</div>
	<div class="top-menu-button">
    <a href="#" type="button" class="btn btn-primary"><?= l('Liste des Page','oslang'); ?></a>
  </div>
</div><br>


<div class="panel panel-default">
	<form class="form-horizontal" id="oslang_cms_form" method="post" action="<?= $ajax_url ;?>product.php">
		<input type="hidden" name="action" value="" id="action"/>
		<div class="panel-heading"><?= l('Ajouter la traduction d\'une Page','oslang'); ?></div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="based_product"><?= l('Nom Original du Page','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="chosen getcmstext" id="based_product" name="id_cms"><!-- chosen -->
						<option value="" selected><?= l('Sélectionnez une Page','oslang'); ?></option>
						<?php foreach ($cms as $key => $value) : ?>
			      	<option value="<?php echo $value['id'];?>">
			      		<?php echo $value['title'];?>
			      	</option>
			      <?php endforeach;?>
          </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="lang"><?= l('Langue','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="getcmstext chosen" id="" name="code_lang"><!-- chosen -->
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
				<label class="col-md-3 control-label" for="title"><?= l('Nom','oslang'); ?></label>  
				<div class="col-md-4">
					<input id="title" name="title" type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="description"><?= l('Description','oslang'); ?></label>
				<div class="col-md-8">                     
					<textarea class="form-control summernote" name="description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="content"><?= l('content','oslang'); ?></label>
				<div class="col-md-8">      
					<textarea class="form-control summernote" name="content"></textarea>
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
		/**/
		$("form#oslang_cms_form").submit(function(event){
	    event.preventDefault();
	    $('#action').val('saveCmsTranslate');
	    submit_ajax_form("oslang_cms_form", function(data) {
	    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
	    	else if( data["msg"] ) os_message_notif( data["msg"] );
	    });
	    return false;

	  });

		//
		$("select.getcmstext").change(function(){
			$('#action').val('getcmstext');
			$('input[name="title"]').val('');
			$('textarea[name="description"]').code('');
			$('textarea[name="content"]').code('');
			submit_ajax_form("oslang_cms_form", function(data) {
				if( data["result"] ){
					console.log();
					$('input[name="title"]').val(data['result']['title']);
					$('textarea[name="description"]').code(data['result']['description']);
					$('textarea[name="content"]').code(data['result']['content']);
				}
	    });
			return false;
		});

		//
	/*	$("#search").keyup(function(){
			$('#action').val('search');
			submit_ajax_form("oslang_product_form", function(data) {
				if( data["result"] ){
					$('select[name="id_product"]').val(data["result"]['id']);
				}	
	    });
	    $("#search").focus();
			return false;
		});*/
		

	});
</script>









<?php
/*============================================================*/
} //END 
/*============================================================*/