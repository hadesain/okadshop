<?php 

function creationDevis(){
   if (!isset($_SESSION['Devis'])){
      $_SESSION['Devis'] = array();
      $_SESSION['Devis']['idProduit'] = array();
      $_SESSION['Devis']['qteProduit'] = array();
      $_SESSION['Devis']['prixProduit'] = array();
      $_SESSION['Devis']['id_dec'] = array();
   }
   return true;
}


/*function os_totalpanel(){
  $total  = 0;
  if (creationDevis())
  {
    for($i = 0; $i < count($_SESSION['Devis']['idProduit']); $i++)
    {
      //$total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
      $product = ProductByid($_SESSION['Devis']['idProduit'][$i]);
      if ($product) {
        $prix = $product['price'];
        if ($_SESSION['Devis']['qteProduit'][$i] >= $product['wholesale_per_qty']) {
          $prix = $product['wholesale_price'];
        }
        if($_SESSION['Devis']['id_dec'][$i] != null){
          $declinaison = getDeclinaisonByid($_SESSION['Devis']['id_dec'][$i]);
         
          $prix =  $declinaison['sell_price'];
          if ($declinaison['price_impact'] == 1) {
            $prix += $declinaison['price'];
          }else if ($product['price_impact'] == 2) {
            $prix -= $declinaison['price'];
          }
        }
        $total += $prix;
      }
    }
  }
}*/

function DevisMontantGlobal(){
   $total=0;
   //var_dump($_SESSION['Devis']['prixProduit']);
   for($i = 0; $i < count($_SESSION['Devis']['idProduit']); $i++)
   {
      $total += $_SESSION['Devis']['qteProduit'][$i] * $_SESSION['Devis']['prixProduit'][$i];
   }
   return $total;
}





function ajouterDevis($idProduit,$qteProduit,$prixProduit,$id_dec = null){
  $isNewDec = false;
   //Si le panier existe
   if (creationDevis())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($idProduit,  $_SESSION['Devis']['idProduit']);
      if ($positionProduit !== false && $id_dec != null) {
          $positionDec = array_search($id_dec,  $_SESSION['Devis']['id_dec']);
          if ($positionDec !== false) {
            $positionProduit = $positionDec;
          }else{
            $isNewDec = true;
          }
      }
      if ($positionProduit !== false && !$isNewDec)
      {
        $_SESSION['Devis']['qteProduit'][$positionProduit] += $qteProduit ;
        return true;
      }
      else
      {
        //Sinon on ajoute le produit
        array_push( $_SESSION['Devis']['idProduit'],$idProduit);
        array_push( $_SESSION['Devis']['qteProduit'],$qteProduit);
        array_push( $_SESSION['Devis']['prixProduit'],$prixProduit);
        array_push( $_SESSION['Devis']['id_dec'],$id_dec);
         return true;
      }
   }
   else
   return false;
}
function supprimeDevis(){
   unset($_SESSION['Devis']);
}


function getDevis(){
   if (creationDevis())
   {
      return $_SESSION['Devis'];
   }
   else 
    return false;
}

function deletFromTable($table,$condition){
  global $DB;
  try {
    $sql = "DELETE FROM "._DB_PREFIX_."$table WHERE $condition";
    $DB->query($sql);
    return true;
  } catch (Exception $e) {
    return false;
  }
}
function editDevis($methode_payment,$id_state,$id_customer,$idquotation,$points_de_fidelite,$recyclable = 0){
  global $DB;
  try {
    $sql = "UPDATE `"._DB_PREFIX_."quotations` SET `id_payment_method` = $methode_payment , `id_state`  = $id_state,  `loyalty_points` = $points_de_fidelite,  `is_packing` = $recyclable,  `udate` = now()
            WHERE  `id_customer` = $id_customer AND id = $idquotation";
     if($DB->query($sql)){
        $condition = " id_quotation = $idquotation";
        if (deletFromTable('quotation_detail',$condition) && deletFromTable('quotation_carrier',$condition)) {
          return $idquotation;
        };
     }
  } catch (Exception $e) {
    return false;
  }
  
   return false;
}

function changeDevisState($id_state,$id_customer,$idquotation){
  global $DB;
  try {
    $sql = "UPDATE `"._DB_PREFIX_."quotations` SET `id_state`  = $id_state,  `udate` = now()
            WHERE  `id_customer` = $id_customer AND id = $idquotation";
    if($DB->query($sql)){
      return true;
    }
  } catch (Exception $e) {
    return false;
  }
   return false;
}

