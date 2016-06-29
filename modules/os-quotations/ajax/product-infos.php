<?php include '../../../config/bootstrap.php';

try {
	global $DB;
	$id_product = intval($_POST['id_product']);
	$id_dec 		= intval($_POST['id_dec']);
	$id_user		= USER_ID;
	if($id_dec < 1 && $id_product < 1 ) return;
	$product = new OS_Product();
	if( $id_dec > 0 ){
		//$return = $product->getDeclinaisonByID($id_dec);
		$query = "SELECT p.name as product_name, p.discount, p.discount_type, d.reference as product_reference, d.ean13 as product_ean13, 
							d.upc as product_upc, d.price as product_price, d.weight as product_weight, d.quantity as product_quantity, 
							pi.name as product_image, t.rate as product_tax
							FROM "._DB_PREFIX_."declinaisons d
							LEFT JOIN "._DB_PREFIX_."products p ON p.id=d.id_product
							LEFT JOIN "._DB_PREFIX_."product_images pi ON pi.id_product=p.id
							LEFT JOIN "._DB_PREFIX_."taxes t ON t.id=p.id_tax
							WHERE d.id=$id_dec LIMIT 1";
		if($res = $DB->query($query)){
      $return = $res->fetch(PDO::FETCH_ASSOC);
    }

	}elseif( $id_product > 0 ){
    $query = "SELECT p.name as product_name, reference as product_reference,  upc as product_upc, ean13 as product_ean13, 
										sell_price as product_price, discount, discount_type, width as product_width, height as product_height, 
										depth as product_depth, weight as product_weight, qty as product_quantity, pi.name as product_image,
										t.rate as product_tax
							FROM "._DB_PREFIX_."products p
							LEFT JOIN "._DB_PREFIX_."product_images pi ON pi.id_product=$id_product
							LEFT JOIN "._DB_PREFIX_."taxes t ON t.id=p.id_tax
							WHERE p.id=$id_product LIMIT 1";
    if($res = $DB->query($query)){
      $return = $res->fetch(PDO::FETCH_ASSOC);
    }
	}
	echo json_encode($return);
} catch (Exception $e) {
	exit;
}