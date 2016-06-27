<?php


function nv_getnewProduct($day,$LIMIT = null){
	global $DB;
	try {
    $sql = "SELECT * FROM "._DB_PREFIX_."products WHERE DATEDIFF(now(),cdate) <= ".$day;
    if ($LIMIT != null) {
    	$sql .= " LIMIT $LIMIT";
    }
    $res = $DB->query($sql);
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    $product = new product();
    $res = $product->oslang_migrate_product($res,true);
    return $res;
  } catch (Exception $e) {
    return false;
  }
}