function getPaymentMethod($id){
  global $DB;
   try {
      $sql = "SELECT * FROM "._DB_PREFIX_."payment_methodes WHERE id = $id";
      $res = $DB->query($sql);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res;
   } catch (Exception $e) {
      return false;
   }
}

function getCurrentState($id){
  global $DB;
   try {
      $sql = "SELECT * FROM "._DB_PREFIX_."quotation_status WHERE id = $id";
      $res = $DB->query($sql);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res;
   } catch (Exception $e) {
      return false;
   }
}

function confirmDevis($options){
  global $DB;
  $os_orders = new os_orders();
  $reference = $os_orders->get_reference_number('quotations');
 
  $options['address_invoice'] = addslashes($options['address_invoice']);
  $options['address_delivery'] = addslashes($options['address_delivery']);
  $options['more_info'] = addslashes($options['more_info']);

  $sql = "INSERT INTO `"._DB_PREFIX_."quotations` ( `id_state`, `id_customer`, loyalty_points  , reference, is_packing,address_invoice,address_delivery,voucher_code,more_info,carrier_type,`cdate`) VALUES 
            (".$options['id_state'].",".$options['id_customer'].",".$options['loyalty_points'].", '$reference' ,'".$options['is_packing']."' ,'".$options['address_invoice']."','".$options['address_delivery']."','".$options['voucher_code']."','".$options['more_info']."','".$options['carrier_type']."',now())";
           // echo $sql;
 if($DB->query($sql)){
    $id_devis = $DB->lastInsertId();
    return $id_devis;
 }
  return false;
}

