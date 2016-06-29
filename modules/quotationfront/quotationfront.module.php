<?php
if (!defined('_OS_VERSION_'))
  exit;

require_once "php/includes/function.php";

//register module infos
global $hooks;
$data = array(
	"name" => "Quotation front",
	"description" => "Quotation front.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('quotationfront', $data);


function quotationfront_install(){
	
}

function getPID($string){
	$tmp = explode('-', $string);
	if (is_numeric($tmp[0])) {
		return $tmp[0];
	}
	return false;
}
function quotationfront_displayProduct(){
	//require_once "php/includes/function.php";
	$output = "";
	if (isset($_POST['SubmitQuotation'])){
		$pid = getPID($_GET['ID']);
		$id_dec = null;
		if (isset($_POST['cu']) && !empty($_POST['cu'])) {
			$cu = $_POST['cu'];
			global $hooks;
			$res = $hooks->select('declinaisons', array('*'), "WHERE cu= '$cu'" );
			if ($res && isset($res[0]) && !empty($res)) {
				$res = $res[0];
				$id_dec = $res['id'];
			}
		}
		$qty = $_POST['qty'];
		if ($pid){
			//add product to quotation
			$prix = 0;
			$res = ajouterDevis($pid,$qty,$prix,$id_dec);
			if ($res) {
				$output .='<div class="alert alert-info" role="alert">'.l('Le produit a bien été ajouté au devis','quotationfront').'</div>';
			}
		}
	}
	$output .= '<div style="display:none;" id="addproduct_alert"></div>';
	//<div class="alert alert-info" role="alert">...</div>
	$pid = getPID($_GET['ID']);
	if (loged()) {
		$product = ProductByid($pid);
		if ($product['min_quantity'] <= 0) {
			$product['min_quantity'] = 1; 
		}
		$output .= '<form action="" method="POST"><p class="buttons_bottom_block" id="add_to_quotation"> 
						<div class="form-group" id_product="'.$product['id'].'">
							<label for="quantité">'.l('Quantité','quotationfront').' : </label>
							<input type="number" name="qty" id="qty" value="'.$product['min_quantity'].'" min="'.$product['min_quantity'].'" >
							<input type="hidden" name="cu" value="" id="cu" class="cu">
							<input type="hidden"  value="'.$product['sell_price'].'" class="sell_price">
							<input type="button" id="add_product_to_quoataion" name="SubmitQuotation" value="'.l('Ajouter au devis','quotationfront').'" class="exclusive" style="margin-top: 7px;padding: 3px 9px;">
						</div>
					</form>';
	}
	
	
	echo $output;
}
add_hook('sec_product_button', 'quotationfront', 'quotationfront_displayProduct', 'Quotation front display Product');


/*function quotationfront_displaysidebar(){
	$output ="";
	
	if (isset($_SESSION['quotationedit'])) {
		$txt = "Completé la modification de mon devis";
	}else{
		$txt = "Faire une demande de devis";
	}
	if (loged()) {
		$output .='<a class="button_large" href="'.WebSite.'cart" title="demande de devis">'.$txt.'</a>';
	}
	echo $output;
}
add_hook('sec_sidebar','quotationfront_displaysidebar');*/
function fixFloat($float){
	return number_format($float,'2','.','');
}

function quotationfront_displaycart(){

	global $hooks;

	$id_delete = _GET('deleteP');
	if ($id_delete && !empty($id_delete)) {
		$id_dec = _GET('dec');
		deleteProductFromDevis($id_delete,$id_dec);
	}
	$id_update = _GET('updatepqty');
	$qty_update = _GET('qty');
	if ($id_update && $qty_update) {
		$id_dec = _GET('iddec');
		updateQteProduct($id_update,$qty_update,$id_dec);
	}

	$quotation_edit = _GET('quotation_edit'); 	
	if ($quotation_edit && !isset($_SESSION['quotation_edit'])) {
		toQuotationSession($quotation_edit);
		$_SESSION['quotation_edit'] = $quotation_edit;	
	}

	if (isset($_SESSION['quotation_edit'])) {
		$quotation_edit = $_SESSION['quotation_edit'];
	}
	$output ="";
	//$output ='<script src="modules/quotationfront/assets/js/script.js"></script>';
/*	$output .="<h1>Récapitulatif des produits ajouté au devis</h1>";*/
	$devis = getDevis();
	//var_dump($devis['qteProduit']);
	if(isset($devis['idProduit'])){
		$nbProduct = count($devis['idProduit']);
	}

	$totalPrice = 0;
	$totalpoints = 0;
	if (isset($nbProduct) &&  $nbProduct >0 ){
		$output .='<div class="table-responsive">
						    <table class="table table-bordered borer0" id="summary">
						      <thead>
						        <tr>
						          <th class="product first_item"><b>'.l('Produit','quotationfront').'</b></th>
						          <th class="description item"><b>'.l('Description','quotationfront').'</b></th>
						          <th class="item"><b>'.l('Prix unitaire','quotationfront').'</b></th>
						          <th width="100" class="quantity item"><b>'.l('Qté','quotationfront').'</b></th>
						          <th class="item"><b>'.l('Action','quotationfront').'</b></th>
						          <th class="item"><b>'.l('Prix total','quotationfront').'</b></th>
						        </tr>
						      </thead>
						      <tbody>';
    for ($i=0; $i <$nbProduct ; $i++) { 
    	$product = getProductByid($devis['idProduit'][$i]);
  		if (!$product || empty($product)) {
  			continue;
  		}
  		$img = getThumbnail($product['id'],'200x200');
  		$product['short_description'] = substr(strip_tags($product['short_description']), 0,100).'...';
  		if ($devis['id_dec'][$i] != null){
    		$declinaison = getDeclinaisonByid($devis['id_dec'][$i]);
    		$product['reference'] = $declinaison['reference'];

	    	$img_id = explode(',', $declinaison['images']);
	    	$img_id =$img_id [0];
	    	$dec_img = getThumbnail($product['id'],'200x200',$img_id);
	    	if ($dec_img != null) {
	    		$img_id = $dec_img;
	    	}
    		if (isset($declinaison['cu'])) {
    			$p_attr_value = getCuString($declinaison['cu']);
    			if ($p_attr_value) {
    				$product['short_description'] = $p_attr_value;
    			}
    		}
    	}else{
    		$declinaison = null;
    	}
    if ($product['wholesale_per_qty'] > 0 && $product['wholesale_price'] > 0 && $devis['qteProduit'][$i] >= $product['wholesale_per_qty']) {
			$product['sell_price'] = $product['wholesale_price'];
		}

  		$totalPrice += ($product['sell_price'] * $devis['qteProduit'][$i]);
  		$totalpoints += ($product['loyalty_points'] * $devis['qteProduit'][$i]);
  		
  		
  		if($img) 
  			$img_src = WebSite.$img; 
  		else 
  			$img_src = 'modules/quotationfront/assets/images/no-image-sm.jpg';

  		$product = fixOneProduct($product);
  		$output .='<tr class="" id="product_'.$product['id'].'" iddec="'.$declinaison['id'].'">
          <td class="cart_product">
            <a href="#" class="pop" title="'.$product['name'].'">
              <img alt="'.$product['name'].'" class="replace-2x" src="'.$img_src.'" style="height:100px;width:100px">
            </a>
          </td>
          <td class="cart_description">
            <p class="product_name">
              <a href="'.WebSite.'product/'.$product['id'].'-'.$product['permalink'].'" title="">'.$product['name'].'</a>
            </p>'./*$product['short_description']*/''.'
            <p class="bold">'.l('Référence','quotationfront').' : '.$product['reference'].'</p>
            <p class="">'.l('Colisage','quotationfront').' : </p>
            <p class="">'.l('Poids','quotationfront').' (kg) : '.$product['weight'].'  '.l('du pack','quotationfront').'</p>
            <p class="">'.l('prix du lot','quotationfront').' : '.number_format($product['wholesale_price'],'2','.','').' '.l('Par','quotationfront').' '.$product['wholesale_per_qty'].'  '.l('du pack','quotationfront').'</p>
            
          </td>
           <td class="cart_price">'.number_format($product['sell_price'],'2','.','').' &euro;</td>
          <td>
          	<div class="input-group" pid="'.$product['id'].'" dec="'.$declinaison['id'].'">
						 	<input type="number" min="1" step="1" placeholder="1" value="'.$devis['qteProduit'][$i].'" class="form-control" value="" style="padding: 16px 0;font-size: 15px;">
						 	<span class="input-group-btn">
						   <a class="btn btn-default refresh_qty_product" type="button"><i class="fa fa-refresh"></i></a>
						 	</span>
						</div>
          </td>
          <td>
          	<a dec="'.$declinaison['id'].'" pid="'.$product['id'].'" href="javascript:;" class="btn btn-danger delete_product" title="'.l('Supprimer ce produit','quotationfront').'"><i class="fa fa-trash"></i></a>
          </td>
          <td class="cart_price">'.number_format($product['sell_price']*$devis['qteProduit'][$i],'2','.','').' &euro;</td>
        </tr>';

    }
    $output .= '<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">              
								      <div class="modal-body">
								      	<button type="button" class="close" data-dismiss="modal">
								      		<span aria-hidden="true">&times;</span>
								      		<span class="sr-only">Close</span>
								      	</button>
								        <img src="" class="imagepreview" style="width: 100%;" >
								      </div>
								    </div>
								  </div>
								</div>';
						      	
  $_SESSION['loyalty_points'] = $totalpoints;
	if (isset($_POST['code_promo'])) {
		$_SESSION['code_promo'] = $_POST['code_promo'];
	}
	$output .='</tbody>
	    					</table>
	  					</div>';
	$totalPrice =fixFloat($totalPrice);
	$promo_discount = 0;
	if (isset($_SESSION['code_promo'])) {
		$tmp = $hooks->select('cart_rule', array('*'), "WHERE code='". $_SESSION['code_promo'] ."' AND quantity != 0 AND minimum_amount <= ".$totalPrice);

		if (isset($tmp[0]['reduction'])) {
			$promo_discount = $tmp[0]['reduction'];
		};
	}
	$tht = fixFloat($totalPrice - $promo_discount);
	$output .=	'<div class="row">
				      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				      	<table id="summary_voucher">
				          <tbody>
				            <tr>
				              <td class="cart_voucher" id="cart_voucher">
				                <p class="title_voucher" id="title_voucher">'.l('Utiliser un code promotionnel','quotationfront').' :</p>
				                <form action="" id="voucher" class="searchbox" method="post" name="voucher">
				                  <p><label for="discount_name">'.l('Code promo','quotationfront').':</label></p>
				                  <div class="input-group">
				                    <input type="text" class="form-control" name="code_promo" value="'.htmlentities($_SESSION['code_promo']).'">
				                    <span class="input-group-btn">
				                      <input class="btn btn-default" type="submit" value="'.l('OK','quotationfront').'"/>
				                    </span>
				                  </div>
				                </form>
				              </td>
				            </tr>
				          </tbody>
				       	</table>
				      </div>
				      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					        <table class="table table-bordered borer0" id="summary_total">
					          <tbody>
					            <tr class="cart_total_price">
					              <td>
					              	<div class="form-group">
						              	<label class="control-label required">
												   		<span class="label-tooltip" data-html="true" data-original-title="'.l('Les tarifs export s’entendent toujours HT, les taxes se règlent dans le pays d’importation. Plus d’info sur : Transport & Taxes.','quotationfront').'" data-toggle="tooltip" title="">'.l('Total produits HT','quotationfront').' :</span>
												  	</label>
					             		</div>
					              </td>
					              <td class="price" id="total_product">'.$totalPrice.' €</td>
					            </tr>
					            <tr class="">
					              <td>'.l('Bon de réduction :','quotationfront').'</td>
					              <td class="" id="">'.htmlentities($_SESSION['code_promo']).'</td>
					            </tr> 
					            <tr class="">
					              <td>'.l('TOTAL HT','quotationfront').' :</td>
					              <td class="price" id="">'.$tht.' €</td>
					            </tr> 
					          </tbody>
					        </table>
					      </div>
					    </div>';

	$_SESSION['totalPrice'] = $totalPrice;
	if ($quotation_edit)
		$output .= 	'<form method="POST" action="'.WebSite.'account/quotation">';	    
  else
  	$output .= 	'<form method="POST" action="'.WebSite.'cart/adresse">';	  	
  //if ($totalpoints > 0) { }
  $loyalty_discount = $hooks->select_mete_value('loyalty_discount');
  $loyalty_discount = number_format($loyalty_discount * $totalpoints,'2','.','');
  	$output .= '<p style="text-align: right;"><small>'.l('En validant votre demande, vous pouvez collecter','quotationfront').' <b>'.$totalpoints.' '.l('points de fidélité','quotationfront').'</b> '.l('pouvant être transformé(s) en un bon de réduction de','quotationfront').' '.$loyalty_discount.' € '.l('sur votre prochaine commande. (offre non cumulable)','quotationfront').' .</small></p>';	
 
					    
  $output .= '<p style="text-align: right;">'.l('Les tarifs export s’entendent toujours HT, les taxes se règlent dans le pays d’importation. Plus d’info sur','quotationfront').' : <a target="_blanc" href="'.WebSite.'cms/51-Transport-and-taxes">'.l('Transport & Taxes','quotationfront').'</a>.</p>';	
	if ($totalPrice >=300) {
		if ($quotation_edit) {
			$output .=' <p class="cart_navigation">
	    	<input type="submit" name="quotation_edit" value="'.l('Valider la Modification','quotationfront').' »" class="exclusive  pull-right">
	    	<input type="hidden" name="idquotation"  value="'.$quotation_edit.'" />
	    	<a href="'.WebSite.'" name="" class="button_large pull-left">« '.l('Continuer mon devis','quotationfront').'</a>
	    </p>';
		}else{
			$output .=' <p class="cart_navigation">
	    	<input type="submit" name="Submitcart" value="'.l('suivant','quotationfront').' »" class="exclusive  pull-right">
	    	<a href="'.WebSite.'" name="" class="button_large pull-left">« '.l('Continuer mon devis','quotationfront').'</a>
	    </p>';
		}
		

	}	else{
		$output .=' <p class="cart_navigation">
					    	<a id="show_cart_popup" href="#cart_popup" class="exclusive pull-right">'.l('suivant','quotationfront').'</a>
					    	<a href="'.WebSite.'" name="" class="button_large pull-left">« '.l('Continuer mon devis','quotationfront').'</a>
					    </p>';
	}
	 

		/*$output .= '<div class="alert alert-warning" role="alert">Attention ! le minimum de commande est de 300€ pour pouvoir bénéficier de nos tarifs et offres promotionnelles.</div>';*/
		$output .= '<div style="display:none"><div style="margin-top: 15px;" class="alert alert-warning" role="alert" id="cart_popup">
								 '.l('Veuillez compléter votre commande afin d’atteindre le minimum de commande de','quotationfront').' 300€.<br><br>
								 <a href="'.WebSite.'"><u>'.l('Continuer mon devis','quotationfront').'.</u></a>
							 </div></div>';
	
	$output .= '</form>';
	}else{
		  '<div class="alert alert-warning" role="alert">'.l('Votre devis est vide','quotationfront').'.</div>';
	}
	
	echo $output;
}
add_hook('sec_cart', 'quotationfront', 'quotationfront_displaycart', 'quotation front display cart');

function quotationfront_displaypayment(){
	$quotation_edit = _GET('quotation_edit'); 
	if (!$quotation_edit) {
		return;
	}
	$output = "";
	global $hooks;
	/*if ($quotation_edit && !isset($_SESSION['payment_id_quotation'])) {
		$_SESSION['payment_id_quotation'] = $quotation_edit;	
	}*/

	if (isset($quotation_edit)) {

			$idquotation = $quotation_edit;
		  $quotation = $hooks->get_quotation($idquotation,$_SESSION['user']);
		  if ($quotation['status']['slug'] != 'quote_available') {
		  	return;
		  }
      $quotation_detail = $quotation['quotation'];
      
      $output .= '<table class="table table-account">
                    <thead>
                      <tr>
                        <th class="col-md-4">'.l('Date','quotationfront').'</th>
                        <th class="col-md-8">'.l('État','quotationfront').'</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>'.$quotation_detail['cdate'].'</td>
                        <td>'.$quotation['status']['name'].'</td>
                      </tr>
                    </tbody>
                  </table>';
            $output .='<div class="table-responsive">
                        <table class="table table-bordered borer0" id="summary">
                          <thead>
                            <tr>
                              <th class="product first_item"><b>'.l('Produit','quotationfront').'</b></th>
                              <th class="product first_item"><b>'.l('Référence','quotationfront').'</b></th>
                              <th class="description item"><b>'.l('Description','quotationfront').'</b></th>
                              <th class="item"><b>'.l('Prix unitaire','quotationfront').'</b></th>
                              <th width="100" class="quantity item"><b>'.l('Qté','quotationfront').'</b></th>
                              <th class="item"><b>'.l('Prix total','quotationfront').'</b></th>
                            </tr>
                          </thead>
                          <tbody>';
            if (isset($quotation['products'])) {
              foreach ($quotation['products'] as $key => $value) {
                $img = str_replace('.jpg', '-80x80.jpg', $value['product_image']);
                $img_src = WebSite.'files/products/'.$value['id_product'].'/'.$img;
                if(!url_exists($img_src)){
                   $img_src = WebSite.'/modules/quotationfront/assets/images/no-image-sm.jpg';
                }
                  
                $output .='<tr class="" id="" iddec="">
                          <td class="cart_product">
                            <a href="'.$img_src.'" class="pop" title="">
                              <img alt="" class="replace-2x" src="'.$img_src.'" style="height:100px;width:100px">
                            </a>
                          </td>
                          <td>'.$value['product_reference'].'</td>
                          <td class="cart_description">
                            <p class="product_name">
                              <a href="'.WebSite.'product/'.$value['id_product'].'" title="'.$value['product_name'].'">'.$value['product_name'].'</a>
                            </p>
                            <p class="">Colisage : </p>
                            <p class="">Poids (kg) :  '.$value['product_weight'].' du pack</p>
                            <p>'.$value['attributs'].'</p>
                          </td>
                          <td class="cart_price">'.$value['product_price'].'</td>
                          <td>'.$value['product_quantity'].'</td>
                          <td class="cart_price">'.$value['product_price'] * $value['product_quantity'].'</td>
                        </tr>';
                $product_name[$value['id_product']] = $value['product_name'] .' '.$value['attributs'];
              }   
            }
              
            

            $output .= '<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">              
                      <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span>
                          <span class="sr-only">Close</span>
                        </button>
                        <img src="" class="imagepreview" style="width: 100%;" >
                      </div>
                    </div>
                  </div>
                </div>';
            $output .='</tbody>
                </table>
              </div>';

          $output .=  '<div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <table class="table table-bordered borer0" id="summary_total">
                      <tbody>
                        <tr class="cart_total_price">
                          <td>'.l('Total produits HT','quotationfront').' :</td>
                          <td class="price" id="total_product"> '.$quotation['total']['tht'].' €</td>
                        </tr>
                        <tr class="">
                          <td>('.l('Remise globale','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Bon de réduction','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Avoir','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Code promo','quotationfront').') :</td>
                          <td class="" id="">'.$quotation['quotation']['voucher_code'].'</td>
                        </tr> 
                        <tr class="">
                          <td>'.l('Frais de transport','quotationfront').' :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>'.l('TOTAL HT','quotationfront').' :</td>
                          <td class="" id="">'.$quotation['total']['tht'].'</td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Acompte','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Solde','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>('.l('Total économisé','quotationfront').') :</td>
                          <td class="" id=""></td>
                        </tr> 
                      </tbody>
                    </table>
                  </div>
                </div>';

         $output .= '<div class="panel panel-default">
                          <div class="panel-body">
                            <p>
                            '.l('Devis valable jusqu’au','quotationfront').' : <b>'.$quotation['quotation']['expiration_date'].'</b>
                            </p><br>';
        $totalpoints = $quotation['quotation']['loyalty_points'];
        $loyalty_discount = $hooks->select_mete_value('loyalty_discount');
  			$loyalty_discount = number_format($loyalty_discount * $totalpoints,'2','.','');
  			$output .= '<p style="text-align: right;"><small>'.l('En validant votre demande, vous pouvez collecter','quotationfront').' <b>'.$totalpoints.' '.l('points de fidélité','quotationfront').'</b> '.l('pouvant être transformé(s) en un bon de réduction de','quotationfront').' '.$loyalty_discount.' € '.l('sur votre prochaine commande. (offre non cumulable)','quotationfront').' .</small></p>';	
            /*if ($quotation['quotation']['loyalty_points'] > 0) {
              $output .= 'En validant ce devis, vous obtiendrez  <b>'.$quotation['quotation']['loyalty_points'].' points de fidélité</b> pouvant 
                            être transformé(s) en un bon de réduction de X.XX € sur votre prochaine commande';
            }*/

          $output .='
                        </div>
                      </div>';
	}

	echo $output;
}
add_hook('sec_payment', 'quotationfront', 'quotationfront_displaypayment', 'quotation front display payment');

function quotationfront_displaycapture(){
	global $hooks;
	$error = false;
	if (isset($_POST['carrier_type'])) {
		$_SESSION['carrier_type'] = $_POST['carrier_type'];
	}

	if (!isset($_SESSION['Devis'])) {
		return;
	}
	$msg_submit = array();
	$output = "";
	
	/*if (isset($_FILES['filejoin']) && $_FILES['filejoin']['size']>0) {
		$allowed =  array('gif','png' ,'jpg','pdf','jpeg','docx','docx');
		$filename = $_FILES['filejoin']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
		  echo '<div class="alert alert-danger" role="alert">Le type de fichier joindre est incorrect, fichier acceptés : jpg, png,jpeg, doc, docx, pdf.</div>';
			$error = true;
		}
	}*/

	if (isset($_POST['SubmitQuotation']) && isset($_SESSION['user']) && !$error) {
		$ordermsg = $_POST['message'];
		$user = $_SESSION['user'];
		$msgObjet = l("message à propos de votre devis",'quotationfront');
		$voucher_code = "";
		if (isset($_SESSION['code_promo'])) {
			$voucher_code = $_SESSION['code_promo'];
		}
		$loyalty_points = 0;
		if (isset($_SESSION['loyalty_points'])) {
				$loyalty_points = $_SESSION['loyalty_points'];
		}

		
		if (isset($_SESSION['quotationedit']) && !empty($_SESSION['quotationedit'])){
			$res = editDevis(1,2,$user,$_SESSION['quotationedit'],$loyalty_points);
			
			if ($res &&  $loyalty_points> 0) {
				$Loyaltydata = array(	
					"points" => $loyalty_points
				);
				$condition = " WHER id_quotation = ".$_SESSION['quotationedit'];
				$hooks->update('`os-loyalty`',$Loyaltydata,$condition);
			}

			$msgObjet = l("Modification de devis");
		}else {
			$options = array(
								"id_state" => 1,
								"id_customer" => $user,
								"loyalty_points" => $loyalty_points,
								"is_packing" => 1,
								"address_invoice" => $_SESSION['invoice_address'],
								"address_delivery" => $_SESSION['shipping_address'],
								"voucher_code" => $voucher_code,
								"more_info" => $ordermsg,
								"carrier_type" => $_SESSION['carrier_type'],
								);
			$res = confirmDevis($options);
			if ($res &&  $loyalty_points> 0) {
				$Loyaltydata = array(	
					"id_loyalty_state" => 1,
					"id_customer" => $user,
					"id_quotation" => $res ,
					"points" => $loyalty_points
				);
				$hooks->save('`os-loyalty`',$Loyaltydata);
			}
			$msgObjet = l("Demander un devis",'quotationfront');
		}
		if ($res) {	
			unset($_SESSION['loyalty_points']);
			$resp = addDevisProduct($res,$_SESSION['Devis']);
			if (!$resp) {
				echo  '<div class="alert alert-info" role="alert">'.l('Produits Non enregistré','quotationfront').'. <a href="'.WebSite.'">'.l('Retour au site','quotationfront').'.</a></div>';
				return;
			}
			$attachement = "";
			if (isset($_FILES['filejoin']) && $_FILES['filejoin']['size']>0) {
				$allowed =  array('gif','png' ,'jpg','pdf','jpeg','docx','docx');
				$filename = $_FILES['filejoin']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed) ) {
					$uploaddir = ROOTPATH."files/quotatonattachments/$res/";
					if (!file_exists($uploaddir)) {
					    mkdir($uploaddir, 0777, true);
					}
					$uploadfile = $uploaddir . basename($_FILES['filejoin']['name']);
					if (move_uploaded_file($_FILES['filejoin']['tmp_name'], $uploadfile)) {
						$attachement = basename($_FILES['filejoin']['name']);
					}
				}
			}
			devisMessage($res,$msgObjet,$attachement,$user,1,$ordermsg);
			echo '<div class="box information_box">
			'.l('Nous vous remercions pour votre consultation','quotationfront').'. <br>
			'.l('Votre demande va être soigneusement étudiée et votre devis vous sera envoyé dans les plus brefs délais','quotationfront').' <br>('.l('max 48h ouvrées','quotationfront').').<br><br>
			'.l('Vous pouvez suivre votre devis pas à pas et nous contacter à tout moment depuis','quotationfront').' <a href="'.WebSite.'account/quotation"><u style="color:#a6754b;">'.l('votre compte','quotationfront').'</u></a>
			<br><br>
			<a href="'.WebSite.'"><u style="color:#a6754b;">'.l('Retour à l’accueil','quotationfront').'</u></a>
			</div>';
			return;
		}

	}
	
	/*products */

	$devis = getDevis();
	if(isset($devis['idProduit'])){
		$nbProduct = count($devis['idProduit']);
	}

	$totalPrice = 0;
	$totalpoints = 0;
	if (isset($nbProduct) &&  $nbProduct >0 ){
		$output .='<div class="table-responsive">
						    <table class="table table-bordered borer0" id="summary">
						      <thead>
						        <tr>
						          <th class="product first_item"><b>'.l('Produit','quotationfront').'</b></th>
						          <th class="description item"><b>'.l('Description','quotationfront').'</b></th>
						          <th class="item"><b>'.l('Prix unitaire','quotationfront').'</b></th>
						          <th width="100" class="quantity item"><b>'.l('Qté','quotationfront').'</b></th>
						          <th class="item"><b>'.l('Prix total','quotationfront').'</b></th>
						        </tr>
						      </thead>
						      <tbody>';
    for ($i=0; $i <$nbProduct ; $i++) { 
    	$product = getProductByid($devis['idProduit'][$i]);
  		if (!$product || empty($product)) {
  			continue;
  		}
  		$img = getThumbnail($product['id'],'200x200');
  		$product['short_description'] = substr(strip_tags($product['short_description']), 0,100).'...';
  		if ($devis['id_dec'][$i] != null){
    		$declinaison = getDeclinaisonByid($devis['id_dec'][$i]);
    		$product['reference'] = $declinaison['reference'];

	    	$img_id = explode(',', $declinaison['images']);
	    	$img_id =$img_id [0];
	    	$dec_img = getThumbnail($product['id'],'200x200',$img_id);
	    	if ($dec_img != null) {
	    		$img_id = $dec_img;
	    	}
    		if (isset($declinaison['cu'])) {
    			$p_attr_value = getCuString($declinaison['cu']);
    			if ($p_attr_value) {
    				$product['short_description'] = $p_attr_value;
    			}
    		}
    	}else{
    		$declinaison = null;
    	}
    if ($product['wholesale_per_qty'] > 0 && $product['wholesale_price'] > 0 && $devis['qteProduit'][$i] >= $product['wholesale_per_qty']) {
			$product['sell_price'] = $product['wholesale_price'];
		}

  		$totalPrice += ($product['sell_price'] * $devis['qteProduit'][$i]);
  		$totalpoints += ($product['loyalty_points'] * $devis['qteProduit'][$i]);
  		
  		
  		if($img) 
  			$img_src = WebSite.$img; 
  		else 
  			$img_src = WebSite.'/modules/quotationfront/assets/images/no-image-sm.jpg';

  		$product = fixOneProduct($product);
  		$output .='<tr class="" id="product_'.$product['id'].'" iddec="'.$declinaison['id'].'">
          <td class="cart_product">
            <a href="#" class="pop" title="'.$product['name'].'">
              <img alt="'.$product['name'].'" class="replace-2x" src="'.$img_src.'" style="height:100px;width:100px">
            </a>
          </td>
          <td class="cart_description">
            <p class="product_name">
              <a href="'.WebSite.'product/'.$product['id'].'-'.$product['permalink'].'" title="">'.$product['name'].'</a>
            </p>'./*$product['short_description']*/''.'
            <p class="bold">'.l('Référence','quotationfront').' : '.$product['reference'].'</p>
            <p class="">'.l('Colisage','quotationfront').' : </p>
            <p class="">'.l('Poids','quotationfront').' (kg) : '.$product['weight'].'  '.l('du pack','quotationfront').'</p>
            <p class="">'.l('prix du lot','quotationfront').' : '.number_format($product['wholesale_price'],'2','.','').' '.l('Par','quotationfront').' '.$product['wholesale_per_qty'].'  '.l('du pack','quotationfront').'</p>
            
          </td>
           <td class="cart_price">'.number_format($product['sell_price'],'2','.','').'</td>
          <td>'.$devis['qteProduit'][$i].'
          </td>
          <td class="cart_price">'.number_format($product['sell_price'],'2','.','')*$devis['qteProduit'][$i].'</td>
        </tr>';

    }
    $output .= '<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">              
								      <div class="modal-body">
								      	<button type="button" class="close" data-dismiss="modal">
								      		<span aria-hidden="true">&times;</span>
								      		<span class="sr-only">Close</span>
								      	</button>
								        <img src="" class="imagepreview" style="width: 100%;" >
								      </div>
								    </div>
								  </div>
								</div>';
						      	
  $_SESSION['loyalty_points'] = $totalpoints;
	$output .='</tbody>
	    					</table>
	  					</div>';
	$output .=	'<div class="row">
					      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					      </div>
					      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						        <table class="table table-bordered borer0" id="summary_total">
						          <tbody>
						            <tr class="cart_total_price">
						              <td>'.l('Total produits HT','quotationfront').' :</td>
						              <td class="price" id="total_product">'.$totalPrice.' €</td>
						            </tr>
						            <tr class="">
						              <td>('.l('Code promo','quotationfront').') :</td>
						              <td class="" id="">'.htmlentities($_SESSION['code_promo']).'</td>
						            </tr> 
						            <tr class="">
						              <td>'.l('Points de fidélité','quotationfront').' :</td>
						              <td class="" id="">'.$totalpoints.'</td>
						            </tr> 
						          </tbody>
						        </table>
						      </div>
						    </div>';
						    
	$_SESSION['totalPrice'] = $totalPrice;   
  
  $loyalty_discount = $hooks->select_mete_value('loyalty_discount');
	$loyalty_discount = number_format($loyalty_discount * $totalpoints,'2','.','');
	$output .= '<p style="text-align: right;"><small>'.l('En validant votre demande, vous pouvez collecter','quotationfront').' <b>'.$totalpoints.' '.l('points de fidélité','quotationfront').'</b> '.l('pouvant être transformé(s) en un bon de réduction de','quotationfront').' '.$loyalty_discount.' € '.l('sur votre prochaine commande. (offre non cumulable)','quotationfront').' .</small></p>';	
  //if ($totalpoints > 0) {}
  $output .= '<p style="text-align: right;">'.l('Les tarifs export s’entendent toujours HT, les taxes se règlent dans le pays d’importation. Plus d’info sur','quotationfront').' : <a href="'.WebSite.'cms/51-Transport-and-taxes" target="_blanc">'.l('Transport & Taxes','quotationfront').'</a>.</p>';	
}
	/* ./ end of product*/

	$output .= '<form method="POST" action=""  enctype="multipart/form-data" id="send_quotation_form">
								<div class="col-sm-12 padding0" id="">';











	if (isset($_SESSION['quotationedit'])) {
		$txt = l("Valider La modification du devis",'quotationfront');
	}
	else
		$txt = l("Envoyer ma demande de devis",'quotationfront');

	$output .=  '</div>
		  <div id="ordermsg">
		    <p class="txt">
		       '.l('Si vous voulez nous laisser un message à propos de votre devis, merci de bien vouloir le renseigner dans le champ ci-dessous.','quotationfront').'
		     </p>
		    <p class="textarea">
		      <textarea cols="60" id="message" name="message" rows="3" class="form-control"></textarea>
		    </p>
		  </div>
		  <div id ="filejoin">
			  <input type="file" name="filejoin" class="form-control"/>
		  </div>

		  

			<p class="cart_navigation checkbox">
			 	<input id="cgv_checkbox" type="checkbox"  name="confirm"/> 
			 	<label for="cgv_checkbox">'.l('J\'ai lu les conditions générales de vente et j\'y adhère sans réserve','quotationfront').'.</label>
			 	 (<a href="'.WebSite.'cms/53-conditions-Générales-de-Vente" target="_blanc">'.l('Lire les Conditions Générales de Vente','quotationfront').'</a>)<br><br>
			 	<div id="cgv_warning_msg" style="display:none" class="alert alert-warning" role="alert">'.l('Veuillez accepter nos Conditions Générales de Vente pour continuer','quotationfront').' </div>
			  <a class="button_large" href="'.WebSite.'cart/livraison" title="'.l('Précédent','quotationfront').'">« '.l('Précédent','quotationfront').'</a>
			  <input id="send_quotation" type="submit" name="SubmitQuotation" value="'.$txt.'" class="exclusive pull-right">
			</p>
		</form>';



	echo $output;
}
add_hook('sec_capture', 'quotationfront', 'quotationfront_displaycapture', 'quotation front display capture');


