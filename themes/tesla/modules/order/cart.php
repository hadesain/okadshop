<?php 
	if (isset($CART['idProduit'])) {
		$nbProduct = count($CART['idProduit']);
	}

?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title=""><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Votre devis", "tesla");?></li>
	</ol>

	<h1><?= l("Récapitulatif des produits ajoutés au devis", "tesla");?></h1>

  <ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_current">
      <p class="number">1</p>
      <p class="name"><?= l("Résumé", "tesla");?></p>
    </li>
    <!-- <li class="step_todo">
      <p class="number">2</p>
      <p class="name">Identification</p>
    </li> -->
    <li class="step_todo">
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
<?php if (isset($nbProduct) &&  $nbProduct >0 ): ?>
  <div class="table-responsive">
    <table class="table table-bordered borer0" id="summary">
      <thead>
        <tr>
          <th class="product first_item"><?= l("Produit", "tesla");?></th>
          <th class="description item"><?= l("Description", "tesla");?></th>
          <th class="unit item"><?= l("Prix unitaire", "tesla");?></th>
          <th class="quantity item"><?= l("Qté", "tesla");?></th>
          <th class="total item"><?= l("Prix total", "tesla");?></th>
        </tr>
      </thead>
      <tbody>

      	<?php for ($i=0; $i < $nbProduct; $i++): ?>
      	<?php 
      		$product = getProductByid($CART['idProduit'][$i]);
      		if (!$product || empty($product)) {
      			continue;
      		}
      		$img = getThumbnail($product['id'],'80x80');
      	?>

        <tr class="" id="product_<?= $product['id'];?>"><!-- first_item odd -->
          <td class="cart_product">
            <a href="#" title="<?= $product['name'];?>">
              <img alt="<?= $product['name'];?>" class="replace-2x" src="<?php if($img) echo WebSite.$img; else echo $themeDir.'images/no-image-sm.jpg' ?>" style="height:80px;width:80px">
            </a>
          </td>
          <td class="cart_description">
            <p class="product_name">
              <a href="#" title=""><?= $product['name']; ?></a>
            </p>
            <?= substr(strip_tags($product['short_description']), 0,100) ; ?>...
            <p class="bold"><?= l("Référence :", "tesla");?> <?= $product['reference']; ?></p>
            <?php if ($product['qty']>0): ?>
            	<p class="availability bold available"><?= l("En stock", "tesla");?></p>
			<?php else: ?>
				<p class="availability bold"><?= l("Out of stock", "tesla");?></p>
			<?php endif ?>
            <p class="delete"><a class="quantity_delete ajax_delete_product_cart" href="#" id="" rel="nofollow" title="" l="<?= $product['id']; ?>"><?= l("Supprimer ce produit", "tesla");?></a></p>
          </td>
          <td class="cart_unit"><span class="price" id=""><?= $product['sell_price']; ?> €</span></td>
          <td class="cart_quantity">
            <div class="cart_quantity_button" id="cart_quantity_button">
              <a class="cart_quantity_up" href="javascript:;"  id="" rel="nofollow" title="">
                <i class="fa fa-plus-square"></i>
              </a> 
              <a class="cart_quantity_down" href="javascript:;" id="" rel="nofollow" title=""><i class="fa fa-minus-square"></i></a>
            </div>
            <input name="" type="hidden" value="1"> 
            <input autocomplete="off" class="cart_quantity_input" name="quantity" size="2" type="text" value="<?= $CART['qteProduit'][$i]; ?>" l="<?= $CART['idProduit'][$i]?>">
          </td>
          <td class="cart_total"><span class="price" id="total_product_price"><?= $CART['qteProduit'][$i]*$CART['prixProduit'][$i]; ?> €</span></td>
        </tr>
        <?php endfor ?>
      </tbody>
    </table>
  </div>


    <div class="row">
      
      <?php 
      	$totalht = MontantGlobal();
      ?>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <table class="table table-bordered borer0" id="summary_total">
          <tbody>
            <tr class="cart_total_price">
              <td><?= l("Total produits HT :", "tesla");?></td>
              <td class="price" id="total_product"><?= $totalht; ?> €</td>
            </tr>
            <tr class="cart_total_delivery">
              <td><?= l("Total livraison TTC :", "tesla");?></td>
              <td class="price" id="total_shipping">--</td>
            </tr>
            <tr class="">
              <td><?= l("Taux TVA :", "tesla");?></td>
              <td class="price" id="">--</td>
            </tr>
            <tr class="cart_total_price">
              <td><?= l("Total TVA :", "tesla");?></td>
              <td class="price" id="total_price_without_tax">--</td>
            </tr>
            
