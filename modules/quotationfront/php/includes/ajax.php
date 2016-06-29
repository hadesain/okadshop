<?php 
require_once '../../../../config/bootstrap.php';
require_once 'function.php';
$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
	if(!in_array($action,array('getcarrier','updateQteProduct', 'deleteproduct','getquotation','getquotationmessage','addproducttoquotation','getLiteProductForm','getquotationhistory','sendquotationmessage')))
    $erreur=true;

   //récuperation des variables en POST ou GET
   $idquotation = (isset($_POST['idquotation'])? $_POST['idquotation']:  (isset($_GET['idquotation'])? $_GET['idquotation']:null )) ;
   $idproduct = (isset($_POST['idproduct'])? $_POST['idproduct']:  (isset($_GET['idproduct'])? $_GET['idproduct']:null )) ;
   $cu = (isset($_POST['cu'])? $_POST['cu']:  (isset($_GET['cu'])? $_GET['cu']:null )) ;
   $qty = (isset($_POST['qty'])? $_POST['qty']:  (isset($_GET['qty'])? $_GET['qty']:null )) ;
   $prix = (isset($_POST['prix'])? $_POST['prix']:  (isset($_GET['prix'])? $_GET['prix']:null )) ;
   $dec = (isset($_POST['dec'])? $_POST['dec']:  (isset($_GET['dec'])? $_GET['dec']:null )) ;
   $idcarrier = (isset($_POST['idcarrier'])? $_POST['idcarrier']:  (isset($_GET['idcarrier'])? $_GET['idcarrier']:null )) ;
   $object = (isset($_POST['object'])? $_POST['object']:  (isset($_GET['object'])? $_GET['object']:null )) ;
   $message = (isset($_POST['message'])? $_POST['message']:  (isset($_GET['message'])? $_GET['message']:null )) ;
   $rejected = (isset($_POST['rejected'])? $_POST['rejected']:  (isset($_GET['rejected'])? $_GET['rejected']:null )) ;
   
   if (!$erreur) {
   		switch ($action) {
   			case 'getquotation':
               if (isset($_SESSION['user']) && $idquotation != null) {
                  $res = getQuotationById($idquotation,$condition,$_SESSION['user']);

                  if ($res) {
                     echo json_encode($res);
                  } else echo 0;
               } else echo 0;
   				break;
        case 'getquotationmessage':
            if (isset($_SESSION['user']) && $idquotation != null) {
              $res = quotationMessage($idquotation,$_SESSION['user']);
              if ($res) {
                 echo json_encode($res);

              } else echo 0;
            } else echo 0;
           break;
        case 'sendquotationmessage':
          $return = array();
          if (isset($_SESSION['user']) && $idquotation != null) {
            $res = devisMessage($idquotation,$object,"",$_SESSION['user'],1,$message);
            if ($res) {
               if ($rejected == 1) {
                 changeDevisState(6,$_SESSION['user'],$idquotation);
               }
               $return['result'] = l('Message Envoyé','quotationfront');
              // echo 1;
            } else $return['error'] = l('Message Non Envoyé','quotationfront');
          } else $return['error'] = l('Message Non Envoyé','quotationfront');
          echo json_encode($return);
          break;  
        case 'getcarrier':
            if (isset($_SESSION['user']) && $idcarrier != null) {
              $options = array(
                          "c.id" => $idcarrier
                        ); 
              $res = getcarrierList($options);
              if ($res) {
                 echo json_encode($res);

              } else echo 0;
            } else echo 0;
           break;
        case 'addproducttoquotation':
           if (isset($_SESSION['user']) && $idproduct != null && $qty != null) {
              $id_dec = null;
              if ($cu != null && !empty($cu)) {
                global $hooks;
                $res0 = $hooks->select('declinaisons', array('*'), "WHERE cu= '$cu'" );
                if ($res0 && isset($res0[0]) && !empty($res0)) {
                  $res0 = $res0[0];
                  $id_dec = $res0['id'];
                }
              }

              $res = ajouterDevis($idproduct,$qty,$prix,$id_dec);
              if ($res) {
                 $return['ok'] = l('Le produit a bien été ajouté au devis','quotationfront');
                 $return['btn1'] = l('Continuer mon devis','quotationfront');
                 $return['btn2'] = l('Soumettre mon devis','quotationfront');
                 echo json_encode($return);
              } else echo 0;
            } else echo 0;
          break;
        case 'deleteproduct':
           if (isset($_SESSION['user']) && $idproduct != null) {
              $res = deleteProductFromDevis($idproduct,$dec);
              if ($res) {
                 echo 1;
              } else echo 0;
            } else echo 0;
          break;
         case 'updateQteProduct':
           if (isset($_SESSION['user']) && $idproduct != null && $qty != null) {
              $res = updateQteProduct($idproduct,$qty,$dec);
              if ($res) {
                 echo 1;
              } else echo 0;
            } else echo 0;
          break; 
        case 'getLiteProductForm':
           if ($idproduct != null) {
              $productdetail = getProductByid($idproduct);
              $product_images = getProductsImaesBySize($productdetail['id'],'360x360');
              $products_attributes_values = getProductDeclinaisons($productdetail['id']);
              $isConnected = isConnected();
              $output = "";
              $output .= '<h1>'.$productdetail['name'].'</h1>';
              $output .= '<div class="product-block">
                            <div class="row">
                              <div class="col-sm-12 col-md-5">
                                 <div id="carousel" class="carousel slide" data-ride="carousel">
                                   <div class="carousel-inner">';
              $cmpt = 0; 
              $thumbcarousel = array();
              $tmp = "";
              if (!empty($product_images)){
                 foreach ($product_images as $key => $value){
                    $cls = "";
                    $tmp .= '<div data-target="#carousel" data-slide-to="'.$cmpt.'" class="thumb"><img src="'.WebSite.$value.'"></div>';
                    if ($cmpt ==0) {
                      $cls =  'active';
                    }
                    if ($cmpt != 0 && (($cmpt+1) %4 == 0 || ($cmpt+1) == count($product_images))) {
                      $thumbcarousel[] = $tmp ;
                      $tmp ="";
                    }

                    $cmpt++;
                    $output .= '<div class="item '.$cls.'">
                      <a  class="product_image_galery" rel="group1" href="'.WebSite.$value.'">
                        <img src="'.WebSite.$value.'">
                      </a>
                    </div>';
                 }
              }else{
                $output .= '<li data-thumb="'.$themeDir.'images/no-image.jpg">
                            <img src="'.$themeDir.'images/no-image.jpg" />
                          </li>';
              }
              $output .= ' </div>
                          </div>
                          <div class="clearfix">';
              if ($thumbcarousel && !empty($thumbcarousel)){
                  $output .= '<div id="thumbcarousel" class="carousel slide" data-interval="false">
                                <div class="carousel-inner">';
                  $j = 0;
                  foreach ($thumbcarousel as $key => $tc) {
                    if ($j==0) {
                      $output .= ' <div class="item active">';
                    }else
                      $output .= ' <div class="item">';
                      $output .= $tc;
                      $output .= ' </div><!-- /item -->';
                      $j++;
                  }
                  $output .= '</div>
                                <!-- /carousel-inner -->
                                <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                             </div>';
              }
              $output .= '</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                          <div class="short_description_block">
                            <div id="short_description_content">';
             

              if (isset($productdetail['short_description']) && rtrim(strip_tags($productdetail['short_description'])) != ""){
                   $output .= htmlspecialchars_decode($productdetail['short_description']);
                }
              $output .= ' </div>
                        </div>
                        <div class="product_attributes">
                          <div class="row">
                            <div class="col-md-6">';

               if ($isConnected){
                  $output .= '<div class="attributes">';
                  if (isset($products_attributes_values) && $products_attributes_values && !empty($products_attributes_values)){
                    foreach ($products_attributes_values as $key => $att_val){
                    $output .= '<div class="form-group">
                       <label for="'.$att_val['attributes']['name'].'">'.$att_val['attributes']['name'].' :</label>
                        <select id="'.$att_val['attributes']['name'].'" attrId="'.$att_val['attributes']['id'].'">';
                          foreach ($att_val['attribute_values'] as $key => $value){
                            $output .= '<option title="'.$value['name'].'" value="'.$value['id'].'">'.$value['name'].'</option>';
                          }
                    $output .= '</select></div>';
                  }
                }
                $output .=  '</div>';
               }
               $output .=  '</div>
            <div class="col-md-6">';
              if ($isConnected){
              $output .=  '<div class="content_prices">
                <div class="product-price">
                  <p>'.number_format($productdetail['sell_price'], 2, '.', '').' €</p>
                </div>
                <div class="clearfix"></div>';
                if (!empty($productdetail['reference'])){
                   $output .=  '<p id="product_reference"> <label>'.l('Référence','quotationfront').' : </label> <span class="editable">'.$productdetail['reference'].'</span></p>';
               }
               
               $output .=  '<div>
                  <p><b>Poids:</b> '.$productdetail['weight'].'</p>';
                  if ($productdetail['wholesale_price'] >0){
                    $output .=  '<p><b>'.l('Prix du lot','quotationfront').' (HT):</b> '.$productdetail['wholesale_price'].' &euro;</p>';
                  }
                  
                $output .=  '</div>
              </div>';
              }
            $output .=  '</div>
          </div>
        </div>
        <div class="not_in_comm">
          <div class="alert alert-danger">
            '.l('Ce produit n\'existe pas dans cette déclinaison. <br> 
            Vous pouvez néanmoins en sélectionner une autre','quotationfront').'.
          </div>
        </div>
        
           <p class="align_justify" id="loyalty"> '.l('En achetant ce produit vous pouvez gagner jusqu\'à','quotationfront').' <b><span id="loyalty_points">'.$productdetail['loyalty_points'].'</span> '.l('points de fidélité','quotationfront').'</b>.</p>
        ';
        if ($isConnected) {
          if ($productdetail['min_quantity'] <= 0) {
            $productdetail['min_quantity'] = 1; 
          }
          $output .= '<form action="" method="POST"><p class="buttons_bottom_block" id="add_to_quotation"> 
                  <div class="form-group" id_product="'.$productdetail['id'].'">
                    <label for="quantité">'.l('Quantité','quotationfront').' : </label>
                    <input type="number" id ="qty" name="qty" value="'.$productdetail['min_quantity'].'" min="'.$productdetail['min_quantity'].'" >
                    <input type="hidden" name="cu" value="" id="cu" class="cu">
                    <input type="hidden" name="sell_price" value="'.$productdetail['sell_price'].'" id="sell_price" class="sell_price">
                    <input type="button" id="add_to_quoataion_btn_confirm" name="SubmitQuotation" value="'.l('Ajouter au devis','quotationfront').'" class="exclusive" style="margin-top: 7px;padding: 3px 9px;">
                  </div>
                </form>';
        } 


               $output .=  '</div>
            </div>
          </div>';

              $output .= '';
              echo $output;
           }
          break;
        case 'getquotationhistory':
          if (isset($_SESSION['user']) && $idquotation != null) {
            $output = "";
            $condition = "";
            $date_expiration = l('en étude','quotationfront');
            global $hooks;
            $quotation = $hooks->get_quotation($idquotation,$_SESSION['user']);
            $quotation_statu = $quotation['status'];
            $quotation_detail = $quotation['quotation'];
            $quotation_statu_string = $quotation['status']['name'];
            $product_name = array();
            //$quotation_carrier = "en étude";
            if (!empty($quotation['carrier']['carrier_name']))
               $quotation_carrier = $quotation['carrier']['carrier_name'];
            else
              $quotation_carrier = l("en étude",'quotationfront');
            $min_delay = $quotation['carrier']['min_delay'];
            $max_delay = $quotation['carrier']['max_delay'];

            if ($min_delay >0 && $max_delay >0){
              if ($min_delay > 15) {
                $quotation_carrier_delay = floor($min_delay/7).' '.l('à','quotationfront').' '.floor($max_delay/7).' '.l('semaines','quotationfront').'<br>';
              }else
                $carrierExpress_delay .= $min_delay.' '.l('à','quotationfront').' '.$max_delay.' '.l('Jours','quotationfront').'<br>';
            }
            else
              $quotation_carrier_delay = l('en étude','quotationfront');
            $quotation_carrier_type = '';
            $quotation_carrier_type_name = '';
            
            $quotation_adresse_edit = '';
            $is_available = false;
            if ($quotation['quotation']['carrier_type'] == 'economic')
              $quotation_carrier_type_name = l('Economique','quotationfront');
            else if($quotation['quotation']['carrier_type'] == 'express') 
              $quotation_carrier_type_name = l('Express','quotationfront');

            $quotation_edit = '?quotation_edit='.$idquotation;
            if (isset($quotation_statu['slug'])) {
              switch ($quotation_statu['slug']) {
                case 'quote_available':
                  $quotation_statu_string .= '<br><br>';
                  $quotation_statu_string .= '<ul class="list-group">
                                                <li class=""><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;"></i><a download href="'.WebSite.'pdf/quotation.php?id_quotation='.$idquotation.'"> '.l('Télécharger','quotationfront').'</a></li>
                                                <li class=""><i class="fa fa-check" aria-hidden="true"></i><a href="'.WebSite.'cart/paiement'.$quotation_edit.'"> '.l('Accepter le devis','quotationfront').'</a></li>
                                                <li class=""><i style="color: #249EDA;" class="fa fa-refresh" aria-hidden="true"></i><a href="'.WebSite.'cart'.$quotation_edit.'"> '.l('Modifier le devis','quotationfront').'</a></li>
                                                <li class=""><i style="color: red;" class="fa fa-times-circle" aria-hidden="true"></i><a href="javascript:;" class="pop_quote_rejected"> '.l('Refuser le devis','quotationfront').'</a></li>
                                                <li class=""><i style="color: #EA963D;" class="fa fa-envelope-o" aria-hidden="true"></i><a href="#" class="pop_quote_contact"> '.l('Nous contacter','quotationfront').'</a></li>
                                              </ul>';
                  $dt = new DateTime($quotation['quotation']['expiration_date']);
                  $date = $dt->format('d/m/Y');
                  $date_expiration = $date;   
                  $quotation_carrier_type = '<a href="'.WebSite.'cart/livraison'.$quotation_edit.'"> <u class="grenat-color">'.l('Modifier','quotationfront').'</u></a>';
                  $quotation_adresse_edit ='<a href="'.WebSite.'cart/adresse'.$quotation_edit.'">  <u class="grenat-color">'.l('Modifier l’adresse','quotationfront').'</u></a>';
                  $is_available = trur;
                  break; 
                case 'quote_study':
                  $date_expiration = l("en étude",'quotationfront');
                  $quotation_carrier = l("en étude",'quotationfront');
                  $quotation_carrier_delay =  l("en étude",'quotationfront');
                  break;
                case 'quote_expired':
                  $date_expiration = '<a href="#">'.l('Renouveller','quotationfront').'</a>';
                   $quotation_carrier_delay =  l("en étude",'quotationfront');
                  break;
                case 'quote_creation':
                  $quotation_carrier = l("en étude",'quotationfront');
                  $quotation_carrier_delay =  l("en étude",'quotationfront');
                  break;
                default:
                  # code...
                  break;
              }
            }
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
                              <td>'.$quotation_statu_string.'</td>
                            </tr>
                          </tbody
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
                            <p class="">'.l('Colisage','quotationfront').' : </p>
                            <p class="">'.l('Poids','quotationfront').' (kg) :  '.$value['product_weight'].' '.l('du pack','quotationfront').'</p>
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

            //total
            $global_discount = number_format((float)$quotation['quotation']['global_discount'], 2, '.', ''); 
            $voucher_value = number_format((float)$quotation['quotation']['voucher_value'], 2, '.', ''); 
            $shipping_costs = $quotation['carrier']['shipping_costs'];
            $voucher_code = $quotation['quotation']['voucher_code'];
            $avoir = number_format((float)$quotation['quotation']['avoir'], 2, '.', '');
            $global_weight  = floatval($quotation['total']['weight']);
            
            $output .=  '<div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <table class="table table-bordered borer0" id="summary_total">
                      <tbody>
                        <tr class="cart_total_price">
                          <td>'.l('Total produits HT','quotationfront').' :</td>
                          <td class="price" id="total_product"> '.$quotation['total']['product_tht'].' €</td>
                        </tr>';
                        if( $global_discount > 0 ){
                          $output .=  '<tr class="">
                                        <td>'.l('Remise globale','quotationfront').' :</td>
                                        <td class="" id="">'.$global_discount.'</td>
                                      </tr>';
                        }
                        if( $voucher_value > 0 ){
                          $output .=  '<tr class="">
                                        <td>'.l('Bon de réduction','quotationfront').' :</td>
                                        <td class="" id="">'.$voucher_value.'</td>
                                      </tr>';
                        }

                        if( $avoir > 0 ){
                          $output .=  '<tr class="">
                                        <td>'.l('Avoir','quotationfront').' :</td>
                                        <td class="" id="">'.$avoir.'</td>
                                      </tr>';
                        }
                        
                        if( $voucher_code !="" ){
                          $output .=  '<tr class="">
                                        <td>'.l('Code promo','quotationfront').' :</td>
                                        <td class="" id="">'.$voucher_code.'</td>
                                      </tr>';
                        }

            $output .=  '
                        <tr class="">
                          <td>'.l('Frais de transport','quotationfront').' :</td>
                          <td class="" id="">'.$shipping_costs.'</td>
                        </tr> 
                        <tr class="">
                          <td>'.l('TOTAL HT','quotationfront').' :</td>
                          <td class="" id="">'.$quotation['total']['tht'].'</td>
                        </tr>

                        ';

                         /* '
                         <tr class="">
                         <td>(Acompte) :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>(Solde) :</td>
                          <td class="" id=""></td>
                        </tr> 
                        <tr class="">
                          <td>(Total économisé) :</td>
                          <td class="" id=""></td>
                        </tr>';*/

              $output .=  '
                        <tr class="">
                          <td>'.l('Poids total','quotationfront').' :</td>
                          <td class="" id="">'.$global_weight.'</td>
                        </tr>
                        </tbody>
                    </table>
                  </div>
                </div>';

            $output .= '<div class="panel panel-default">
                          <div class="panel-body">
                            <p>
                            '.l('Devis valable jusqu’au','quotationfront').' : <b>'.$date_expiration.'</b>
                            </p>
                            <br>';
           
              /*$output .= '<p>En validant ce devis, vous obtiendrez  <b>'.$quotation['quotation']['loyalty_points'].' points de fidélité</b> pouvant 
                            être transformé(s) en un bon de réduction de X.XX € sur votre prochaine commande </p>';*/
            $totalpoints = $quotation['quotation']['loyalty_points'];
            $loyalty_discount = $hooks->select_mete_value('loyalty_discount');
            $loyalty_discount = number_format($loyalty_discount * $totalpoints,'2','.','');
              $output .= '<p style="text-align: right;"><small>'.l('En validant votre demande, vous pouvez collecter','quotationfront').' <b>'.$totalpoints.' '.l('points de fidélité','quotationfront').'</b> '.l('pouvant être transformé(s) en un bon de réduction de','quotationfront').' '.$loyalty_discount.' € '.l('sur votre prochaine commande. (offre non cumulable)','quotationfront').' .</small></p>'; 
 
             //if ($quotation['quotation']['loyalty_points'] > 0) {}
            $payments = l("en étude",'quotationfront');
            if (!empty($quotation['quotation']['payment_choice'])) {
              $payments = getPaymentByIds($quotation['quotation']['payment_choice'],', ');
            }
            $product_list = "";
            foreach ($product_name as $key => $option_value) {
              $product_list .= '<option selected="selected" value="'.$option_value.'">'.$option_value.'</option>';
            }
           // var_dump($quotation['carrier']);

            $output .='
                        </div>
                      </div>';
             if ($is_available) {
                $output .='<h1 class="text-center"><a href="'.WebSite.'cart/paiement'.$quotation_edit.'">'.l('J’accepte ce devis et je procède au paiement','quotationfront').'</a></h1>';
            }
            $output .='<div class="panel panel-default">
                          <div class="panel-body">
                           <h1>'.l('Règlement','quotationfront').'</h1>
                <p>
                  <b>'.l('Modes de règlement acceptés','quotationfront').' :</b>'.$payments.'<br>
                  <b>'.l('Modalités de règlement','quotationfront').' :</b> '.l('en étude','quotationfront').'<br><br>
                  <a 
                  onclick="javascript:window.open(\''.WebSite.'cms/55-Paiement\',\'mywindowtitle\',\'width=1000,height=500\')" 
                  target="popup" href="'.WebSite.'cms/55-Paiement"><b><u class="grenat-color">'.l('+ d’informations sur le règlement','quotationfront').'</u></b></a>
                </p>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
              <h1>'.l('Livraison','quotationfront').'</h1>
              <p>
                <b>'.l('Poids total estimé (hors emballage)','quotationfront').' :</b>'.$quotation['total']['weight'].' KG<br>
                '.l('Vous avez accepté de recevoir votre commande dans un emballage recyclé','quotationfront').'<br><br>

                <b>'.l('Mode de transport','quotationfront').' :</b>'.$quotation_carrier_type_name.' '.$quotation_carrier_type.' <br>
                <b>'.l('Transporteur','quotationfront').'  :</b>'.$quotation_carrier.'<br> 
                 <b>'.l('Délais de livraison','quotationfront').' :</b> '.$quotation_carrier_delay .' <br><br> 
                 <a 
                onclick="javascript:window.open(\''.WebSite.'cms/55-Paiement\',\'mywindowtitle\',\'width=1000,height=500\')" 
                target="popup" href="'.WebSite.'cms/51-Transport"><b><u class="grenat-color">'.l('+ d’informations sur le transport et les taxes.','quotationfront').'</u> </b></a>
              </p>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
              <h1>'.l('Adresses','quotationfront').'</h1>
              <h3>'.l('Facturation','quotationfront').'</h3>
              <p>
              '.stripslashes($quotation['quotation']['address_invoice']).'<br>
              '.$quotation_adresse_edit.'
              </p>
              <br> <br> <br>
              <h3>'.l('Livraison','quotationfront').'</h3>
              <p>
              '.stripslashes($quotation['quotation']['address_delivery']).'<br>
              '.$quotation_adresse_edit.'
              </p>
               </div>
              </div>
              <div class="panel panel-default">
              <div class="panel-body">
             <h1>'.l('Une question, une demande ?','quotationfront').'</h1>
             <form>
              <div class="form-group">
                <label for="Produit">'.l('Produit','quotationfront').'</label>
                <select class="form-control">
                  '.$product_list.'
                </select>
                <textarea class="form-control" name="textarea" rows="5" required></textarea>
              </div>
              <p class="submit-btn">
                <button id_alert="quotation_message_alert" type="button" class="btn btn-sm btn-default send_quotation_message" id="" idquotation="'.$quotation['quotation']['id'].'">'.l('Envoyer','quotationfront').'</button>
              </p> 
               </div>
              </div> 
            </form>
            <div class="alert alert-info quotation_message_alert" style="display:none;"></div>';
            
            if ($is_available) {

              $output .= '<div class="panel panel-default">
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-xs-12 col-md-4">
                                  <h1 class="text-center"><a href="#" class="pop_quote_rejected">'.l('Je refuse ce devis','quotationfront').'</a></h1>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                  <h1 class="text-center"><a href="'.WebSite.'cart'.$quotation_edit.'">'.l('Je souhaite modifier mon devis','quotationfront').'</a></h1>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                  <h1 class="text-center"><a href="'.WebSite.'cart/paiement'.$quotation_edit.'">'.l('J’accepte ce devis et je procède au paiement','quotationfront').'</a></h1>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                        <div class="modal fade" id="message_bloc" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">              
                              <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">
                                  <span aria-hidden="true">&times;</span>
                                  <span class="sr-only">Close</span>
                                </button>
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    '.l('Nous sommes déçus que vous ne donniez pas suite à votre commande','quotationfront').',<br>
                                    '.l('expliquez en nous la raison, nous pourrons certainement vous satisfaire.','quotationfront').'
                                    <form>
                                      <div class="form-group">
                                        <textarea class="form-control" name="textarea" rows="5"></textarea>
                                      </div>
                                      <p class="submit-btn">
                                        <button rejected="1" id_alert="quotation_message_alert2" type="button" class="btn btn-sm btn-default send_quotation_message" id="" idquotation="'.$quotation['quotation']['id'].'">'.l('Envoyer','quotationfront').'</button>
                                      </p>  
                                    </form>
                                    <div class="alert alert-info quotation_message_alert2" style="display:none;"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        ';


              $output  .= '<div class="modal fade" id="message_bloc3" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">              
                              <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">
                                  <span aria-hidden="true">&times;</span>
                                  <span class="sr-only">Close</span>
                                </button>
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    Nous contacter
                                    <form>
                                      <div class="form-group">
                                        <textarea class="form-control" name="textarea" rows="5"></textarea>
                                      </div>
                                      <p class="submit-btn">
                                        <button id_alert="quotation_message_alert3" type="button" class="btn btn-sm btn-default send_quotation_message" id="" idquotation="'.$quotation['quotation']['id'].'">'.l('Envoyer','quotationfront').'</button>
                                      </p>  
                                    </form>
                                    <div class="alert alert-info quotation_message_alert3" style="display:none;"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>';          


            }
            


            echo $output;
          } else echo 0;
          break;
   			default:
   				echo 0;
   				break;
   		}
   }

}
?>
