<?php  
function updatePaypalSetting($username,$password,$signature){
	try {
		global $DB;
		$query = "UPDATE `"._DB_PREFIX_."paypalexpress_setting` SET `username` = '".$username."', `password` = '".$password."', `signature`  = '".$signature."'";
		$DB->query($query);
		return true;
	} catch (Exception $e) {
		return false;
	}
}
function getPaypalOption(){
	try {
		global $DB;
		$query = "SELECT * FROM `"._DB_PREFIX_."paypalexpress_setting` LIMIT 1";
		$res = $DB->query($query);
    $res = $res->fetch(PDO::FETCH_ASSOC);
    return $res;
	} catch (Exception $e) {
		//echo $e;
		return false;
	}
}

?>