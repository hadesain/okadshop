<?php
class Okad_Install
{
	
	function run_sql_file( $file, $prefix ){
    if( file_exists( $file ) ){
    	global $db;
      $content = file_get_contents($file);
      $query = utf8_decode($content);
      $prefixed_query = str_replace('}','',str_replace('{', $prefix ,$query));
      $stmt = $db->prepare($prefixed_query);
      if( $stmt->execute() ) return true;
    }
    return false;
  }


  function write_config( $filename, $config ) {
    $fh = fopen($filename, "w");
    if (!is_resource($fh)) {
      return false;
    }
    fwrite($fh, '<?php '. print_r($config, true) );
    //fwrite($fh, '<?php $os_config = '. print_r($config, true) );
    fclose($fh);
    return true;
  }


  public function get_json_file($file_path)
  {
    try {
      if( file_exists( $file_path ) ){
        $file_data = file_get_contents( $file_path );
        $data = json_decode( $file_data, true );
        if( !empty( $data ) ) return $data;
        return false;
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }



}