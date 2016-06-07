<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
	
	global $hooks;
	$user = goConnected();
	$cart = getCart();

	if (!$cart || !isset($_SESSION['invoice_address']) || !isset($_SESSION['id_carrier'])) {
		goHome();
	}

	$bankwire_owner = $hooks->select_mete_value("bankwire_owner");
	$bankwire_details = $hooks->select_mete_value("bankwire_details");
	$bankwire_adresse = $hooks->select_mete_value("bankwire_adresse");
	$id_payment_method =  $hooks->select('payment_methodes',array('id'),' WHERE value="Virement bancaire"');
	if (isset($id_payment_method[0]['id']))
		$id_payment_method = $id_payment_method[0]['id'];
	else
		$id_payment_method = null;	

	if (isset($_POST['confim_bankwire'])) {
		$data = array(
			"id_customer" => $user,
			"id_state" => 11,
			"id_payment_method" => $id_payment_method,
			"address_invoice" => $_SESSION['invoice_address'],
			"address_delivery" => $_SESSION['shipping_address'],
			"currency_sign" => CURRENCY
		);
		$id_order = $hooks->save('orders',$data);
		if ($id_order) {
			$carrier =  $hooks->select('carrier',array('*'),' WHERE id='.$_SESSION['id_carrier']);
			if (isset($carrier[0])) {
				$carrier = $carrier[0];
				$data = array(
					"id_order" => $id_order,
					"id_carrier" => $carrier['id'],
					"carrier_name" => $carrier['name'],
					"min_delay" => $carrier['min_delay'],
					"max_delay" => $carrier['max_delay']
				);
				$id_order_carrier = $hooks->save('order_carrier',$data);
				
	      for ($i=0; $i < count($cart['idProduit']) ; $i++) { 
       		$data = array(
       			"id_order" => $id_order,
       			"id_product" => intval($cart['idProduit'][$i]),
       			"product_quantity" => intval($cart['qteProduit'][$i]),
       			"product_price" => floatval($cart['prixProduit'][$i]),
       			"product_name" => floatval($cart['titleProduit'][$i]),
       		);
       		$hooks->save('order_detail',$data);
	      }
			}
			supprimePanier();
			unset($_SESSION['invoice_address']);
			unset($_SESSION['invoice_address']);
			unset($_SESSION['id_carrier']);
			goHome();
		}
	}
?>
  <!-- Main content start here -->
  <ol class="breadcrumb">
    <li><a href="#" title="<?= l("Accueil", "bankwire");?>"><?= l("Accueil", "bankwire");?></a></li>
    <li class=""><?= l("Payment methode", "bankwire");?></li>
    <li class="active"><?= l("Payment par Virement Bancaire", "bankwire");?></li>
  </ol>

	<ul class="step" id="order_step">
    <li class="step_line"></li>
    <li class="step_done">
      <p class="number">1</p>
      <p class="name"><a href="#"><?= l("Résumé", "bankwire");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">2</p>
      <p class="name"><a href="#"><?= l("Adresse", "bankwire");?></a></p>
    </li>
    <li class="step_done">
      <p class="number">3</p>
      <p class="name"><?= l("Livraison", "bankwire");?></p>
    </li>
    <li class="step_done" id="">
      <p class="number">4</p>
      <p class="name"><?= l("Paiement", "bankwire");?></p>
    </li>
  </ul>

	<h1><?= l("Order Confirmation", "bankwire");?> : <?= l("Virement Bancaire", "bankwire");?></h1>
	<p class="payment_module">
		<b><?= l("S'il vous plaît envoyez-nous un virement bancaire avec", "bankwire");?></b><br>
		- <?= l("Montant", "bankwire");?> : <?=MontantGlobal(); ?><br>
		- <?= l("Nom du titulaire de compte", "bankwire");?> <b><?= $bankwire_owner; ?></b><br>
		- <?= l("Inclure ces détails", "bankwire");?> <b><?= $bankwire_details; ?></b><br>
		- <?= l("Nom de banque", "bankwire");?> <b><?= $bankwire_adresse; ?></b><br>
		- <?= l("Ne pas oublier d'insérer votre référence de l'ordre  dans le sujet de votre virement bancaire.", "bankwire");?><br>
		<?= l("Votre commande sera envoyée dès que nous recevons le paiement.", "bankwire");?><br>
		<?= l("Si vous avez des questions, des commentaires ou des préoccupations, s'il vous plaît contacter notre équipe d'assistance à la clientèle d'experts.", "bankwire");?>
		<br><br>
		
	</p>
	<form method="POST" action="">
    <p class="cart_navigation">
      <input type="submit" name="confim_bankwire" value="<?= l("confirmé la commande", "artiza");?>" class="exclusive  pull-right">
      <a href="<?=WebSite; ?>" class="button_large"><?= l("Retour au site", "bankwire");?>.</a>
    </p>
  </form>