<?php header('Content-Type: text/html; charset=utf-8');
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

require_once "../classes/install.class.php";

set_time_limit(120);

$shop = json_decode($_POST['shop'], true);
$user = json_decode($_POST['user'], true);
$database = json_decode($_POST['db'], true);


$user['id_gender'] = 1;
$user['id_lang'] = 1;
$user['active'] = 'actived';

if( empty( $shop ) || empty( $user ) || empty( $database ) ) return;

//prepare database infos
$db = array();
foreach ($database as $key => $d) {
	$db[ $d['name'] ] = $d['value'];
}
$db_server = $db['server'];
$db_name 	 = $db['database'];
$db_user 	 = $db['user'];
$db_pass	 = $db['password'];
$db_prefix = $db['prefix'];


$config = '
define("_DB_SERVER_", "'. $db_server .'");
define("_DB_NAME_", "'. $db_name .'");
define("_DB_USER_", "'. $db_user .'");
define("_DB_PASS_", "'. $db_pass .'");
define("_DB_PREFIX_", "'. $db_prefix .'");
define("_BASE_URL_", "'. $shop['uri'] .'");
';

//connect to database
try {
  $db = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_user, $db_pass);
  if( $db ){
  	
  	//insert database structure
    $os = new Okad_Install();
		$str_file = '../sql/structure.sql';
		$structure = $os->run_sql_file( $str_file, $db_prefix );
    if( $structure ){
      $data_file = '../sql/data.sql';
      $data = $os->run_sql_file( $data_file, $db_prefix );
      if( $data ){

        //insert user admin
        try {
          $user_password = md5($user['password']);

          $stmt = $db->prepare("INSERT INTO ".$db_prefix."users (`id_gender`, `id_country`, `id_lang`, `first_name`, `last_name`, `email`, `password`, `active`,`user_type`) 
                              VALUES (:id_gender, :id_country, :id_lang, :first_name, :last_name, :email, :pass, :active, 'admin')");
          $stmt->bindParam(':id_gender', $user['id_gender']);
          $stmt->bindParam(':id_country', $user['id_country']);
          $stmt->bindParam(':id_lang', $user['id_lang']);
          $stmt->bindParam(':first_name', $user['firstname']);
          $stmt->bindParam(':last_name', $user['lastname']);
          $stmt->bindParam(':email', $user['email']);
          $stmt->bindParam(':pass', $user_password );
          $stmt->bindParam(':active', $user['active']);
          //$stmt->bindParam(':cdate', date('Y-m-d H:s:m'));
          $save_user = $stmt->execute();

          if( $save_user )
          {
            $stmt = $db->prepare("INSERT INTO ".$db_prefix."shop (`id_activity`, `id_country`, `name`, `home_url`) 
                                VALUES (:id_activity, :id_country, :name, :home_url)");
            $stmt->bindParam(':id_activity', $shop['activity']);
            $stmt->bindParam(':id_country', $shop['country']);
            $stmt->bindParam(':name', $shop['name']);
            $stmt->bindParam(':home_url', $shop['home_url']);
            //$stmt->bindParam(':cdate', date('Y-m-d H:s:m'));
            $save_shop = $stmt->execute();
            //write config file
            $write = $os->write_config("../../config/config.inc.php", $config);
            if( $write ){
              
              echo json_encode("done");

            }
          }

        } catch (Exception $e) {
          echo $e->getMessage();
        }

      }
    }

  } 
} catch (PDOException $e) {
	echo $e->getMessage();
}

