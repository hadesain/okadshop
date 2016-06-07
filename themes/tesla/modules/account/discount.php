  <?php
    $user = goConnected();  
  ?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	  <li><a href="#" title="acount"><?= l("Mon compte", "tesla");?></a></li>
	  <li class="active"><?= l("Vos bons de réductions", "tesla");?></li>
	</ol>

	<h1><?= l("Vos bons de réductions", "tesla");?></h1>
  <?php $cart_rule_user = getUserCartRule($user); ?>
	<table class="discount std table_block">
    <thead>
      <tr>
        <th class="discount_code first_item"><?= l("Code", "tesla");?></th>
        <th class="discount_description item"><?= l("Description", "tesla");?></th>
        <th class="discount_quantity item center"><?= l("Qté", "tesla");?></th>
        <th class="discount_value item center"><?= l("Valeur", "tesla");?>*</th>
        <th class="discount_minimum item center"><?= l("Minimum", "tesla");?></th>
        <th class="discount_expiration_date last_item"><?= l("Expiration", "tesla");?></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($cart_rule_user): ?>
        <?php foreach ($cart_rule_user as $key => $value): ?>
          <tr class="first_item">
            <td class="discount_code bold"><?= $value['code']; ?></td>
            <td class="discount_description"><?= $value['description']; ?></td>
            <td class="discount_quantity center"><?= $value['quantity']; ?></td>
            <td class="discount_value center"><?= $value['reduction']; ?> <?= $value['reduction_sign']; ?></td>
            <td class="discount_minimum center"><?= $value['minimum_amount']; ?></td>
            <td class="discount_expiration_date"><?= $value['date_to']; ?></td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
    </tbody>
  </table>
  <p> *<?= l("Taxes comprises", "tesla");?></p>

	<ul class="footer_links">
		<li><a href="" title="Retour à votre compte"><?= l("Retour à votre compte", "tesla");?></a></li>
		<li><a href="/" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	</ul>