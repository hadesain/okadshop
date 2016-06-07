<?php  

function import_table_json($WebSite){
	$tableToImport = array('category_lang_custom' ,'attachment_lang_custom','cms_lang_custom', 'cms_category','attribute','attribute_group','attribute_group_lang','attribute_group_shop','attribute_impact','attribute_lang',  'attribute_shop','product_attribute','product_attribute_combination','product_attribute_image','product_attribute_shop','lang','category_product','product','product_attribute','category_lang','product_lang','image','image_lang','tax_rule','tax','tax_lang','manufacturer','attachment','tag','product_tag','cms_category_lang','cms_lang','cms');
	//$tableToImport = array('attribute');
	$jsondir = dirname(__DIR__).'/php/';
	foreach ($tableToImport as $value) {
		$link = WebSite.'/okadshop.php?table='.$value;
		$res = getJsonFromLink($link);

		$filename = $jsondir ."files/ps_".$value.'.json';
		pto_saveFile($filename,$res);
	}/**/
	/*$link = WebSite.'/okadshop.php?getPREFIX=1';
	$prefix = getJsonFromLink($link);

	$query = "SELECT cl.`id_category`,cl.`id_lang` ,cl.`name`,cl.`description`,cl.`link_rewrite`,c.id_parent,c.position,c.date_add,c.date_upd FROM `ps_category_lang` cl, `ps_category` c  WHERE c.`id_category` = cl.`id_category`";
	$res = getJsonByQuery(WebSite,$query);
	$filename = $jsondir ."files/ps_category_lang_custom.json";
	pto_saveFile($filename,$res);
	

	$query = "SELECT *  FROM `ps_product_attachment`pa,  `ps_attachment` a ,ps_attachment_lang al WHERE pa.`id_attachment` = a.`id_attachment` AND a.`id_attachment` = al.`id_attachment` ";
	$res = getJsonByQuery(WebSite,$query);
	$filename = $jsondir ."files/ps_attachment_lang_custom.json";
	var_dump($res);
	pto_saveFile($filename,$res);

	$query = "SELECT cl.*,c.`id_cms_category`  FROM `ps_cms_lang` cl, `ps_cms` c  WHERE cl.`id_cms` = c.`id_cms`";
	$res = getJsonByQuery(WebSite,$query);
	$filename = $jsondir ."files/ps_cms_lang_custom.json";
	pto_saveFile($filename,$res);*/


	return true;

}

function pto_saveFile($filename,$content){
	$fh = fopen($filename, 'w');
	// Ouvre un fichier pour lire un contenu existant
	$current = file_get_contents($filename);
	// Écrit le résultat dans le fichier
	file_put_contents($filename, $content);
}
function getJsonByQuery($WebSite,$query){
	$link = $WebSite.'/okadshop.php?query='.$query;
	$res = getJsonFromLink($link);
	return $res;
}
function getJsonFromLink($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }

function rmdir_recursive($dir)
{
 //Liste le contenu du répertoire dans un tableau
 $dir_content = scandir($dir);
 //Est-ce bien un répertoire?
 if($dir_content !== FALSE){
  //Pour chaque entrée du répertoire
  foreach ($dir_content as $entry)
  {
   //Raccourcis symboliques sous Unix, on passe
   if(!in_array($entry, array('.','..'))){
    //On retrouve le chemin par rapport au début
    $entry = $dir . '/' . $entry;
    //Cette entrée n'est pas un dossier: on l'efface
    if(!is_dir($entry)){
     unlink($entry);
    }
    //Cette entrée est un dossier, on recommence sur ce dossier
    else{
     rmdir_recursive($entry);
    }
   }
  }
 }
 //On a bien effacé toutes les entrées du dossier, on peut à présent l'effacer
 rmdir($dir);
}

