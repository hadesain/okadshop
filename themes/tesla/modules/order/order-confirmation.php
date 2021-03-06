<?php 
	if (isset($CART['idProduit']) && !empty($CART['idProduit'])) {
			$total = MontantGlobal();
      if (!isset($_SESSION['payment_methode']) || !isset($_SESSION['adress_fact']) || !isset($_SESSION['adress_liv'])) {
        goHome();
      }
			$resultConfirm = confirmOrder($_SESSION['payment_methode'],1,$_SESSION['adress_fact'],$_SESSION['adress_liv']);
	} else{
		goHome();
	}
?>
<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Confirmation de commande", "tesla");?></li>
	</ol>

  <h1><?= l("Confirmation de commande", "tesla");?></h1>
  <ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_done">
      <p class="number">1</p>
      <p class="name"><a href="#"><?= l("Résumé", "tesla");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">2</p>
      <p class="name"><a href="#"><?= l("Adresse", "tesla");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "tesla");?></p>
    </li>
    <li class="step_current" id="step_end">
      <p class="number">4</p>
      <p class="name"><?= l("Envoi Devis", "tesla");?></p>
    </li>
  </ul>
<?php if ($resultConfirm): ?>
    <div class="alert alert-success" role="alert">

    </div>
  <ul class="footer_links">
    <li><a href="" title="<?= l("Retour à votre compte", "tesla");?>"><?= l("Retour aux commandes", "tesla");?></a></li>
    <li><a href="<?= WebSite; ?>" title="<?= l("Accueil", "tesla");?>"><?= l("Retour à l'accueil", "tesla");?></a></li>
  </ul>
<?php else: ?>
  <div class="alert alert-danger" role="alert"><?= l("Votre commande n'a pas enregistrée", "tesla");?></div>
<?php endif ?>

	