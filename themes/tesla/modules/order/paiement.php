  
  <?php 
    if (isset($_POST['id_carrier'])) {
      $_SESSION['id_carrier'] = $_POST['id_carrier'];
    }
    if (isset($CART['idProduit'])) {
      $nbProduct = count($CART['idProduit']);
    }
    $totalht = MontantGlobal();
  ?>
  <!-- Main content start here -->
  <ol class="breadcrumb">
    <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
    <li class="active"><?= l("Votre méthode de paiement", "artiza");?></li>
  </ol>

  <h1 class="text-center"><?= l("Nous vous remercions pour votre commande.", "artiza");?></h1>
  <h1><?= l("Choisissez votre méthode de paiement", "artiza");?></h1>
	<ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_done">
      <p class="number">1</p>
      <p class="name"><a href="#"><?= l("Résumé", "artiza");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">2</p>
      <p class="name"><a href="#"><?= l("Adresse", "artiza");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "artiza");?></p>
    </li>
    <li class="step_todo" id="step_end">
      <p class="number">4</p>
      <p class="name"><?= l("Paiement", "artiza");?></p>
    </li>
  </ul>

  <?php if (isset($nbProduct) &&  $nbProduct >0 ): ?>
  <div class="table-responsive">
    <table class="table table-bordered borer0" id="summary">
      <thead>
        <tr>
          <th class="product first_item"><?= l("Produit", "artiza");?></th>
          <th class="description item"><?= l("Description", "artiza");?></th>
          <th class="unit item"><?= l("Prix unitaire", "artiza");?></th>
          <th class="quantity item"><?= l("Qté", "artiza");?></th>
          <th class="total item"><?= l("Prix total", "artiza");?></th>
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
            <p class="bold"><?= l("Référence :", "artiza");?> <?= $product['reference']; ?></p>
          </td>
          <td class="cart_unit"><span class="price" id=""><?= $product['sell_price']; ?> €</span></td>
          <td class="cart_quantity">
            <?= $CART['qteProduit'][$i]; ?>
          </td>
          <td class="cart_total"><span class="price" id="total_product_price"><?= $CART['qteProduit'][$i]*$CART['prixProduit'][$i]; ?> €</span></td>
        </tr>
        <?php endfor ?>
      </tbody>
    </table>
  </div>


  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <table class="table table-bordered borer0" id="summary_total">
        <tbody>
          <tr class="cart_total_price">
            <td><?= l("Total produits HT :", "artiza");?></td>
            <td class="price" id="total_product"><?= $totalht; ?> €</td>
          </tr>
          <tr class="cart_total_delivery">
            <td><?= l("Total livraison TTC :", "artiza");?></td>
            <td class="price" id="total_shipping">--</td>
          </tr>
          <tr class="">
            <td><?= l("Taux TVA :", "artiza");?></td>
            <td class="price" id="">--</td>
          </tr>
          <tr class="cart_total_price">
            <td><?= l("Total TVA :", "artiza");?></td>
            <td class="price" id="total_price_without_tax">--</td>
          </tr>
          <tr class="cart_total_price">
            <td class="total_price" id="total_price_label"><?= l("Total TTC :", "artiza");?></td>
            <td class="total_price price" id="total_price_amount"><?= $totalht; ?> €</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php execute_section_hooks('sec_payment'); ?>
  <?php execute_section_hooks('sec_payment_list'); ?>

<?php else: ?>    
  <!-- ca -->
<?php endif ?>

