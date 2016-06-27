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
 * ADRESS PDF VIEW
 * This part well apply when you go to view adress PDF
 *=============================================================
 */

	header('Content-Type: text/html; charset=UTF-8');
	$home_page = '<script>window.location.href="'. _WebSite_ .'"</script>';

	if ( 
		empty($_GET['id_adress']) && !is_numeric($_GET['id_adress']) || intval($_GET['id_adress']) <= 0
	) echo $home_page;

	
global $DB;
$id_adress = intval($_GET['id_adress']);
$query = "SELECT a.name as adress_name, a.addresse, a.firstname, a.company, a.lastname, a.city, a.codepostal, a.mobile, c.name as country
					FROM "._DB_PREFIX_."addresses a, "._DB_PREFIX_."countries c WHERE a.id_country=c.id AND a.id=".$id_adress;
if($rows = $DB->query($query)){

  $adress = $rows->fetch(PDO::FETCH_ASSOC);
  if(!empty($adress)){

  	$html  = '<h1>Étiquette de l\'adresse : '. $adress['adress_name'] .'<h1>';
  	$html .= '<div style="width:500px;margin:0px;">';
	  $html .= '<table border="1" cellpadding="5" cellspacing="0">';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Nom</th>';
	      $html .= '<td>: '. $adress['firstname'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Prénom</th>';
	      $html .= '<td>: '. $adress['lastname'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Société</th>';
	      $html .= '<td>: '. $adress['company'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Adresse</th>';
	      $html .= '<td>: '. $adress['addresse'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Code Postal</th>';
	      $html .= '<td>: '. $adress['codepostal'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Ville</th>';
	      $html .= '<td>: '. $adress['city'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Pays</th>';
	      $html .= '<td>: '. $adress['country'] .'</td>';
	    $html .= '</tr>';
	    $html .= '<tr>';
	      $html .= '<th style="text-align:left;">Téléphone portable</th>';
	      $html .= '<td>: '. $adress['mobile'] .'</td>';
	    $html .= '</tr>';
	  $html .= '</table>';
	  $html .= '</div>';

	  $pdf_name = str_replace(" ", "_", $adress['adress_name'].'_pour_'.$adress['firstname'].'_'.$adress['lastname'] ) .'_'. date('Y_d_m_H_m_s') .'.pdf';

	  try
		{
		  $mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 15 , 15 , 10 , 10 , 10 , 5); 
		  $mpdf->SetDisplayMode('fullpage');
		  $mpdf->list_indent_first_level = 0;
		  $mpdf->setDefaultFont("Arial");
		  $mpdf->WriteHTML($html);
		  $mpdf->Output( $pdf_name , 'D' );
		}
		catch(HTML2PDF_exception $e) {
		  echo $home_page;
		}

  }else{
  	echo $home_page;
  }


}else{
	echo $home_page;
}