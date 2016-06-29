<?php

class Common{


	/**
   * @param string $table
   * @param array  $data
   * @param array  $exclude
   * @throws Exception
   */
  public function save($table, $data, $exclude = array()) {
    try {
      $fields = $values = array();
      if( !is_array($exclude) ) $exclude = array($exclude);
      //Add Created date to data
      $data['cdate'] = date('Y-m-d H:s:m');
      foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
          $fields[] = "`$key`";
          $values[] = "'" . $data[$key] . "'";
        }
      }
      // Set fields and values
      $fields = implode(",", $fields);
      $values = implode(",", $values);
      //Start saving data
      $DB = Database::getInstance();
      $query = "INSERT INTO ". _DB_PREFIX_ .$table."(".$fields.") VALUES(".$values.")";
      if($DB->query($query)){
        $id_product = $DB->lastInsertId();
        return $id_product;
      }
    } catch (Exception $e) {
      return false;
    }
  }


  function deleteData($table,$condition=""){
    try {
      $DB = Database::getInstance();
      $query = "DELETE from "._DB_PREFIX_."$table $condition";
      $stm = $DB->prepare($query);
      $stm->execute();
      return $stm->rowCount();
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * @param string $table
   * @param array $params
   * @param string $condition
   * @return int
   * @throws Exception
   */
  function update($table,$params,$condition="") {
    try {
      //Create SQL from Params
      $param_string = '';
      //Add Updated date to params
      foreach ($params as $key => $param) {
        $param_string .= $key.'=:'.$key.',';
      }

      $param_string =  rtrim($param_string, ',');
      //Update Table
      $DB = Database::getInstance();
      $query = 'UPDATE '. _DB_PREFIX_ . $table.' SET '.$param_string.' '.$condition;
      $stm = $DB->prepare($query);
      //Bind Params
      foreach($params as $param => &$value) {
        $stm->bindParam($param, $value);
      }
      //Execute
      $stm->execute();
      return $stm->rowCount();
    } catch (Exception $e) {
      return false;
    }
  }


  /**
   * Multiple Files Uploader
   * @param array $files
   * @param string $uploadDir
   * @param array  $extensions
   * @return $files || $errors
   */
  public function uploadFiles($files,$uploadDir,$extensions=array('jpg', 'jpeg', 'png', 'gif'))
  {
    //Create directory if not exist
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    //Start uploading files
    $uploader = new Uploader();
    $data = $uploader->upload($files, array(
      'limit' => 10, //Maximum Limit of files. {null, Number}
      'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
      'extensions' => $extensions, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
      'required' => false, //Minimum one file is required for upload {Boolean}
      'uploadDir' => $uploadDir, //Upload directory {String}
      'title' => null, //New file name {null, String, Array} *please read documentation in README.md
      'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
      'perms' => null, //Uploaded file permisions {null, Number}
      'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
      'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
      'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
      'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
      'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
      //'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
    if($data['hasErrors']){
      //$errors = $data['errors'];
      return false;
    }
    if($data['isComplete']){
      $files = $data['data']['files'];
      return $files;
    }
  }


  /**
   * File Crop
   * @param string $uploadDir
   * @param string $filename
   * @param array  $sizes
   * @param int    $quality
   * @return true
   */
  public function cropFile($uploadDir,$filename,$sizes=null,$quality=100)
  {
    //Vars
    $ext      = pathinfo($filename, PATHINFO_EXTENSION);
    $title    = explode('.'.$ext, $filename);
    $path     = getcwd().'/'.$uploadDir;
    $fullpath = $path.'/'.$filename;
    //Defauls Sizes
    if($sizes == null) $sizes = array('200x200','80x80');
    //Check if file exist
    $crop = new resize($fullpath);
    if(file_exists($fullpath)){
      foreach ($sizes as $key => $size) {
        $size = explode("x", $size);
        $crop->resizeImage($size[0], $size[1], 'crop');
        $crop->saveImage($path.'/'.$title[0].'-'.$size[0].'x'.$size[1].'.'.$ext, $quality);
      }
    }
  }


  /**
   * URL Slugify
   * @param string $text
   * @return $text
   */
  public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text))
    {
      return 'n-a';
    }
    return $text;
  }




	public function UList($table,$fields,$limit,$order,$where,$join){
		$DB = Database::getInstance();
		/*
		params of this function
		$table = name of table
		$fields : array , format : $fields = array('*'), format : $fields = array('field1','field1','field1',..)
		$limit = array($start,$end) ex : select * from $table limit $limit[0],$limit[0]
		
		$where : array = format $where = array('where1'=>array('fieldname','value'),'where2'=>array('fieldname','value'),xxx) ex  
		$order = filed name
		$join  : array(array(table,field1,field2),array(table,field1,field2),x) 
		*/

		//var_dump($where);
		if(!empty($where))
		{
			foreach($where as $where_el)
			{
				echo 1;
				echo $where_el;
				$this->where = $where_el;
			}
		}else{
			$this->where = '';
		}

		$this->table = $table;
		$this->limit = $limit;
		$this->order = $order[0];
		$this->fields = $fields;

		foreach($fields as $field)
		{
			$this->sql_fields .= ",$field";
		}

		foreach($join as $join_e => $join_k)
		{
			//var_dump($join_k);
			$this->sql_join = "$join_k[0] join $join_k[1] on ($join_k[2] = $join_k[1].$join_k[3]) ";
		}
		$this->sql_fields = substr($this->sql_fields, 1 );

		//$this->join = $join;
		
		$sql = 'select '.$this->sql_fields.' from '.$this->table.' '.$this->sql_join.' where 1=1 '.$this->where.' order by '.$this->order.' limit '.$this->limit[0].','.$this->limit[1];
		//var_dump($sql);
		return $DB->query($sql)->fetchAll();
	}



}
?>