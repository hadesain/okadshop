
<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Devis", "artiza");?></li>
	</ol>

	<h1><?= l("Devis", "artiza");?></h1>
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
    <li class="step_todo">
      <p class="number">4</p>
      <p class="name"><?= l("Devis", "artiza");?></p>
    </li>
    <li class="step_todo" id="step_end">
      <p class="number">5</p>
      <p class="name"><?= l("Paiement", "artiza");?></p>
    </li>
  </ul>

<?php execute_section_hooks('sec_capture'); ?>
