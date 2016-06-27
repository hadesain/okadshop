<?php
/*============================================================*/
 //begin oslang_product_translate function
/*============================================================*/

function page_oslang_product_translate(){
	global $hooks;
	$products = $hooks->select('products',array('*'));
	$langs = $hooks->select('langs',array('*'));
	$ajax_url = "../modules/os-lang/ajax/";
?>
<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-language"></i> <?= l('Traduire une produit','oslang'); ?>
		</h3>
	</div>
	<div class="top-menu-button">
    <a href="#" type="button" class="btn btn-primary"><?= l('Liste des produit','oslang'); ?></a>
  </div>
</div><br>


<div class="panel panel-default">
	<form class="form-horizontal" id="oslang_product_form" method="post" action="<?= $ajax_url ;?>product.php">
		<input type="hidden" name="action" value="" id="action"/>
		<div class="panel-heading"><?= l('Ajouter la traduction d\'un produit','oslang'); ?></div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="based_product"><?= l('Nom Original du produit','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="chosen getproducttext" id="based_product" name="id_product"><!-- chosen -->
						<option value="" selected><?= l('Sélectionnez un produit','oslang'); ?></option>
						<?php foreach ($products as $key => $product) : ?>
			      	<option value="<?php echo $product['id'];?>">
			      		<?php echo $product['name'];?>
			      	</option>
			      <?php endforeach;?>
          </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="lang"><?= l('Langue','oslang'); ?></label>  
				<div class="col-sm-4">
					<select class="getproducttext chosen" id="" name="code_lang"><!-- chosen -->
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
				<label class="col-md-3 control-label" for="short_description"><?= l('Résumé','oslang'); ?></label>
				<div class="col-md-8">                     
					<textarea class="form-control summernote" name="short_description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="long_description"><?= l('Description','oslang'); ?></label>
				<div class="col-md-8">      
					<textarea class="form-control summernote" name="long_description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="meta_title"><?= l('meta title','oslang'); ?></label>  
				<div class="col-md-4">
					<input id="meta_title" name="meta_title" type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="meta_description"><?= l('meta description','oslang'); ?></label>
				<div class="col-md-8">      
					<textarea class="form-control " name="meta_description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="meta_keywords"><?= l('meta keywords','oslang'); ?></label>
				<div class="col-md-8">      
					<textarea class="form-control " name="meta_keywords"></textarea>
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
		$("form#oslang_product_form").submit(function(event){
	    event.preventDefault();
	    $('#action').val('saveProductTranslate');
	    submit_ajax_form("oslang_product_form", function(data) {
	    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
	    	else if( data["msg"] ) os_message_notif( data["msg"] );
	    });
	    return false;

	  });

		//
		$("select.getproducttext").change(function(){
			$('#action').val('getproducttext');
			$('input[name="name"]').val('');
			$('textarea[name="short_description"]').code('');
			$('textarea[name="long_description"]').code('');
			$('textarea[name="meta_title"]').code('');
			$('textarea[name="meta_description"]').code('');
			$('textarea[name="meta_keywords"]').code('');
			submit_ajax_form("oslang_product_form", function(data) {
				if( data["result"] ){
					console.log(data["result"]);
					$('input[name="name"]').val(data['result']['name']);
					$('textarea[name="short_description"]').code(data['result']['short_description']);
					$('textarea[name="long_description"]').code(data['result']['long_description']);
					$('input[name="meta_title"]').val(data['result']['meta_title']);
					$('textarea[name="meta_description"]').text(data['result']['meta_description']);
					$('textarea[name="meta_keywords"]').text(data['result']['meta_keywords']);
				}
	    });
			return false;
		});

		//
		/*$("#search").keyup(function(){
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