<?php
function page_product_edit(){
	$os_product = new OS_Product();
	$products  = $os_product->get_products_list();
	$taxes 		 = $os_product->select('taxes', array('id', 'name', 'rate'), "WHERE active=1");

?>
<style>
#load_product{
	border: 2px solid #A5245E;
}
</style>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-list-alt"></i> <?=l("Édition rapide des produits", "fast_edit");?></h3>
  </div>
</div><br>

	<div class="panel panel-default tab-pane fade in active" id="Product">
		<div class="panel-heading"><?=l("Informations de Produit", "fast_edit");?></div>
		<div class="panel-body">

			<div class="row">
				<div class="form-group col-md-4">
					<select data-placeholder="<?=l("Sélectionnez un produit", "fast_edit");?>" class="chosen" id="load_product">
					<!--<select class="form-control" id="load_product"> chosen -->
						<option value="" selected><?=l("Sélectionnez un produit", "fast_edit");?></option>
						<?php foreach ($products as $key => $value) : ?>
            	<option value="<?php echo $value['id'];?>">
            		<?php echo $value['name'];?>
            	</option>
            <?php endforeach;?>
          </select>
				</div>
				<div class="form-group col-sm-4">
					<input type="number" min="0" step="1" class="form-control" id="quantity" value="" placeholder="<?=l("Quantité", "fast_edit");?>">
				</div>
				<div class="form-group col-sm-4">
					<input type="number" min="1" step="1" class="form-control" id="min_quantity" value="" placeholder="<?=l("Quantité minimal", "fast_edit");?>">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<input type="text" class="form-control" id="product_name" value="" placeholder="<?=l("Nom de produit", "fast_edit");?>" required>
				</div>
				<div class="form-group col-sm-4">
					<input type="text" class="form-control" id="product_reference" value="" placeholder="<?=l("Référence", "fast_edit");?>">
				</div>
				<div class="form-group col-sm-4">
					<input type="number" min="0" step="1" class="form-control" id="loyalty_points" value="" placeholder="<?=l("Points de fidélité", "fast_edit");?>">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<input type="text" class="form-control" id="product_ean13" value="" placeholder="<?=l("Code-barres EAN-13 ou JAN", "fast_edit");?>">
				</div>
				<div class="form-group col-sm-4">
					<input type="text" class="form-control" id="product_upc" value="" placeholder="<?=l("Code-barres UPC", "fast_edit");?>">
				</div>
				<div class="form-group col-sm-4">
					<select class="form-control" id="product_condition">
						<option value="new" selected><?=l("Nouveau", "fast_edit");?></option>
						<option value="used"><?=l("Utilisé", "fast_edit");?></option>
						<option value="refurbished"><?=l("Reconditionné", "fast_edit");?></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<input type="number" min="0" step="0.01" class="form-control" id="product_price" value="" placeholder="<?=l("Prix de vente HT", "fast_edit");?>">
				</div>
				<div class="form-group col-sm-4">
					<select class="form-control" id="id_tax">
          	<option value="0" selected><?=l("Règle de taxe", "fast_edit");?></option>
            <?php if( !empty($taxes) ) : ?>
            <?php foreach ($taxes as $key => $tax) : ?>
              <option value="<?php echo $tax['id'] ?>"><?php echo $tax['name']. ' '. $tax['rate'] .'%'; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
				</div>
				<div class="form-group col-sm-4">
					<div class="input-group">
						<input type="number" min="0" step="0.01" class="form-control" placeholder="<?=l("Remise", "fast_edit");?>" id="discount">
						<span class="input-group-addon" style="padding: 0px;border: 0px;">
							<select id="discount_type" class="form-control" style="width: 70px;">
								<option value="0" selected>%</option>
								<option value="1">&#128;</option>
							</select>
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<div class="input-group">
						<input type="number" min="0" step="0.01" placeholder="<?=l("Poids", "fast_edit");?>" value="" class="form-control" id="weight">
						<span class="input-group-addon"><?=l("KG", "fast_edit");?></span>
					</div>
				</div>
				<div class="form-group col-sm-4">
					<div class="input-group">
						<input type="number" min="0" step="0.01" placeholder="<?=l("Hauteur", "fast_edit");?>" value="" class="form-control" id="height">
						<span class="input-group-addon"><?=l("CM", "fast_edit");?></span>
					</div>
				</div>
				<div class="form-group col-sm-4">
					<div class="input-group">
						<input type="number" min="0" step="0.01" placeholder="<?=l("Largeur", "fast_edit");?>" value="" class="form-control" id="width">
						<span class="input-group-addon"><?=l("CM", "fast_edit");?></span>
					</div>
				</div>
			</div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<a href="javascript:;" class="btn btn-danger cancel"><?=l("Annuler", "fast_edit");?></a>
			<a href="javascript:;" class="btn btn-primary pull-right" id="update_product"><?=l("Sauvegarder les informations", "fast_edit");?></a>
		</div><!--/ .panel-footer -->
	</div><!--/ .panel -->


