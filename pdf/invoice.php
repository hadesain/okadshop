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

include '../config/bootstrap.php';


/**
 *=============================================================
 * invoice PDF VIEW
 * This part well apply when you go to view invoices PDF
 * EX: [WewSite]?module=invoices&action=view&id=[1]
 *=============================================================
 */
	session_start();
	header('Content-Type: text/html; charset=UTF-8');

	//we have id_invoice in url
	if ( empty($_GET['id_invoice']) ) return;

	//invoice
	$id_invoice = intval($_GET['id_invoice']);
	if ( intval($_GET['id_invoice']) <= 0 ) return;

	//customer
	if( isset($_GET['id_customer']) && intval($_GET['id_customer']) > 0 ){
		$id_customer  = intval($_GET["id_customer"]);
	}else{
		$id_customer  = intval($_SESSION["user"]);
	}
	
	//check if this invoice exist
	global $common;
	$i = $common->get_invoice($id_invoice, $id_customer);
	if( empty($i) ) return;

	//footer information and logo
	$setting  = $common->select('quotation_setting', array('footer', 'footer_logo', 'conditions') );

	//payment_choice
	$payment_choice = $i['invoice']['payment_choice'];
	if( $payment_choice != "" ){
		$methods = $common->select('payment_methodes', array('value'), "WHERE id IN($payment_choice)" );
	}
	if( $i['invoice']['id_payment_method'] != "0" ){
		$payment_method = $common->select('payment_methodes', array('value'), "WHERE id=".$i['invoice']['id_payment_method'] );
	}


	//currency
	$currency = $i['invoice']['currency_sign'];

	$site_logo = "../files/quotatonattachments/setting/".$setting[0]['footer_logo'];
	if( !file_exists($site_logo) ){
		$site_logo = "../modules/os-quotations/images/site_logo.jpg";
	}


	//total
	$total_products  = $i['total']['product_tht'];
	$total_ht 			 = $i['total']['tht'];
	$global_weight   = $i['total']['weight'];
	$global_discount = $i['invoice']['global_discount']; 
	//invoice infos
	$voucher_code 	 = $i['invoice']['voucher_code'];
	$voucher_value 	 = $i['invoice']['voucher_value']; 
	$avoir 					 = $i['invoice']['avoir'];
	//carrier infos
	$shipping_costs  = number_format($i['carrier']['shipping_costs'], 2);

	//prepare html for new PDF
	$html .= '<style>#products tbody tr:nth-child(even) {background-color: #e9e9e9;}</style>';

	$html .= '<div style="width:1024px;margin:0px auto;">';
		$html .= '<table cellpadding="5" cellspacing="0" style="width:1024px;margin:0px auto;">';
			$html .= '<tr>';
			$html .= '<th colspan="6" style="text-align:left;">';
			$html .= '<img src="'.$site_logo .'" height="90">';
			$html .= '</th>';
			$html .= '<th colspan="2" style="text-align:right;vertical-align:top;font-size:26px;">';
			$html .= '<h2 style="color:#44271A;">FACTURE</h2>';
			$html .= '</th>';
			$html .= '</tr>';
			$html .= '<tr><td style="height:40px;"></td></tr>';
		$html .= '</table>';

		$html .= '<table border="0" cellpadding="5" cellspacing="0" style="width:1024px;">';
			$html .= '<tr>';
			$html .= '<th style="width:190px;text-align:left;">Réference</th>';
			$html .= '<td style="width:350px;text-align:left;">: '. $i['invoice']['reference'] .'</td>';
			$html .= '<th style="width:125px;text-align:left;">Nom de Client</th>';
			$html .= '<td style="text-align:left;">: '. $i['customer']['first_name'] .' '. $i['customer']['last_name'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<th style="text-align:left;">Transporteur</th>';
			$html .= '<td style="text-align:left;">: '. $i['carrier']['carrier_name'] .'</td>';
			$html .= '<th style="text-align:left;">Téléhone</th>';
			$html .= '<td style="text-align:left;">: '. $i['customer']['mobile'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			//$html .= '<th style="text-align:left;">Méthode de paiement</th>';
			//$html .= '<td style="text-align:left;">: '. $i['invoice']['payment_method'] .'</td>';
			$html .= '<th style="text-align:left;">Adresse de facturation</th>';
			$html .= '<td colspan="4" style="text-align:left;">: '. $i['invoice']['address_invoice'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr><td style="height:50px;"></td></tr>';
		$html .= '</table>';

		$html .= '<table cellpadding="10" cellspacing="0" style="width:1024px;margin:0px auto;border:1px solid #44271A;" id="products">';
			$html .= '<tr style="background:#44271A;color:#FFF;">';
			$html .= '<th style="color:#FFF;font-size:18px;ext-align:center;width:60px;">Image</th>';
			$html .= '<th style="color:#FFF;font-size:18px;text-align:left;width:130px;">Réference</th>';
			$html .= '<th colspan="3" style="color:#FFF;font-size:18px;text-align:left;">Désignation</th>';
			$html .= '<th style="width:90px;color:#FFF;font-size:18px;">Prix ('. $currency .')</th>';
			$html .= '<th style="width:70px;color:#FFF;font-size:18px;">Quantité</th>';
			//$html .= '<th style="width:120px;color:#FFF;font-size:18px;">Remise ('. $currency .')</th>';
			$html .= '<th style="width:130px;color:#FFF;font-size:18px;">Total Ligne</th>';
			$html .= '</tr>';
			$html .= '<tbody>';
				if( !empty($i['products']) ){
					foreach ($i['products'] as $key => $product) {
		        $html .= '<tr>';
		        $html .= '<td  style="text-align:center;border-right:1px solid #44271A;">';
	  					$file_name = $common->get_file_name( $product['product_image'] );
	  					$image_path = "../files/products/". $product['id_product'] ."/". $file_name;
	  					if( file_exists($image_path) ){
	  						$html .= "<img class='img-thumbnail' src='". $image_path ."' width='45'>";
	  					}else{
	  						$html .= "<img class='img-thumbnail' src='../modules/os-quotations/images/no-image45.png' width='45'>";
	  					}
		        $html .= '</td>';
		        $html .= '<td style="border-right:1px solid #44271A;">'. $product['product_reference'] .'</td>';
		        $html .= '<td colspan="3" style="border-right:1px solid #44271A;"><strong>'. $product['product_name'] .'</strong>
				        			<p>
												Colisage : '. $product['product_packing'] .' unités<br>
												Poids (kg) : '. $product['product_weight'] .' du pack<br>';
												if( $product['attributs'] != "" ){
													$html .= "Attributs : ".$product['attributs'];//Attributs quand renseignés 
												}
						$html .= '</p>
				        		</td>';
		        $html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['product_price'] .'</td>';
		        $html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['product_quantity'] .'</td>';
		        //$html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['discount'] .'</td>';
		        $html .= '<td style="text-align:right;">'. $product['total_ht'] .'</td>';//.' '. $currency
		        $html .= '</tr>';
		      }
				}

				$html .= '<tr style="background-color:#fff;">';
					
					$html .= '<td colspan="7" style="text-align:right;border-top:1px solid #44271A;border-right:1px solid #44271A;">';
					$html .= '<b>Total produits HT</b><br>';
					if($global_discount > 0) $html .= '<b>Remise globale</b><br>';
					if($voucher_value > 0) $html .= '<b>Bon de réduction</b><br>';
					if($avoir > 0) $html .= '<b>Avoir</b><br>';
					if($voucher_code != "") $html .= '<b>Code promo</b><br>';
					$html .= '<b>Frais de transport</b><br>';
					$html .= '<b>TOTAL HT</b><br>';
					$html .= '<b>Poids total</b><br>';
					$html .= '</td>';

					$html .= '<td style="text-align:right;border-top:1px solid #44271A">';
					$html .= '<b>'. $total_products .'</b><br>';
					if($global_discount > 0) $html .= '<b>'. $global_discount .'</b><br>';
					if($voucher_value > 0) $html .= '<b>'. $voucher_value .'</b><br>';
					if($avoir > 0) $html .= '<b>'. $avoir .'</b><br>';
					if($voucher_code != "") $html .= '<b>'. $voucher_code .'</b><br>';
					$html .= '<b>'. $shipping_costs .'</b><br>';
					$html .= '<b>'. $total_ht .'</b><br>';
					$html .= '<b>'. $global_weight .'</b><br>';
					$html .= '</td>';

				$html .= '</tr>';
				
      $html .= '</tbody>';
      $html .= '</table>';

		if( $i['invoice']['informations'] != "" ){
			$html .= '<div style="margin-top:50px;">';
				$html .= '<p style="font-size:11px;"><strong>Informations: </strong>'. $i['invoice']['informations'] .'</p>';
			$html .= '</div>';
		}


		$html .= '<div><br>';

			if( !empty($methods) ){
				$html .= '<strong>Règlement</strong>';
				$html .= '<p style="margin:0px;">Mode de règlement acceptés :</p>';
				$html .= '<ul style="margin-top:5px;">';
				foreach ($methods as $key => $method) {
					$html .= '<li>'.$method['value'].'</li>';
				}
				$html .= '</ul>';
			}

			if( !empty($payment_method) ){
				$html .= '<strong>Modalités de règlement :</strong>';
				$html .= '<ul style="margin-top:5px;">';
				$html .= '<li>'.$payment_method[0]['value'].'</li>';
				$html .= '</ul>';
			}

			if( $i['invoice']['more_info'] != "" ){
				$html .= '<strong>Informations complémentaires</strong>';
				$html .= '<p>'.$i['invoice']['more_info'].'</p>';
			}

			if( $i['invoice']['informations'] != "" ){
				$html .= '<strong>Divers</strong>';
				$html .= '<p style="margin:0px;">Informations complémentaires :</p>';
				$html .= '<p>'.$i['invoice']['informations'].'</p>';
			}

			$html .= '<p>Pour accepter, modifier, refuser cette facture ou pour nous contacter, rendez vous sur votre espace professionnel : ';
			$html .= '<a href="'.$website_url.'account/invoices">'.$website_url.'account/invoices</a><br>';
			$html .= 'Notre service client se tient à votre entière disposition pour toute demande ou information complémentaire.</p>';
		
		$html .= '</div>';



		if( $setting[0]['conditions'] != "" ){
			$html .= '<div style="margin-top:50px;">';
				$html .= '<p style="font-size:11px;">'. $setting[0]['conditions'] .'</p>';
			$html .= '</div>';
		}

	$html .= '</div>';//END WRAPPER

	//footer
	$footer = '<table border="0" cellpadding="0" cellspacing="0" style="width:1024px;margin:0px auto;">';
	$footer .= '<tr>';
	$footer .= '<td>';
	$footer .= '<img src="'. $site_logo .'" height="60">';
	$footer .= '</td>';
	$footer .= '<td style="padding-left:20px;">';
	$footer .= $setting[0]['footer'];
	//$footer .= '<b><center>Cet document est crée par <a target="_blank" href="#" style="color:#44271A;">OkadShop</a></center></b>';
	$footer .= '</td>';
	$footer .= '</tr>';
	$footer .= '</table>';


	try
	{
	  $mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 15 , 15 , 10 , 10 , 10 , 5); 
	  $mpdf->SetDisplayMode('fullpage');
	  $mpdf->list_indent_first_level = 0;
	  $mpdf->setDefaultFont("Arial");
	  $mpdf->WriteHTML($html);
	  $mpdf->SetHTMLFooter($footer);
	  $mpdf->Output( $i['invoice']['reference'].'.pdf' , 'I' );
	}
	catch(HTML2PDF_exception $e) {
	  exit;
	}

	//echo $html;