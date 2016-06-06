<?php
	if(!isset($productdetail)) goHome();
	$product_images = getProductsImaesBySize($productdetail['id'],'360x360',true);
	
	
	$product_similair =getSimProductByCategory($productdetail['id_category_default'],null);

	$products_attributes_values = getProductDeclinaisons($productdetail['id']);
	$isConnected = isConnected();
	/*	setViewdProduct($productdetail['id']);*/
	$long_description = htmlspecialchars_decode($productdetail['long_description']);
	$have_long_description = false;

	if ($long_description && rtrim(strip_tags($long_description)) != ""){
		$have_long_description = true;
	}

	$productdetail['name'] = stripslashes($productdetail['name']);

	/*if ($long_description && !empty(rtrim(strip_tags($long_description)))){
		$have_long_description = true;
	}*/


?>
<?php execute_section_hooks('sec_top_product'); ?>
<input type="hidden" value="<?= $productdetail['id']; ?>" id="product_id">
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?=l("Accueil", "artiza");?></a></li>
	  <li class=""><a href="#" title=""><?=l("Products", "artiza");?></a></li>
<!-- 	  <li class=""><a href="#" title="">Sous-catégorie</a></li>
	  <li class=""><a href="#" title="">Sous-catégorie</a></li> -->
	  <li class="active"><?= $productdetail['name'] ?></li>
	</ol>
	<h1><?= $productdetail['name']; ?></h1>
	<div class="product-block">
		<div class="row">
			<div class="col-sm-12 col-md-5">
			   <div id="carousel" class="carousel slide" data-ride="carousel">
				   <div class="carousel-inner">
				   	<?php 
				   		$cmpt = 0; 
				   		$thumbcarousel = array();
				   		$tmp = "";
				   	?>
				   	<?php if (!empty($product_images)): ?>
				   		<?php foreach ($product_images as $key => $value): ?>
				   		<?php 
				   			$cls = "";
				   			
				   			$tmp .= '<div data-target="#carousel" data-slide-to="'.$cmpt.'" class="thumb"><img class="update_p_dec" id="'.$value['id'].'" src="'.WebSite.$value['link'].'"></div>';
				   			if ($cmpt ==0) {
				   				$cls =  'active';
				   			}

				   			//echo $cmpt.'<br>';
				   			if ($cmpt != 0 && (($cmpt+1) %4 == 0 || ($cmpt+1) == count($product_images))) {
				   				$thumbcarousel[] = $tmp ;
				   				$tmp ="";
				   			}

				   			$cmpt++;

				   		?>

				   			<div class="item <?= $cls; ?>">
				   				<a id="<?= $value['id']; ?>" class="product_image_galery update_p_dec" autoclick="false" rel="group1" href="<?= WebSite.$value['link']; ?>">
					        	<img src="<?= WebSite.$value['link']; ?>">
					      	</a>
					      </div>
				   		<?php endforeach ?>
				   	<?php else: ?>
			      	<li data-thumb="<?= $themeDir; ?>images/no-image.jpg">
			    	    <img src="<?= $themeDir; ?>images/no-image.jpg" />
			    		</li>
				   	<?php endif ?>
				   </div>
				</div>
				<div class="clearfix">
					<?php //var_dump($thumbcarousel); ?>
					<?php if ($thumbcarousel && !empty($thumbcarousel)): ?>
				   <div id="thumbcarousel" class="carousel slide" data-interval="false">
				      <div class="carousel-inner">
				      	<?php  
				      		$j = 0;
				      		//var_dump($thumbcarousel);
				      		foreach ($thumbcarousel as $key => $tc) {
				      			if ($j==0) {
				      				echo ' <div class="item active">';
				      			}else
				      				echo ' <div class="item">';
				      			echo $tc;
				      			echo ' </div><!-- /item -->';
				      			$j++;
				      		}
				      	?>
				      </div>
				      <!-- /carousel-inner -->
				      <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
				      <span class="glyphicon glyphicon-chevron-left"></span>
				      </a>
				      <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
				      <span class="glyphicon glyphicon-chevron-right"></span>
				      </a>
				   </div>
				   <!-- /thumbcarousel -->
				   <?php endif ?>
				</div>
				<!-- /clearfix -->
			</div>
			<div class="col-sm-12 col-md-7">
				<div class="short_description_block">
					<!-- <p class="online_only"> Exclusivité web</p> -->
					<div id="short_description_content">
						<?php
						 //htmlspecialchars_decode($productdetail['short_description']);
						if (isset($productdetail['short_description']) && rtrim(strip_tags($productdetail['short_description'])) != ""){
						 	echo htmlspecialchars_decode($productdetail['short_description']);
						}
						 ?>
					</div>
					<p class="buttons_bottom_block">
						<?php if ($have_long_description): ?>
						<a class="lnk plus-detail" href="#"><?=l("Plus de détails...", "artiza");?></a>
						<?php endif ?>
					</p>
					<div class="short_description_pack">
							<!-- <h3>Contenu du pack</h3> 
					<div class="pack_content"> 1 x <a href="#">Coffret cadeau prestige chocolats assortis</a></div>
						<div class="pack_content"> 1 x <a href="#">Coffret cadeau prestige chocolats assortis</a></div>
						<div class="pack_content"> 1 x <a href="#">Coffret cadeau prestige chocolats assortis</a></div>
						<div class="pack_content"> 1 x <a href="#">Coffret cadeau prestige chocolats assortis</a></div> -->
					</div>
				</div>
				<div class="product_attributes">
					<input type="hidden" name="cu" value="" class="cu">
					<div class="row">
						<div class="col-md-6">
							<?php if ($isConnected): ?>
							<div class="attributes">
								<?php if (isset($products_attributes_values) && $products_attributes_values && !empty($products_attributes_values)): ?>
									<?php foreach ($products_attributes_values as $key => $att_val): ?>
										<div class="form-group">
											 <label for="<?= $att_val['attributes']['name']; ?>"><?= $att_val['attributes']['name']; ?> :</label>
												<select id="<?= $att_val['attributes']['name']; ?>" attrId="<?= $att_val['attributes']['id']; ?>">
													<?php foreach ($att_val['attribute_values'] as $key => $value): ?>
														<option title="<?=  $value['name']; ?>" value="<?= $value['id']; ?>" id="<?= $value['id']; ?>"><?= $value['name']; ?></option>
													<?php endforeach ?>
												</select>
										</div>
									<?php endforeach ?>
								<?php endif ?>
							</div>
							<?php endif ?>
						</div>
						<div class="col-md-6">
							<?php if (displayPrice()): ?>
							<div class="content_prices">
								<div class="product-price">
									<p><span id="product_sell_price" p="<?=$productdetail['sell_price']; ?>"><?= number_format($productdetail['sell_price'], 2, '.', ''); ?></span> €</p>
								</div>
								<div class="clearfix"></div>
								<!-- <p class="pack_price"><span>174,60 €</span> hors pack</p> -->
								<?php if (!empty($productdetail['reference'])): ?>
									<p id="product_reference"> <label><?= l("Référence :", "artiza");?> </label> <span class="editable"><?= $productdetail['reference'] ?></span></p>
								<?php endif ?>
								<!-- <p id="availability_statut"> <span id="availability_label">Disponibilité :</span> 
									<?php /*if ($productdetail['qty']>0): ?>
										<span class="available" id="availability_value"><i class="fa fa-check"></i> En stock</span>
									<?php else: ?>
										<span class="available" id="availability_value">Out of stock</span>
									<?php endif */?>
								</p> -->
								<!-- <p id="pQuantityAvailable"> <span id="quantityAvailable"><?= $productdetail['qty']; ?></span> <span id="quantityAvailableTxt" style="display:none">pièce disponible</span> <span id="quantityAvailableTxtMultiple">pièces disponibles</span></p> -->
								<div>
									<p><b>Poids:</b> <?= $productdetail['weight']; ?></p>
									<?php if ($productdetail['wholesale_price'] >0): ?>
										<p><b>Prix du lot (HT):</b> <?= $productdetail['wholesale_price']; ?> &euro;</p>
									<?php endif ?>
									
								</div>
							</div>
							<?php endif ?>
						</div>
					</div>
				</div>
				<div class="not_in_comm">
					<div class="alert alert-danger">
						<?=l("Ce produit n'existe pas dans cette déclinaison. <br> 
						Vous pouvez néanmoins en sélectionner une autre.", "artiza");?>
					</div>
				</div>
				
					 <p class="align_justify" id="loyalty"><?=l("En achetant ce produit vous pouvez gagner jusqu'à ", "artiza");?> <b><span id="loyalty_points"><?= $productdetail['loyalty_points']; ?></span> <?=l("points de fidélité", "artiza");?></b>.</p>
				
			<!-- 	<?php if (isset($productdetail['loyalty_points']) && $productdetail['loyalty_points'] != 0): ?>
				<?php endif ?> -->
					<div class="add_to_cart_block">
					  <p class="buttons_bottom_block" id="add_to_cart"> 
					   	<input type="submit" name="Submit" value="Ajouter au panier" class="exclusive ajax_add_to_cart_product_button" l="<?=$productdetail['id']; ?>" t="<?=$productdetail['name']; ?>"></p>
					  <p id="quantity_wanted_p"> <label>Quantité :</label> 
					   	<input type="number" name="qty" min="1" id="quantity_wanted" value="1">
					  </p>
					   <div class="clearfix"></div>
					</div>
					
				<!-- <?php if ($cart['selling_rule'] == 'cart'): ?>
					
				<?php elseif ($cart['selling_rule'] == 'quotation'): ?>
					<?php execute_section_hooks('sec_product_button'); ?>
				<?php endif ?> -->
					

				
				
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php $product_attachments = getAttachments($productdetail['id']); 
	
	?>

	<div class="row" style="padding-top: 20px;">
		<div class="col-sm-12 col-md-7">
			<div id="product-tabs">
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs idTabs idTabsShort clearfix" role="tablist">
			  	<?php if ($have_long_description): ?>
			    <li role="presentation" class="active"><a href="#idTab1" aria-controls="idTab1" role="tab" data-toggle="tab"><?=l("En savoir plus", "artiza");?></a></li>
			    <?php endif ?>
			    <?php if ($product_attachments && !empty($product_attachments)): ?>
			    <li role="presentation"><a href="#idTab2" <?php if(!$have_long_description) echo 'class="active"';?> aria-controls="idTab2" role="tab" data-toggle="tab"><?=l("Télécharger la fiche technique", "artiza");?></a></li>
			    <?php endif ?>
<!-- 			    <li role="presentation"><a href="#idTab3" aria-controls="idTab3" role="tab" data-toggle="tab">Personnalisation</a></li> -->
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content rte">
			    <div role="tabpanel" class="tab-pane active" id="idTab1">
						<?= $long_description; ?>
					</div>
					<div role="tabpanel" class="tab-pane" id="idTab2">
			    	<ul class="bullet" id="idTab2">
			    		<?php if ($product_attachments && !empty($product_attachments)): ?>
			    			<?php foreach ($product_attachments as $key => $value): ?>
			    				<li>
			    					<a download="<?= $value['name']; ?>" href="<?= WebSite.'files/attachments/'.$value['attachment']; ?>"><?= $value['name']; ?></a>
			    				</li>
			    			<?php endforeach ?>
			    		<?php endif ?>
			    	</ul>
			    </div>


			  </div>

			</div>
		</div>
		<?php $product_associated = getProductAssociated($productdetail['id']); ?>
		<?php if ($product_associated  && !empty($product_associated)): ?>
		<div class="col-sm-12 col-md-5">
			<div id="accessories_block">
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs  idTabs idTabsShort clearfix" role="tablist">
			    <li role="presentation" class="active"><a href="#Accessoires" aria-controls="Accessoires" role="tab" data-toggle="tab"><?=l("Accessoires", "artiza");?></a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="Accessoires">
			    	<div class="products_block accessories_block">
							<ul class="clearfix">
								<?php foreach ($product_associated as $key => $associated): ?>
									<?php $associated_img = getThumbnail($associated['id_product'],"45x45");?>
									 <li class="ajax_block_product first_item product_accessories_description">
								     <a class="product_image" href="<?= WebSite.'product/'.$associated['id_product'].'-'.$associated['permalink']; ?>" title="">
								     	<img class="replace-2x" src="<?= WebSite.$associated_img; ?>" alt="Coffret" style="height:45px;width:45px"></a>
								     <h5>
								     	<a href="<?= WebSite.'product/'.$associated['id_product'].'-'.$associated['permalink']; ?>" title="<?= $associated['name'] ?>"><?= $associated['name'] ?></a>
								     </h5>
								     <p class="price_container"> 
								     	<?php if ($isConnected): ?>
								     		<span class="price"><?= $associated['sell_price']; ?> &euro;</span>
								     	<?php endif ?>
								     </p>
								     <p class="accessories_btn">
								     	<a href="<?= WebSite.'product/'.$associated['id_product'].'-'.$associated['permalink']; ?>" class="button"><i class="fa fa-search"></i></a>
			  							<a href="<?= WebSite.'product/'.$associated['id_product'].'-'.$associated['permalink']; ?>" class="exclusive"><?=l("Voir ce Produit", "artiza");?></a>
								     </p>	
								     <div class="clearfix"></div>
								  </li>
								<?php endforeach ?>
							</ul>
						</div>
			    </div>
			  </div>
			</div>
		</div>
		<?php endif ?>
	</div>
	<?php if ($product_similair && !empty($product_similair)): ?>
		<h2 id="productscategory_h2"><?= count($product_similair);?> <?=l("autres produits dans la même catégorie :", "artiza");?></h2>
		<div id="productscategory">
			<div class="carousel slide media-carousel" id="media">
		    <div class="carousel-inner">
		    	<div class="item active">
		        	<div class="row">
				    <?php 
					$i = 1;
					foreach ($product_similair as $key => $value){ ?>
						<?php $img = getThumbnail($value['id'],'80x80'); ?>
			        	<div class="col-md-2">
				          <a class="thumbnail" href="<?= WebSite.'product/'.$value['id'].'-'.$value['permalink']; ?>"><img alt="" src="<?php if($img) echo WebSite.$img; else echo $themeDir.'images/no-image.jpg' ?>"></a>
				          <p class="productscategory_name"><a href="<?= WebSite.'product/'.$value['id'].'-'.$value['permalink']; ?>" title=""><?= $value['name']; ?></a></p>
				          <?php if ($isConnected): ?>
				          	<p class="productscategory_price"><?= number_format($value['sell_price'], 2, '.', '').' &euro;'; ?></p>
				          <?php endif ?>
				          
				        </div>
				    	<?php 
				    	if ($i%6 == 0 && $i != 1 && $i != count($product_similair)) {
				    		echo "</div></div>";
				    		echo '<div class="item"><div class="row">';
				    	}
				     	$i++; 
				 	} 
				    ?>
		    		</div>
				</div>
		    </div>
		    <a data-slide="prev" href="#media" id="productscategory_prev" class="" style="display: block;">‹</a>
		    <a data-slide="next" href="#media" id="productscategory_next" class="" style="display: block;">›</a>
		  </div>
		</div>
	<?php endif ?>