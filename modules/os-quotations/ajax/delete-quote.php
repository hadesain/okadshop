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

//common instance
$common = new OS_Common();

//check if exist
$exist = $common->select('quotations', array('id'), "WHERE id=".$id_quote );
if( $exist ){

	//delete quotation options
	$common->delete('quotation_options', "WHERE id_quotation=".$id_quote );

	//delete quotation messages
	$common->delete('quotation_messages', "WHERE id_quotation=".$id_quote );

	//delete quotation emails
	$common->delete('quotation_emails', "WHERE id_quotation=".$id_quote );

	//delete quotation shipping
	$common->delete('quotation_carrier', "WHERE id_quotation=".$id_quote );

	//delete quotation products
	$common->delete('quotation_detail', "WHERE id_quotation=".$id_quote );

	//delete quotation
	$common->delete('quotations', "WHERE id=".$id_quote );

	//success
	echo l("Quotation was deleted.", "quotation");
}