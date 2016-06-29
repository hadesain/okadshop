<?php
class OS_Devis
{


  /**
   *=============================================================
   * get_users_infos_by_group
   *=============================================================
   * @param  $group_ids (array)
   * @throws Exception
   * @return $data (array)
   */
  public function get_users_infos_by_group($group_ids = array())
  {
    try {
      $group_ids = implode(',', $group_ids);
      if($group_ids != ''){
        $DB = Database::getInstance();
        $query = "SELECT `id`, `email`, `first_name`, `last_name`, `id_gender` FROM `"._DB_PREFIX_."users` WHERE `id_group` IN ($group_ids)";
        if($rows = $DB->query($query)){
          $data = $rows->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      }
    } catch (Exception $e) {
      exit;
    }
  }

  /**
   *=============================================================
   * get_users_infos_by_type
   *=============================================================
   * @param  $types (array)
   * @throws Exception
   * @return $data (array)
   */
  public function get_users_infos_by_type($types = array())
  {
    try {
      $types_list = implode('", "', $types);
      $types_list = '"'. $types_list .'"';
      if($types_list != ''){
        $DB = Database::getInstance();
        $query = "SELECT `id`, `email`, `first_name`, `last_name`, `id_gender` FROM `"._DB_PREFIX_."users` WHERE `user_type` IN ($types_list)";
        if($rows = $DB->query($query)){
          $data = $rows->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_customer_infos
   *=============================================================
   * @param  $id_customer (int)
   * @throws Exception
   * @return $data (array)
   */
  public function get_customer_infos($id_customer)
  {
    try {
        global $DB;
        $query = "SELECT first_name, last_name, phone, mobile
                  FROM "._DB_PREFIX_."users
                  WHERE id=$id_customer LIMIT 1";
        if($rows = $DB->query($query)){
          $data = $rows->fetch(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_carriers_list
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_carriers_list()
  {
    try {
      global $DB;
      //$query = "SELECT `id`, `name`, `delay`, `price_without_tax`, `tax_rule` FROM `carrier` WHERE `active` = 1";
      $query = "SELECT `id`, `name`, `min_delay` as min, `max_delay` as max, `id_tax` FROM `"._DB_PREFIX_."carrier` WHERE `active` = 1";
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
   * get_shipping_infos
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_shipping_infos($id_quotation)
  {
    try {
      global $DB;
      $query = "SELECT qs.shipping_address, qs.invoice_address, 
                qs.delay, qs.price, qs.tax, c.name as carrier
                FROM "._DB_PREFIX_."quotation_shipping qs, "._DB_PREFIX_."carrier c
                WHERE qs.id_quotation=$id_quotation LIMIT 1";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_quotation_status_list
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_status_list()
  {
    try {
      global $DB;
      $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."quotation_status`";
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
   * get_quotation_products_list
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_products_list($id)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_detail` WHERE id_quotation=$id";
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
   * get_quotation_data
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_data($id)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotations` WHERE `id`=$id";
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }

  /**
   *=============================================================
   * get_quotation_infos
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_infos($id)
  {
    try {
      global $DB;
      $query = "SELECT q.name, q.points_de_fidelite, q.modes_de_reglement, q.informations,
                qo.global_discount, qo.global_discount_type, qo.can_be_ordered, qo.expiration_date,
                qs.footer, qs.footer_logo, qs.conditions
                FROM "._DB_PREFIX_."quotations q, "._DB_PREFIX_."quotation_options qo, "._DB_PREFIX_."quotation_setting qs
                WHERE q.id=$id AND qo.id_quotation=$id LIMIT 1";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_quotation_data
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotations_list()
  {
    try {
      global $DB;
      $query = "SELECT q.*, u.first_name, qs.name as state, u.last_name, ug.name as user_group,
                u.active as user_state, c.name as country, pm.value as method
                FROM "._DB_PREFIX_."quotations q
                LEFT JOIN "._DB_PREFIX_."users u ON u.id = q.id_customer
                LEFT JOIN "._DB_PREFIX_."users_groups ug ON u.id_group = ug.id
                LEFT JOIN "._DB_PREFIX_."quotation_status qs ON q.id_state=qs.id
                LEFT JOIN "._DB_PREFIX_."countries c ON u.id_country=c.id
                LEFT JOIN "._DB_PREFIX_."payment_methodes pm ON pm.id=q.id_payment_method
                ORDER BY q.id DESC";
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
   * get_quotation_shipping
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_shipping($id)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_carrier` WHERE `id_quotation`=$id";
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }

  
  /**
   *=============================================================
   * get_quotation_emails
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_emails($id)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_emails` WHERE `id_quotation`=$id";
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_quotation_options
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_options($id)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_options` WHERE `id_quotation`=$id";
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * get_quotation_messages
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_quotation_messages($id_quotation)
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_messages` WHERE `id_quotation`=$id_quotation ORDER BY id DESC";
      // AND `id_sender`=$id_sender AND `id_receiver`=$id_receiver
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
   * get_payment_methodes
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_payment_methodes()
  {
    try {
      global $DB;
      $query = "SELECT `id`, `value` FROM `"._DB_PREFIX_."payment_methodes`";
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
   * get_settings
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_settings()
  {
    try {
      global $DB;
      $query = "SELECT * FROM `"._DB_PREFIX_."quotation_setting`";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  //upload product_image
  public function upload_product_image($id_product){
    if( $id_product < 1 ) return;
    if( isset($_FILES['product_image']) && $_FILES['product_image']['size'][0] > 0 ){
      global $common;
      $uploadDir = "../../../../files/products/". $id_product ."/";
      $file_target = $common->uploadImage($_FILES['product_image'], $uploadDir);
      $image_name = str_replace( $uploadDir , '', $file_target[0] );
      //crop image
      $common->cropFile($uploadDir,$image_name);
      return $image_name;
    }
  }

  


/*============================================================*/
} //END CLASS
/*============================================================*/
?>