<!--             <tr class="cart_total_tax">
              <td>Total taxes :</td>
              <td class="price" id="total_tax">17,05 €</td>
            </tr> -->
            <tr class="cart_total_price">
              <td class="total_price" id="total_price_label"><?= l("Total TTC :", "tesla");?></td>
              <td class="total_price price" id="total_price_amount"><?= $totalht; ?> €</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <!-- <table id="summary_voucher">
          <tbody>
            <tr>
              <td class="cart_voucher" id="cart_voucher">
                <p class="title_voucher" id="title_voucher"><?= l("Utiliser un code promotionnel :", "tesla");?></p>
                <form action="order.php" id="voucher" class="searchbox" method="post" name="voucher">
                  <p><label for="discount_name"><?= l("Code promo:", "tesla");?></label></p>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="<?= l("Votre adresse mail", "tesla");?>">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><?= l("OK", "tesla");?></button>
                    </span>
                  </div>
                </form>
              </td>
            </tr>
          </tbody>
       </table> -->
      </div>
    </div>


    <!-- <p style="text-align: right;">En validant votre panier, vous pouvez collecter <b>9 points de fidélité</b> pouvant être transformé(s) en un bon de réduction de 1,80 €<sup>*</sup>.<br> <sup>*</sup> Offre non applicable pour les commandes passées en tant qu'invité</p> -->


<!--     <form action="#" class="std form-horizental" id="compare_shipping_form" method="post" name="compare_shipping_form">
      <fieldset id="compare_shipping">
        <h3>Estimez vos frais de livraison &amp; taxes</h3>
        <p><label for="id_country">Pays</label></p>
        <div class="styled-select" style="width: 280px;">
          <select id="id_country" name="id_country">
            <option value="231">Afghanistan</option>
            <option value="30">Afrique du Sud</option>
            <option value="244">Åland, Îles</option>
            <option value="230">Albanie</option>
            <option value="38">Algérie</option>
            <option value="1">Allemagne</option>
            <option value="40">Andorre</option>
            <option value="41">Angola</option>
            <option value="42">Anguilla</option>
          </select>
        </div>

        <div class="form-group">
          <label for="zipcode">Code postal</label>
          <input type="text" name="zipcode" value="" id="zipcode"> (Nécessaires pour certains transporteurs)
        </div>

        <div id="availableCarriers">
          <table cellpadding="0" cellspacing="0" class="std" id="availableCarriers_table">
            <thead>
              <tr>
                <th class="carrier_action first_item"></th>
                <th class="carrier_name item">Transporteur</th>
                <th class="carrier_infos item">Information</th>
                <th class="carrier_price last_item">Prix</th>
              </tr>
            </thead>
            <tbody id="carriers_list">
              <tr class="item">
                <td class="carrier_action">
                  <input checked="checked" id="id_carrier2" name="id_carrier" type="radio" value="2">
                </td>
                <td class="carrier_name"><label for="id_carrier2">My carrier</label></td>
                <td class="carrier_infos">Livraison le lendemain !</td>
                <td class="carrier_price"><span class="price">8,37 €</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="SE_SubmitRefreshCard">
          <input class="exclusive_large" id="carriercompare_submit" name="carriercompare_submit" type="submit" value="Mise a jour du panier"> 
          <input class="exclusive_large" id="update_carriers_list" type="button" value="Mise a jour de la liste de transporteurs">
        </p>
      </fieldset>
    </form> -->

    <p class="cart_navigation">
      <a class="exclusive" href="javascript:;" title="<?= l("actualiser le panier", "tesla");?>" id="cart_panel_refresh"><?= l("Actualiser le panier", "tesla");?></a> 
      <a class="exclusive standard-checkout pull-right" href="<?= WebSite;?>cart/adresse/" title="Suivant"><?= l("Suivant", "tesla");?> »</a> 
      <a class="button_large" href="<?= WebSite;?>" title="<?= l("Continuer mes achats", "tesla");?>">« <?= l("Continuer mes achats", "tesla");?></a>
    </p>
<?php else: ?>    
	<!-- ca -->
<?php endif ?>

<?php execute_section_hooks('sec_cart'); ?>