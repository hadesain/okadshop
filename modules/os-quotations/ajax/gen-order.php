<?php include '../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}


$id_quote = intval($_POST['id_quote']);
if( $id_quote < 1 ) return;


$common = new OS_Common();
$os_orders = new OS_Orders();

//get quoattion data
//$columns = array('id_customer', 'id_employee', 'currency_sign', 'current_state', 'send_state_email', 'payment_method', 'loyalty_points', 'total_paid', 'informations');
$order = $common->select('quotations', array('*'), "WHERE id=".$id_quote );

//prepare new order data
$order = $order[0];
if( empty($order) ) return;
$order['id_quotation'] = $id_quote;
$order['reference'] = $os_orders->get_reference_number('orders');
$order['cby'] = USER_ID;

//insert order
$exclude 	= array('id', 'expiration_date', 'can_be_ordered', 'count_emails', 'payment_choice', 'loyalty_state', 'is_packing', 'cdate', 'uby', 'udate');
$id_order = $common->save('orders', $order, $exclude);

if( $id_order ){
	
	//order carrier
	//$columns = array('id_carrier', 'carrier_name', 'delay', 'address_delivery', 'address_invoice', 'tax_rule', 'tax_type', 'global_discount', 'global_discount_type', 'global_price');
	$carrier = $common->select('quotation_carrier', array('*'), "WHERE id_quotation=".$id_quote );
	$carrier[0]['id_order'] = $id_order;
	$carrier[0]['cby'] = USER_ID;
	$exclude 	= array('id', 'id_quotation', 'uby', 'cdate', 'udate');
	$order_carrier = $common->save('order_carrier', $carrier[0], $exclude );

	

	if( $order_carrier ){
		
		//get quotation products
		//$columns = array('id_product', 'id_declinaisons', 'product_name', 'product_reference', 'product_image', 'product_ean13', 'product_upc', 'product_price', 'product_quantity', 'product_width', 'product_height', 'product_depth', 'product_weight', 'product_tax', 'tax_type', 'discount', 'discount_type');
		$order_detail = $common->select('quotation_detail', array('*'), "WHERE id_quotation=".$id_quote );
		$exclude 	= array('id', 'id_quotation', 'uby', 'cdate', 'udate');
		
		if( !empty($order_detail) ){
			foreach ($order_detail as $key => $detail) {
				//insert invoice_detail
				$detail['id_order'] = $id_order;
				$detail['cby'] = USER_ID;
				$common->save('order_detail', $detail, $exclude);
			}
		}

	}
		
	echo $id_order;
}