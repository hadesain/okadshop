  <?php 
  
    if (isset($_POST['shipping_address']) && isset($_POST['invoice_address']) && isset($_POST['id_country'])) {
      $_SESSION['shipping_address'] = $_POST['shipping_address'];
      $_SESSION['invoice_address'] = $_POST['invoice_address'];
      $_SESSION['id_country'] = $_POST['id_country'];
    }
    if (!isset($_SESSION['shipping_address'])) {
      goHome();
    }
    $options = array(
      "id_country" => $_SESSION['id_country']
    );
    $CarrierList = getCarrierByOption($options); 
    //var_dump($CarrierList[0][''])
  ?>
  <!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Livraison", "tesla");?></li>
	</ol>

	<h1><?= l("Livraison", "tesla");?></h1>
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
    <li class="step_current">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "tesla");?></p>
    </li>
    <li class="step_todo" id="step_end">
      <p class="number">4</p>
      <p class="name"><?= l("Paiement", "tesla");?></p>
    </li>
  </ul>

<?php execute_section_hooks('sec_carrierfront'); ?>
  <form method="POST" action="<?= WebSite ?>cart/paiement">
   <div class="order_carrier_content">
    <h3 class="carrier_title"><?= l("Choisissez votre mode de livraison", "tesla");?></h3>
     <div id="HOOK_BEFORECARRIER">
      <!-- <p id="dateofdelivery">Date approximative de livraison avec ce transporteur est entre le <span id="minimal"><b>Jeudi 10 Mars 2016</b></span> et <span id="maximal"><b>Vendredi 11 Mars 2016</b></span> <sup>*</sup></p> 
      <p style="font-size:10px;margin:0padding:0;"><sup>*</sup> avec un moyen de paiement direct (ex.: carte bancaire)</p>-->
    </div> 

    <table class="std" id="carrierTable">
      <thead>
        <tr>
          <th class="carrier_action first_item"></th>
          <th class="carrier_name"></th>
          <th class="carrier_name item"><?= l("Transporteur", "tesla");?></th>
          <th class="carrier_infos item"><?= l("Information", "tesla");?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($CarrierList as $key => $value): ?>
        <tr class="item first_item">
          <td class="carrier_action">
            <input  class="delivery_radio" id="" name="id_carrier" type="radio" value="<?=  $value['id'] ?>" required="required">
          </td>
          <td class="carrier_name"> 
            <?php if (!empty($value['logo'])): ?>
              <img src="../files/carriers/<?=$value['logo']; ?>" alt="Transporteur"/ width="70px">
            <?php endif ?>
          </td>
          <td class="carrier_name"><label for="carrier_name"><?=  $value['name'] ?></label></td>
          <td class="carrier_infos"><?=  $value['description'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <!-- <td class="carrier_price"><span class="price">8,37 €</span> TTC</td> -->
<!--     <h3 class="recyclable_title">Emballage recyclé</h3>
    <div class="box">
      <p class="checkbox"><input checked="checked" id="recyclable" name="recyclable" type="checkbox" value="1"> <label for="recyclable">J'accepte de recevoir ma commande dans un emballage recyclé.</label></p>
    </div> 
    <h3 class="gift_title">Cadeau</h3>
    <div class="box">
      <p class="checkbox">
        <input id="gift" name="gift" onclick="$('#gift_div').toggle('slow');" type="checkbox" value="1"> 
        <label for="gift">Je souhaite que ma commande soit emballée dans un papier-cadeau.</label> 
        (Coût suppl. de <span class="price" id="gift-price">11,96 €</span> TTC)
      </p>
    </div>
    <p class="textarea" id="gift_div">
      <label for="gift_message">Vous pouvez ajouter un message d'accompagnement à votre commande :</label>
      <textarea cols="35" id="gift_message" name="gift_message" rows="5"></textarea>
    </p> -->


  </div>

  <p class="cart_navigation">
    <input type="submit" name="Submitaddress" value="<?= l("Suivant", "tesla");?>" class="exclusive  pull-right">
    <a class="button_large" href="<?= WebSite;?>cart/adresse/" title="<?= l("Précédent", "tesla");?>">« <?= l("Précédent", "tesla");?></a>
  </p>
</form>

	<!--<p class="cart_navigation">
	  <a class="exclusive standard-checkout pull-right" href="<?= WebSite;?>cart/paiement" title="Suivant">Suivant »</a> 
	  <a class="button_large" href="<?= WebSite;?>cart/adresse" title="Continuer mes achats">« Précédent</a>
	</p>-->
