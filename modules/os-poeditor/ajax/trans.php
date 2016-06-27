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

//classes
include '../../../modules/os-poeditor/classes/writer.class.php';
include '../../../modules/os-poeditor/classes/entry.class.php';
include '../../../modules/os-poeditor/classes/parser.class.php';



//get posted data
$iso_code = $_POST['iso_code'];
$file_name = $_POST['file_name'];
if( $iso_code == "" || $file_name == "" ) return;

//read file
$parser = new Parser();
$file_path = '../../../languages/locale/'. $iso_code .'/LC_MESSAGES/'. $file_name;
$parser->read( $file_path );
$entries = $parser->getEntriesAsArrays();

//create table rows
$rows = "";
if( !empty($entries) ){
	unset($entries['']);
	foreach ($entries as $entry) {
		$rows .= '<tr>';
			if( $entry['msgid'][0] ){
				$rows .= '<td>'. $entry['msgid'] .'</td>';
			}else{
				$rows .= '<td>'. $entry['msgid'][0] .'</td>';
			}
			$rows .= '<td><input type="text" class="form-control msgstr" value="'. $entry['msgstr'][0] .'"></td>';
			//$rows .= '<td>'. $entry['msgstr'][0] .'</td>';
		$rows .= '</tr>';
	}
}
echo $rows;