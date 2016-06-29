<?php
include '../../../config/bootstrap.php';

try {
	$id_product = intval($_POST['id_product']);
	if($id_product < 1) return;
	$devis = new OS_Product();
	//Product Declinaisons
	$product_declinaisons = $devis->getProductDeclinaisons($id_product);
	$options = '<option value="" selected>'. l("Sélectionnez une attribut", "quotation") .'</option>';
	if(!empty($product_declinaisons)) {
		foreach ($product_declinaisons as $key => $value) {
			$data_comb = $devis->getCombinations($id_product, $value['id']);
			$attr_string = '';
			foreach ($data_comb as $key => $comb) {
				$attr_string .= $comb['attr_name'].' - '.$comb['value_name'].', ';
			}
			$attr_string = substr($attr_string, 0, -2);
			$options .= '<option value="'. $value['id'] .'">'. $attr_string .'</option>';
		}
	}
	echo $options;
} catch (Exception $e) {
	exit;
}