function createDir($dir){
	if (!file_exists($dir)) {
		mkdir($dir, 777);
	}
}
function prestashop_import_files(){

	$prestashop_dir = dirname(__DIR__) .'/php/prestashop/';

	rrmdir('../files/attachments');
	rrmdir('../files/category');
	rrmdir('../files/cms');
	rrmdir('../files/products');

	createDir('../files/attachments');
	createDir('../files/category');
	createDir('../files/cms');
	createDir('../files/products');


	recurse_copy($prestashop_dir.'attachments','../files/attachments');
	recurse_copy($prestashop_dir.'category','../files/category');
	recurse_copy($prestashop_dir.'cms','../files/cms');
	recurse_copy($prestashop_dir.'products','../files/products');

	

	$file = $prestashop_dir .'sqlfile.sql';
	$tables = array(
						'product_associated',
						'categories',
						'product_attachments',
						'cms',
						'product_declinaisons',
						'declinaisons',
						'product_attributes',
						'attribute_values',
						'attributes',
						'cms_categories',
						'product_category',
						'products',
						'tags',
						'product_tags',
						'langs',
						'product_images',
						);
	foreach ($tables as $key => $value) {
		deleteTableByName($value);
	}
	run_sql_file( $file );
}

function run_sql_file( $file ){
    if( file_exists( $file ) ){
      global $DB;
      $query = file_get_contents( $file );
      $stmt  = $DB->prepare($query);
      if( $stmt->execute() ) return true;
    }
    return false;
  }

function recurse_copy($src,$dst,$acceptedsize = null) {
	if (!file_exists($src)) {
		return;
	}
  $dir = opendir($src); 
  @mkdir($dst); 
  while(false !== ( $file = readdir($dir)) ) { 
      if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.htaccess' ) && ( $file != 'index.php' ) && ( $file != 'Thumbs.db' )) { 
          if ( is_dir($src . '/' . $file) ) { 
              recurse_copy($src . '/' . $file,$dst . '/' . $file); 
          } 
          else { 
              
            if ($acceptedsize != null) {
              $sizeName = explode('-', $file);
              $sizeName = end($sizeName);
              if (in_array($sizeName,$acceptedsize)) {
               copy($src . '/' . $file,$dst . '/' . $file);

              }
            }else
              copy($src . '/' . $file,$dst . '/' . $file);  
          } 
      } 
  } 
  closedir($dir); 
}

function prestashop_import_table(){
	$json = array();
	$tablesimport = array();
	$ret = 0;
	try {
		pto_import_category();//
		$tablesimport[]  = "categories";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}
	
	try {
		$jsondir = dirname(__DIR__).'/php/';
		$category_dir = $jsondir .'/category';
		listcatFiles($category_dir);//
		$tablesimport[]  = "categories images";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}
	

/*

try {
		pto_import_products();//
		$tablesimport[]  = "Produits";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}




	
	
	
	


	try {
		pto_import_tags();//
		$tablesimport[]  = "tags";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	try {
		pto_import_lang();//
		$tablesimport[]  = "lang";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	try {
		pto_import_cms(); //
		$tablesimport[]  = "cms";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	try {
		pto_import_declinisans(); //
		$tablesimport[]  = "declinisans";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	

	try {
		pto_import_attachements();//
		$tablesimport[]  = "attachment";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	

	

	try {
		pto_import_accessory();//
		$tablesimport[]  = "accessory";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}

	try {
		pto_import_images(); // listFolderFiles *
		$tablesimport[]  = "images";
		$ret++;
	} catch (Exception $e) {
		echo $e;
	}
	*/

	/*
	pto_import_tags();
	pto_import_products();
	pto_import_category();
	pto_import_lang();
	pto_import_cms();
	pto_import_declinisans();
	pto_import_images();
	pto_import_attachements();
	*/

	


	if ($ret == 0 ) {
		return false;
	}else 
		return $tablesimport;
	
}

