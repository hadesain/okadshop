<?php
$cUser = getCurrentUser();
?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Plan du site", "tesla");?></li>
	</ol>

	<h1><?= l("Plan du site", "tesla");?></h1>
	<div class="sitemap">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<div id="sitemap_content">
					<div class="row">
						<div class="col-sm-6">
							<div class="sitemap_block">
					         <h3><?= l("Nos offres", "tesla");?></h3>
					         <ul>
					            <li><a href="<?=WebSite ?>views/new-products" title="<?= l("Nouveaux produits", "tesla");?>"><?= l("Nouveaux produits", "tesla");?></a></li>
					            <li><a href="<?=WebSite ?>views/promos" title="<?= l("Promotions", "tesla");?>"><?= l("Promotions", "tesla");?></a></li>
					            <li><a href="<?=WebSite ?>views/nos-fabricant" title="<?= l("nos fabricants", "tesla");?>"><?= l("Nos fabricants", "tesla");?></a></li>
					            <li><a href="<?=WebSite ?>views/viewed-products" title="<?= l("Produits déjà vus", "tesla");?>"><?= l("Produits déjà vus", "tesla");?></a></li>
					         </ul>
					      </div>
						</div>
						<div class="col-sm-6">
							<div class="sitemap_block">
					         <h3><?= l("Votre compte", "tesla");?></h3>
					         <ul>
					            <li><a href="<?php if($cUser) echo WebSite.'account'; else  echo WebSite.'account/login'; ?>" title="<?= l("Votre compte", "tesla");?>">Votre compte</a></li>
					            <li><a href="<?= WebSite;?>account/identity" title="<?= l("Informations personnelles", "tesla");?>"><?= l("Informations personnelles", "tesla");?></a></li>
					            <li><a href="<?= WebSite;?>account/addresses" title="<?= l("Adresses", "tesla");?>"><?= l("Adresses", "tesla");?></a></li>
					            <li><a href="<?= WebSite;?>account/discount" title="<?= l("Bons de réduction", "tesla");?>"><?= l("Bons de réduction", "tesla");?></a></li>
					            <li><a href="<?= WebSite;?>account/history" title="<?= l("Historique des commandes", "tesla");?>"><?= l("Historique des commandes", "tesla");?></a></li>
					            <!-- <li><a href="<?= WebSite;?>account/quotation" title="<?= l("Vos devis", "tesla");?>"><?= l("Vos devis", "tesla");?></a></li> -->
					         </ul>
					      </div>
						</div>
					</div>
			   </div>
			   <div id="listpage_content">
			   	<div class="row">
						<div class="col-sm-6">


						<div class="sitemap_block">
					        <h3><?= l("Catégories", "tesla");?></h3>
					        <div class="tree_top"><a href="" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></div>
					        <ul class="tree">
					        	<?php echo getSitemapCatList(2); ?>
					            <!-- <li>
					               <a href="" title="Découvrez">Boîtes chocolats</a>
					               <ul>
					                  <li>
					                     <a href="" title="">Sous-catégorie</a>
					                     <ul>
					                        <li> <a href="" title="Découvrez">Sous-catégorie</a></li>
					                        <li class="last"> <a href="" title="Découvrez">Sous-catégorie</a></li>
					                     </ul>
					                  </li>
					                  <li> <a href="" title="Découvrez">Sous-catégorie</a></li>
					                  <li> <a href="" title="Découvrez">Sous-catégorie</a></li>
					                  <li class="last"> <a href="" title="Découvrez">Sous-catégorie</a></li>
					               </ul>
					            </li>
					            <li> <a href="" title="">Coffrets chocolats</a></li>
					            <li> <a href="" title="Découvrez">Friandises</a></li>
					            <li> <a href="" title="Découvrez">Tablettes</a></li>
					            <li> <a href="" title="Découvrez">Patisseries</a></li>
					            <li class="last"> <a href="h" title="">Cosmétiques</a></li> -->
					        </ul>
					     </div>


						</div>
						<div class="col-sm-6">
							<div class="sitemap_block">
					         <h3><?= l("Pages", "tesla");?></h3>
					         <div class="tree_top"><a href="<?= WebSite; ?>" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></div>
					         <?php $accueil_cms = getCmsByCatId(1); ?>
					         <?php if (is_array($accueil_cms)): ?>
					         	<ul class="tree">
						         	<?php foreach ($accueil_cms as $key => $value): ?>
						         		<li><a href="<?= WebSite.'cms/'.$value['id'].'-'.$value['permalink']; ?>" title=""><?= $value['title']; ?></a></li>
						         	<?php endforeach ?>
						         	<li><a href="<?= WebSite ?>account/login" title="<?= l("Créer un compte", "tesla");?>"><?= l("Créer un compte", "tesla");?></a></li>
						         	<li><a href="<?= WebSite ?>cms/contact" title="<?= l("Contact", "tesla");?>"><?= l("Contact", "tesla");?></a></li>
						         </ul>
					         <?php endif ?>
					         
					      </div>
						</div>
					</div>
			   </div>
			</div>
		</div>
	</div>

