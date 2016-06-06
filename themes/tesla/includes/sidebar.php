
<!-- informations panel -->
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Catégories</h3>
  </div>
  <div class="panel-body">
    <ul>
      <?php 
        $homeCat = getcategoryByName('Accueil');
        getCatList($homeCat['id']);
       ?>
    </ul>
  </div>
</div>


<!-- cart panel -->
<div class="panel" id="cart_block">
  <div class="panel-heading">
    <h3 class="panel-title">Panier</h3>
  </div>
  <div class="panel-body">
    <div class="expanded" id="cart_block_list">
      <div id="product-cart-list"></div>
      <p id="cart_block_no_products" class="hidden">Aucun produit</p>
      <p id="cart-prices"> 
        <span>Total</span> 
        <span class="price ajax_block_cart_total" id="cart_block_total">0,00 €</span>
      </p>
      <p id="cart-buttons"> 
        <a class="button_small" href="<?= WebSite;?>cart/" title="Panier">Panier</a> 
        <a class="exclusive" href="<?= WebSite;?>cart/" id="button_order_cart" title="Commander">Commander</a>
      </p>
    </div>
  </div>
</div>
<!-- Mon compte panel -->
<?php if (isConnected()): ?>
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Mon compte</h3>
    </div>
    <div class="panel-body">
      <ul>
        <li><a href="<?= WebSite;?>account/history">Mes commandes</a></li>
        <li><a href="<?= WebSite;?>account/order-follow">Mes retours produits</a></li>
        <li><a href="<?= WebSite;?>account/order-slip">Mes avoirs</a></li>
        <li><a href="<?= WebSite;?>account/addresses">Mes adresses</a></li>
        <li><a href="<?= WebSite;?>account/identity">Mes données personnelles</a></li>
        <li><a href="<?= WebSite;?>account/discount">Mes bons de réductions</a></li>
        <li><a href="<?= WebSite;?>account/loyalty-program">Mes points de fidélité</a></li>
        <li><a href="<?= WebSite;?>account/referralprogram-program">Parrainage</a></li>
        <li><a href="<?= WebSite;?>account/myalerts">Mes alertes</a></li>
      </ul>
      <p class="logout"><a href="<?= WebSite;?>account/logout" title="Déconnexion">Déconnexion</a></p>
    </div>
  </div>
<?php endif ?>


<!-- informations panel -->
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Informations</h3>
  </div>
  <div class="panel-body">
    <ul>
      <li><a href="<?= WebSite;?>cms/livraisons-et-retours">OKADSHOP</a></li>
      <li><a href="<?= WebSite;?>cms/privacy">Demander un devis</a></li>
      <li><a href="<?= WebSite;?>cms/conditions">Transport & Taxes</a></li>
      <li><a href="<?= WebSite;?>cms/secured-paiement">Paiement sécurisé</a></li>
      <li><a href="<?= WebSite;?>cms/stores">Conditions d'utilisation</a></li>
    </ul>
  </div>
</div>
<?php 
$viewed_product_ids = implode(',', getViewdProduct());
$viewed_product = getProductByids($viewed_product_ids,11);
 ?>
<!-- Nouveautés panel -->
 <div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Produits déjà vus</h3>
  </div>
  <div class="panel-body">
    <?php if (isset($viewed_product) && $viewed_product && !empty($viewed_product)): ?>
        <?php foreach ($viewed_product as $key => $value): ?>
        <div class="media">
          <div class="media-left media-middle">
            <a href="<?= WebSite.'product/'.$value['id']; ?>">
              <?php $img = getThumbnail($value['id'],'45x45'); ?>
              <img class="media-object" src="<?php if($img) echo WebSite.$img; else echo $themeDir.'images/no-image-l.png'; ?>" alt="" style="width: 45px;height: 45px;">
            </a>
          </div>
          <div class="media-body">
            <h5 class="media-heading"><a href="<?= WebSite.'product/'.$value['id']; ?>"><?= substr(strip_tags($value['name']),0,15); ?>...</a></h5>
            <p><?= substr(strip_tags($value['short_description']), 0,20); ?>...</p>
            <p></p>
          </div>
        </div>
      <?php endforeach ?>
    <?php endif ?>
    

   
<!--     <p class="lnk">
      <a class="button_large" href="<?= $themeDir;?>prices-drop" title="Toutes les nouveautés">Toutes les nouveautés</a>
    </p> -->
  </div>
</div>


<p class="lnk">
  <a class="button_large" href="<?= $themeDir;?>prices-drop" title="Toutes les nouveautés">Transformer mon panier en devis</a>
  <a class="button_large" href="<?= $themeDir;?>prices-drop" title="Toutes les nouveautés">Faire une demande de devis</a>
</p>
<!-- Nouveautés panel -->
<!-- <div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Promotions</h3>
  </div>
  <div class="panel-body">
    <div class="media">
      <div class="media-left media-middle">
        <a href="#">
          <img class="media-object" src="<?= $themeDir;?>/images/17-110-medium.jpg" alt="">
        </a>
      </div>
      <div class="media-body">
        <div class="product_content">
          <p class="product_name">
            <a href="" title="Coffret cadeau prestige chocolats assortis">Coffret cadeau prestige...</a>
          </p>
          <p class="product_old_price">49,00 €</p>
          <p class="product_reduction">-10%</p>
          <p class="product_price">44,10 €</p>
        </div>
      </div>
    </div>
    <p class="lnk">
      <a class="button_large" href="<?= $themeDir;?>prices-drop" title="Toutes les nouveautés">Toutes les Promotions</a>
    </p>
  </div>
</div> -->
<!-- Nos magasins panel -->
<!-- <div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Nos magasins</h3>
  </div>
  <div class="panel-body text-center">
    <div class="media">
      <a href="<?= WebSite;?>cms/stores">
        <img class="media-object full-width" src="<?= $themeDir;?>images/store.jpg" alt="">
      </a>
      <p><a href="<?= WebSite;?>cms/stores">Découvrez nos magasins</a></p>
    </div>
  </div>
</div> -->