function quotationfront_displaycarrier(){
	global $hooks;
	if (isset($_POST['shipping_address'])) {
		$_SESSION['shipping_address'] = $_POST['shipping_address'];
	}
	if (isset($_POST['invoice_address'])) {
		$_SESSION['invoice_address'] = $_POST['invoice_address'];
	}

	$output = '';
	$carrierList = getcarrierList();
	if (!$carrierList) {
		return;
	}
	
	$carrierExpress = "";
	$carrierExpress_delay = "";
	$carrierEconomic = "";
	$carrierEconomic_delay = "";

	foreach ($carrierList as $key => $value) {
		if ($value['type'] == 'express') {

			$carrierExpress .= '<a class="carrier-pop" href="#" idcarrier="'.$value['id'].'">'.$value['name'].'</a><br>';
			if ($value['min_delay'] > 15) {
				$carrierExpress_delay .= floor($value['min_delay']/7).' '.l('à','quotationfront').' '.floor($value['max_delay']/7).' '.l('semaines','quotationfront').'<br>';
			}else
				$carrierExpress_delay .= $value['min_delay'].' '.l('à','quotationfront').' '.$value['max_delay'].' '.l('Jours','quotationfront').'<br>';
		}else if ($value['type'] == 'economic') {
			$carrierEconomic .= '<a class="carrier-pop" href="#" idcarrier="'.$value['id'].'">'.$value['name'].'</a><br>';
			if ($value['min_delay'] > 15) {
				$carrierEconomic_delay .= floor($value['min_delay']/7).' '.l('à','quotationfront').' '.floor($value['max_delay']/7).' '.l('semaines').'<br>';
			}else
				$carrierEconomic_delay .= $value['min_delay'].' '.l('à','quotationfront').' '.$value['max_delay'].' '.l('Jours','quotationfront').'<br>';
		}
	}
	if ($idquotation = _GET('quotation_edit')){
		$output .= '<form method="POST" action="'.WebSite.'account/quotation">';
	}else
		$output .= '<form method="POST" action="'.WebSite.'cart/capture">';
	
	$output .= '<div class="order_carrier_content">
				    <h3 class="carrier_title">'.l('Choisissez votre mode de livraison','quotationfront').'</h3>
				    <table class="std" id="carrierTable">
				      <thead>
				        <tr>
				          <th class="carrier_action first_item"></th>
				          <th class="carrier_action">'.l('Mode de livraison','quotationfront').'</th>
				          <th class="carrier_name item">'.l('Transporteur','quotationfront').'</th>
				          <th class="carrier_infos item">'.l('Délais de Transit','quotationfront').' <br><small>('.l('à compter de l’envoi','quotationfront').')</small></th>
				        </tr>
				      </thead>
				      <tbody>
				      <tr class="item first_item">
			          <td class="carrier_action">
			            <input  required class="delivery_radio" checked id="carrier_type" name="carrier_type" type="radio" value="economic">
			          </td>
			          <td class="carrier_name"><b>'.l('Economique','quotationfront').' <br>('.l('le moins cher','quotationfront').')</b></td>
			          <td class="carrier_list">'.$carrierEconomic.'</td>
			          <td class="carrier_infos">'.$carrierEconomic_delay.'</td>
		        	</tr>

							<tr class="item first_item">
			          <td class="carrier_action">
			            <input  required class="delivery_radio" id="carrier_type" name="carrier_type" type="radio" value="express">
			          </td>
			          <td class="carrier_name"><b>'.l('Express','quotationfront').' <br>('.l('le plus rapide','quotationfront').')</b></td>
			         <td class="carrier_list">'.$carrierExpress.'</td>
			          <td class="carrier_infos">'.$carrierExpress_delay.'</td>
			        </tr>';

	/*foreach ($carrierList as $key => $carrier) {

		$output .= '<tr class="item first_item">
			          <td class="carrier_action">
			            <input  required class="delivery_radio" id="id_carrier'.$carrier['id'].'" name="id_carrier" type="radio" value="'.$carrier['id'].'">
			          </td>
			          <td class="carrier_image"><img style="width: 48px;height: 48px;" src="'.WebSite.'files/carriers/'.$carrier['logo'].'" alt="'.$carrier['name'].'"/></td>
			          <td class="carrier_name"><label for="id_carrier">'.$carrier['name'].'</label></td>
			          <td class="carrier_infos"><b>Delay:</b> entre '.$carrier['min_delay'].' et '.$carrier['max_delay'].' Jour</td>
			        </tr>';
	}*/


	$output .=  '</tbody>
			    </table>
			</div>
			
		    <div class="box">
		    <h3 class="recyclable_title">'.l('Emballage recyclé','quotationfront').'</h3>
		      <p class="checkbox"><input  id="recyclable" name="recyclable" type="checkbox" value="1" checked> <label for="recyclable">'.l('J\'accepte de recevoir ma commande dans un emballage recyclé','quotationfront').'.</label></p>
		    </div>';
	$shipping_information_bloc = $hooks->select_mete_value('shipping_information_bloc');
	$output .=  ' <div class="box information_box">'.$shipping_information_bloc.'
	<p><br><br><a  target="_blanc" href="'.WebSite.'cms/51-Transport-and-taxes"><b><u class="grenat-color">'.l('+ d’informations sur le transport et les taxes','quotationfront').'</u></b> </a></p>
	<br><br>
	</div>';

	$output .=  '<p class="cart_navigation">';
		if ($idquotation) {
			$output .=  '<input type="hidden" name="idquotation"  value="'.$idquotation.'" />
									<input type="submit" name="Submitcarrier" value="'.l('Valider la modification','quotationfront').'" class="exclusive  pull-right">';
		}else{
			$output .=  '<a class="button_large" href="'.WebSite.'cart/adresse" title="'.l('Continuer mes achats','quotationfront').'">« '.l('Précédent','quotationfront').'</a>
				<input type="submit" name="Submitcarrier" value="'.l('Suivant','quotationfront').'" class="exclusive  pull-right">';
		}
			  
	$output .=  '</p></form>';
		
		$output .=	'<div class="modal fade" id="carriermodal" tabindex="-1" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">              
								      <div class="modal-body">
								      	<button type="button" class="close" data-dismiss="modal">
								      		<span aria-hidden="true">&times;</span>
								      		<span class="sr-only">Close</span>
								      	</button>
								        <div id="carrier_description"></div>
								      </div>
								    </div>
								  </div>
								</div>';
	
	echo $output;
} 
add_hook('sec_carrierfront', 'quotationfront', 'quotationfront_displaycarrier', 'quotation front display carrier');