function pto_import_accessory(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$jsondir = dirname(__DIR__).'/php/';

	$json = array();
	if (!file_exists($jsondir."files/ps_accessory.json")) {
		return;
	}
	$json['ps_accessory'] = file_get_contents($jsondir."files/ps_accessory.json");
	$ps_accessory  = json_decode($json['ps_accessory'],true);

	
	$query = "INSERT INTO `"._DB_PREFIX_."product_associated` (`id_product`, `associated_with`, `cdate`) VALUES ";
	$query_line  = "";
	foreach ($ps_accessory as $key => $accessory) {
		$query_line .= " (".$accessory['id_product_1'].",".$accessory['id_product_2'].",now()),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);
}


function getProductIdByImage($name){
	$jsondir = dirname(__DIR__).'/php/';
    $json['ps_image'] = file_get_contents($jsondir."files/ps_image.json");
    $ps_image  = json_decode($json['ps_image'],true);
    $res =  pto_search($ps_image, 'id_image', $name);
    return $res[0]['id_product'];

}

function pto_import_attachements(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	deleteTableByName('product_attachments');
	$jsondir = dirname(__DIR__).'/php/';
	
	$json = array();
	$json['ps_attachment_lang_custom'] = file_get_contents($jsondir."files/ps_attachment_lang_custom.json");
	$ps_attachment_lang_custom  = json_decode($json['ps_attachment_lang_custom'],true);

	$query = "INSERT INTO `"._DB_PREFIX_."product_attachments` (`name`, `slug`, `description`, `attachment`, `id_product`, `cdate`) VALUES ";
	$query_line  = "";
	$error = true;
	if (!file_exists($jsondir."attachments/")) {
	    mkdir($jsondir."attachments/", 0777, true);
	}
	foreach ($ps_attachment_lang_custom as $key => $attachment) {
		$old_file = $jsondir."download/". $attachment['file'];
		$new_file = $jsondir."attachments/". $attachment['file_name'];

		$slug = str_replace(' ', '-',  strtolower($attachment['name']));
		//echo $attachment['file_name'].'<br>';
		if (file_exists($old_file)) {
			$error = false;
	/*		echo $old_file."<br>";
			echo $old_file."<br>";
			die();*/
			if(copy($old_file, $new_file)){
				$query_line .= " ('".$attachment['name']."','".$slug."','".$attachment['description']."','".$attachment['file_name']."',".$attachment['id_product'].",now()),";
			}
			//rename($old_file , $new_file);
			
		}	
	}
	if (!$error) {
		$query_line = $query . rtrim($query_line ,',');
		$DB->query($query_line);
	}
}

function listcatFiles($dir){
	global $DB;
    $ffs = scandir($dir);
    $i = 0;
    $list = array();
    foreach ( $ffs as $ff ){
        if ( $ff != '.' && $ff != '..' ){
            if ( strlen($ff)>=5 ) {
                if ( substr($ff, -4) == '.jpg' ) {
                    $list[] = $ff;
                    $path = $dir.'/'.$ff;
                   	if (strpos($ff,'-') || strpos($ff,'_')) {
                      continue;
                   	}

                    $id_product = explode('.', $ff);
                    $id_product = intval($id_product[0]);
                    $query ="UPDATE `"._DB_PREFIX_."categories` SET `image_cat` ='$ff' WHERE `id` = $id_product";
                    $DB->query($query);

                    $i++;
                }    
            }       
        }
    }
    return $i;
}

function deleteTableByName($table){
	global $DB;
	
	$query = "DELETE FROM "._DB_PREFIX_."$table";
	$DB->query($query);
	return true;
}
function pto_import_products(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	deleteTableByName('products');

	$jsondir = dirname(__DIR__).'/php/';
	$json['ps_product'] = file_get_contents($jsondir."files/ps_product.json");
	$ps_product  = json_decode($json['ps_product'],true);

	$json['ps_product_lang'] = file_get_contents($jsondir."files/ps_product_lang.json");
	$ps_product_lang  = json_decode($json['ps_product_lang'],true);

	$query = "INSERT INTO `"._DB_PREFIX_."products` (`id`, `name`, `permalink`, `short_description`, `long_description`, `buy_price`, `sell_price`, `qty`, `ean13`, `upc`, `active`, `cdate`, `udate`, `id_lang`, `reference`,id_user,id_category_default,width,height, depth,weight,min_quantity,meta_title,meta_description,wholesale_per_qty,wholesale_price) VALUES ";
	$query_line = "";
	foreach ($ps_product as $key => $product) {
		$pid =  $product['id_product'];
		$quantity = $product['quantity'];
		$price = $product['price'];
		$reference = $product['reference'];
		$ean13 = $product['ean13'];
		$upc = $product['upc'];
		$active = $product['active'];
		$date_add = $product['date_add'];
		$date_upd = $product['date_upd'];
		$wholesale_price = $product['unit_price_ratio'] * $price;
		$buy_price = $product['wholesale_price'];
		$def_cat = $product['id_category_default'];



		//find in ps_product_lang
		$product_lang = pto_search($ps_product_lang, 'id_product', $pid);
		//var_dump($product_lang);
		if (!isset($product_lang['id_lang'])) {
			$product_lang= $product_lang[0];
		}
		$id_lang = $product_lang['id_lang'];
		$description = strip_tags($product_lang['description'], $allowed_tags);
		$description_short = strip_tags($product_lang['description_short'], $allowed_tags);
		$name = strip_tags($product_lang['name'], $allowed_tags);
		$meta_des = strip_tags($product_lang['meta_description'], $allowed_tags);
		$meta_title = strip_tags($product_lang['meta_title'], $allowed_tags);

		$description = addslashes($product_lang['description']);
		$description_short = addslashes($product_lang['description_short']);
		$link_rewrite = addslashes($product_lang['link_rewrite']);
		$name = addslashes($product_lang['name']);
		$meta_des = addslashes($product_lang['meta_description']);
		$meta_title = addslashes($product_lang['meta_title']);



		$query_line .= " ($pid,'$name','$link_rewrite','$description_short','$description',$buy_price,$price,$quantity,'$ean13','$upc',$active,'$date_add','$date_upd','$id_lang','$reference',1,$def_cat,".$product['width'].",".$product['height'].",".$product['depth'].",".$product['weight'].",".$product['minimal_quantity'].",'".$meta_title."','".$meta_des."','".$product['unity']."',".$wholesale_price."),";

	}

	$query_line = $query . rtrim($query_line ,',');

	$DB->query($query_line);

}

function pto_import_declinisans(){
	global $DB;
	$jsondir = dirname(__DIR__).'/php/';
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$json['ps_product_attribute_combination'] = file_get_contents($jsondir."files/ps_product_attribute_combination.json");
	$ps_product_attribute_combination  = json_decode($json['ps_product_attribute_combination'],true);
	

	$json['ps_attribute'] = file_get_contents($jsondir."files/ps_attribute.json");
	$ps_attribute  = json_decode($json['ps_attribute'],true);

	deleteTableByName('product_declinaisons');
	$query = "INSERT INTO `"._DB_PREFIX_."product_declinaisons`(`id_declinaison`, `id_attribute`, `id_value`) VALUES  ";
	$query_line = "";
	foreach ($ps_product_attribute_combination as $key => $product_attribute_combination) {
		$id_attribute_group = pto_search($ps_attribute, 'id_attribute', $product_attribute_combination['id_attribute']);
		if (!isset($id_attribute_group[0])) {
			continue;
		}
		$id_attribute_group = $id_attribute_group[0];
		$query_line .= " (".$product_attribute_combination['id_product_attribute'].",".$id_attribute_group['id_attribute_group'].",".$product_attribute_combination['id_attribute']."),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);


	$json['ps_product_attribute'] = file_get_contents($jsondir."files/ps_product_attribute.json");
	$ps_product_attribute  = json_decode($json['ps_product_attribute'],true);
	
	deleteTableByName('declinaisons');
	$query = "INSERT INTO `"._DB_PREFIX_."declinaisons` (`id`, `id_product`,  `reference`) VALUES  ";
	$query_line = "";
	foreach ($ps_product_attribute as $key => $product_attribute) {
		$query_line .= " (".$product_attribute['id_product_attribute'].",".$product_attribute['id_product'].",'".$product_attribute['reference']."'),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	$DB->query("UPDATE `"._DB_PREFIX_."declinaisons` d SET cu = (SELECT GROUP_CONCAT(concat(pd.`id_attribute`,':',pd.`id_value`) SEPARATOR  ',' ) as cu FROM `product_declinaisons` pd WHERE pd.`id_declinaison` = d.id)");


	$json['ps_attribute_impact'] = file_get_contents($jsondir."files/ps_attribute_impact.json");
	$ps_attribute_impact  = json_decode($json['ps_attribute_impact'],true);
	
	$json['ps_attribute'] = file_get_contents($jsondir."files/ps_attribute.json");
	$ps_attribute  = json_decode($json['ps_attribute'],true);
	deleteTableByName('product_attributes');
	$query = "INSERT INTO `"._DB_PREFIX_."product_attributes`(`id`, `id_product`, `id_attribute`, `id_value`) VALUES ";
	$query_line = "";
	foreach ($ps_attribute_impact as $key => $attribute_impact) {
		$id_attribute_group = pto_search($ps_attribute, 'id_attribute', $attribute_impact['id_attribute']);
		if (!isset($id_attribute_group[0])) {
			continue;
		}
		$id_attribute_group = $id_attribute_group[0];
		$query_line .= " (".$attribute_impact['id_attribute_impact'].",".$attribute_impact['id_product'].",".$id_attribute_group['id_attribute_group']." ,".$attribute_impact['id_attribute']."),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);



	$json['ps_attribute_lang'] = file_get_contents($jsondir."files/ps_attribute_lang.json");
	$ps_attribute_lang  = json_decode($json['ps_attribute_lang'],true);
	
	$json['ps_attribute'] = file_get_contents($jsondir."files/ps_attribute.json");
	$ps_attribute  = json_decode($json['ps_attribute'],true);
	deleteTableByName('attribute_values');
	$query = "INSERT INTO `"._DB_PREFIX_."attribute_values`(`id`, `name`, `id_attribute` , `id_lang`) VALUES ";
	$query_line = "";
	foreach ($ps_attribute_lang as $key => $attribute_lang) {
		$id_attribute_group = pto_search($ps_attribute, 'id_attribute', $attribute_lang['id_attribute'])[0];
		$query_line .= " (".$attribute_lang['id_attribute'].",'".addslashes($attribute_lang['name'])."',".$id_attribute_group['id_attribute_group']." ,".$attribute_lang['id_lang']."),";
	}
	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	$json['ps_attribute_group_lang'] = file_get_contents($jsondir."files/ps_attribute_group_lang.json");
	$ps_attribute_group_lang  = json_decode($json['ps_attribute_group_lang'],true);
	deleteTableByName('attributes');
	$query = "INSERT INTO `"._DB_PREFIX_."attributes`(`id`, `name`, `id_lang`) VALUES ";
	$query_line = "";
	foreach ($ps_attribute_group_lang as $key => $attribute_group_lang) {
		$query_line .= " (".$attribute_group_lang['id_attribute_group'].",'".addslashes($attribute_group_lang['name'])."',".$attribute_group_lang['id_lang']."),";
	}


	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

}

function pto_import_cms(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';

	$jsondir = dirname(__DIR__).'/php/';
	$json['ps_cms_lang_custom'] = file_get_contents($jsondir."files/ps_cms_lang_custom.json");
	$ps_cms_lang_custom  = json_decode($json['ps_cms_lang_custom'],true);
	deleteTableByName('cms');
	$query = "INSERT INTO `"._DB_PREFIX_."cms` (id,`title`, `description`, `content`, `id_cmscat`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES ";
	$query_line = "";
	foreach ($ps_cms_lang_custom as $key => $cms) {

		$cms['meta_title'] = strip_tags($cms['meta_title'], $allowed_tags);
		$cms['meta_description'] = strip_tags($cms['meta_description'], $allowed_tags);
		$cms['content'] = strip_tags($cms['content'], $allowed_tags);
		$cms['meta_keywords'] = strip_tags($cms['meta_keywords'], $allowed_tags);
		$cms['link_rewrite'] = strip_tags($cms['link_rewrite'], $allowed_tags);



		$cms['meta_title'] = addslashes($cms['meta_title']);
		$cms['meta_description'] = addslashes($cms['meta_description']);
		$cms['content'] = addslashes($cms['content']);
		$cms['meta_keywords'] = addslashes($cms['meta_keywords']);
		$cms['link_rewrite'] = addslashes($cms['link_rewrite']);

		$query_line .= " (".$cms['id_cms'].", '".$cms['meta_title']."','".$cms['meta_description']."','".$cms['content']."',".$cms['id_cms_category'].",'".$cms['meta_keywords']."','".$cms['link_rewrite']."',".$cms['id_lang'].",now()),";
	}


	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);
}



function pto_import_category(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$jsondir = dirname(__DIR__).'/php/';

	$json['ps_cms_category_lang'] = file_get_contents($jsondir."files/ps_cms_category_lang.json");
	$ps_cms_category_lang  = json_decode($json['ps_cms_category_lang'],true);

	deleteTableByName('cms_categories');
	$query = "INSERT INTO `"._DB_PREFIX_."cms_categories` (`id`, `title`, `description`,`keywords`,`permalink`,`id_lang` ,`cdate`) VALUES ";
	$query_line = "";
	foreach ($ps_cms_category_lang as $key => $cat) {

		$cat['name'] = strip_tags($cat['name'], $allowed_tags);
		$cat['meta_description'] = strip_tags($cat['meta_description'], $allowed_tags);
		$cat['meta_keywords'] = strip_tags($cat['meta_keywords'], $allowed_tags);
		$cat['link_rewrite'] = strip_tags($cat['link_rewrite'], $allowed_tags);

		$cat['name'] = addslashes($cat['name']);
		$cat['meta_description'] = addslashes($cat['meta_description']);
		$cat['meta_keywords'] = addslashes($cat['meta_keywords']);
		$cat['link_rewrite'] = addslashes($cat['link_rewrite']);

		$query_line .= " (".$cat['id_cms_category'].",'".$cat['name']."','".$cat['meta_description']."','".$cat['meta_keywords']."','".$cat['link_rewrite']."',".$cat['id_lang'].",now()),";
	}


	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	$json['ps_category_product'] = file_get_contents($jsondir."files/ps_category_product.json");
	$ps_category_product  = json_decode($json['ps_category_product'],true);

	deleteTableByName('product_category');
	$query = "INSERT INTO `"._DB_PREFIX_."product_category`(`id_product`, `id_category`, `cdate`) VALUES ";
	$query_line = "";
	foreach ($ps_category_product as $key => $cat) {
		$query_line .= " (".$cat['id_product'].",".$cat['id_category'].",now()),";
	}


	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	deleteTableByName('categories');
	$query = "INSERT INTO `"._DB_PREFIX_."categories`(`id`, `name`, `permalink`, `cdate`, `udate`, `id_lang`, `parent`, `description`,position , meta_title,meta_description,meta_keywords) VALUES ";
	$query_line = "";


	$json['ps_category_lang_custom'] = file_get_contents($jsondir."files/ps_category_lang_custom.json");
	$ps_category_lang_custom  = json_decode($json['ps_category_lang_custom'],true);
	

	foreach ($ps_category_lang_custom as $key => $cat) {

		$cat['name'] = strip_tags($cat['name'], $allowed_tags);
		$cat['description'] = strip_tags($cat['description'], $allowed_tags);

		$cat['meta_title'] = strip_tags($cat['meta_title'], $allowed_tags);
		$cat['meta_description'] = strip_tags($cat['meta_description'], $allowed_tags);
		$cat['description'] = strip_tags($cat['description'], $allowed_tags);

		$cat['name'] = addslashes($cat['name']);
		$cat['description'] = addslashes($cat['description']);
		$cat['meta_keywords'] = addslashes($cat['meta_keywords']);

		$cat['meta_title'] = addslashes($cat['meta_title']);
		$cat['meta_description'] = addslashes($cat['meta_description']);
		$cat['meta_keywords'] = addslashes($cat['meta_keywords']);


		$query_line .= " (".$cat['id_category'].",'".$cat['name']."','".$cat['link_rewrite']."','".$cat['date_add']."','".$cat['date_upd']."',".$cat['id_lang'].",".$cat['id_parent'].",'".$cat['description']."',".$cat['position'].",'".$cat['meta_title']."','".$cat['meta_description']."','".$cat['meta_keywords']."'),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	
	/*$query_line = "";
	foreach ($ps_category_lang_custom as $key => $cat) {
		$query_line .= " when id = ".$cat['id_category'] ." then ".$cat['position'];
	}

	$query_line = "UPDATE `categories` SET position  = (case ".$query_line.' end)';
	$DB->query($query_line);*/

	


}

function pto_import_images(){
	global $DB;
	$jsondir = dirname(__DIR__).'/php/';
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$json['ps_image'] = file_get_contents($jsondir."files/ps_image.json");
	$ps_image  = json_decode($json['ps_image'],true);

	deleteTableByName('product_images');
	$query = "INSERT INTO `"._DB_PREFIX_."product_images`(`name`, `position`, `id_product`, `cdate`,futured) VALUES ";
	$query_line = "";
	foreach ($ps_image as $key => $image) {
		if ($image['cover'] == null) {
			$image['cover'] = 0;
		}
		$query_line .= " ('".$image['id_image'].".jpg',".$image['position'].",".$image['id_product'].",now(),".$image['cover']."),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	listFolderFiles($jsondir.'p');
}

function pto_import_lang(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$jsondir = dirname(__DIR__).'/php/';
	$json['ps_lang'] = file_get_contents($jsondir."files/ps_lang.json");
	$ps_lang  = json_decode($json['ps_lang'],true);
	deleteTableByName('langs');
	$query = "INSERT INTO `"._DB_PREFIX_."langs`(`id`, `code`, `name`) VALUES ";
	$query_line = "";
	foreach ($ps_lang as $key => $lang) {
		$query_line .= " (".$lang['id_lang'].",'".$lang['language_code']."','".$lang['name']."'),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);
}

function pto_import_tags(){
	global $DB;
	$allowed_tags = '<strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre>';
	$jsondir = dirname(__DIR__).'/php/';
	$json['ps_product_tag'] = file_get_contents($jsondir."files/ps_product_tag.json");
	$ps_product_tag  = json_decode($json['ps_product_tag'],true);

	$json['ps_tag'] = file_get_contents($jsondir."files/ps_tag.json");
	$ps_tag  = json_decode($json['ps_tag'],true);
	deleteTableByName('tags');
	$query = "INSERT INTO `"._DB_PREFIX_."tags` (`id`,`name`,  `id_lang`, `cdate`) VALUES ";
	$query_line = "";
	foreach ($ps_tag as $key => $tag) {
		$tag['name'] = strip_tags($tag['name'], $allowed_tags);
		$tag['name'] = addslashes($tag['name']);
		$query_line .= " (".$tag['id_tag'].",'".$tag['name']."',".$tag['id_lang'].",now()),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);

	deleteTableByName('product_tags');
	$query = "INSERT INTO `"._DB_PREFIX_."product_tags`(`id_tag`, `id_product`, `cdate`) VALUES ";
	$query_line = "";
	foreach ($ps_product_tag as $key => $tag) {
		$query_line .= " (".$tag['id_tag'].",".$tag['id_product'].",now()),";
	}

	$query_line = $query . rtrim($query_line ,',');
	$DB->query($query_line);
}

function pto_search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, pto_search($subarray, $key, $value));
        }
    }

    return $results;
}


function listFolderFiles($dir){
    $ffs = scandir($dir);
    $jsondir = dirname(__DIR__).'/php/';
    $i = 0;
    $list = array();
    foreach ( $ffs as $ff ){
        if ( $ff != '.' && $ff != '..'){
            if (strlen($ff)>=5 ) {
                if ( substr($ff, -4) == '.jpg' ) {
                    // $list[] = $ff;
                    $path = $dir.'/'.$ff;
                    $tmp = explode('-', $ff);
                    $name = explode('.', $tmp[0]);
                    $name  = $name[0];
                    if (is_numeric($name)   && (strpos($ff, '-home.jpg') || strpos($ff, '-medium.jpg') ||  strpos($ff, '-large.jpg') ||  strpos($ff, '-small.jpg'))) {
                        $newImgName = "";
                        $id_product = getProductIdByImage($name);
                        if (count($tmp) == 1) {
                            $newImgName = $ff;
                        }else if (count($tmp) == 2){
                            $sizeName = end($tmp);
                            
                            switch ($sizeName){
                                case 'small.jpg':
                                    $newImgName = $name.'-45x45.jpg';
                                   break;
                                case 'medium.jpg':
                                    $newImgName = $name.'-80x80.jpg';
                                   break;
                                case 'home.jpg':
                                    $newImgName = $name.'-200x200.jpg';
                                   break;
                                case 'large.jpg':
                                    $newImgName = $name.'-360x360.jpg';
                                   break;
                            }
                        }
                        
                        if (isset($newImgName) && $newImgName !="") {
                            $dirP = $jsondir.'products/'.$id_product;
                           /* echo $newImgName.'<br>';
                            echo $path.'<br><br>';
                            echo $dirP.'/'.$newImgName;*/
                            if (!file_exists($dirP)) {
                                mkdir($dirP, 0777, true);
                            }
                           
                            copy($path, $dirP.'/'.$newImgName);
                            //exit();
                        }
                    }
                }    
            }       
            if(is_dir($dir.'/'.$ff)) 
                    listFolderFiles($dir.'/'.$ff);
        }
    }
    return $list;
}
?>