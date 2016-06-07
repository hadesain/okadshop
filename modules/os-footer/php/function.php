<?php  
	function getFooterMenuByBlock($block = null){
		global $DB;
		$condition = "";
	    try {
	    if ($block != null) {
	    	$condition =  "WHERE block = $block";
	    }
	      $query = "SELECT * FROM "._DB_PREFIX_."footer_menu $condition";
	      $res = $DB->query($query);
	      if ($block != null) {
	      	$res = $res->fetch(PDO::FETCH_ASSOC);
	      }else
	      	$res = $res->fetchAll(PDO::FETCH_ASSOC);
	      
	      return $res;
	    } catch (Exception $e) {
	      return false;
	    }
	}
	function getFooterMenuLinksByBlock($block){
		global $DB;
	    try {
	      $query = "SELECT * FROM "._DB_PREFIX_."footer_menu_links WHERE block = $block ORDER BY position ASC";
	      $res = $DB->query($query);
	      $res = $res->fetchAll(PDO::FETCH_ASSOC);
	      return $res;
	    } catch (Exception $e) {
	      return false;
	    }
	}

	function deleteLinkById($id){
		global $DB;
	    try {
	      $query = "DELETE FROM "._DB_PREFIX_."footer_menu_links WHERE id = $id";
	      $res = $DB->query($query);
	      return true;
	    } catch (Exception $e) {
	      return false;
	    }
	}
?>