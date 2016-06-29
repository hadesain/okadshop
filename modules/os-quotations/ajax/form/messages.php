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

include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//get posted data
$id_sender = intval($_POST['id_sender']);
$id_receiver = intval($_POST['id_receiver']);
$id_quotation = intval($_POST['id_quotation']);
if( $id_quotation < 1 || $id_sender < 1 || $id_receiver < 1 ) return;

global $common;
$image_name = "";
$allowed_tags = allowed_tags();
$message = strip_tags($_POST['message'], $allowed_tags);
$objet = addslashes($_POST['objet']);
$emails = explode(",", $_POST['recipient_emails']);

$message_data = array(
	'id_quotation' => $id_quotation,
	'id_sender' => $id_sender,
	'id_receiver' => $id_receiver,
	'recipient_emails' => addslashes($_POST['recipient_emails']),
	'objet' => $objet,
	'message' => $message
);

//attachement
if( isset($_FILES['attachement']) && $_FILES['attachement']['size'][0] > 0 ){
  $uploadDir = "../../../../files/quotatonattachments/". $id_quotation ."/";
  $file_target = $common->uploadImage($_FILES['attachement'], $uploadDir);
  $image_name = str_replace( $uploadDir , '', $file_target[0] );
  if( $image_name != "" ){
  	$message_data['attachement'] = $image_name;
  	$message_data['file_name'] = substr_replace($image_name, "", -4);
  }
}

//prepare email
$headers  = "From:< no-reply@demo.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$Sender   = "no-reply@demo.com";
$subject  = "- ".$objet;
$content  = 'Bonjour,<br><br>';
$content .= $message."<br><br>";
$content .= "Cordialement.";

//proccessing
if( $_POST['email'] ){
	foreach ($emails as $key => $email) {
		mail($email,$subject,$content,$headers);
	}
	$return['msg'] = "Le message a été envoyer par mail.";
	echo json_encode($return);

}elseif( $_POST['acount'] || $_POST['both'] ){

	$save = $common->save('quotation_messages', $message_data);
	if( $save ){
		$row = '<tr id="'.$save.'" role="row" class="even">
							<td>#'.$save.'</td>
							<td>'.$objet.'</td>
							<td>'.$_POST['recipient_emails'].'</td>
							<td>'.$message.'</td>
							<td class="text-center">';
							if($image_name != "" ){
								$row .= '<a download="'.$image_name.'" target="_blank" href="../files/quotatonattachments/'. $id_quotation .'/'.$image_name.'" class="btn btn-primary"><i class="fa fa-download"></i></a>';
							}
						  $row .= '</td>
							<td>
								<a href="javascript:;" class="btn btn-danger delete_msg" title="'. l("Supprimer ce message", "quotation") .'">
						  		<i class="fa fa-trash"></i>
						  	</a>
						  </td>
						</tr>';
		$return['row'] = $row;

		if( $_POST['email'] ){
			$return['msg'] = l("Le message a été envoyer sur le compte client.", "quotation");
			echo json_encode($return);
		}else{
			foreach ($emails as $key => $email) {
				mail($email,$subject,$content,$headers);
			}
			$return['msg'] = l("Le message a été envoyer par mail et sur le compte.", "quotation");
			echo json_encode($return);
		}
	}

}