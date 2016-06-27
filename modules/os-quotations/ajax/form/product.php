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

include '../../../../config/bootstrap.php';
//include '../../classes/devis.class.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//get posted data
$product_name = addslashes($_POST['product_name']);
$id_quotation = intval($_POST['id_quotation']);
$id_product = intval($_POST['id_product']);
$id_declinaisons = intval($_POST['id_declinaisons']);
$id_quotation_detail = intval($_POST['id_detail']);

if( $product_name == "" || $id_quotation < 1) return;


$os_product = new OS_Product();
$os_devis 	= new OS_Devis();
$os_orders 	= new OS_Orders();
$id_user = USER_ID;

//get product reference
if( empty($_POST['product_reference']) ){
	$product_reference = $os_orders->get_reference_number('products');
}else{
	$product_reference = addslashes($_POST['product_reference']);
}

//prepare quotation detail
$quotation_detail = array(
	'id_quotation' => $id_quotation, 
	'attributs' => addslashes($_POST['attributs']), 
	'product_name' => addslashes($_POST['product_name']), 
	'product_reference' => $product_reference, 
	'product_image' => addslashes($_POST['product_image']), 
	'product_price' => floatval($_POST['product_price']), 
	'product_buyprice' => floatval($_POST['product_buyprice']), 
	'loyalty_points' => intval($_POST['loyalty_points']), 
	'product_packing' => floatval($_POST['product_packing']), 
	'product_quantity' => intval($_POST['product_quantity']), 
	'product_min_quantity' => intval($_POST['product_min_quantity']), 
	'product_stock' => intval($_POST['product_stock']), 
	'product_weight' => floatval($_POST['product_weight']), 
	'product_height' => floatval($_POST['product_height']), 
	'product_width' => floatval($_POST['product_width']), 
	'product_depth' => floatval($_POST['product_depth'])
);
if( $id_product > 0 ){
	$quotation_detail['id_product'] = $id_product;
}
if( $id_declinaisons > 0 ){
	$quotation_detail['id_declinaisons'] = $id_declinaisons;
}

 
/*echo '<pre>';
print_r($id_quotation_detail);
echo '</pre>';exit;*/

//insert new product in cataloque and quotation products
if( $id_product == 0 && $id_quotation_detail == 0 )
{

	$product_data = array(
		'name'					=> addslashes($_POST['product_name']), 
		'permalink'			=> $os_product->slugify( $_POST['product_name'] ), 
		'reference'			=> $product_reference,
		'buy_price'			=> floatval($_POST['product_buyprice']), 
		'sell_price'		=> floatval($_POST['product_price']), 
		'qty'						=> intval($_POST['product_quantity']), 
		'width'					=> floatval($_POST['product_width']),  
		'height'				=> floatval($_POST['product_height']),  
		'depth'					=> floatval($_POST['product_depth']),  
		'weight'				=> floatval($_POST['product_weight']),
		'id_user'				=> USER_ID, 
		'id_lang'				=> LANG_ID,
		'active'				=> 1
	);
	$id_product = $os_product->save('products', $product_data);

	if( $id_product ){
		//insert product image
		$product_image = $os_devis->upload_product_image( $id_product );
		if( $product_image != "" ){
			$image_data = array(
				'name' => $product_image, 
				'id_product' => $id_product
			);
			$id_image = $os_product->save('product_images', $image_data);
		}
		//insert quotation product
		$quotation_detail['id_product'] = $id_product;
		if( $_POST['product_image'] != "" ) $quotation_detail['product_image'] = $_POST['product_image'];
		if( $product_image != "" ) $quotation_detail['product_image'] = $product_image;
		$os_product->save('quotation_detail', $quotation_detail);

		$response["success"] = l("Le produit a été insérer dans le catalogue des produit et dans les details de devis.", "quotation");
	  echo json_encode($response);
	}

}
//INSERT DETAILS MODE
elseif( $id_product > 0 && $id_quotation_detail == 0 )
{
	//product already exist in cataloque, insert it just in quotation product
	$product_image = $os_devis->upload_product_image( $id_product );
	if( $_POST['image'] != "" ) $quotation_detail['product_image'] = $_POST['image'];
	if( $product_image != "" ) $quotation_detail['product_image'] = $product_image;
	//insert quotation product
	$quotation_detail['id_product'] = $id_product;
	$save = $os_product->save('quotation_detail', $quotation_detail);
	if( $save ){
		$response["success"] = l("Le produit a été ajouter les details de devis.", "quotation");
	  echo json_encode($response);
	}
}
//EDIT DEATILS MODE
elseif( $id_product > 0 && $id_quotation_detail > 0 )
{
	$product_image = $os_devis->upload_product_image( $id_product );	
	if( $_POST['product_image'] != "" ) $quotation_detail['product_image'] = $_POST['product_image'];
	if( $_POST['image'] != "" ) $quotation_detail['product_image'] = $_POST['image'];
	if( $product_image != "" ) $quotation_detail['product_image'] = $product_image;
	//insert quotation product
	$quotation_detail['id_product'] = $id_product;
	$update = $os_product->update('quotation_detail', $quotation_detail, "WHERE id=".$id_quotation_detail );
	if( $update ){
		$response["success"] = l("Le produit a été mise a jour.", "quotation");
	  echo json_encode($response);
	}
}
