<?php
class OS_Product extends OS_Common
{


  /**
   *=============================================================
   * get_products_list
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_products_list()
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."products` ORDER BY name ASC";
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
   * get_associated_products
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_associated_products($associated_with)
  {
    try {
      global $DB;
      $query = "SELECT ap.id, ap.id_product, p.name as product_name, p.sell_price as product_price
                FROM "._DB_PREFIX_."product_associated ap
                LEFT JOIN "._DB_PREFIX_."products p ON p.id=ap.id_product
                WHERE ap.associated_with=$associated_with";
      if($rows = $DB->query($query)){
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
      return false;
    } catch (Exception $e) {
      exit;
    }
  }

  /**
   *=============================================================
   * get_associated_products
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_product_image($id_product)
  {
    try {
      global $DB;
      $query = "SELECT `name` FROM `"._DB_PREFIX_."product_images` WHERE `id_product`=$id_product AND `futured`=1";
      if($rows = $DB->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data['name'])) return $data['name'];
      }
      return false;
    } catch (Exception $e) {
      exit;
    }
  }


  


  /**
   *=============================================================
   * get_taxes_rules
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_taxes_rules($id_group)
  {
    try {
      global $DB;
      $query = "SELECT r.id, r.description, c.id as id_country, c.name as country, t.id as id_tax, t.rate as rate
                FROM "._DB_PREFIX_."taxes_rules r 
                INNER JOIN "._DB_PREFIX_."countries c ON c.id = r.id_country
                INNER JOIN "._DB_PREFIX_."taxes t ON t.id = r.id_tax
                WHERE r.id_group=$id_group ORDER BY r.cdate DESC";
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
   * Get Association By ID
   *=============================================================
   * @param int $id_product
   * @param int $id_category
   * @throws Exception
   * @return boolean (true || false)
   */
  public function getAssociationByID($id_product,$id_category)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."product_category WHERE id_product=$id_product AND id_category=$id_category";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Association Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }




  /**
   *=============================================================
   * Get Product In Order By ID
   *=============================================================
   * @param int $id_product
   * @throws Exception
   * @return boolean (true || false)
   */
  public function getProductInOrderByID($id_product){
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."order_detail WHERE id_product=$id_product";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Product In Order By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



  /**
   *=============================================================
   * Get Product By ID
   *=============================================================
   * @param int $id_product
   * @param int $id_user
   * @throws Exception
   * @return $id_product (int)
   */
  public function getProductByID($id_product,$id_user)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id FROM "._DB_PREFIX_."products WHERE id=$id_product AND id_user=$id_user LIMIT 1";
      $row = $DB->query($query); 
      $product = $row->fetch(PDO::FETCH_ASSOC);
      return $product['id'];
    } catch (Exception $e) {
      echo "Get Product By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert Association
   *=============================================================
   * @param int $id_product
   * @param array $categories
   * @throws Exception
   */
  public function insertAssociations($id_product,$categories)
  {
    try {
      
      $DB = Database::getInstance();
      if(!empty($categories)){
        foreach ($categories as $id_category) {
          $check = self::getAssociationByID($id_product,$id_category);
          if($check == false){
            $query = "INSERT INTO "._DB_PREFIX_."product_category(cdate,id_product,id_category) VALUES(NOW(),$id_product,$id_category)";
            $DB->query($query);
          }
        }
        //Delete old associations
        $cat_ids = implode(",", $categories);
        $query = "DELETE FROM "._DB_PREFIX_."product_category WHERE id_product=$id_product AND id_category NOT IN ($cat_ids)";
        $DB->query($query);
      }else{
        $query = "DELETE FROM "._DB_PREFIX_."product_category WHERE id_product=$id_product";
        $DB->query($query);
      }

    } catch (Exception $e) {
      echo "Insert Association Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert Tag
   *=============================================================
   * @param string $name
   * @throws Exception
   * @return $id_tag
   */
  public function insertTag($name)
  {
    try {
      $DB = Database::getInstance();
      $name = addslashes($name);
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."tags WHERE name='$name'";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        $permalink = self::slugify($name);
        $query = "INSERT INTO "._DB_PREFIX_."tags(name, permalink, cdate, id_lang) VALUES('$name','$permalink',NOW(),1)";
        if($DB->query($query)){
          $id_tag = $DB->lastInsertId();
          return $id_tag;
        }
      }else{
        $query = "SELECT id FROM "._DB_PREFIX_."tags WHERE name='$name'";
        $row = $DB->query($query);  
        $id_tag = $row->fetch(PDO::FETCH_ASSOC);
        return $id_tag['id'];
      }
    } catch (Exception $e) {
      echo "Insert Tag Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert product tags
   *=============================================================
   * @param int $id_product
   * @param array $tags
   * @throws Exception
   */
  public function insertProductTags($id_product,$tags)
  {
    try {
      $DB = Database::getInstance();

      $tag_ids = array();
      if(!empty($tags)){
        foreach ($tags as $tag) {
          $id_tag = self::insertTag($tag);
          //Insert tag if not exist
          $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."product_tags WHERE id_product=$id_product AND id_tag=$id_tag";
          $row = $DB->query($query);  
          $res = $row->fetch(PDO::FETCH_ASSOC);
          if($res['count'] == 0){
            $query = "INSERT INTO "._DB_PREFIX_."product_tags(id_tag, id_product, cdate) VALUES($id_tag,$id_product,NOW())";
            $DB->query($query);
          }
          //push ids
          array_push($tag_ids, $id_tag);
        }
      }
      //Delete old Tags
      if(!empty($tag_ids)){
        $tag_ids = implode(",", $tag_ids);
        $oldtags = "DELETE FROM "._DB_PREFIX_."product_tags WHERE id_product=$id_product AND id_tag NOT IN ($tag_ids)";
        $DB->query($oldtags);
      }

    } catch (Exception $e) {
      echo "Insert Product Tags Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Update Declinaison Quantities
   *=============================================================
   * @param json $quantities
   * @throws Exception
   */
  public function updateDeclinaisonQuantities($json)
  {
    try {
      $quantities = json_decode($json, true);
      if(!empty($quantities)){
        foreach ($quantities as $key => $value) {
          $condition = 'WHERE id='.key($value);
          $data = array('quantity' => end($value));
          self::update('declinaisons',$data,$condition);
        }
      }
    } catch (Exception $e) {
      echo "Update Declinaison Quantities Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert Product Attributes
   *=============================================================
   * @param int $id_product
   * @param array $attributes
   * @param array $attr_ids
   * @return true
   * @throws Exception
   */
  public function insert_feature_product($id_product,$features,$feature_ids)
  {
    try {
      global $DB;

      if(!empty($features))
      {
        foreach ($features as $f)
        {
          $exist = $this->select("feature_product", array('id'), "WHERE id_feature=". $f['id_feature']. " AND id_product=$id_product");
          if( $exist )
          {
            $this->update(
              'feature_product', 
              array('id_feature_value' => $f['id_feature_value'], 'custom' => $f['custom']),
              "WHERE id_feature=". $f['id_feature']." AND id_product=".$id_product
            );
          }else{
            $this->save('feature_product',$f);
          }
        }
        //Delete old features
        if(!empty($feature_ids)){
          $this->delete('feature_product', "WHERE id_product=$id_product AND id_feature NOT IN ($feature_ids)");
        }
        return true;
      }else{
        $this->delete('feature_product', "WHERE id_product=$id_product");
        return true;
      }

      return false;

    } catch (Exception $e) {
      echo "Insert Product Attributes Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


    /**
   *=============================================================
   * Insert Product Combinations
   *=============================================================
   * @param int $id_product
   * @param array $combinations
   * @return true
   * @throws Exception
   */
  public function insertProductCombinations($id_declinaison,$combinations)
  {
    try {
      $DB = Database::getInstance();
      if(!empty($combinations)){
        $attr_ids = array();
        foreach ($combinations as $combination) {
          array_push($attr_ids, $combination['id_attribute']);
          $exist = self::getProductDeclinaisonByID($combination['id_attribute'],$id_declinaison);
          if($exist == false){
            $combination['id_declinaison'] = $id_declinaison;
            self::save('product_declinaisons',$combination);
          }else if($exist == true){
            $condition = 'WHERE id_attribute='.$combination['id_attribute'].' AND id_declinaison='.$id_declinaison;
            self::update('product_declinaisons',$combination,$condition);
          }
        }
        //Delete old Attributes
        if(!empty($attr_ids)){
          $attr_ids = implode(',', $attr_ids);
          $query = "DELETE FROM "._DB_PREFIX_."product_declinaisons WHERE id_declinaison=$id_declinaison AND id_attribute NOT IN ($attr_ids)";
          $DB->query($query);
        }
        return true;
      }else{
        $query = "DELETE FROM "._DB_PREFIX_."product_declinaisons WHERE id_declinaison=$id_declinaison";
        $DB->query($query);
        return true;
      }

    } catch (Exception $e) {
      echo "Insert Product Attributes Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



  /**
   *=============================================================
   * Get Declinaison By CU
   *=============================================================
   * @param (string) $cu
   * @return (int) $id
   * @throws Exception
   */
  public function getDeclinaisonByCU($CU)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id FROM "._DB_PREFIX_."declinaisons WHERE cu='$CU'";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      return $res['id'];
    } catch (Exception $e) {
      echo "Get Declinaison By CU Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Declinaison By ID
   *=============================================================
   * @param string $reference
   * @return id_declinaison (int)
   * @throws Exception
   */
  public function getDeclinaisonByID($ID)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT d.*, p.name as product_name 
      FROM "._DB_PREFIX_."declinaisons d, "._DB_PREFIX_."products p WHERE d.id=$ID AND p.id=d.id_product";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   *=============================================================
   * Get Product Attribute By ID
   *=============================================================
   * @param int $id_attribute
   * @param int $id_product
   * @return boolean (true || false)
   * @throws Exception
   */
  public function getProductAttributeByID($id_attribute,$id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."product_attributes WHERE id_attribute=$id_attribute AND id_product=$id_product";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Attribute By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Product Declinaison By ID
   *=============================================================
   * @param int $id_attribute
   * @param int $id_declinaison
   * @return boolean (true || false)
   * @throws Exception
   */
  public function getProductDeclinaisonByID($id_attribute,$id_declinaison)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."product_declinaisons WHERE id_attribute=$id_attribute AND id_declinaison=$id_declinaison";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Declinaison By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Attribute ID
   *=============================================================
   * @param int $id_attribute
   * @param int $id_product
   * @return data (array)
   * @throws Exception
   */
  public function getByAttributeID($id_attribute,$id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id_value,value FROM "._DB_PREFIX_."product_attributes WHERE id_attribute=$id_attribute AND id_product=$id_product";
      $row = $DB->query($query);
      $data = $row->fetch(PDO::FETCH_ASSOC);
      if(!empty($data)) return $data;
    } catch (Exception $e) {
      echo "Get Attribute By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Image By Name
   *=============================================================
   * @param string $name
   * @param int $id_product
   * @return boolean (true || false)
   * @throws Exception
   */
  public function getImageByName($name,$id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."product_images WHERE name='$name' AND id_product=$id_product";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Image By Name Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert product image
   *=============================================================
   * @param string $name
   * @param string $image
   * @throws Exception
   */
  public function insertProductImage($id_product,$image)
  {
    try {
      $DB = Database::getInstance();
      $exist = self::getImageByName($image,$id_product);
      if($exist == false){
        $position = self::getMaxPosition($id_product);
        $query = "INSERT INTO "._DB_PREFIX_."product_images(id_product, name,position,cdate) VALUES($id_product,'$image','$position',NOW())";
        $DB->query($query);
        return $DB->lastInsertId();
      }
    } catch (Exception $e) {
      echo "Insert Product Image Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Insert product tags
   *=============================================================
   * @param int $id_product
   * @return $max (int)
   * @throws Exception
   */
  public function getMaxPosition($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT MAX(position) as pos FROM "._DB_PREFIX_."product_images WHERE id_product=$id_product";
      $row = $DB->query($query);  
      $max = $row->fetch(PDO::FETCH_ASSOC);
      if($max['pos'] > 0){
        return $max['pos']+1;
      }else{
        return 1;
      }
    } catch (Exception $e) {
      echo "Insert Product Image Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Next Category ID
   *=============================================================
   * @param int $id_product
   * @return $max (int)
   * @throws Exception
   */
  public function getNextCategoryID()
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT MAX(id) as next FROM "._DB_PREFIX_."categories";
      $row = $DB->query($query);  
      $next = $row->fetch(PDO::FETCH_ASSOC);
      if($next['next'] > 0){
        return $next['next']+1;
      }else{
        return 1;
      }
    } catch (Exception $e) {
      echo "Get Next Category ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }
  

  /**
   *=============================================================
   * Get product Images
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function getProductImages($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,name,position,futured FROM "._DB_PREFIX_."product_images WHERE id_product=$id_product ORDER BY position ASC";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Product Images Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get product Attributes
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function getProductAttributes($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id_value,value FROM "._DB_PREFIX_."product_attributes WHERE id_product=$id_product";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Product Attributes Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get product Data
   *=============================================================
   * @param int $id_product
   * @param int $id_user
   * @return $data (array)
   * @throws Exception
   */
  public function getProductData($id_product,$id_user)
  {
    try {
      $DB = Database::getInstance();
     $query = "SELECT * FROM "._DB_PREFIX_."products WHERE id=$id_product AND id_user=$id_user LIMIT 1";
      /*$query = "SELECT p.name as product_name, p.buy_price, p.qty as quantity, p.ean13, p.upc, p.active, p.id_lang, p.reference, pi.name as product_image
                FROM products p, product_images pi
                WHERE pi.id_product=$id_product AND p.id_user=$id_user
                ORDER BY pi.cdate DESC LIMIT 1";*/
      if($res = $DB->query($query)){
        $data = $res->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Product Data Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



  /**
   *=============================================================
   * Get product Declinaisons
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function getProductDeclinaisons($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,reference,ean13,upc,price_impact,weight_impact,default_dec,quantity FROM "._DB_PREFIX_."declinaisons WHERE id_product=$id_product";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Product Declinaisons Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



  /**
   *=============================================================
   * Get product Attachments
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function getProductAttachments($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,name,slug,description,attachment FROM "._DB_PREFIX_."product_attachments WHERE id_product=$id_product";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Product Attachments Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get product Tags
   *=============================================================
   * @param int $id_product
   * @return $tag_list (array)
   * @throws Exception
   */
  public function getProductTags($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT t.name FROM "._DB_PREFIX_."tags t INNER JOIN "._DB_PREFIX_."product_tags pt ON pt.id_tag = t.id WHERE pt.id_product=$id_product";
      if($res = $DB->query($query)){
        $tags = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($tags)){
          $tag_list = array();
          foreach ($tags as $key => $tag) {
            array_push($tag_list, $tag['name']);
          }
          return $tag_list;
        }
      }
    } catch (Exception $e) {
      echo "Get Product Tags Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get product Categories
   *=============================================================
   * @param int $id_product
   * @return $categories_list (array)
   * @throws Exception
   */
  public function getProductCategories($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id_category FROM "._DB_PREFIX_."product_category WHERE id_product=$id_product";
      if($res = $DB->query($query)){
        $categories = $res->fetchAll(PDO::FETCH_ASSOC);
        $categories_list = array();
        foreach ($categories as $key => $category) {
          array_push($categories_list, $category['id_category']);
        }
        return $categories_list;
      }
    } catch (Exception $e) {
      echo "Get Product Categories Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Attribuetes
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function getAttributes()
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,name FROM "._DB_PREFIX_."attributes";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Attribuetes Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



  /**
   *=============================================================
   * Get Product Combinations
   *=============================================================
   * @param int $id_product
   * @param int $id_declinaison
   * @return $data (array)
   * @throws Exception
   */
  public function getCombinations($id_product, $id_declinaison = null)
  {
    try {
      if($id_declinaison > 0){
        $and = 'AND d.id='.$id_declinaison;
      }else{
        $and = '';
      }
      $DB = Database::getInstance();
      $query = "SELECT pd.id as pd_id, pd.id_attribute, pd.id_value, a.name as attr_name, av.name as value_name
                FROM "._DB_PREFIX_."product_declinaisons pd
                INNER JOIN "._DB_PREFIX_."declinaisons d ON d.id = pd.id_declinaison
                INNER JOIN "._DB_PREFIX_."attributes a ON a.id = pd.id_attribute 
                INNER JOIN "._DB_PREFIX_."attribute_values av ON av.id = pd.id_value 
                WHERE d.id_product=$id_product $and";//  GROUP BY d.id
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Combinations Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Attributes To Json
   *=============================================================
   * @param int $id_product
   * @return $data (array)
   * @throws Exception
   */
  public function AttributesToJson($id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id_product,id_attribute,id_value,value FROM "._DB_PREFIX_."product_attributes WHERE id_product=$id_product";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Attributes To Json Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Combinations To Json
   *=============================================================
   * @param int $id_declinaison
   * @return $data (array)
   * @throws Exception
   */
  public function CombinationsToJson($id_declinaison)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id_attribute,id_value FROM "._DB_PREFIX_."product_declinaisons WHERE id_declinaison=$id_declinaison";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Combinations To Json Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Value By ID
   *=============================================================
   * @param int $id_value
   * @return $data (array)
   * @throws Exception
   */
  public function getValueByID($id_value)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT name,permalink,id_attribute FROM "._DB_PREFIX_."attribute_values WHERE id=$id_value";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data[0];
      }
    } catch (Exception $e) {
      echo "Get Value By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Attribute By ID
   *=============================================================
   * @param int $id_value
   * @return $data (array)
   * @throws Exception
   */
  public function getAttributeByID($id_attr)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT COUNT(id) as count FROM "._DB_PREFIX_."attributes WHERE id=$id_attr";
      $row = $DB->query($query);  
      $res = $row->fetch(PDO::FETCH_ASSOC);
      if($res['count'] == 0){
        return false;
      }else{
        return true;
      }
    } catch (Exception $e) {
      echo "Get Value By ID Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Values By Attribute
   *=============================================================
   * @param int $id_attribute
   * @return $data (array)
   * @throws Exception
   */
  public function getValuesByAttribute($id_attribute)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,name FROM "._DB_PREFIX_."attribute_values WHERE id_attribute=$id_attribute";
      if($res = $DB->query($query)){
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data;
      }
    } catch (Exception $e) {
      echo "Get Values By Attribute Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Set Futured Image
   *=============================================================
   * @param int $id_image
   * @param int $id_product
   * @return $true
   * @throws Exception
   */
  public function setFuturedImage($id_image,$id_product)
  {
    try {
      $DB = Database::getInstance();
      $query = "UPDATE "._DB_PREFIX_."product_images SET futured=0 WHERE futured=1 AND id_product=$id_product";
      if($res = $DB->query($query)){
        $query = "UPDATE "._DB_PREFIX_."product_images SET futured=1 WHERE id=$id_image";
        $DB->query($query);
        return true;
      }
    } catch (Exception $e) {
      echo "Set Futured Image Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }
  


/*============================================================*/
} //END PRODUCT CLASS
/*============================================================*/
?>