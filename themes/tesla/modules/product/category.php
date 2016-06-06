<?php 
	if (isset($_GET['ID']) && !empty($_GET['ID'])) {
		$categorydetail = getCategoryById($_GET['ID']);
		$condition = '';
		$orderby = " reference ASC";
		$page = 1;
		$perpage = 24;
		$isStartPage = false;
		if (isset($_GET['ID2']) && !empty($_GET['ID2'])) {
			$page = $_GET['ID2'];
		}else $isStartPage = true;

		if (isset($_POST['perpage'])) {
			$_SESSION['perpage'] = $_POST['perpage'];
			$page = 1;
		}
		if (isset($_POST['orderby'])) {
			$_SESSION['orderby'] = $_POST['orderby'];
		}else if(!isset($_GET['ID2'])){
			unset($_SESSION['orderby']);
		}
		if (isset($_SESSION['orderby'])) {
			if ($_SESSION['orderby'] == 1) {
				$orderby = " p.`sell_price` ASC";
			}else if ($_SESSION['orderby'] == 2) {
				$orderby = " p.`sell_price` DESC";
			}else if ($_SESSION['orderby'] == 3) {
				$orderby = " p.cdate DESC";
			}else{
				unset($_SESSION['orderby']);
			}
		}
		if (isset($_SESSION['perpage'])) {
			$perpage = $_SESSION['perpage'];
		}
		$ProductList = getProductListByCategory($_GET['ID'],$page,$perpage,$condition,$isStartPage,$orderby);
		$productdetail = $ProductList['result'];
		if (!$productdetail && !$categorydetail) 
			goHome(); 
		/*
		else if (!$productdetail) 
			die("<h1>Aucun product</h1>");
		*/
	}else 
		goHome(); 
?>

<ol class="breadcrumb">
	<li><a href="#" title=""><?=l("Accueil", "artiza");?></a></li>
	<li><a href="#" title=""><?=l("Categories", "artiza");?></a></li>
	<li class="active"><?= $categorydetail['name']; ?></li>
</ol>

<h1><?= $categorydetail['name']; ?>
	<?php 
		$condition = " id_category = ".$categorydetail['id'];
		$nbcat = getCount('product_category' ,$condition); 
	?>
	<?php if (!$nbcat || $nbcat ==0): ?>
		<span class="category-product-count"> <?=l("Aucun produit dans cette catégorie.", "artiza");?></span>
	<?php else: ?>
	<span class="category-product-count"> <?=l("Il y a", "artiza");?>  <?= $nbcat; ?> <?=l("produits", "artiza");?>.</span>
	<?php endif ?>
</h1>

	<?php $cat_img = getCatImg($categorydetail['id'],null);?><!-- '-category' -->
	<?php if ($cat_img): ?>
		<!-- category slider -->
		<div id="home-slider" class="carousel slide" data-ride="carousel">
	 		<!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="<?= WebSite.$cat_img;?>" alt="" style="margin: auto;">
		    </div>
		  </div>
		</div>
		<!-- ./category slider -->
	<?php endif ?>
	<?php if ($categorydetail['description'] &&  !empty($categorydetail['description'])): ?>
		<div class="cat_desc">
			<p><?= $categorydetail['description']; ?></p>
		</div>
	<?php endif ?>


<div id="subcategories">
	<?php $sub_category = getcategoryByParent($categorydetail['id']); ?>

   <ul class="inline_list row">
   	<?php foreach ($sub_category as $key => $value): ?>
			<li class="first_item_of_line col-xs-12 col-sm-6 col-md-3">
      	<div class="subc">
      		<a class="img hidden-xs" href="<?= $value['id'].'-'.$value['permalink']; ?>" title="<?= $value['name'] ?>"> 
      			<?php $cat_img = getCatImg($value['id'],null);?>
      			<?php if ($cat_img): ?>
      				<img src="<?= WebSite.$cat_img;?>" alt=""> 
      			<?php else: ?>
      				<img src="<?= $themeDir; ?>images/no-image-l.png" alt=""> 
      			<?php endif ?>
      		</a> 
      		<a class="cat_name" href="<?= $value['id'].'-'.$value['permalink']; ?>" title="<?= $value['name'] ?>"><?= $value['name'] ?></a>
      	</div>
      </li>
		<?php endforeach ?>
	</ul>
