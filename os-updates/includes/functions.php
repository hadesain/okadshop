<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
//http://stackoverflow.com/questions/9835492/move-all-files-and-folders-in-a-folder-to-another
// Function to remove folders and files 
function remove_folders($dir) {
  try {
  	if (is_dir($dir)) {
	    $files = scandir($dir);
	    foreach ($files as $file)
	    {
				if ($file != "." && $file != ".."){
					remove_folders("$dir/$file");
				}
	    }
	    chmod($dir, 0750);
			rmdir($dir);
	  }elseif( file_exists($dir) )
	  {
	  	//chown($dir,465);
	  	// Everything for owner, read and execute for owner's group
			chmod($dir, 0750);
	  	unlink($dir);
	  }
	  return true;
  } catch (Exception $e) {
  	return false;
  }
}

// Function to Copy folders and files       
function copy_folders($source, $target) {
  try {
  	//start copping
	  if( is_dir( $source ) )
	  {
	  	//create folders if not exist
	  	if (!file_exists( $target )) {
			  mkdir($target, 0777, true);
			}
			$files = preg_grep('/^([^.])/', scandir($source));
	    //$files = scandir( $source );
	    foreach ( $files as $file )
	    {
	      if($file != "." && $file != "..")
	      {
	        copy_folders( "$source/$file", "$target/$file" );
	      }
	    }
	  }elseif( file_exists( $source ) )
	  {
	  	//Thumbs.db
	    copy( $source, $target );
	  }
  	return true;
  } catch (Exception $e) {
  	return false;
  }
}