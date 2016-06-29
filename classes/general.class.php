<?php
/**
* 
*/
class general
{
	public function ToId($str){
		$id = explode('-', $str);
		$id = $id[0];
		$Security = new Security();
		if (!$Security->check_numbers($id)) {
			return false;
		}
		return $id;
	}
	public function getCms($id)
	{
		$DB = Database::getInstance();
		$cmsid = self::ToId($id);
		if (!$cmsid) {
			return false;
		}
		try {
	      $sql = "SELECT * FROM "._DB_PREFIX_."cms WHERE id = $cmsid";
	      $res = $DB->query($sql);
	      $res = $res->fetch(PDO::FETCH_ASSOC);
	      $res = self::oslang_migrate_cms($res);
	      return $res;
	    } catch (Exception $e) {
	      return false;
	    }
	}

	public function oslang_migrate_cms($cms,$list = false){
		if (!$cms || empty($cms)) return $cms;
		$tmp = $cms;
		if (!$list){
			$tmp = self::oslang_migrate_cms_table($tmp);
		}else{
			for ($i=0; $i <count($tmp) ; $i++) { 
				$tmp[$i] = self::oslang_migrate_cms_table($tmp[$i]);
			}
		}
		return $tmp;
	}

	public function oslang_migrate_cms_table($cms){
		$tmp = $cms;
		global $hooks;
		if (isset($_SESSION['code_lang'])) {
			$id_cms = $tmp['id'];
			$code_lang = $_SESSION['code_lang'];
			$condition = " WHERE id_cms = ".$id_cms." AND code_lang = '".$code_lang."'";
			//echo $condition;
			$res = $hooks->select('lang_cms',array('*'),$condition);
			if (isset($res[0])) {
				$res = $res[0];
				if (!empty($res['title'])) {
					$tmp['title'] = $res['title'];

				}
				if (!empty($res['description'])) {
					$tmp['description'] = $res['description'];
				}
				if (!empty($res['content'])) {
					$tmp['content'] = $res['content'];
				}
			}
		}
		return $tmp;
	}


	public function getCmsByCatTitle($name){
		$DB = Database::getInstance();
		try {
	      $sql = "SELECT "._DB_PREFIX_."cms.* FROM `"._DB_PREFIX_."cms_categories`, "._DB_PREFIX_."cms  
	      WHERE  cms.id_cmscat = cms_categories.id AND cms_categories.`title` = '$name'";
	      $res = $DB->query($sql);
	      $res = $res->fetchAll(PDO::FETCH_ASSOC);
	      return $res;
	    } catch (Exception $e) {
	      return false;
	    }

	}


	public function getCmsByCatId($id){
		$DB = Database::getInstance();
		try {
	      $sql = "SELECT * FROM "._DB_PREFIX_."cms  
	      WHERE  id_cmscat =  '$id'";
	      $res = $DB->query($sql);
	      $res = $res->fetchAll(PDO::FETCH_ASSOC);
	      return $res;
	    } catch (Exception $e) {
	      return false;
	    }

	}

}