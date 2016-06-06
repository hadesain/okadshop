	<!-- Main content start here -->
<ol class="breadcrumb">
  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
  <li class="active"><?= l("Confirmation de commande", "artiza");?></li>
</ol>
<h1><?= l("Choisissez votre méthode de paiement", "artiza");?></h1>
 <?php execute_section_hooks('sec_payment_top_list'); ?>
<div class="col-sm-12 padding0" id="HOOK_PAYMENT">
    <?php execute_section_hooks('sec_payment_list'); ?>
</div>