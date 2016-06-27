<?php include '../../../../config/bootstrap.php';

try {
	$id = intval($_POST['id']);

	if($id < 1 ) return;
	$common = new OS_Common();
	$success = $common->delete( "quotation_detail", "WHERE id=".$id );
	if( $success ){
		echo l("le produit a été supprimer avec success.", "quotation");
	}
	

} catch (Exception $e) {
	exit;
}