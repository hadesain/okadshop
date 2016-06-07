<?php  

function saveLoyaltyOptions($name,$value){
	try{
		global $DB;
		$query = "DELETE FROM `"._DB_PREFIX_."loyalty_options` WHERE name = '$name'";
		$DB->query($query);
		$query = "INSERT INTO `"._DB_PREFIX_."loyalty_options` (`name`,`value`) VALUES ('$name','$value')";
		$DB->query($query);
		return true;
	}catch (Exception $e) {
		return false;
	}
}
function getLoyaltyOptions($name){
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





?>