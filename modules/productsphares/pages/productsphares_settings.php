<?php
/*============================================================*/
 //begin featuredproduct_settings function
/*============================================================*/




function page_productsphares_settings(){
	global $hooks;
	$products = $hooks->select('products',array('*'));
	$home_product = $hooks->select('home_product',array('id_product'),' ORDER BY position ASC');
	if ($home_product)
		$home_product_ids = implode(",", array_column( $home_product,'id_product'));
	else
		$home_product_ids = "";
	$products_list = array();
	if (!empty($home_product_ids)) {
		$products_list = $hooks->select('products',array('*')," WHERE id in ($home_product_ids)");
	}
	
	//var_dump($products_list);
	
?>


<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-cog"></i> <?= l('Home product','productsphares'); ?>  :<?= l('Page configuration','productsphares'); ?>
		</h3>
	</div>
	<div class="top-menu-button">
  </div>
</div><br>
<div class="panel panel-default">
	<div class="panel-body">
		<form  method="POST" id="productsphares_form" action="../modules/productsphares/php/ajax.php">
			<input type="hidden" name="action" value="" id="action"/>
			<input type="hidden" name="idproduct_delete" value="" id="idproduct_delete"/>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="based_product"><?= l('liste des produits','productsphares'); ?></label>  
				<div class="col-sm-4">
					<select class="chosen getproducttext" id="based_product" name="id_product"><!-- chosen -->
						<option value="" selected><?= l('Sélectionnez un produit','productsphares'); ?></option>
						<?php foreach ($products as $key => $product) : ?>
					      	<option value="<?php echo $product['id'];?>">
					      		<?php echo $product['name'];?>
					      	</option>
				      <?php endforeach;?>
	      			</select>
				</div>
				<div class="col-sm-4">
					<input type="submit" name="" class="btn btn-success" value="<?= l('Ajouté','productsphares'); ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="panel-subheading col-sm-12">
					<i class="fa fa-picture-o"></i>
					<strong><?=l("liste des produit dans la page d'accueil.", "productsphares");?></strong>
					<ul class="list-inline" id="images">
						<?php 
						if ($products_list) {
						foreach ($products_list as $key => $value) { 
							$img = getThumbnail($value['id'],'45x45');
							//var_dump($value['id']);
							if($img) 
				        		$src =  WebSite.$img; 
				        	else 
				        		$src =  themeDir.'images/no-image.jpg';
						?>
							<li class="text-center">
								<label for="">
									<img src="<?=$src;?>" class="img-thumbnail" id="">
								</label>
								<div class="text-center">
									<label class="control-label" for=""><?= $value['name']; ?></label>
								</div>
								<div class="text-center">
									<a data-name="" id="<?= $value['id']; ?>" class="btn btn-danger delete_home_product" href="javascript:;"><i class="fa fa-trash"></i></a>
								</div>
							</li>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){

		//submit form
		$(".delete_home_product").click(function(){
			$('#action').val('delete_home_product');
			$('#idproduct_delete').val($(this).attr('id'));
		    submit_ajax_form("productsphares_form", function(data) {
		    	console.log(data);
		    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
		    	else if( data["msg"] ) location.reload();
		    });
		    return false;
		 });


		//submit form
		$("form#productsphares_form").submit(function(event){
		    event.preventDefault();
		    $('#action').val('saveProductHome');
		    submit_ajax_form("productsphares_form", function(data) {
		    	if( data["error"] ) os_message_notif( data["error"] ,'warning');
		    	else if( data["msg"] ) location.reload();
		    });
		    return false;

		  });


	});
</script>





<?php
/*============================================================*/
} //END 
/*============================================================*/