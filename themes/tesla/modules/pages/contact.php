<?php  

/*$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'user@example.com';                 // SMTP username
$mail->Password = 'secret';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('from@example.com', 'Mailer');
$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->addAttachment('files/attachments/ag.png');         // Add attachments
$mail->addAttachment('files/attachments/ag.png', 'new.png');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}





die();*/
global $_CONFIG;
$id_lang = $_CONFIG['lang'];
$contact_trans = $hooks->select('contact_trans',array('*'),'WHERE id_lang = '.$id_lang);
$send_msg = "";

if (isset($_POST['submitContact'])) {
	$contact_Receiver = $hooks->select('contact',array('*'),'WHERE id = '.$_POST['objet']);

	if (isset($contact_Receiver[0]['email'])) {
		$contact_Receiver = $contact_Receiver[0];
	}else
		$contact_Receiver = null;

	$data = array(
			"Receiver" => $contact_Receiver['email'],
			"Sender" => $_POST['email'],
			"reference" => $_POST['reference'],
			"message" => $_POST['message'],
			);
	$attachement_file = "";
	$attachement = "";

	if ( isset($contact_Receiver['save_msg']) && $contact_Receiver['save_msg'] == "1") {
		$contact_messages_data = array(
							"email" => $data['Sender'],
							"receiver" => $data['Receiver'],
							"id_receiver" => 1,
							"message" => $data['message'],
							"object" => 'Référence de commande :'. $data['reference']
							);
		$resMSG = $hooks->save('contact_messages',$contact_messages_data);
		if ($resMSG && isset($_FILES['attachement']) && $_FILES['attachement']['size']>0) {
			$allowed =  array('gif','png' ,'jpg','pdf','doc','docx');
			$filename = $_FILES['attachement']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed) ) {
			  	$uploaddir = ROOTPATH."files/attachments/contact/$resMSG/";

				if (!file_exists($uploaddir)) {
				    mkdir($uploaddir, 0777, true);
				}

				$uploadfile = $uploaddir . basename($_FILES['attachement']['name']);
				if (move_uploaded_file($_FILES['attachement']['tmp_name'], $uploadfile)) {
					$attachement = basename($_FILES['attachement']['name']);
					$params = array(
											'attachement' => $attachement,
										);
					$condition = " WHERE id = $resMSG";
					$ret = updateData('contact_messages',$params,$condition);
					$attachement_file = $uploaddir.$attachement;

				}
			}
		}
		
	}

	$email = new PHPMailer();
	$email->From      = $data['Receiver'];
	$email->FromName  = '';
	$email->Subject   = l('Référence de commande : '). $data['reference'];
	$email->Body      = $data['message'];
	$email->AddAddress( $data['Receiver'] );

	if (isset($_FILES['attachement']) && $_FILES['attachement']['size']>0) {
		$email->AddAttachment($_FILES['attachement']['tmp_name'],$_FILES['attachement']['name']);
	}
	

	$res = $email->Send();


	if($res){
		$send_msg = '<div class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Votre message a bien été envoyé à notre équipe.</div>';
		
	}
	else
		$send_msg = '<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Il y a des erreurs.</div>';













	





/*
	$headers  = "From: Client < $data[email]>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$Sender   = $data['Sender'];
	$Receiver = $data['Receiver'];
    $Subject  = "contact";
    $Content  = 'Référence de commande :'. $data['reference'].',<br><br>';
    $Content .= $data['message'];

	if(mail($Receiver,$Subject,$Content,$headers)){
		$send_msg = '<div class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Votre message a bien été envoyé à notre équipe.</div>';
		if (isset($contact_Receiver['save_msg']) && $contact_Receiver['save_msg'] == "1") {
			$contact_messages_data = array(
									"email" => $data['Sender'],
									"id_receiver" => 1,
									"message" => $data['message'],
									"object" => 'Référence de commande :'. $data['reference']
									);
			$hooks->save('contact_messages',$contact_messages_data);
		}
	}
	else
		$send_msg = '<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Il y a des erreurs.</div>';*/

	}


?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "tesla");?>"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Contact", "tesla");?></li>
	</ol>

	<h1><?= l("Service client - Contactez-nous", "tesla");?></h1>

	<div class="contact-form">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	<h3 class="panel-title">
		  		<strong><?= l("Envoyez un message", "tesla");?></strong>
		  	</h3>
		  </div>

		  <div class="panel-body">
		   	<form role="form" enctype="multipart/form-data" method="POST"> 
		   		<p>
		   			<?=$send_msg; ?>
		   		</p>
		   		<p class="bold"><?= l("Pour des questions à propos d'une commande ou des informations sur nos produits.", "tesla");?></p>
				  <br>

				 
				  <div class="row">
			   		<div class="col-xs-12">
			   			<div class="form-group">
							  <label ><?= l("Objet", "tesla");?><sup>*</sup></label>
							  <p>
							  	<select name="objet" id="contact_objet">
							  		<?php foreach ($contact_trans as $key => $value): ?>
							  			<option value="<?=$value['id_contact'] ?>" data-description="<?=$value['description'] ?>"><?=$value['name']; ?></option>
							  		<?php endforeach ?>
							    </select>
								</p>
								<p> <label class="contact_objet_label"></label></p>
							</div>
			   		</div>
			   	</div>	

		   		<div class="row">
			   		<div class="col-xs-12 col-md-6">
							<div class="form-group">
							  <label for="exampleInputEmail1"><?= l("Adresse e-mail", "tesla");?><sup>*</sup></label>
							  <input type="email" class="form-control" name="email" value="" required="required">
							</div>
						</div>
					</div>
	


			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="telp"><?= l("Référence de commande", "tesla");?> <sup>*</sup></label>
							    <p>
							    	<input type="text" class="form-control" name="reference" value="" required="required">
							  	</p>
							  </div>
			   			</div>
			   		</div>

			   		<div class="row">
			   			<div class="col-xs-12">
							  <div class="form-group">
							    <label for="Fichier"><?= l("Fichier joint", "tesla");?> </label>
							    <p>
							    	<input type="file" name="attachement" style="width:50%">
							    </p>
							  </div>
			   			</div>
			   		</div>

						<div class="row">
			   			<div class="col-xs-12">
							  <div class="form-group">
							    <label for="infos"><?= l("Message", "tesla");?> <sup>*</sup></label>
							    <textarea class="form-control" rows="10" name="message" required="required"></textarea>
							  </div>
			   			</div>
			   		</div>


 
				  <p class="submit-btn">
				  	<input type="submit" name="submitContact" id="submitContact" value="<?= l("Envoyer", "tesla");?>" class="exclusive btn btn-sm btn-default button_large" style="float: right;">
					</p>
				</form>
		  </div>
		</div>
	</div>
