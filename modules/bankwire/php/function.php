<?php  
function bw_save_mete_value($name, $value) {
	global $DB;
    try {
      $query = "DELETE FROM `"._DB_PREFIX_."meta_value` WHERE name = '$name'";
      $DB->query($query);
      $query = "INSERT INTO `"._DB_PREFIX_."meta_value`(`name`, `value`, `cdate`) VALUES('".$name."','".$value."',now())";
      if($DB->query($query)){
        $id_product = $DB->lastInsertId();
        return $id_product;
      }
    } catch (Exception $e) {
      return false;
    }
}

function bw_select_mete_value($name){
	global $DB;
    try {
      $query = "SELECT value FROM "._DB_PREFIX_."meta_value WHERE name = '$name'";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data['value'];
      }
    } catch (Exception $e) {
      return false;
    }
}
?>