function quotationfront_displayhistory(){
	global $hooks;
	if (isset($_POST['Submitaddress']) && isset($_POST['idquotation'])) {
		$options = array(
								"address_invoice" => $_POST['invoice_address'],
								"address_delivery" => $_POST['shipping_address'],
							);
		$condition = ' WHERE id = '.$_POST['idquotation'].' AND id_customer = '.$_SESSION['user'];
		$hooks->update('quotations',$options,$condition);
	}

	if (isset($_POST['Submitcarrier']) && isset($_POST['idquotation'])) {
		$options = array(
								"carrier_type" => $_POST['carrier_type']
							);
		$condition = ' WHERE id = '.$_POST['idquotation'].' AND id_customer = '.$_SESSION['user'];
		$hooks->update('quotations',$options,$condition);
	}

	if (isset($_SESSION['quotation_edit'])) {
      unset($_SESSION['quotation_edit']);
   }
	if (isset($_POST['quotation_edit']) && isset($_POST['idquotation']) && isset($_SESSION['Devis'])) {
		$condition = ' WHERE id_quotation = '.$_POST['idquotation'];
		$res =$hooks->delete('quotation_detail',$condition);
		$res = addDevisProduct($_POST['idquotation'],$_SESSION['devis']);
		changeDevisState(2,$_SESSION['user'],$_POST['idquotation']);
	}

	if (isset($_POST['prolongation']) && isset($_POST['idquotation'])) {
		$idquotation = $_POST['idquotation'];
		$res = devisMessage($idquotation,"","",$_SESSION['user'],1,l("demander une prolongation ou une réactualisation.",'quotationfront'));
		if($res && isset($_SESSION['user'])){
			changeDevisState(2,$_SESSION['user'],$idquotation);
		}
	}

	if (isset($_POST['quotation_rejet']) && isset($_POST['idquotation'])) {
		$idquotation = $_POST['idquotation'];
		$res = devisMessage($idquotation,"","",$_SESSION['user'],1,"rejeter un devis");
		changeDevisState(6,$_SESSION['user'],$idquotation);

	}
	$q_file = _GET('getquotationFile');
	$q_edit = _GET('idquotation');
		

	if ($q_file && !empty($q_file) && is_numeric($q_file)){
		getDevisFileById($q_file);
	}

	if ($q_edit && !empty($q_edit) && is_numeric($q_edit)){
		editDevisById($q_edit);
		return;
	}

	$output = "";
	if (!isset($_SESSION['user'])) {
		return;
	}
	$devis = getUserQuotation($_SESSION['user']);

	if (isset($_POST['send_message']) && isset($_POST['message']) && isset($_POST['idquotation'])) {
		$attachement = "";
		$message = $_POST['message'];
		$idquotation = $_POST['idquotation'];

		if (isset($_FILES['filejoin']) && $_FILES['filejoin']['size']>0) {
			$allowed =  array('gif','png' ,'jpg','pdf');
			$filename = $_FILES['filejoin']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed) ) {
		   	$uploaddir = ROOTPATH."files/quotatonattachments/$idquotation/";
				if (!file_exists($uploaddir)) {
				    mkdir($uploaddir, 0777, true);
				}
				$uploadfile = $uploaddir . basename($_FILES['filejoin']['name']);
				if (move_uploaded_file($_FILES['filejoin']['tmp_name'], $uploadfile)) {
					$attachement = basename($_FILES['filejoin']['name']);
				}
			}
		}
		devisMessage($idquotation,"",$attachement,$_SESSION['user'],1,$message);
	}
	//var_dump($devis);
	$output .='<style>
							.quotation-detail h3,.quotation-detail h4,.quotation-detail h5{color:#000;}
							.conversation-wrap{box-shadow:-2px 0 3px #ddd;padding:0;max-height:400px;overflow:auto}.conversation{padding:5px;border-bottom:1px solid #ddd;margin:0}.message-wrap{box-shadow:0 0 3px #ddd;padding:0}.msg{padding:5px;margin:0}.msg-wrap{padding:10px;max-height:400px;overflow:auto}.time{color:#bfbfbf}.send-wrap{border-top:1px solid #eee;border-bottom:1px solid #eee;padding:10px}.send-message{resize:none}.highlight{background-color:#f7f7f9;border:1px solid #e1e1e8}.send-message-btn{border-top-left-radius:0;border-top-right-radius:0;border-bottom-left-radius:0;border-bottom-right-radius:0}.btn-panel{background:#f7f7f9}.btn-panel .btn{transition:.2s all ease-in-out}.btn-panel .btn:hover{color:#666;background:#f8f8f8}.btn-panel .btn:active{background:#f8f8f8;box-shadow:0 0 1px #ddd}.btn-panel-conversation .btn,.btn-panel-msg .btn{background:#f8f8f8}.btn-panel-conversation .btn:first-child{border-right:1px solid #ddd}.msg-wrap .media-heading{color:#003bb3;font-weight:700}.msg-date{background:none;text-align:center;color:#aaa;border:none;box-shadow:none;border-bottom:1px solid #ddd}body::-webkit-scrollbar{width:12px}::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3)}::-webkit-scrollbar-thumb{background:#ddd;-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.5)}::-webkit-scrollbar-thumb:window-inactive{background:#ddd}
						</style>';
	$output .='<div class="block-center" id="block-history">
				<h1>'.l('Historique de votre devis','quotationfront').'Historique de votre devis</h1>
				<table id_customer="'.$_SESSION['user'].'" class="table table-account">
					<thead >
						<tr>
							<th class="col-md-2">'.l('Devis/Facture','quotationfront').'</th>
							<th class="col-md-2">'.l('Date','quotationfront').'</th>
							<th class="text-center col-md-1">'.l('Prix total','quotationfront').' (&euro;)</th>
							<th class="text-center col-md-1">'.l('Paiement','quotationfront').'</th>
							<th class="col-md-4">'.l('État','quotationfront').'</th>
							<th class="text-center col-md-3">'.l('Devis','quotationfront').'</th>
							<th class="text-center col-md-1">'.l('Facture','quotationfront').'</th>
						</tr>
					</thead>
					<tbody>';
	
	foreach ($devis as $key => $devi) {
		$price = '-';
		$invoice = "-";
		$payments  = "-";
		$num = l('Devis N°','quotationfront')."<br> DEV".sprintf("%06d", $devi['id']);
		$dt = new DateTime($devi['cdate']);
		$date = $dt->format('d/m/Y');
		$devis_detail = '-';
		global $hooks;
		if ($devi['status_slug'] == 'quote_creation') {
			if (!empty($devi['payment_choice'])) {
				$payments = getPaymentByIds($devi['payment_choice'],'<br>');
			}
			$devis_detail = '<a href="javascript:;" devisId="'.$devi['id'].'" class="detail-quotation">'.l('Détail','quotationfront').'</a>';
		}else if ($devi['status_slug'] == 'quote_study') {
			$devis_detail = '<a href="javascript:;" devisId="'.$devi['id'].'" class="detail-quotation">'.l('Détail','quotationfront').'</a>';
		}else if ($devi['status_slug'] == 'quote_available') {
			$quotation_detail = $hooks->get_quotation($devi['id'],$devi['id_customer']);
			$price = $quotation_detail['total']['ttc'];
			//var_dump($quotation_detail['total']);
			$devis_detail = '<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true" style="color: red;"></i><br>';
			$dt = new DateTime($devi['expiration_date']);
			$devi['expiration_date'] = $dt->format('d/m/Y');
			$devis_detail .= l('Valable jusqu\'au','quotationfront').' <br>'.$devi['expiration_date'];
			$devis_detail .= '<form action="" method="POST" id="quotation_action_form">
												<div class="form-group">
													<div class="">
												    <select name="quotation_action" class="form-control quotation_action" id_quotation="'.$devi['id'].'">
															<option value="download" selected="selected">'.l('Télécharger','quotationfront').'</option>
															<option value="pay">'.l('Valider et payer','quotationfront').'</option>
															<option value="details">'.l('Details','quotationfront').'</option>
															<option value="edit">'.l('Modifier','quotationfront').'</option>
												    </select>
												    <span class="input-group-btn">
												      <a devisid="'.$devi['id'].'" download href="'.WebSite.'pdf/quotation.php?id_quotation='.$devi['id'].'" class="btn btn-primary quotation_action_btn detail-quotation detail-quotation-skip" type="button"><i class="fa fa-send-o"></i> OK</a>
												    </span>
												  </div>
												</div>
												</form>';
			if (!empty($devi['payment_choice'])) {
				$payments = getPaymentByIds($devi['payment_choice'],'<br>');
			}
		}else if ($devi['status_slug'] == 'waiting_for_payment') {
			$devis_detail = '<a href="javascript:;" devisId="'.$devi['id'].'" class="detail-quotation">'.l('Détail','quotationfront').'</a>';
			if (!empty($devi['payment_choice'])) {
				$payments = getPaymentByIds($devi['payment_choice'],'<br>');
			}
		}else if ($devi['status_slug'] == 'order_registered') {
			$order = $hooks->select('orders', array('*'), "WHERE id_quotation=". $devi['id']);
			if (isset($order[0])) {
				$order = $order[0];
			}else continue;
			$order_detail =  $hooks->get_order($order['id'],$order['id_customer']);
			if (!isset($order_detail['order'])) continue;
			$num = l('Commande N°','quotationfront')."<br>".sprintf("%06d", $order_detail['order']['id']);
			$price = $order_detail['total']['ttc'];
			$dt = new DateTime($order_detail['order']['cdate']);
			$date = $dt->format('d/m/Y');
			$payments = $order['payment_method'];

			$invoice = $hooks->select('invoices', array('*'), "WHERE id_order=". $order_detail['order']['id']);
			if (isset($invoice[0])) {
				$invoice = $invoice[0];
			}else continue;
			
			$invoice = '<a download href="'.WebSite.'pdf/invoice.php?id_invoice='.$invoice['id'].'"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true" style="color: red;"></i></a>';
			
		}else if ($devi['status_slug'] == 'quote_rejected') {

		}else if ($devi['status_slug'] == 'quote_expired') {
			$devis_detail = '<a href="javascript:;" devisId="'.$devi['id'].'" class="detail-quotation">'.l('Détail','quotationfront').'</a>';
		}else if ($devi['status_slug'] == 'quote_canceled') {
			
		}
		$output .=  '<tr>
									<td>'.$num.'</td>
									<td>'.$date.'</td>
									<td class="text-center">'.$price.'</td>
									<td class="text-center">'.$payments.'</td>
									<td>'.$devi['status_name'].'</td>
									<td class="text-center">'.$devis_detail.'</td>
									<td class="text-center">'.$invoice.'</td>
								</tr>';
	}

	$output .= '</tbody>
				</table>
			</div>';

	$output .= '<div class="quotation-detail" id="quotation-detail" style="display:none;">
								<div class="panel panel-default">
								  <div class="">
								    <h1>'.l('Suivre votre Devis pas à pas','quotationfront').' :</h1>
								    <div id="quotation_detail_table"></div>
								  </div>
								</div>
							</div>';

	echo $output;
	?>
   <script src="<?= WebSite; ?>modules/quotationfront/assets/js/script.js"></script>
   <?php
}
add_hook('sec_history', 'quotationfront', 'quotationfront_displayhistory', 'quotation front display history');

function quotationfront_displayorderpage(){
	if (isset($_POST['quotation_confirm']) && isset($_POST['idquotation'])) {
		$_SESSION['idquotation'] = $_POST['idquotation'];
	}
	if (isset($_SESSION['idquotation'])) {
		$output .= "<h3>".l('Validation de Commande Num','quotationfront')." ".$_SESSION['idquotation']."</h3>";
	}
/*	$dataPayment = array(
			"f" => 1,
	);*/
	echo $output;
}
add_hook('sec_payment_top_list', 'quotationfront', 'quotationfront_displayorderpage', 'quotation front display order page');

function quotationfront_addlinks(){
	?>
	<script src="<?= WebSite; ?>modules/quotationfront/assets/js/quotation.js"></script>
	<?php
}
add_hook('sec_footer_link', 'quotationfront', 'quotationfront_addlinks','quotation front add links');


function front_quotationdetail(){
	echo "string";
}
/*function quotationfront_displayCategoryPage(){
	$output = "";
	$output .= '<div id="add_to_quoataion_form" style="display:none">hello dev!</div>';
	echo $output;
}
add_hook('sec_category_page','quotationfront_displayCategoryPage');*/