</div>
<?php if ($productdetail && !empty($productdetail)): ?>
<div class="content_sortPagiBar">
	<div class="sortPagiBar">
		<form method="POST" action="" name="filter" id="filter">
			<!-- <p>
				<input type="submit" class="bt_compare exclusive" value="Comparer">
			</p> -->
			<p>
				<label><?=l("Afficher :", "artiza");?></label>
				<select  name="perpage" class="submit-filter"><!-- id="perpage-select" -->
					<option value="24" <?php if($perpage == 24) echo 'selected="selected"'; ?>>24</option>
					<option value="48" <?php if($perpage == 48) echo 'selected="selected"'; ?>>48</option>
					<option value="120" <?php if($perpage==  120) echo 'selected="selected"'; ?>>120</option>
					<option value="120" <?php if($perpage==  120) echo 'selected="selected"'; ?>>120</option>
				</select>
			</p>
			<p>
				<label><?=l("Tri :", "artiza");?></label>
				<select class="submit-filter" name="orderby">
					<option <?= (!isset($_SESSION['orderby'])) ? 'selected="selected"' : '' ?>>--</option>
					<option value="1" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==1) ? 'selected="selected"' : '' ?>><?= l("Du – cher au + cher", "artiza");?></option>
					<option value="2" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==2) ? 'selected="selected"' : '' ?>><?= l("Du + cher au – cher", "artiza");?></option>
					<option value="3" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==3) ? 'selected="selected"' : '' ?>><?= l("Nouveauté", "artiza");?></option>
					<option value="4" <?= (isset($_SESSION['orderby']) && $_SESSION['orderby'] ==4) ? 'selected="selected"' : '' ?>><?= l("Popularité", "artiza");?></option>
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
			  			<a class="lnk_view"  href="<?= WebSite.'product/'.$value['id'] ?>" title="<?= l("Voir ce produit", "artiza");?>"><?=l("Voir ce produit", "artiza");?> </a>
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
			  			<p><?= $value['sell_price'];?> &euro;</p>
			  		</div>
			  		<?php endif ?>
			  		<?php if ($value['qty']>0): ?>
							<span class="available" id="availability_value"><i class="fa fa-check"></i><?=l("En stock", "artiza");?> </span>
						<?php else: ?>
							<span class="" id="availability_value"><?=l("Out of stock", "artiza");?></span>
						<?php endif ?>

			  		<!-- <p class="compare"> 
			  			<input type="checkbox" onclick="checkForComparison(3)" id="comparator_item_1" class="comparator" value="1"> 
			  			<label for="comparator_item_1">Comparer</label>
			  		</p> -->
			  		<div class="btns">
			  			<a class="button"><i class="fa fa-search"></i></a>
			  			<a l="<?=$value['id']; ?>" t="<?=$value['name']; ?>" q="1" href="#" class="exclusive ajax_add_to_cart_button" idproduct="<?= $value['id']; ?>" p="<?= $value['sell_price'];?>"><?=l("Ajouter au panier", "artiza");?></a>
			  			<!-- <a href="" class="exclusive ">Ajouter au panier</a> -->
						<!-- <a href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>" class="exclusive"> Voir ce produit</a> -->
			  			
			  			<!-- <?php if ($value['qty']>0): ?>
			  				<a href="#" class="exclusive ajax_add_to_cart_button" idproduct="<?= $value['id']; ?>"><?=l("Ajouter au panier", "artiza");?></a>
			  			<?php else: ?>
			  				<a href="<?=  WebSite.'product/'.$value['id'].'-'.$value['permalink'] ?>" class="exclusive"> <?=l("Voir ce produit", "artiza");?></a>
			  			<?php endif ?> -->

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