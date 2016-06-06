<?php
$cUser = getCurrentUser();
?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Plan du site", "artiza");?></li>
	</ol>

	<h1><?= l("Plan du site", "artiza");?></h1>
	<div class="sitemap">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<div id="sitemap_content">
					<div class="row">
						<div class="col-sm-6">
							<div class="sitemap_block">
					         <h3><?= l("Nos offres", "artiza");?></h3>
					         <ul>
					            <li><a href="<?=WebSite ?>views/new-products" title="<?= l("Nouveaux produits", "artiza");?>"><?= l("Nouveaux produits", "artiza");?></a></li>
					            <li><a href="<?=WebSite ?>views/promos" title="<?= l("Promotions", "artiza");?>"><?= l("Promotions", "artiza");?></a></li>
					            <li><a href="<?=WebSite ?>views/nos-fabricant" title="<?= l("nos fabricants", "artiza");?>"><?= l("Nos fabricants", "artiza");?></a></li>
					            <li><a href="<?=WebSite ?>views/viewed-products" title="<?= l("Produits déjà vus", "artiza");?>"><?= l("Produits déjà vus", "artiza");?></a></li>
					         </ul>
					      </div>
						</div>
						<div class="col-sm-6">
							<div class="sitemap_block">
					         <h3><?= l("Votre compte", "artiza");?></h3>
					         <ul>
					            <li><a href="<?php if($cUser) echo WebSite.'account'; else  echo WebSite.'account/login'; ?>" title="<?= l("Votre compte", "artiza");?>">Votre compte</a></li>
					            <li><a href="<?= WebSite;?>account/identity" title="<?= l("Informations personnelles", "artiza");?>"><?= l("Informations personnelles", "artiza");?></a></li>
					            <li><a href="<?= WebSite;?>account/addresses" title="<?= l("Adresses", "artiza");?>"><?= l("Adresses", "artiza");?></a></li>
					            <li><a href="<?= WebSite;?>account/discount" title="<?= l("Bons de réduction", "artiza");?>"><?= l("Bons de réduction", "artiza");?></a></li>
					            <li><a href="<?= WebSite;?>account/history" title="<?= l("Historique des commandes", "artiza");?>"><?= l("Historique des commandes", "artiza");?></a></li>
					            <!-- <li><a href="<?= WebSite;?>account/quotation" title="<?= l("Vos devis", "artiza");?>"><?= l("Vos devis", "artiza");?></a></li> -->
					         </ul>
					      </div>
						</div>
					</div>
			   </div>
			   <div id="listpage_content">
			   	<div class="row">
						<div class="col-sm-6">


						<div class="sitemap_block">
					        <h3><?= l("Catégories", "artiza");?></h3>
					        <div class="tree_top"><a href="" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></div>
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
					         <h3><?= l("Pages", "artiza");?></h3>
					         <div class="tree_top"><a href="<?= WebSite; ?>" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></div>
					         <?php $accueil_cms = getCmsByCatTitle('Accueil'); ?>
					         <ul class="tree">
					         	<?php foreach ($accueil_cms as $key => $value): ?>
					         		<li><a href="<?= WebSite.'cms/'.$value['id'].'-'.$value['permalink']; ?>" title=""><?= $value['title']; ?></a></li>
					         	<?php endforeach ?>
					         	<li><a href="<?= WebSite ?>account/login" title="<?= l("Créer un compte", "artiza");?>"><?= l("Créer un compte", "artiza");?></a></li>
					         	<li><a href="<?= WebSite ?>cms/contact" title="<?= l("Contact", "artiza");?>"><?= l("Contact", "artiza");?></a></li>
					         </ul>
					      </div>
						</div>
					</div>
			   </div>
			</div>
		</div>
	</div>

