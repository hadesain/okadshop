<?php
class OS_Carrier {


  public function get_carrier_name_by_id($id){
      $DB = Database::getInstance();
      try {
        $query = "SELECT name FROM "._DB_PREFIX_."carrier WHERE id=$id";
        if($rows = $DB->query($query)){
          $data = $rows->fetch(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data['name'];
        }
      } catch (Exception $e) {
        return false;
      }
  }

/*============================================================*/
} //END COMMON CLASS
/*============================================================*/
?>