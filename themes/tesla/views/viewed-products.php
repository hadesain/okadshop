<?php 
		$ViewdProduct = getViewdProduct();
		$ViewdProduct = implode(',', $ViewdProduct);
		if (!empty($ViewdProduct)) {
			$condition = " p.id in ($ViewdProduct)";
			$params = array(
							"orderby" => " reference ASC",
							"page" => 1,
							"perpage" => 24,
							"isStartPage" => false,
						);

			$orderby = " reference ASC";
			$page = 1;
			$perpage = 24;
			$isStartPage = false;

			if (isset($_GET['ID2']) && !empty($_GET['ID2'])) {
				$params['page'] = $_GET['ID2'];

			}else $params['isStartPage'] = true;

			if (isset($_POST['perpage'])) {
				$_SESSION['perpage'] = $_POST['perpage'];
				$params['page'] =  1;
			}
			if (isset($_POST['orderby'])) {
				$_SESSION['orderby'] = $_POST['orderby'];
			}
			if (isset($_SESSION['orderby'])) {
				if ($_SESSION['orderby'] == 1) {
						$params['orderby'] = " p.`sell_price` ASC";
				}else if ($_SESSION['orderby'] == 2) {
						$params['orderby'] = " p.`sell_price` DESC";
				}else if ($_SESSION['orderby'] == 3) {
						$params['orderby'] = " p.cdate DESC";
				}else{
					unset($_SESSION['orderby']);
				}
			}
			if (isset($_SESSION['perpage'])) {
					$params['perpage'] = $_SESSION['perpage'];
			}
			$ProductList = getProductListByOptions($page,$perpage,$params,$condition);
			$productdetail = $ProductList['result'];
			if (!$productdetail) 
				goHome();
		}
		 
		/*
		else if (!$productdetail) 
			die("<h1>Aucun product</h1>");
		*/
?>

<ol class="breadcrumb">
	<li><a href="#" title="<?=l("Accueil", "tesla");?>"><?=l("Accueil", "tesla");?></a></li>
	<li class="active"><?=l("Produits déjà vus", "tesla");?></li>
</ol>

<h1><?=l("Produits déjà vus", "tesla");?>
	<?php 
		$nbproduct = count(explode(',', $ViewdProduct)); 
	?>
	<?php if (!$nbproduct || $nbproduct ==0 || $ViewdProduct == null): ?>
		<span class="category-product-count"> <?=l("Aucun produit.", "tesla");?></span>
	<?php else: ?>
	<span class="category-product-count"> <?=l("Il y a", "tesla");?>  <?= $nbproduct; ?> <?=l("produits.", "tesla");?></span>
	<?php endif ?>
</h1>

<?php if ($productdetail && !empty($productdetail)): ?>
<div class="content_sortPagiBar">
	<div class="sortPagiBar">
		<form method="POST" action="" name="filter" id="filter">
			<!-- <p>
				<input type="submit" class="bt_compare exclusive" value="Comparer">
			</p> -->
			<p>
				<label><?=l("Afficher :", "tesla");?></label>
				<select  name="perpage" class="submit-filter"><!-- id="perpage-select" -->
					<option value="24" <?php if($perpage == 24) echo 'selected="selected"'; ?>>24</option>
					<option value="48" <?php if($perpage == 48) echo 'selected="selected"'; ?>>48</option>
					<option value="120" <?php if($perpage==  120) echo 'selected="selected"'; ?>>120</option>
					<option value="120" <?php if($perpage==  120) echo 'selected="selected"'; ?>>120</option>
				</select>
			</p>
			<p>
				<label><?=l("Tri :", "tesla");?></label>
				<select class="submit-filter" name="orderby">
					<option <?= (!isset($_SESSION['orderby'])) ? 'selected="selected"' : '' ?>>--</option>
					<option value="1" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==1) ? 'selected="selected"' : '' ?>><?=l("Du – cher au + cher", "tesla");?></option>
					<option value="2" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==2) ? 'selected="selected"' : '' ?>><?=l("Du + cher au – cher", "tesla");?></option>
					<option value="3" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==3) ? 'selected="selected"' : '' ?>><?=l("Nouveauté", "tesla");?></option>
					<option value="4" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==4) ? 'selected="selected"' : '' ?>><?=l("Popularité", "tesla");?></option>
				</select>
			</p>
			<span class="gridorlist hidden-xs"> 
				<a class="gridview active" href="javascript:;" title="Grille"><i class="fa fa-th-large"></i></a> 
				<a class="listview" href="javascript:;" title="Liste"><i class="fa fa-list-ul"></i></a> 
			</span>
		</form>
	</div>
</div>

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
			  			<a class="lnk_view"  href="<?= WebSite.'product/'.$value['id'] ?>" title="<?=l("Voir ce produit", "tesla");?>"> <?=l("Voir ce produit", "tesla");?></a>
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
	  				<?php if (displayPrice()): ?>
	  				<div class="product-price">
			  			<p><?= $value['sell_price'];?> <?= CURRENCY; ?></p>
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
			  			<a class="button"  href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>"><i class="fa fa-search"></i></a>
			  			<?php if (displayAddToCart($value['qty'])): ?>
			  				<a l="<?=$value['id']; ?>" t="<?=$value['name']; ?>" q="1" href="#" class="exclusive ajax_add_to_cart_button" idproduct="<?= $value['id']; ?>" p="<?= $value['sell_price'];?>"><?=l("Ajouter au panier", "tesla");?></a>
			  			<?php else: ?>
			  				<a href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>" class="exclusive"> <?=l("Voir ce produit", "tesla");?> </a>
			  			<?php endif ?>
			  		</div>
	  			</div>
	  		</div>
	  	</div>
  	<?php endforeach ?>
  </div>
</div>

<div class="content_sortPagiBar">
	<div class="sortPagiBar">
		<!-- <p>
			<input type="submit" class="bt_compare exclusive" value="Comparer">
		</p> -->
		<?php
			if ($ProductList['total'] > $perpage) {
	      echo '<center>'.$ProductList['links_html'].'</center>';
	    }
		 ?>
	</div>
</div>
<?php endif ?>
<?php  execute_section_hooks( 'sec_category_page'); ?>