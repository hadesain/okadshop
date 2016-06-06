  <?php 
    $UID = goConnected();
    $customGET = customGET();
    if (isset($customGET['id_delete']) && !empty($customGET['id_delete'])) {
      deleteUserAdress($customGET['id_delete']);
      if ($customGET['fromcart'] == '1') {
        goTolink(WebSite.'cart/adresse');
        echo "string";
      }
    }
    $userAdresses = getUserAdresse($UID,null);

  ?>
  <!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?=l("Accueil", "artiza");?></a></li>
	  <li><a href="#" title="acount"><?=l("Mon compte", "artiza");?></a></li>
	  <li class="active"><?=l("Mes adresses", "artiza");?></li>
	</ol>

	<h1><?=l("Mes adresses", "artiza");?></h1>

	<div class="addresses">
    <p><?=l("Choisissez vos adresses de facturation et de livraison. Ces dernières seront présélectionnées lors de vos commandes. Vous pouvez également ajouter d'autres adresses, ce qui est particulièrement intéressant pour envoyer des cadeaux ou recevoir votre commande au bureau.", "artiza");?></p><br>
    <h3><?=l("Vos adresses sont listées ci-dessous :", "artiza");?></h3>
    <p><?=l("Pensez à les tenir à jour si ces dernières venaient à changer.", "artiza");?></p>
    <div class="row">
      <?php if ($userAdresses && !empty($userAdresses)): ?>
        <?php foreach ($userAdresses as $key => $Adresses): ?>
        <div class="col-sm-12 col-md-6">
          <div class="bloc_adresses">
            <ul class="address item first_item">
              <li class="address_title"><?= $Adresses['name']; ?></li>
              <li><span class="address_name"><?= $Adresses['firstname']; ?></span> <span class="address_name"><?= $Adresses['lastname']; ?></span></li>
              <li><span class="address_address1"><?= stripcslashes($Adresses['addresse']); ?></span></li>
              <li><span class="address_address2"></span></li>
              <li><span><?= $Adresses['codepostal']; ?></span> <span class="address_city"><?= $Adresses['city']; ?></span></li>
              <li><span><?= $Adresses['country']; ?></span></li>
              <li><span class="address_phone"><?= $Adresses['phone']; ?></span></li>
              <li><span class="address_mobile"><?= $Adresses['mobile']; ?></span></li>
              <li class="address_update">
                <a href="<?= WebSite.'account/adresse?id_address='.$Adresses['id']; ?>" title="Mettre à jour"><?=l("Mettre à jour", "artiza");?></a>
              </li>
              <li class="address_delete">
                <a href="<?= WebSite.'account/addresses?id_delete='.$Adresses['id']; ?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer"><?=l("Supprimer", "artiza");?></a>
              </li>
            </ul>
          </div>
        </div>
        <?php endforeach ?>
      <?php endif ?>

    </div>
    <div class="address_add">
      <a class="button_large" href="<?= WebSite; ?>account/adresse" title="Ajouter une adresse"><?=l("Ajouter une adresse", "artiza");?></a>
    </div>
  </div>

  <ul class="footer_links">
		<li><a href="" title="Retour à votre compte"><?=l("Retour à votre compte", "artiza");?></a></li>
		<li><a href="/" title="Accueil"><?=l("Accueil", "artiza");?></a></li>
	</ul>
