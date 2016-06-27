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


//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
  die();
}

include "../../../config/bootstrap.php";
include "../functions.php";


//return if empty post version
$version = $_POST['version'];
$link = $_POST['link'];
if( $version == "" || $version == _OS_VERSION_ || $link == "" ) return;


global $common;
$return = array();


try {
  
  //get admin directory
  $exclude_dir = array(".", "..", ".htaccess", "classes", "config", "files", "functions", "includes", "index.php", "install", "languages", "modules", "pdf", "robots.txt", "themes", "os-updates");
  $files = $common->get_dir_contents( $website_root, $exclude_dir );
  $admin_dir = "";
  foreach ($files as $key => $full_path) {
    if (preg_match('/adminbar.php$/', $full_path)) {
      $admin_dir = dirname($full_path);
      $admin_dir = str_replace("\\", "/", $admin_dir);
      $admin_dir = str_replace($website_root, "", $admin_dir);
    }
  }
  if( $admin_dir == "" ) return;

  //prepare download url and files distination
  $download_url = trim($link);
  $zip_archive = "../../../os-updates/okadshop_".$version.".zip";

  //download new okadshop version
  file_put_contents($zip_archive, fopen($download_url, 'r'));

  //get the absolute path  and open $zip_archive
  $absolute_path = pathinfo(realpath($zip_archive), PATHINFO_DIRNAME);
  $zip = new ZipArchive;
  $open_zip = $zip->open($zip_archive);

  //extract zip files
  if ($open_zip === TRUE) {

    $zip->extractTo($absolute_path);
    $zip->close();
    unlink($zip_archive);

    //rename admin dir
    $update_dir = "../../../os-updates/okadshop_".$version;
    $ren_admin = rename( $update_dir."/admin", $update_dir."/".$admin_dir);
    if( $ren_admin )
    {

      //delete old website files
      $remove_files = array($admin_dir, "classes", "functions", "includes", "pdf", "index.php");
      foreach ($remove_files as $key => $rem_path) {
        remove_folders( "../../../".$rem_path );
      }


      //copy updates files to root
      $copy_updates = copy_folders($update_dir, "../../../");
      if( $copy_updates ){
        $rem_updates = remove_folders($update_dir);
        if( $rem_updates )
        {
          include "../migrations.php";
          $return['success'] = l("Installation terminée avec success.", "os_updates");
        }
      }

    }else{
      $return['error'] = l("Problème lors de renommage de répertoire administrator.", "os_updates");
    }

  }else {
    $return['error'] = l("Problème lors de l'ouverture de fichier zip.", "os_updates");
  }



} catch (Exception $e) {
  $return['error'] = l("Mise à jour impossible.", "os_updates") ."<br>". $common->get_exception_error($e);
}

//return a responce
echo json_encode( $return );

