<?php include '../../../config/bootstrap.php';

try {
	$id_cart_rule = intval($_POST['id_cart_rule']);
	if($id_cart_rule < 1) return;

	global $common;
	$exist = $common->select('cart_rule', array('*'), "WHERE id=". $id_cart_rule );
	if( $exist[0] ){
		$cart_data = array();
		$cart_data['name'] = $exist[0]['name'];
		$cart_data['code'] = $exist[0]['code'];
		$cart_data['free_shipping'] = $exist[0]['free_shipping'];
		$cart_data['reduction'] = $exist[0]['reduction'];
		$cart_data['apply_discount'] = $exist[0]['apply_discount'];
		$cart_data['reduction_type'] = $exist[0]['reduction_type'];
		$cart_data['gift_product'] = $exist[0]['gift_product'];
		$cart_data['gift_product_attribute'] = $exist[0]['gift_product_attribute'];
		//product restriction
	  $product_ids = $exist[0]['product_restriction'];
	  if( !empty($product_ids) ){
	    $product_res = $common->select('products', array('id', 'name'), "WHERE id IN ($product_ids) AND active=1" );
	    $options = "";
	    foreach ($product_res as $key => $product) {
	    	$options .= "<option value='".$product['id']."'>".$product['name']."</option>";
	    }
	    $cart_data['reduction_products'] = $options;
	  }else{
	  	$cart_data['reduction_products'] = "";
	  }

		echo json_encode($cart_data);
	}

} catch (Exception $e) {
	exit;
}