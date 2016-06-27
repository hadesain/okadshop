<?php include '../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//exit if empty
$id_quote = intval($_POST['id_quote']);
if( $id_quote < 1 ) return;

//orders instance
$os_orders = new OS_Orders();

//get quoattion data
$quotation = $os_orders->select('quotations', array('*'), "WHERE id=".$id_quote );
if( ! $quotation[0] ) return;

//prepare new quoattion data
$quotation[0]['reference'] = $os_orders->get_reference_number('quotations');
$quotation[0]['cby']   = USER_ID;

//insert quotation
$exclude = array('id', 'cdate', 'udate', 'uby');
$id_quotation = $os_orders->save('quotations', $quotation[0], $exclude);

//insert quotation assets
if( $id_quotation ){

	//get quotation detail
	$quotation_detail = $os_orders->select('quotation_detail', array('*'), "WHERE id_quotation=".$id_quote );
	if( !empty($quotation_detail) ){
		foreach ($quotation_detail as $key => $detail) {
			//insert detail
			$detail['id_quotation'] = intval($id_quotation);
			$detail['product_name'] 	= addslashes($detail['product_name']);
			$detail['cby'] = USER_ID;
			$exclude = array('id', 'cdate', 'udate');
			$os_orders->save('quotation_detail', $detail, $exclude);
		}
	}

	//get quotation shipping
	$quotation_carrier = $common->select('quotation_carrier', array('*'), "WHERE id_quotation=".$id_quote );
	if( !empty($quotation_carrier) ){
		//insert carrier
		$carrier_data = $quotation_carrier[0];
		$carrier_data['id_quotation'] = intval($id_quotation);
		$carrier_data['cby'] = USER_ID;
		//$exclude = array('id', 'uby', 'cdate', 'udate');
		$common->save('quotation_carrier', $carrier_data, $exclude);
	}

	$return['id_quote'] = $id_quotation;
	$return['id_customer']  = $quotation[0]['id_customer'];
	echo json_encode($return);

	//echo $id_quotation;
}