<script>
$(document).ready(function(){

	//load product
	$('#load_product').on('change', function(){
		var id_product = $(this).find('option:selected').val();
    $.ajax({
      type: "POST",
      data: {id_product:id_product},
      url: '../modules/os-fast-product-edit/ajax/load-product.php',
      success: function(data){
      	var data = $.parseJSON(data);
      	var product_name = data['name'].replace(/\\/g, '');
      	$('#product_name').val(product_name);
      	$('#product_reference').val(data['reference']);
      	$('#quantity').val(data['qty']);
      	$('#min_quantity').val(data['min_quantity']);
      	$('#loyalty_points').val(data['loyalty_points']);
      	$('#product_ean13').val(data['ean13']);
      	$('#product_upc').val(data['upc']);
      	$("#product_condition option[value='"+ data['product_condition'] +"']").prop("selected", true);
      	$('#product_price').val(data['sell_price']);
      	$("#id_tax option[value='"+ data['id_tax'] +"']").prop("selected", true);
      	$('#discount').val(data['discount']);
      	$("#discount_type option[value='"+ data['discount_type'] +"']").prop("selected", true);
      	$('#weight').val(data['weight']);
      	$('#height').val(data['height']);
      	$('#width').val(data['width']);
      	//message de notif
				os_message_notif("<?=l('Le produit a été chargé avec success.', 'fast_edit');?>");
      }
    });
	});

	//update product
	$('#update_product').on('click', function(){
		var product = {};
		product['name'] 						 = $('#product_name').val().replace(/'/g, "\\'");
		product['reference'] 				 = $('#product_reference').val();
		product['qty'] 					 		 = $('#quantity').val();
		product['min_quantity'] 		 = $('#min_quantity').val();
		product['upc'] 							 = $('#product_upc').val();
		product['ean13'] 						 = $('#product_ean13').val();
		product['product_condition'] = $('#product_condition').val();
		product['sell_price'] 			 = $('#product_price').val();
		product['discount'] 				 = $('#discount').val();
		product['discount_type'] 		 = $('#discount_type').val();
		product['width'] 						 = $('#width').val();
		product['height'] 					 = $('#height').val();
		product['weight'] 					 = $('#weight').val();
		product['loyalty_points'] 	 = $('#loyalty_points').val();
		// product is the parameter sent to the success function in the ajax handle
		product = JSON.stringify( product , null, '\t');
    $.ajax({
      type: "POST",
      data: {
      	product:product, 
      	id_product:$('#load_product option:selected').val()
      },
      url: '../modules/os-fast-product-edit/ajax/update-product.php',
      success: function(data){
      	//message de notif
				os_message_notif("<?=l('Le produit a été mise à jour avec success.', 'fast_edit');?>");
      }
    });
	});
	//cancel
	$('.cancel').on('click', function(){
		$('input').val('');
	});

});
</script>
<?php
/*============================================================*/
} //END PAGE SETTING
/*============================================================*/