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
$return = array();
//echo $website_root;exit;


try {
  
  // Get real path for our folder
  $source = $website_root;
  //$source = "../../../";
  $target = "../../../os-updates/backups/backups_". date("Y_m_d_H_i").".zip";

  // Initialize archive object
  $zip = new ZipArchive();
  $zip->open( $target , ZipArchive::CREATE | ZipArchive::OVERWRITE);

  // Create recursive directory iterator
  /** @var SplFileInfo[] $files */
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source),
    RecursiveIteratorIterator::LEAVES_ONLY
  );

  foreach ($files as $name => $file)
  {
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
      // Get real and relative path for current file
      $filePath = $file->getRealPath();
      $relativePath = substr($filePath, strlen($source) + 1);
      // Add current file to archive
      $zip->addFile($filePath, $relativePath);
    }
  }

  // Zip archive will be created only after closing object
  $zip->close();

  $return['success'] = l("Le sauvegarde a été terminé avec succès.", "os_updates");

} catch (Exception $e) {
  $return['error'] = l("Sauvegarde impossible.", "os_updates") ."<br>". $common->get_exception_error($e);
}

//return a responce
echo json_encode( $return );

