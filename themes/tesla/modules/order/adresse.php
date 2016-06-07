	<?php 
		$UID = isConnected();
    if (!$UID) {
      $_SESSION['fromcart'] = 1;
      goConnected();
    }
    $UADRESSE = getUserAdresse($UID,null);
    /*var_dump($UADRESSE);
    die();*/
    if (!$UADRESSE) {
     /* goHome();*/
      $addresse_link = WebSite."account/addresses";
      goTolink($addresse_link);
    }
    if (isset($_POST['loyalty_used'])) {
      $_SESSION['loyalty_used'] = $_POST['loyalty_used'];
    }

  /*  if ($idquotation = customGET('quotation_edit')) {
      $_SESSION['quotation_edit'] = $idquotation;
    }*/
	?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active">Adresses</li>
	</ol>

	<h1><?= l("Adresses", "tesla");?></h1>
	<ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_done">
      <p class="number">1</p>
      <p class="name"><a href="order.php"><?= l("Résumé", "tesla");?></a></p>
    </li>
    <li class="step_current">
      <p class="number">2</p>
      <p class="name"><?= l("Adresse", "tesla");?></p>
    </li>
    <li class="step_todo">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "tesla");?></p>
    </li>
    <!-- <li class="step_todo">
      <p class="number">4</p>
      <p class="name"><?= l("Devis", "tesla");?></p>
    </li> -->
    <li class="step_todo" id="step_end">
      <p class="number">4</p>
      <p class="name"><?= l("Paiement", "tesla");?></p>
    </li>
  </ul>

  <div class="addresses">
    <div class="styled-select">
    	<label for="id_address_delivery"><?= l("Choisissez une adresse de livraison :", "tesla");?></label>
      <select class="select" id="id_address_delivery" name="id_address_delivery" onchange="updateAddressesDisplay();">
        <?php foreach ($UADRESSE as $key => $value): ?>
          <option selected="selected" value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
        <?php endforeach ?>
        
      </select>
    </div>

    <p class="checkbox">
      <input checked="checked" name="same" id="adresse_multiple" onclick="updateAddressesDisplay();" type="checkbox" value="1"> 
      <label><?= l("Utiliser la même adresse pour la facturation", "tesla");?></label>
    </p>

     

    <div class="styled-select" id="adresse_select_invoice">
      <p>
       <a class="button_large" href="<?= WebSite; ?>account/adresse?fromcart=1" title=""><?= l("Ajoutez une nouvelle adresse", "tesla");?>
       </a>
      <p>
      <label for=""><?= l("Choisissez une adresse de facturation  :", "tesla");?></label>
      <select class="select" id="id_address_invoice" name="id_address_invoice" onchange="updateAddressesDisplay();">
        <?php foreach ($UADRESSE as $key => $value): ?>
          <option selected="selected" value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
        <?php endforeach ?>
        
      </select>
    </div>

    <div class="row">
    	<div class="col-sm-6">
    		<ul class="address item" id="address_delivery">
        <li class="address_title"><?= l("Votre adresse de livraison", "tesla");?></li>
        <li class="address_firstname lastname"></li>
        <li class="address_company"></li>
        <li class="address_address1"></li>
        <li class="address_postcode city"></li>
        <li class="address_Country"></li>
        <li class="address_phone"></li>
        <li class="address_mobile"></li>
        <li class="address_update">
          <a href="" title=""  class="update"><?= l("Modifier cette adresse", "tesla");?></a>
          <a href="" title=""  class="delete"> / <?= l("Supprimer", "tesla");?></a></li>
      </ul>
    	</div>
    	<div class="col-sm-6">
    		<ul class="address alternate_item" id="address_invoice">
					<li class="address_title"><?= l("Votre adresse de facturation", "tesla");?></li>
					<li class="address_firstname lastname"></li>
          <li class="address_company"></li>
					<li class="address_address1"></li>
					<li class="address_postcode city"></li>
					<li class="address_Country"></li>
          <li class="address_phone"></li>
					<li class="address_mobile"></li>
					<li class="address_update">
            <a href="" title="Mettre à jour" class="update"><?= l("Modifier cette adresse", "tesla");?></a>
            <a href="" title="Supprimer" class="delete"> / <?= l("Supprimer", "tesla");?></a></li>
          </li>
				</ul>
    	</div>
    </div>



    <p class="address_add submit">
      <a class="button_large" href="<?= WebSite; ?>account/adresse?fromcart=1" title=""><?= l("Ajoutez une nouvelle adresse", "tesla");?></a>
    </p>
     <!--  <form method="POST" action="<?= WebSite ?>account/adresse">
        <input type="hidden" name="fromcart"  value="cart/adresse" />
        <input type="submit" name="Submitaddress" value="Ajoutez une nouvelle adresse" class="button_large">
      </form> -->
      <!-- <a class="button_large" href="<?= WebSite; ?>account/adresse" title="Ajoutez une nouvelle adresse">Ajoutez une nouvelle adresse</a> -->

   <!--  <div id="ordermsg">
      <p class="txt">
        Si vous voulez nous laisser un message à propos de votre commande, merci de bien vouloir le renseigner dans le champ ci-dessous.
      </p>
      <p class="textarea">
        <textarea cols="60" id="message" name="message" rows="3"></textarea>
      </p>
    </div> -->
  </div>

  <form method="POST" action="<?= WebSite ?>cart/livraison">
    <p class="cart_navigation">
      <input type="hidden" name="shipping_address" id="shipping_address" value="" />
      <input type="hidden" name="invoice_address" id="invoice_address"  value="" />
      <input type="hidden" name="id_country" id="id_country"  value="" />
      <input type="submit" name="Submitaddress" value="<?= l("Suivant", "tesla");?>" class="exclusive  pull-right">
      <a class="button_large" href="<?= WebSite;?>cart/" title="<?= l("Continuer mes achats", "tesla");?>">« <?= l("Précédent", "tesla");?></a>
    </p>
  </form>
	 <!--  <?php if (customGET('quotation_edit')): ?>
      <form method="POST" action="<?= WebSite ?>account/quotation">
        <p class="cart_navigation">
          <input type="hidden" name="shipping_address" id="shipping_address" value="" />
          <input type="hidden" name="invoice_address" id="invoice_address"  value="" />
          <input type="hidden" name="idquotation"  value="<?= $idquotation ?>" />
          <input type="submit" name="Submitaddress" value="<?= l("Validé la modification", "tesla");?>" class="exclusive  pull-right">
        </p>
      </form>
    <?php else: ?>
      <form method="POST" action="<?= WebSite ?>cart/livraison">
        <p class="cart_navigation">
          <input type="hidden" name="shipping_address" id="shipping_address" value="" />
          <input type="hidden" name="invoice_address" id="invoice_address"  value="" />
          <input type="submit" name="Submitaddress" value="<?= l("Suivant", "tesla");?>" class="exclusive  pull-right">
          <a class="button_large" href="<?= WebSite;?>cart/" title="<?= l("Continuer mes achats", "tesla");?>">« <?= l("Précédent", "tesla");?></a>
        </p>
      </form>
    <?php endif ?> -->
	  <!-- <a class="exclusive standard-checkout pull-right" href="<?= WebSite;?>cart/livraison" title="Suivant">Suivant »</a>  -->
    
