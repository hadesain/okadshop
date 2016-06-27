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

$id_quotation = intval($_POST['id_quotation']);
$id_customer = intval($_POST['id_customer']);
if($id_quotation < 1 || $id_customer < 1 ) return;

global $common;
$q = $common->get_quotation($id_quotation, $id_customer);
$totals = $products = "";

//total
$total_products = number_format((float)$q['total']['product_tht'], 2, '.', '');
$total_ht = number_format((float)$q['total']['tht'], 2, '.', '');
$global_weight  = floatval($q['total']['weight']);
$global_discount = number_format((float)$q['quotation']['global_discount'], 2, '.', ''); 

//quotation infos
$voucher_code = $q['quotation']['voucher_code'];
$voucher_value = number_format((float)$q['quotation']['voucher_value'], 2, '.', ''); 
$avoir = number_format((float)$q['quotation']['avoir'], 2, '.', '');


//carrier infos
$shipping_costs = (isset($q['carrier']['shipping_costs'])) ? $q['carrier']['shipping_costs'] : '0.00';

if( !empty($q['products']) )
{

	foreach ($q['products'] as $key => $product)
	{

		$products .= '<tr id="'.$product['id'].'">';
		$products .= '<td class="text-center">
										<a href="#" class="pop">';
										$file_name = $common->get_file_name( $product['product_image'], "80x80" );
										$image_path = '../../../../files/products/'.$product['id_product'].'/'.$file_name;
										if( file_exists($image_path) ){
											$products .= "<img class='img-thumbnail' src='../files/products/".$product['id_product']."/".$file_name."' width='80'>";
										}else{
											$products .= "<img class='img-thumbnail' src='../modules/os-quotations/images/no-image45.png' width='80'>";
										}
		$products .= '</a>
									</td>
									<td class="text-center">'.$product['product_reference'].'</td>
									<td>';
		$products .= '<strong><a href="?module=products&action=edit&id='.$product['id_product'].'" target="_blank">'.stripslashes($product['product_name']).'</a></strong><p>
									Colisage : '.$product['product_packing'].' unités<br>
									Poids (kg) : '.$product['product_weight'].' du pack<br>';
									if( $product['attributs'] != "" ){
										$products .= "Attributs : ".$product['attributs'];
									}
		$products .= '</p>
									</td>
									<td class="text-center">'.$product['product_price'].'</td>
									<td>
										<div class="input-group">
								      <input type="number" min="1" step="1" placeholder="1" class="form-control product_qty" value="'.$product['product_quantity'].'">
								      <span class="input-group-btn">
								        <a class="btn btn-default refresh_qty" type="button"><i class="fa fa-refresh"></i></a>
								      </span>
								    </div>
									</td>';
		$products .= '<td class="text-center">'.$product['total_ht'].'</td>
									<td class="text-center">'.$product['product_stock'].'</td>
									<td class="text-center">
							    	<a href="javascript:;" class="btn btn-default update" title="Mettre à jour">
							    		<i class="fa fa-pencil"></i>
							    	</a>
							    	<a href="javascript:;" class="btn btn-danger delete" title="Supprimer ce produit">
							    		<i class="fa fa-trash"></i>
							    	</a>
							    </td>
								</tr>';

	}

}


//totals
$totals = '<tr>
							<th width="150">'. l("Total produits HT", "quotation") .'</th>
							<td><span class="total_products">'.$total_products.'</span></td>
						</tr>';
					if( $global_discount > 0 ){
						$totals .= '<tr>
							<th width="150">'. l("Remise globale", "quotation") .'</th>
							<td><span class="discount">'. $global_discount .'</span></td>
						</tr>';
					}
						
					if( $voucher_value > 0 ){
						$totals .= '<tr>
							<th width="150">'. l("Bon de réduction", "quotation") .'</th>
							<td><span class="reduction">'.$voucher_value.'</span></td>
						</tr>';
					}
						
					if( $avoir > 0 ){
						$totals .= '<tr>
							<th width="150">'. l("Avoir", "quotation") .'</th>
							<td><span class="avoir">'.$avoir.'</span></td>
						</tr>';
					}
						
					if( $voucher_code != "" ){
						$totals .= '<tr>
							<th width="150">'. l("Code promo", "quotation") .'</th>
							<td><span class="code">'.$voucher_code.'</span></td>
						</tr>';
					}

$totals .= '<tr>
							<th width="150">'. l("Frais de transport", "quotation") .'</th>
							<td><span class="shipping">'.$shipping_costs.'</span></td>
						</tr>
						<tr>
							<th width="150">'. l("TOTAL HT", "quotation") .'</th>
							<td><span class="tht">'.$total_ht.'</span></td>
						</tr>
						<!--tr>
							<th width="150">'. l("Acompte", "quotation") .'</th>
							<td><span class="acompte"></span></td>
						</tr>
						<tr>
							<th width="150">'. l("Solde", "quotation") .'</th>
							<td><span class="solde"></span></td>
						</tr-->
						<tr>
							<th width="150">'. l("Poids total", "quotation") .'</th>
							<td><span class="weight">'.$global_weight.'</span></td>
						</tr>';

//return
$return['products'] = $products;
$return['totals'] = $totals;
$return['company'] = ($q['quotation']['company'] != "") ? $q['quotation']['company'] : $q['customer']['company'];
echo json_encode($return);
exit;