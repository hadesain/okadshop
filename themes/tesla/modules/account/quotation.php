	<?php  
		goConnected();
	?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li><a href="#" title="acount"><?= l("Mon compte", "artiza");?></a></li>
	  <li class="active"><?= l("Historique de votre devis", "artiza");?></li>
	</ol>

	<?php execute_section_hooks('sec_history'); ?>

	<ul class="footer_links">
		<li><a href="<?= WebSite;?>account/" title="Retour à votre compte"><?= l("Retour à votre compte", "artiza");?></a></li>
		<li><a href="<?= WebSite;?>" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	</ul>
