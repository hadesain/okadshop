<?php
		global $hooks;
		$user = goConnected();
		$cart = getCart();

		if (!$cart || !isset($_SESSION['invoice_address']) || !isset($_SESSION['id_carrier'])) {
			goHome();
		}
		$id_payment_method =  $hooks->select('payment_methodes',array('id'),' WHERE value="Western Union"');
		if (isset($id_payment_method[0]['id']))
			$id_payment_method = $id_payment_method[0]['id'];
		else
			$id_payment_method = null;
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