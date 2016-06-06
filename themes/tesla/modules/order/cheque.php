<?php 
	if (isset($CART['idProduit']) && !empty($CART['idProduit'])) {
			$total = MontantGlobal();
	} else{
		goHome();
	}
?>
<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Paiement par chèque", "artiza");?></li>
	</ol>

	<h1><?= l("Récapitulatif de commande", "artiza");?></h1>
	<ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_current">
      <p class="number">1</p>
      <p class="name"><a href="#"><?= l("Résumé", "artiza");?></a></p>
    </li>
    <li class="step_current">
      <p class="number">2</p>
      <p class="name"><a href="#"><?= l("Adresse", "artiza");?></a></p>
    </li>
    <li class="step_current">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "artiza");?></p>
    </li>
    <li class="step_current" id="step_end">
      <p class="number">4</p>
      <p class="name"><?= l("Paiement", "artiza");?></p>
    </li>
  </ul>
  <h3><?= l("Paiement par chèque", "artiza");?></h3>
   	<div class="row">
   		<div class="col-xs-2">
   			<img alt="Payer par chèque" height="49" src="<?= themeDir; ?>images/cheque.jpg" width="86">
   		</div>
   		<div class="col-xs-10">
   			<p>
      	 <?= l("Vous avez choisi de régler par chèque.", "artiza");?> <br><br>
      		<?= l("Voici un bref récapitulatif de votre commande :", "artiza");?>
      	</p>
   		</div>
    </div>
    <div class="clearfix">
	    <p>
	    	<br>
	    	- <?= l("Le montant total de votre commande s'élève à", "artiza");?> <?= $total; ?> € <?= l("TTC", "artiza");?><br>
				- <?= l("Nous acceptons plusieurs devises pour les chèques.", "artiza");?> <br><br>
			</p>
			<p>
				<?= l("Merci de choisir parmi les suivantes :", "artiza");?> 
				<select>
					<option><?= l("Euro", "artiza");?></option>
					<option><?= l("Dollar", "artiza");?></option>
				</select> <br><br>
				<?= l("L'ordre et l'adresse du chèque seront affichés sur la page suivante.", "artiza");?> <br><br>

				<strong><?= l("Merci de confirmer votre commande en cliquant sur", "artiza");?> "<?= l("Je confirme ma commande", "artiza");?>".</strong>
			</p>
		</div>
  	<p class="cart_navigation">
      <a class="exclusive pull-right" href="<?= WebSite;?>cart/order-confirmation" title="<?= l("Je confirme ma commande", "artiza");?>"><?= l("Je confirme ma commande", "artiza");?> »</a> 
      <a class="button_large" href="<?= WebSite;?>cart/paiement" title="<?= l("Autres moyens de paiement", "artiza");?>">« <?= l("Autres moyens de paiement", "artiza");?></a>
    </p>