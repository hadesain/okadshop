<?php include '../../../config/bootstrap.php';

$id_customer  = intval($_GET['id_customer']);
$id_quotation = intval($_GET['id_quotation']);;
$quotations_page = '<script>window.location.href="?module=quotations"</script>';
if( ! isset( $id_customer ) && ! is_numeric( $id_customer ) || ! isset( $id_quotation ) && ! is_numeric( $id_quotation ) ) back_to_quotations();

$os_common  = new OS_Common();

//get quoattion
$data = $os_common->get_quotation($id_quotation, $id_customer);
if( empty($data) ) echo $quotations_page;

//footer information and logo
$setting  = $os_common->select('quotation_setting', array('footer', 'footer_logo', 'conditions') );
$option   = $os_common->select('quotation_options', array('expiration_date') );

//currency
$currency = $data['quotation']['currency_sign'];

	
	$html .= '<style>#products tbody tr:nth-child(even) {background-color: #e9e9e9;}</style>';

	$html .= '<div style="width:1024px;margin:0px auto;">';
		$html .= '<table cellpadding="5" cellspacing="0" style="width:1024px;margin:0px auto;">';
			$html .= '<tr>';
			$html .= '<th colspan="6" style="text-align:left;">';
			$html .= '<img src="'. UPLOADS_DIR . 'quotatonattachments/setting/'. $setting[0]['footer_logo'] .'" height="90">';
			$html .= '</th>';
			$html .= '<th colspan="2" style="text-align:right;vertical-align:top;font-size:26px;">';
			$html .= '<h2 style="color:#44271A;">DEVIS</h2>';
			$html .= '</th>';
			$html .= '</tr>';
			$html .= '<tr><td style="height:40px;"></td></tr>';
		$html .= '</table>';

		$html .= '<table border="0" cellpadding="5" cellspacing="0" style="width:1024px;">';
			$html .= '<tr>';
			$html .= '<th style="width:130px;text-align:left;">Réference</th>';
			$html .= '<td style="width:180px;text-align:left;">: '. $data['quotation']['reference'] .'</td>';
			$html .= '<th style="width:170px;text-align:left;">Nom de Client</th>';
			$html .= '<td style="text-align:left;">: '. $data['customer']['first_name'] .' '. $data['customer']['last_name'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<th style="text-align:left;">Transporteur</th>';
			$html .= '<td style="text-align:left;">: '. $data['carrier']['carrier_name'] .'</td>';
			$html .= '<th style="text-align:left;">Téléhone</th>';
			$html .= '<td style="text-align:left;">: '. $data['customer']['phone'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<th style="text-align:left;">Valable Jusqu\'a</th>';
			$html .= '<td style="text-align:left;">: '. $option[0]['expiration_date'] .'</td>';
			$html .= '<th style="text-align:left;">Adresse de livraison</th>';
			$html .= '<td style="text-align:left;">: '. $data['carrier']['address_delivery'] .'</td>';
			$html .= '</tr>';
			$html .= '<tr><td style="height:50px;"></td></tr>';
		$html .= '</table>';

		$html .= '<table cellpadding="10" cellspacing="0" style="width:1024px;margin:0px auto;border:1px solid #44271A;" id="products">';
			$html .= '<tr style="background:#44271A;color:#FFF;">';
			$html .= '<th style="color:#FFF;font-size:18px;ext-align:center;width:60px;">Image</th>';
			$html .= '<th style="color:#FFF;font-size:18px;text-align:left;width:130px;">Réference</th>';
			$html .= '<th colspan="2" style="color:#FFF;font-size:18px;text-align:left;">Désignation</th>';
			$html .= '<th style="width:90px;color:#FFF;font-size:18px;">Prix ('. $currency .')</th>';
			$html .= '<th style="width:70px;color:#FFF;font-size:18px;">Quantité</th>';
			$html .= '<th style="width:120px;color:#FFF;font-size:18px;">Remise ('. $currency .')</th>';
			$html .= '<th style="width:130px;color:#FFF;font-size:18px;">Total Ligne</th>';
			$html .= '</tr>';
			$html .= '<tbody>';
				if( !empty($data['products']) ){
					foreach ($data['products'] as $key => $product) {
		        $html .= '<tr>';
		        $html .= '<td  style="text-align:center;border-right:1px solid #44271A;">';
							$file_name = $os_common->get_file_name( $product['product_image'] );
	  					$image_path = UPLOADS_PATH ."products/". $product['id_product'] ."/". $file_name;
	  					if( file_exists($image_path) ){
	  						$html .= "<img class='img-thumbnail' src='". UPLOADS_DIR ."products/". $key ."/". $file_name ."'>";
	  					}else{
	  						$html .= "<img class='img-thumbnail' src='". MODULES_DIR ."os-quotations/images/no-image45.png' width='45'>";
	  					}
		        $html .= '</td>';
		        $html .= '<td style="border-right:1px solid #44271A;">'. $product['product_reference'] .'</td>';
		        $html .= '<td colspan="2" style="border-right:1px solid #44271A;">'. $product['product_name'] .'</td>';
		        $html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['product_price'] .'</td>';
		        $html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['product_quantity'] .'</td>';
		        $html .= '<td style="border-right:1px solid #44271A;text-align:center;">'. $product['discount'] . '</td>';
		        $html .= '<td style="text-align:right;">'. $product['total_ht'] .' '. $currency .'</td>';
		        $html .= '</tr>';
		      }
				}
      
      $html .= '</tbody>';
      $html .= '<tr style="background-color:#fff;">';
			$html .= '<td colspan="7" style="text-align:right;border-top:1px solid #44271A;border-right:1px solid #44271A;">';
			$html .= '<b>Poids global</b><br>';
			$html .= '<b>Quantité</b><br>';
			$html .= '<b>Remise</b><br>';
			$html .= '<b>TVA</b><br>';
			$html .= '<b>Frais de Transport</b><br>';
			$html .= '<b>Total HT</b><br>';
			$html .= '<b>Total TTC</b><br>';
			$html .= '</td>';
			$html .= '<td style="text-align:right;border-top:1px solid #44271A">';
			$html .= '<b>'. $data['total']['weight'] .' Kg</b><br>';
			$html .= '<b>'. $data['total']['quantity'] .' Pièces</b><br>';
			$html .= '<b>'. $data['total']['discount'] .' '. $currency .'</b><br>';
			$html .= '<b>'. $data['total']['tax'] .' '. $currency .'</b><br>';
			$html .= '<b>'. $data['total']['shipping'] .' '. $currency .'</b><br>';
			$html .= '<b>'. $data['total']['tht'] .' '. $currency .'</b><br>';
			$html .= '<b>'. $data['total']['ttc'] .' '. $currency .'</b><br>';
			$html .= '</td>';
			$html .= '</tr>';
		$html .= '</table>';

		$html .= '<div style="margin-top:50px;">';
			$html .= '<p style="font-size:11px;"><strong>Informations: </strong>'. $data['quotation']['informations'] .'</p>';
		$html .= '</div>';

	$html .= '</div>';//END WRAPPER

	//footer
	$footer = '<table border="0" cellpadding="0" cellspacing="0" style="width:1024px;margin:0px auto;">';
	$footer .= '<tr>';
	$footer .= '<td>';
	$footer .= '<img src="'. UPLOADS_DIR . 'quotatonattachments/setting/'. $setting[0]['footer_logo'] .'" height="60">';
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
	  $mpdf->Output( $reference.'.pdf' , 'I' );
	}
	catch(HTML2PDF_exception $e) {
	  exit;
	}

	//echo $html;