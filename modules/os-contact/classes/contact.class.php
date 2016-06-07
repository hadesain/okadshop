<?php
class Contact_Form
{


  /**
   *=============================================================
   * get_contact_messages
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_contact_messages()
  {
    try {
      global $DB;
      $query = "SELECT * FROM(
                  SELECT cm.*, c.name as country
                  FROM "._DB_PREFIX_."contact_messages cm
                  LEFT JOIN "._DB_PREFIX_."countries c ON cm.id_country=c.id
                  WHERE cm.`from` = cm.`id_sender` OR cm.`from` = cm.`id_receiver`
                  ORDER BY cm.cdate DESC
                )msg
                GROUP BY `email`";
                /*SELECT cm.*, c.name as country   
                FROM `contact_messages` cm, countries c  
                WHERE cm.id = (SELECT min(cm2.id) parent 
                              FROM `contact_messages` cm2
                              WHERE cm2.`id_sender` = cm.`id_sender`
                              or cm2.`id_receiver` = cm.`id_sender`
                              ORDER BY cm2.id DESC)
                AND cm.id_country=c.id*/
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_message_by_directory
   *=============================================================
   * @param  $id_msg (int)
   * @throws Exception
   * @return $data (array)
   */
  public function get_message_by_directory($email, $id_directory)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."contact_messages`
                WHERE `email`='$email' AND id_directory=$id_directory
                ORDER BY id DESC";
                //echo $query;
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_sender_info
   *=============================================================
   * @param  $id_sender (int)
   * @throws Exception
   * @return $data (array)
   */
  public function get_sender_info($email)
  {
    try {
      global $DB;
      $query = "SELECT cm.firstname, cm.lastname, cm.company, cm.siret_tva, 
                cm.email, cm.adresse, cm.adresse2, cm.zipcode, cm.city, 
                cm.mobile, cm.ip, cm.id_country, c.name as country
              FROM `"._DB_PREFIX_."contact_messages` cm
              LEFT JOIN "._DB_PREFIX_."countries c on c.id=cm.id_country
              WHERE cm.email='". $email ."' ORDER BY cm.cdate DESC LIMIT 1";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }



  

/*============================================================*/
} //END CLASS
/*============================================================*/
?>