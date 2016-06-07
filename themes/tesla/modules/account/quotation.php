	<?php  
		goConnected();
	?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	  <li><a href="#" title="acount"><?= l("Mon compte", "tesla");?></a></li>
	  <li class="active"><?= l("Historique de votre devis", "tesla");?></li>
	</ol>

	<?php execute_section_hooks('sec_history'); ?>

	<ul class="footer_links">
		<li><a href="<?= WebSite;?>account/" title="Retour à votre compte"><?= l("Retour à votre compte", "tesla");?></a></li>
		<li><a href="<?= WebSite;?>" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	</ul>
