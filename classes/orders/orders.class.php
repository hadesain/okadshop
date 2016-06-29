<?php
class OS_Orders extends OS_Common
{


  /**
   *=============================================================
   * get order number
   *=============================================================
   * @param int $id_order
   * @throws Exception
   */
  function get_reference_number($table) {
    $lastID = $this->select($table, array('id'), "ORDER BY id DESC LIMIT 1" );
    $randomString = intval($lastID[0]['id']) + 1;
    $char_length = 9 - strlen( $randomString );
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $char_length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return str_shuffle($randomString);
  }


  /**
   *=============================================================
   * get_adress_details
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_adress_details($id_adress)
  {
    try {
      global $DB;
      $query = "SELECT a.*, c.name as country 
      FROM "._DB_PREFIX_."addresses a, "._DB_PREFIX_."countries c 
      WHERE c.id = a.id_country AND a.id=". $id_adress ." LIMIT 1";
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
   * get order states
   *=============================================================
   * @throws Exception
   * @return $order_states (array)
   */
  public function get_order_states($id_order)
  {
    try {
      global $DB;
      $query = "SELECT os.id as id_line, s.id as id_state, os.cdate, s.name, u.first_name, u.last_name
                FROM "._DB_PREFIX_."order_state_line os, "._DB_PREFIX_."order_states s, "._DB_PREFIX_."orders o, "._DB_PREFIX_."users u
                WHERE s.id = os.id_state AND u.id = o.id_customer AND o.id=$id_order AND os.id_order=$id_order
                ORDER BY os.id DESC";
      if($rows = $DB->query($query)){
        $order_states = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($order_states)) return $order_states;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get order addresses
   *=============================================================
   * @throws Exception
   * @return $addresses (array)
   */
  public function get_order_addresses($id_customer)
  {
    try {
      global $DB;
      $query = "SELECT a.*, c.name as country 
                FROM "._DB_PREFIX_."addresses a, "._DB_PREFIX_."countries c 
                WHERE c.id = a.id_country AND id_user=". $id_customer ." ORDER BY a.id DESC";
      if($rows = $DB->query($query)){
        $addresses = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($addresses)) return $addresses;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get customer infos
   *=============================================================
   * @throws Exception
   * @return $infos (array)
   */
  public function get_customer_infos($id_customer)
  {
    try {
      global $DB;
      $query = "SELECT u.id, u.email, u.first_name, u.last_name, u.phone, u.mobile, u.city, 
                u.cdate, g.name as gender, c.name as country
                FROM "._DB_PREFIX_."users u, "._DB_PREFIX_."gender g, "._DB_PREFIX_."countries c
                WHERE u.id=1 AND g.id = u.id_gender AND c.id = u.id_country";
      if($rows = $DB->query($query)){
        $infos = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($infos)) return $infos[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }



  /**
   *=============================================================
   * send_order_email
   *=============================================================
   * @throws Exception
   * @return true || false (bootlean)
   */
  public function send_order_email($id_order, $id_state)
  {
    try {
      global $DB;
      $query = "SELECT o.reference, os.name as state, u.first_name, u.last_name, u.email, g.name as gender
                FROM "._DB_PREFIX_."orders o
                INNER JOIN "._DB_PREFIX_."order_states os ON os.id = $id_state
                INNER JOIN "._DB_PREFIX_."users u ON u.id = o.id_customer
                INNER JOIN "._DB_PREFIX_."gender g ON g.id = u.id_gender
                WHERE o.id=$id_order LIMIT 1";
                return $query;
      if($rows = $DB->query($query)){
        $order = $rows->fetch(PDO::FETCH_ASSOC);

        if(!empty($order)){
          $Mails = new Mails();
          $Sender    = "no-reply@okadshop.com";
          $Receiver  = $order['email'];
          $Subject   = "OkadShop - Statut de la Commande changé !";
          $Content   = 'Bonjour '. $order['gender'] .' '. $order['first_name'] .' '. $order['last_name'] .',<br><br>';
          $Content  .= 'Le statut de votre Commande avec le réference '. $order['reference'] .' a été changé, le nouveau statut est : '. $order['state'] .'.<br><br>';
          $Content  .= 'Cordialement<br>';
          return $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
        }
      }

      return false;
    } catch (Exception $e) {
      exit;
    }
  }


/*============================================================*/
} //END PRODUCT CLASS
/*============================================================*/
?>