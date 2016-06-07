<?php 
//var_dump($_POST);
if (isset($_POST['search_query']) && !empty($_POST['search_query'])) {
	$options = array(
		"search_query" => $_POST['search_query']
	);
	$productdetail = getProductByOption($options);
	//var_dump($productdetail);
}

//$productdetail = getHomeProduct(); 

?>
<ol class="breadcrumb">
	<li><a href="#" title=""><?= l("Accueil", "tesla");?></a></li>
	<li class="active"><?= l("Recherche", "tesla");?></li>
</ol>

<!-- <h1>Recherche "<?= $_POST['search_query']; ?>"</h1> -->
<?php if (isset($productdetail) && $productdetail && !empty($productdetail)): ?>
<p class="warning"> <span class="big"><?= count($productdetail); ?>&nbsp;<?= l("résultats ont été trouvés.", "tesla");?></span></p>


<div class="product-list">
<!-- 	<h4>Produits phares</h4> -->
	  <div class="row padding15">
  	<?php foreach ($productdetail as $key => $value): ?>
  	<?php $img = getThumbnail($value['id'],'200x200'); ?>
  		<div class="col-xs-6 col-sm-4 col-md-3 paddingleft0">
	  		<div class="product-item">
	  			<div class="box1">
	  				<div class="product_img_container">
			  			<a class="product_image"  href="<?= WebSite.'product/'.$value['id'].'-'.$value['permalink']; ?>">
			  				<img src="<?php if($img) echo WebSite.$img; else echo $themeDir.'images/no-image.jpg' ?>">
			  			</a>
			  			<a class="lnk_view"  href="<?= WebSite.'product/'.$value['id'] ?>" title="<?= l("Voir ce produit", "tesla");?>"><?= l("Voir ce produit", "tesla");?></a>
			  		</div>
			  		<div class="product_desc">
			  			<p>
			  				
			  				<a href="<?= WebSite.'product/'.$value['id'].'-'.$value['permalink']; ?>"><?= $value['name']; ?></a>
			  			</p>
			  			<div class="short-description">
			  				<?= strip_tags($value['short_description']); ?>
			  			</div>
			  		</div>
	  			</div>
	  			<div class="box2">
	  				<?php if (isConnected()): ?>
	  				<div class="product-price">
			  			<p><?= $value['sell_price'];?> &euro;</p>
			  		</div>
			  		<?php endif ?>
<!-- 			  		<?php if ($value['qty']>0): ?>
							<span class="available" id="availability_value"><i class="fa fa-check"></i> En stock</span>
						<?php else: ?>
							<span class="" id="availability_value">Out of stock</span>
						<?php endif ?> -->

			  		<!-- <p class="compare"> 
			  			<input type="checkbox" onclick="checkForComparison(3)" id="comparator_item_1" class="comparator" value="1"> 
			  			<label for="comparator_item_1">Comparer</label>
			  		</p> -->
			  		<div class="btns">
			  			<a class="button"><i class="fa fa-search"></i></a>
			  			<!-- <a href="" class="exclusive ">Ajouter au panier</a> -->
						<!-- <a href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>" class="exclusive"> Voir ce produit</a> -->
			  			<?php if (isConnected()): ?>
			  				<a href="#add_to_quoataion_form" class="exclusive add_to_quoataion_btn" idproduct="<?= $value['id']; ?>"><?= l("Ajouter au devis", "tesla");?></a>
			  			<?php else: ?>
			  				<a href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>" class="exclusive"> <?= l("Voir ce produit", "tesla");?></a>
			  			<?php endif ?>
			  		</div>
	  			</div>
	  		</div>
	  	</div>
  	<?php endforeach ?>
  </div>
</div>

<?php else: ?>	
	<p class="warning"> <span class="big"><?= l("Aucun résultat trouvé", "tesla");?> "<?php if(isset($_POST['search_query'])) echo $_POST['search_query']; ?>"</span></p>
<?php endif ?>