function saveLoyalty($data){
  try {
    global $DB;
    $query = "INSERT INTO `"._DB_PREFIX_."loyalty` (`id_loyalty_state`,`id_customer`, `id_quotation`, `points`, `cdate`) VALUES (".$data['id_loyalty_state'].",".$data['id_customer'].",".$data['id_quotation'].",".$data['points'].",now())";
    $DB->query($query);
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function updateLoyalty($data,$condition){
  try {
    global $DB;
    $fields_list = " ";

    foreach ($data as $key => $value) {
      $fields_list .= $key .' = '.  $value.',';
    }
    $fields_list = rtrim($fields_list,',');
    $query = "UPDATE `"._DB_PREFIX_."loyalty` SET $fields_list WHERE $condition";
    $DB->query($query);
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function ProductByid($id){
   global $DB;
   try {
      $sql = "SELECT * FROM "._DB_PREFIX_."products WHERE id = $id";
      $res = $DB->query($sql);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res;
   } catch (Exception $e) {
      return false;
   }
}

function addDevisProduct($id_quotation,$sessionProducts){
   global $DB;   
   $nb_product = count($_SESSION['Devis']['idProduit']);
   if ($nb_product>0) {
      $query = "INSERT INTO `"._DB_PREFIX_."quotation_detail`(`id_product`, `product_quantity`,`id_quotation`,`product_name`, `product_image`,`product_reference`,`cdate` ,`product_price` ,`id_declinaisons` ,`attributs`,  `product_weight`,`product_height`,`product_width`,`product_depth`,`product_stock`,`product_min_quantity` ,`product_packing` ,`product_buyprice` ,`product_discount` ) VALUES ";
      for($i = 0; $i < $nb_product; $i++)
      {
         $product = ProductByid($_SESSION['Devis']['idProduit'][$i]);
         $product['name'] = addslashes($product['name']);
         $product['reference'] = addslashes($product['reference']);
         $product_image = getProductImage($_SESSION['Devis']['idProduit'][$i]);
         $attributs = "";
         if (!$product_image)
           $product_image = "";

        if ($_SESSION['Devis']['id_dec'][$i] != null) {
            $declinaison = getDeclinaisonByid($_SESSION['Devis']['id_dec'][$i]);
            $product['reference'] = $declinaison['reference'];
            
            if (isset($declinaison['cu'])) {
              $p_attr_value = getCuString($declinaison['cu']);
              if ($p_attr_value) {
                $attributs = addslashes($p_attr_value);
              }
            }
        }
        if ($product['wholesale_per_qty'] > 0 && $product['wholesale_price'] > 0 && $devis['qteProduit'][$i] >= $product['wholesale_per_qty']) {
            $product['sell_price'] = $product['wholesale_price'];
          }
         $query .= " (".$_SESSION['Devis']['idProduit'][$i].",".$_SESSION['Devis']['qteProduit'][$i].",$id_quotation,'".$product['name']."','".$product_image."', '".$product['reference']."',now() ,".$product['sell_price'].",'".$_SESSION['Devis']['id_dec'][$i]."' ,'$attributs' , ".$product['weight'].", ".$product['height'].", ".$product['width'].", ".$product['depth'].", ".$product['qty'].", ".$product['min_quantity'].", ".$product['packing_price'].", ".$product['buy_price'].", ".$product['discount']." ),";
      }
     // echo $query;
      $query = rtrim($query, ",");
      try {
         $DB->query($query);
         unset($_SESSION['Devis']);
         if (isset($_SESSION['quotationedit'])) {
            unset($_SESSION['quotationedit']);
         }
         if (isset($_SESSION['quotation_edit'])) {
            unset($_SESSION['quotation_edit']);
         }
         return true;
      }catch (Exception $e) {
        //echo $e;
         return false;
      }
   }
   return false;
}

function getFullAdresse($id){
   global $DB; 
   try {
      $query = "SELECT   CONCAT(a.`firstname` ,'  ', a.`lastname` ,' \n ',  a.`addresse` ,'  ',  a.`city` ,'  ', a.`codepostal`,' \n ' , c.name  ) as fulladresse FROM `"._DB_PREFIX_."addresses` a, "._DB_PREFIX_."countries c WHERE a.`id_country` = c.id AND a.`id` = $id";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res['fulladresse'];
   }catch (Exception $e) {
      return false;
   }
}

function getUserFullAdresse($iduser){
   global $DB; 
   try {
      $query = "SELECT   CONCAT(a.`addresse` ,'  ',  a.`city` ,'  ', a.`codepostal`,' \n ' , c.name  ) as fulladresse FROM `"._DB_PREFIX_."addresses` a, "._DB_PREFIX_."countries c WHERE a.`id_country` = c.id AND a.`id_user` = $iduser";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res['fulladresse'];
   }catch (Exception $e) {
      return false;
   }
}

function getcarrierList($options = null){
   global $DB; 
   try {
    $condition = "";
    if ($options && !empty($options)) {
      $condition = " WHERE 1 = 1 ";
      foreach ($options as $key => $value) {
        $condition .= " AND $key = '$value'";
      }
    }
    $query = "SELECT c.*,t.name as taxname, t.rate as taxrate FROM `"._DB_PREFIX_."carrier` c LEFT JOIN "._DB_PREFIX_."taxes t ON  c.id_tax = t.id  $condition";
    $res = $DB->query($query);
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    return $res;
   }catch (Exception $e) {
      return false;
   }
}
function getPaymentList(){
   global $DB; 
   try {
      $query = "SELECT * FROM `"._DB_PREFIX_."payment_methodes`";
      $res = $DB->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
   }catch (Exception $e) {
      return false;
   }
}

function getCarrier($id){
  global $DB;
  try {
      $query = "SELECT c.*,t.rate FROM `"._DB_PREFIX_."carrier` c, "._DB_PREFIX_."taxes t WHERE c.id_tax = t.id AND c.`id` = $id";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res;
  }catch (Exception $e) {
      return false;
  }
}

function devisshipping($id_carrier,$id_quotation,$adress_liv,$adress_fact){
   global $DB;
   try {
      $adress_liv = addslashes($adress_liv);
      $adress_fact = addslashes($adress_fact);
      $carrier = getCarrier($id_carrier);

      $query = "INSERT INTO `"._DB_PREFIX_."quotation_carrier`(`id_carrier`, `id_quotation`, `address_delivery`, `address_invoice`, `carrier_name`  , `delay`, `tax_rule`  , `tax_type`, `cdate`) 
               VALUES ($id_carrier,$id_quotation,'$adress_liv','$adress_fact','".$carrier['name']."','".$carrier['max_delay']."','".$carrier['rate']."' ,0,now())";
      $DB->query($query);
      $id_msg = $DB->lastInsertId();
      unset($_SESSION['id_carrier']);
      return $id_msg;
   }catch (Exception $e) {
      return false;
   }
}

function _GET($index){
   $req = $_SERVER['REQUEST_URI'];
    $req = substr($req,strpos($req, '?')+1);
    $req  = explode('&', $req);
    $return = array();
    foreach ($req as $value) {
      $tmp = explode('=', $value);
      if (count($tmp) == 2) {
         $return[$tmp[0]] = $tmp[1];
      }
    }
    if (isset($return[$index])) {
       return $return[$index];
    }
   return false; 
}

function deleteProductFromDevis($idProduit,$id_dec = null){
   if (creationPanier())
   {
      $tmp=array();
      $tmp['idProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();
      $tmp['id_dec'] = array();

      for($i = 0; $i < count($_SESSION['Devis']['idProduit']); $i++)
      {
         if ($_SESSION['Devis']['idProduit'][$i] !== $idProduit || (!empty($id_dec) && $id_dec != null && $_SESSION['Devis']['id_dec'][$i] !== $id_dec))
         {
            array_push( $tmp['idProduit'],$_SESSION['Devis']['idProduit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['Devis']['qteProduit'][$i]);
            array_push( $tmp['prixProduit'],$_SESSION['Devis']['prixProduit'][$i]);
            array_push( $tmp['id_dec'],$_SESSION['Devis']['id_dec'][$i]);
         }
      }
      $_SESSION['Devis'] =  $tmp;
      unset($tmp);
      return true;
   }
   else
      return false;
}

function updateQteProduct($idProduit,$qte,$id_dec=null){
    $isNewDec = false;

   if (creationPanier())
   {
      $positionProduit = array_search($idProduit,  $_SESSION['Devis']['idProduit']);
      if ($positionProduit !== false && $id_dec != null) {
          $positionDec = array_search($id_dec,  $_SESSION['Devis']['id_dec']);
          if ($positionDec !== false) {
            $positionProduit = $positionDec;
          }else{
            $isNewDec = true;
          }
      }

      if ($positionProduit !== false)
      {

         if (is_numeric($qte)){
            $_SESSION['Devis']['qteProduit'][$positionProduit] = $qte;
         }
         if ($_SESSION['Devis']['qteProduit'][$positionProduit] <= 0) {
           deleteProductFromDevis($idProduit);
         }
      }
    return true;
   }
   else
      return false;
}

function getUserDevis($UID){
   global $DB; 
   try {
      $query = "SELECT  q.`id`,q.`cdate`,q.payment_method as payment ,qs.name as status,q.id_state 
      FROM `"._DB_PREFIX_."quotations` q , "._DB_PREFIX_."quotation_status qs WHERE qs.id = q.id_state
      AND q.`id_customer` = $UID ORDER BY q.cdate DESC";
      $res = $DB->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
   }catch (Exception $e) {
      return false;
   }
}

function getUserQuotation($UID){
   global $DB; 
   try {
      $query = "SELECT  q.* ,qs.slug status_slug, qs.name status_name
      FROM `"._DB_PREFIX_."quotations` q , "._DB_PREFIX_."quotation_status qs 
      WHERE q.id_state = qs.id AND q.`id_customer` = $UID ORDER BY cdate DESC";
      $res = $DB->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
   }catch (Exception $e) {
      return false;
   }
}

function getPaymentByIds($ids,$separator = ' '){
   global $DB; 
   try {
      $query = "SELECT  GROUP_CONCAT(value  SEPARATOR '$separator') as payment_choice FROM "._DB_PREFIX_."payment_methodes WHERE id in ($ids)";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res['payment_choice'];
   }catch (Exception $e) {
      echo $e;
      return false;
   }
}

function getDevisFileById($id){
  $uid = loged();
  if (!$uid){
    return false;
  }
   global $DB; 
   try{
      $query = "SELECT q.*,u.`first_name`,u.`last_name` ,u.`phone`,u.`mobile`,u.id as userid ,qo.`expiration_date`,pm.value as payment ,qs.name as status
      FROM (`"._DB_PREFIX_."quotations` q,  "._DB_PREFIX_."users u  ,`"._DB_PREFIX_."quotation_status` qs, "._DB_PREFIX_."payment_methodes pm) LEFT JOIN  `"._DB_PREFIX_."quotation_options` qo ON(q.id = qo.`id_quotation`) 
      WHERE q.`id_customer` = u.`id` AND q.`id_state` = qs.id AND q.`id_payment_method`=pm.id and  q.id = $id AND u.`id` = $uid AND q.`id_state` in (3,4)";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      
      //get quotation Product
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_products` WHERE   `id_quotation` = ".$res['id'];
      $products = $DB->query($query);
      $products = $products->fetchAll(PDO::FETCH_ASSOC);

    //  var_dump($products);

      $html = "";
      $html .= '
         <style>
         html, body {height: 100%;font-family:Tahoma,Arial}
         .page-wrap {min-height: 100%; margin-bottom: -142px; }
         .page-wrap:after {content: ""; display: block; }
         .footer, .page-wrap:after {height: 142px; }
         .footer{position: fixed; bottom: 0px; width: 100%; height: 110px;border-top:5px solid #5BAA25;}
         #second tr:nth-child(odd) {background-color: #e9e9e9;}
         .left{text-align: left;}
         th,td{vertical-align: top;}
         .quote{width:90px;} 
         .quote2{width:200px;} 
         .cli{width:120px;}
         </style>';
      $html .= '<div class="page-wrap">
               <table cellpadding="2" cellspacing="0" style="width:1024px;margin:0px auto;">
                 <tr>
                   <th colspan="6" style="text-align:left;">';
      $html .= '<img src="'.WebSite.'modules/quotationfront/assets/images/logo.jpg">';
      $html .= '</th>
             <th colspan="2" style="text-align:right;vertical-align:bottom;font-size:26px;"><h2 style="color:#44271A;">Devis N° '.$res['id'].'</h2></th>
           </tr>

           <tr><td style="height:30px;"></td></tr>';
      $html .= '<tr>';
      $html .= '<th class="left quote">Devis N°</th><td colspan="2">'.$res['id'].'</td>';
      $html .= '<th class="left cli">Client</th><td colspan="4">'.$res['first_name'].' '.$res['last_name'].'</td>';
      $html .= '</tr>';

      $html .= '<tr>';
      $html .= '<th class="left quote">Date</th><td colspan="2">'.$res['cdate'].'</td>';
      $html .= '<th class="left cli">Adresse</th><td colspan="4">'.getUserFullAdresse($res['userid']).'</td>';
      $html .= '</tr>';

      $html .= '<tr>';
      $html .=  '<th class="left quote">valable</th><td colspan="2">'.$res['expiration_date'].'</td>' ;
      $html .=  '<th class="left cli">Téléphone</th><td colspan="4">'.$res['phone'].' / '.$res['phone'].' </td>' ;
      $html .= '</tr>';

      $html .= '<tr>';
      $html .=  '<th class="left quote">statue</th><td colspan="2">'.$res['status'].'</td>' ;
      $html .=  '<th class="left cli">Methode de paiment</th><td colspan="4">'.$res['payment']. ' </td>' ;
      $html .= '</tr>';

      $html .= '<tr><td style="height:30px;"></td></tr>
      </table>



      <table cellpadding="10" cellspacing="0" style="width:1024px;margin:0px auto;border:1px solid #44271A;" id="second">
        <tr style="background:#44271A;">
          <td  style="color:#FFF;font-size:15px;">Image</td>
          <td style="color:#FFF;font-size:15px;">Désignation</td>
          <td style="color:#FFF;font-size:15px;">Quantité</td>
          <td style="color:#FFF;font-size:15px;">TVA (%)</td>
          <td style="color:#FFF;font-size:15px;">Remise</td>
          <td style="color:#FFF;font-size:15px;">Price (tax excl.)</td>
          <td style="color:#FFF;font-size:15px;">Price (tax incl.)</td>
          <td style="color:#FFF;font-size:15px;">Total (tax excl.)</td>
          <td style="color:#FFF;font-size:15px;">Total (tax incl.)</td>
        </tr>';
       $hts  = 0;
        $tvas = 0;
        $ttcs = 0;
        $qtes = 0;
        $Poids = 0;
        $discounts = 0;

         foreach ($products as $key => $product) {
            $hts  += $product['buy_price']*$product['quantity'];
            $tvas += $product['tax_rule'];
            $discounts += $product['discount'];
            //$ttcs += $product['price_with_tax'];
            $qtes += $product['quantity'];
            $html .= '<tr>
                        <td style="border-right:1px solid #44271A;"><img src="'.WebSite.'files/products/'.$product['product_image'].'" alt="image"/></td>
                        <td style="border-right:1px solid #44271A;">'.$product['product_name'].' <br><b>REF:</b> '.$product['product_reference'].'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['quantity'].'</td>
                        <td style="border-right:1px solid #44271A;"></td>
                        <td style="border-right:1px solid #44271A;">'.$product['discount'].'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['buy_price'].' &euro;</td>
                        <td style="border-right:1px solid #44271A;">'.($product['buy_price'] - $product['discount']).' &euro;</td>
                        <td style="border-right:1px solid #44271A;">'.($product['buy_price'] * $product['quantity']).' &euro;</td>
                        <td style="border-right:1px solid #44271A;">'.(($product['buy_price'] - $product['discount'] )* $product['quantity']).' &euro;</td>
                    </tr>';
        }
        $ttcs = ($hts + $tvas - $discounts);
        $html .= '<tr style="background-color:#fff;">
            <td colspan="8" style="text-align:right;border-top:1px solid #44271A">
                <b>Quantité Total : </b><br>
                <b>Poids global : </b><br>
                <b>Total Remise : </b><br>
               <b>Total HT : </b><br>
               <b>TVA : </b><br>
               <b>Total TTC :</b>
            </td>
            <td style="border-top:1px solid #44271A">
              '.$qtes.'<br>
              '.$Poids.' KG<br>
              '.$discounts.' &euro;<br>
               '.$hts.' &euro;<br>
               '.$tvas.' &euro;<br>
               '.$ttcs.' &euro;
            </td>
           </tr>
         </table>

         </div>';
         $footer = '<table border="0" cellpadding="0" cellspacing="0" style="width:1024px;margin:0px auto;">
             <tr>
                 <td>';
         $footer .= '</td>
                 <td style="vertical-align: middle;">';
         $footer .= '</td>
             </tr>
             <tr>
                 <td colspan="2">
                     <hr style="margin-top:0px;">';
         $footer .= '<b><center>';
         $footer .= '</b></center>';
         $footer .= '</td>
             </tr>
             <tr>
                 <td colspan="2">
                     <b><center>Cet document est crée par <a target="_blank" href="#" style="color:#44271A;"></a></center></b>
                 </td>
             </tr>
         </table>';


         /*echo $html;
         echo $footer;
         exit();*/


        $mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 15 , 15 , 10 , 10 , 10 , 5); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->setDefaultFont("Arial");
        $mpdf->WriteHTML($html);
        $mpdf->SetHTMLFooter($footer);
        $dir = 'files/quotatonattachments/'.$id;
         if (!file_exists($dir)) {
             mkdir($dir, 0777, true);
         }
         $file_dir = $dir.'/devis_'.md5($id).'.pdf';
         $mpdf->Output($file_dir,'F');
         echo '<script>window.location.href = "'.WebSite.$file_dir.'"</script>';
      return;
      $mpdf = new mPDF();
      $mpdf->WriteHTML($html);
      $dir = 'files/quotatonattachments/'.$id;
      if (!file_exists($dir)) {
          mkdir($dir, 0777, true);
      }
      $file_dir = $dir.'/devis_'.md5($id).'.pdf';
      $mpdf->Output($file_dir,'F');
      echo '<script>window.location.href = "'.WebSite.$file_dir.'"</script>';
      
   } catch (Exception $e) {
      return false;
   }
}
function loged(){
  if (isset($_SESSION['user']))
    return $_SESSION['user'];
  else
    return false;
}



function editDevisById($idquotation){
 // '.WebSite.'cart
  $output =  "";

  

  $uid = loged();
  if (!$uid){
    return false;
  }
  $res = array();
  global $DB; 
  try{
      /*$query = "SELECT q.*,u.`first_name`,u.`last_name` ,u.`phone`,u.`mobile`,u.id as userid ,qo.`expiration_date`,pm.value as payment ,qs.name as status
      FROM (`quotations` q,  users u  ,`quotation_status` qs,payment_methodes pm) LEFT JOIN  `quotation_options` qo ON(q.id = qo.`id_quotation`) 
      WHERE q.`id_customer` = u.`id` AND q.`id_state` = qs.id AND q.`modes_de_reglement`=pm.id and  q.id = $idquotation AND u.`id` = $uid AND q.`id_state` = 3";
      $res = $DB->query($query);
      $res = $res->fetch(PDO::FETCH_ASSOC);*/
      
      //get quotation Product
   /*   $query = "SELECT * FROM `quotation_products` WHERE   `id_quotation` = ".$res['id'];
      $products = $DB->query($query);
      $products = $products->fetchAll(PDO::FETCH_ASSOC);*/
      
      if(isset($_POST['submitEdit'])){
        $_SESSION['quotationedit'] = $idquotation;
        toQuotationSession($products);
        redirect(WebSite.'cart');
      }
      global $hooks;
      $quotations = $hooks->get_quotation($idquotation, $uid);
      $quotation = $quotations['quotation'];
      $customer = $quotations['customer'];
      $options = $quotations['options'];
      $products = $quotations['products'];
      $total = $quotations['total'];
     
      $html  = "";
      $html .= '<h1>Devis N° '.$quotation['id'].'</h1>';
      $html .= '
              <form method="POST" action="">
              <div class="alert alert-warning" role="alert">
                <p>Pour modifier, ajouter ou supprimer des <b>produit</b> dans le devis ou votre <b>information</b> de livraison veuillez cliquer en dessous et renouveler la demande avant la validation de la modification</p>
                <p><input type="submit" name="submitEdit" value="Modifier mon devis" class="exclusive"></p>
              </div>
              </form>';


      $html .= '<div class="page-wrap">
               <table cellpadding="2" cellspacing="0">';

      $html .= '<tr>';
      $html .= '<th class="left quote">Devis N°</th><td colspan="2">'.$quotation['id'].'</td>';
      $html .= '<th class="left cli">Client</th><td colspan="4">'.$customer['first_name'].' '.$customer['last_name'].'</td>';
      $html .= '</tr>';

      $html .= '<tr>';
      $html .= '<th class="left quote">Date</th><td colspan="2">'.$quotation['cdate'].'</td>';
      $html .= '<th class="left cli">Adresse</th><td colspan="4">'.getUserFullAdresse($uid).'</td>';
      $html .= '</tr>';

      $html .= '<tr>';
      $html .=  '<th class="left quote">valable</th><td colspan="2">'.$options['expiration_date'].'</td>' ;
      $html .=  '<th class="left cli">Téléphone</th><td colspan="4">'.$customer['phone'].' / '.$customer['phone'].' </td>' ;
      $html .= '</tr>';

      $html .= '<tr>';
      $html .=  '<th class="left quote">statue</th><td colspan="2"></td>' ;
      $html .=  '<th class="left cli">Methode de paiment</th><td colspan="4">'.$quotation['payment_method']. ' </td>' ;
      $html .= '</tr>';

      $html .= '<tr><td style="height:30px;"></td></tr>
      </table>



      <table cellpadding="10" cellspacing="0" id="second" style="text-align: center;">
        <tr style="background:#44271A;">
          <td  style="color:#FFF;font-size:15px;">Image</td>
          <td style="color:#FFF;font-size:15px;">Réference</td>
          <td style="color:#FFF;font-size:15px;">Désignation</td>
          <td style="color:#FFF;font-size:15px;">Prix ($euro;)</td>
          <td style="color:#FFF;font-size:15px;">Quantité</td>
          <td style="color:#FFF;font-size:15px;">Remise ($euro;)</td>
          <td style="color:#FFF;font-size:15px;">Total Ligne</td> 
        </tr>';
/*
        $hts  = 0;
        $tvas = 0;
        $ttcs = 0;
        $qtes = 0;
        $Poids = 0;
        $discounts = 0;*/

         foreach ($products as $key => $product) {
          /*  $hts  += $product['buy_price']*$product['quantity'];
            $tvas += $product['tax_rule'];
            $discounts += $product['discount'];*/
            //$ttcs += $product['price_with_tax'];
           // $qtes += $product['quantity'];
            $product_image_src = $hooks->get_file_name( $product['product_image'] );
            $product_image_src = WebSite.'files/products/'.$product['id_product'].'/'.$product_image_src;
            $html .= '<tr id="product_'.$product['id_product'].'">
                        <td style="border-right:1px solid #44271A;"><img src="'.$product_image_src.'" alt="image"/></td>
                        <td style="border-right:1px solid #44271A;">'.$product['product_reference'].'</td>
                        <td style="border-right:1px solid #44271A;">'.stripslashes($product['product_name']).'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['product_price'].'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['product_quantity'].'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['discount'].'</td>
                        <td style="border-right:1px solid #44271A;">'.$product['total_ht'].' &euro;</td>
                      </tr>';
        }
        //var_dump($total['tax']);
    /*    $ttcs = ($hts + $tvas - $discounts);*/
        $html .= '<tr style="background-color:#fff;">
            <td colspan="6" style="text-align:right;border-top:1px solid #44271A">
                <b>Poids global</b><br>
                <b>Quantité</b><br>
                <b>Remise</b><br>
               <b>TVA</b><br>
               <b>Frais de Transport</b><br>
               <b>Total HT</b><br>
               <b>Total TTC</b>
            </td>
            <td style="text-align:right;border-top:1px solid #44271A">
              '.$total['weight'].' KG<br>
              '.$total['quantity'].' Pièces<br>
              '.$total['discount'].' &euro;<br>
              '.$total['tax'].' &euro;<br>
              '.$total['shipping'].' &euro;<br>
              '.$total['tht'].' &euro;<br>
              '.$total['ttc'].' &euro;
            </td>
           </tr>';
        $html .= '</table>

         </div>';

      } catch (Exception $e) {
      return false;
   }
  $output .= $html;
  echo $output;
}

function toQuotationSession($id_quotation){
  supprimeDevis();
  global $hooks;
  $array = $hooks->select('quotation_detail', array('*'), " WHERE id_quotation=". $id_quotation);
  if ($array && !empty($array)) {
    foreach ($array as $key => $value) {
      if (isset($value['id_product']) && isset($value['product_quantity'])) {
        ajouterDevis($value['id_product'],$value['product_quantity'],$value['product_price'],$value['id_declinaisons']);
      }
    }
  }
  
}

function redirect($link){
  echo '<script>window.location.href = "'.$link.'"</script>';
}

function quotationMessage($idquotation,$iduser){
  global $DB;
  try {
      $sql = "SELECT `id`,`message`,`objet`,`attachement`,`file_name`,`status`,`cdate` ,
      CASE id_sender 
       WHEN $iduser THEN 'Vous'
       ELSE 'marchand'
      END as sender
      FROM `"._DB_PREFIX_."quotation_messages` 
      WHERE `id_quotation` = $idquotation AND (`id_sender` = $iduser OR `id_receiver` =  $iduser )";
      $res = $DB->query($sql);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      $i=0;
      foreach ($res as $key => $value) {
       $link = ROOTPATH."files/quotatonattachments/".$idquotation."/". $value['attachement'];
       if (file_exists($link) && !empty($value['attachement'])) {
          $res[$i]['attachement_link'] =  WebSite."files/quotatonattachments/".$idquotation."/". $value['attachement'];
       }
       $i++;
      }
      return $res;
  }catch (Exception $e) {
      return false;
  }
}
function qf_getLoyaltyOptions($name){
  try{
    global $DB;
    $query = "SELECT value FROM `"._DB_PREFIX_."loyalty_options` WHERE name = '$name'";
    $res = $DB->query($query);
    $res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
  }catch (Exception $e){
    return false;
  }
}

function getDeclinaisonByid($id){
  try{
    global $DB;
    $query = "SELECT * FROM `"._DB_PREFIX_."declinaisons` WHERE id = $id";
    $res = $DB->query($query);
    $res = $res->fetch(PDO::FETCH_ASSOC);
    return $res;
  }catch (Exception $e){
    return false;
  }
}
function getCuString($cu){
  try{
    global $DB;
    $condition = "";
    $tmp = explode(",",$cu);
    foreach ($tmp as $key => $value) {
      $tmp2 = explode(":",$value );
      $condition .= ' (a.id = '.$tmp2[0].' AND av.id = '.$tmp2[1].') or';
    }
    $condition = rtrim($condition ,'or');
    $query = "SELECT GROUP_CONCAT(concat(a.name,' - ', av.`name`) SEPARATOR ' , ') as p_attr_values FROM `"._DB_PREFIX_."attribute_values` av,`"._DB_PREFIX_."attributes` a WHERE $condition";
    $res = $DB->query($query);
    $res = $res->fetch(PDO::FETCH_ASSOC);
    return $res['p_attr_values'];
  }catch (Exception $e){
    return false;
  }
}


?>