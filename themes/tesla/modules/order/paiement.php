  
  <?php 
    if (isset($_POST['id_carrier'])) {
      $_SESSION['id_carrier'] = $_POST['id_carrier'];
    }
    if (isset($CART['idProduit'])) {
      $nbProduct = count($CART['idProduit']);
    }
    $total_ht = 0;
     $tva = 0;
     $discount = 0;
  ?>
  <!-- Main content start here -->
  <ol class="breadcrumb">
    <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
    <li class="active"><?= l("Votre méthode de paiement", "tesla");?></li>
  </ol>

  <h1 class="text-center"><?= l("Nous vous remercions pour votre commande.", "tesla");?></h1>
  <h1><?= l("Choisissez votre méthode de paiement", "tesla");?></h1>
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
          $img = getThumbnail($product['id'],'45x45');
           $price_ht = floatval($CART['qteProduit'][$i]*$CART['prixProduit'][$i]);
          $total_ht   .= $price_ht;
          if (is_numeric($product['rate'])) {
            $tva .= ($product['rate'] * $price_ht / 100);
          }
          
          if ($product['discount_type'] == "0") {
            $discount .= ($product['discount'] * $price_ht / 100);
          }else if ($product['discount_type'] == "1") {
            $discount .= ($product['discount']);
          }
        ?>

        <tr class="" id="product_<?= $product['id'];?>"><!-- first_item odd -->
          <td class="cart_product">
            <a href="#" title="<?= $product['name'];?>">
              <img alt="<?= $product['name'];?>" class="replace-2x" src="<?php if($img) echo WebSite.$img; else echo $themeDir.'images/no-image-sm.jpg' ?>" style="height:45px;width:45px">
            </a>
          </td>
          <td class="cart_description">
            <p class="product_name">
              <a href="#" title=""><?= $product['name']; ?></a>
            </p>
            <?= substr(strip_tags($product['short_description']), 0,100) ; ?>...
            <p class="bold"><?= l("Référence :", "tesla");?> <?= $product['reference']; ?></p>
          </td>
          <td class="cart_unit"><span class="price" id=""><?= $product['sell_price']; ?> <?= CURRENCY; ?></span></td>
          <td class="cart_quantity">
            <?= $CART['qteProduit'][$i]; ?>
          </td>
          <td class="cart_total"><span class="price" id="total_product_price"><?= $CART['qteProduit'][$i]*$CART['prixProduit'][$i]; ?> <?= CURRENCY; ?></span></td>
        </tr>
        <?php endfor ?>
      </tbody>
    </table>
  </div>


  <div class="row">
    <?php 
      $total_ht =  $total_ht - $discount;
      $total_ttc =  $total_ht + $tva;
     ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <table class="table table-bordered borer0" id="summary_total">
        <tbody>
          <tr class="cart_total_price">
            <td><?= l("Total produits HT :", "tesla");?></td>
            <td class="price" id="total_product"><?= $total_ht; ?> <?= CURRENCY; ?></td>
          </tr>
          <!-- <tr class="cart_total_delivery">
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
          </tr> -->
           <?php if ($discount>0): ?>
              <tr class="cart_total_price">
                <td><?= l("Total Remise :", "tesla");?></td>
                <td class="price" id=""><?= $discount; ?> <?= CURRENCY; ?></td>
              </tr>
            <?php endif ?>
            
            <?php if ($tva>0): ?>
              <tr class="cart_total_price">
                <td><?= l("Total TVA :", "tesla");?></td>
                <td class="price" id=""><?= $tva; ?> <?= CURRENCY; ?></td>
              </tr>
            <?php endif ?>
            
          <tr class="cart_total_price">
            <td class="total_price" id="total_price_label"><?= l("Total TTC :", "tesla");?></td>
            <td class="total_price price" id="total_price_amount"><?= $total_ttc; ?> <?= CURRENCY; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    </div>
  </div>
  <?php execute_section_hooks('sec_payment'); ?>
  <?php execute_section_hooks('sec_payment_list'); ?>

<?php else: ?>    
  <!-- ca -->
<?php endif ?>

