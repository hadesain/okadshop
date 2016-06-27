<?php


function pv_getViewdProductSESSION(){
	if (!isset($_SESSION['ViewdProduct'])){
  		$_SESSION['ViewdProduct']=array();
	}
		krsort($_SESSION['ViewdProduct']);
	return $_SESSION['ViewdProduct'];
}

function pv_getProductByids($ids,$LIMIT){
	global $DB;
	try {
    $sql = "SELECT * FROM "._DB_PREFIX_."products WHERE id in ($ids)";
    if ($LIMIT != null) {
    	$sql .= " LIMIT $LIMIT";
    }
    $res = $DB->query($sql);
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  } catch (Exception $e) {
    return false;
  }
}

function pv_getViewedProduct($LIMIT = null){

	$viewed_product_ids = implode(',',pv_getViewdProductSESSION());
	if (!empty($viewed_product_ids)) {
	 	$res = pv_getProductByids($viewed_product_ids,$LIMIT);
	 	$product = new product();
    	$res = $product->oslang_migrate_product($res,true);
		$res = fixProduct($res);
		return $res;
	}
	return false;
}

function pv_setViewdProduct($id){
	if (!isset($_SESSION['ViewdProduct'])){
    $_SESSION['ViewdProduct']=array();
 	}
 if (!array_search($id, $_SESSION['ViewdProduct'])) {
 		/*if (count($_SESSION['ViewdProduct']) >= 4 ) {
 			array_pop($_SESSION['ViewdProduct']);
 		}*/
 		$_SESSION['ViewdProduct'][] = $id;
 }
 
 return true;
}

function pv_getCorrectId($id){
	$id = explode('-', $id);
	$id = $id[0];
	if (is_numeric($id)) {
		return $id;
	}
	return false;
}

?>