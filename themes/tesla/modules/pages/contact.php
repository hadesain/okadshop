<?php 
$CurrentUser = getCurrentUser();
if (isset($_POST['submitContact'])) {

			$error = array();
			if (!isset($_POST['captcha']) || empty($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha']['code']) {
				$error[] = l('Captcha erroné.');
			}

			if (!isset($_POST['firstname']) || empty($_POST['firstname'])) {
				$error[] = l('Le nom est un champ obligatoir');
			}
			if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
				$error[] = l('Le prenom est un champ obligatoir');
			}
			if (!isset($_POST['email']) || empty($_POST['email'])) {
				$error[] = l('L\'adresse e-mail est un champ obligatoir');
			}
			if (!isset($_POST['id_country']) || empty($_POST['id_country'])) {
				$error[] = l('Le Pays est un champ obligatoir');
			}
			if (!isset($_POST['mobile']) || empty($_POST['mobile'])) {
				$error[] = l('La Téléphone  est un champ obligatoir');
			}

			
			
			if (empty($error)) {
				$data = array(
					'id_receiver' => 1,
					'firstname' => addslashes($_POST['firstname']),
					'lastname' => addslashes($_POST['lastname']),
					'company' => addslashes($_POST['company']),
					'siret_tva' => addslashes($_POST['siret_tva']),
					'email' => addslashes($_POST['email']),
					'adresse' => addslashes($_POST['adresse']),
					'adresse2' => addslashes($_POST['adresseligne2']),
					'zipcode' => addslashes($_POST['zipcode']),
					'city' => addslashes($_POST['city']),
					'mobile' => addslashes($_POST['mobile']),
					'message' => addslashes($_POST['message']),
					'id_country' => addslashes($_POST['id_country']),
					'ip' => get_client_ip_country()
					);
				if (isset($CurrentUser['uid'])) {
					$data['id_sender'] = $CurrentUser['uid'];
					$data['from'] = $CurrentUser['uid'];
				}
				$resMSG = saveData('contact_messages',$data);
				if ($resMSG && isset($_FILES['attachement']) && $_FILES['attachement']['size']>0) {
					$allowed =  array('gif','png' ,'jpg','pdf');
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
						}
					}
				}
			}			
}
?>

	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Contact", "artiza");?></li>
	</ol>

	<h1><?= l("Service client - Contactez-nous", "artiza");?></h1>
	<?php if (isset($resMSG) && $resMSG): ?>
		<div class="alert alert-success" role="alert">
			<?= l("Nous vous remercions pour votre message. Une réponse vous sera apportée dans les plus brefs délais (max 48h)", "artiza");?>
		</div>
	<?php else: ?>

	<div class="contact-form">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	<h3 class="panel-title">
		  		<strong><?= l("Envoyez un message", "artiza");?></strong>
		  	</h3>
		  </div>
		  <?php if (isset($error) && !empty($error)): ?>
		  	<div class="alert alert-danger" role="alert">
		  		<?php foreach ($error as $key => $value){
		  			echo $value."<br>";
		  		} ?>
		  	</div>
		  <?php endif ?>
		  <div class="panel-body">
		   	<form role="form" enctype="multipart/form-data" method="POST"> 
		   		<p class="bold"><?= l("Pour des questions à propos d'une commande ou des informations sur nos produits.", "artiza");?></p>
				  <br>
				  <?php if (!isconnected()): ?>
				  	<div style="color: #DA9B39;padding-left: 10px;">
				  		<p><?= l("Vous êtes un professionnel ou en création d’entreprise et vous souhaitez avoir accès à nos tarifs ?", "artiza");?> <a class="text-underline" href="<?= WebSite;?>account/register"><?= l("Créez votre compte", "artiza");?></a></p>
				  		<p><?= l("Vous possédez déjà un compte ?", "artiza");?> <a class="text-underline" href="<?= WebSite;?>account/login"><?= l("Connectez vous", "artiza");?></a></p>
				  	</div>
				  <?php endif ?>
				 
				  <div class="row">
			   		
			   		<div class="col-xs-12 col-md-6">
			   			<div class="form-group">
							  <label ><?= l("Prénom", "artiza");?><sup>*</sup></label>
							  <p>
							  	<input type="text" class="form-control" name="lastname" value="<?= 	(isset($CurrentUser['last_name']) && !empty($CurrentUser['last_name'])) ? $CurrentUser['last_name'] : htmlentities($_POST['lastname']) ?>" required="required">
								</p>
							</div>
			   		</div>
			   		<div class="col-xs-12 col-md-6">
			   			<div class="form-group">
							  <label ><?= l("Nom", "artiza");?><sup>*</sup></label>
							  <p>
							 		<input type="text" class="form-control" name="firstname" value="<?= (isset($CurrentUser['first_name']) && !empty($CurrentUser['first_name'])) ? $CurrentUser['first_name'] : htmlentities($_POST['firstname']); ?>" required="required">
								</p>
							</div>
						</div>
			   	</div>	
			   	<div class="row">
		   			<div class="col-xs-12 col-md-6">
		   				<div class="form-group">
						    <label for=""><?= l("Société", "artiza");?></label>
						    <p>
						    	<input type="text" class="form-control" name="company" value="<?= (isset($CurrentUser['company']) && !empty($CurrentUser['company'])) ? $CurrentUser['company'] : htmlentities($_POST['company']); ?>">
								</p>
							</div>
						</div>
					</div>
					<div class="row">
		   			<div class="col-xs-12 col-md-6">
		   				<div class="form-group">
						    <label for="siret_tva"><?= l("N° de siret / TVA<", "artiza");?>/label>
						    <p>
						    	<input type="text" class="form-control" name="siret_tva" value="<?=  (isset($CurrentUser['siret_tva']) && !empty($CurrentUser['siret_tva'])) ? $CurrentUser['siret_tva'] : htmlentities($_POST['siret_tva']); ?>" >
						  	</p>
						  </div>
						</div>
		   		</div>
		   		<div class="row">
			   		<div class="col-xs-12 col-md-6">
							<div class="form-group">
							  <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?><sup>*</sup></label>
							  <input type="email" class="form-control" name="email" value="<?= (isset($CurrentUser['email']) && !empty($CurrentUser['email'])) ? $CurrentUser['email'] : htmlentities($_POST['email']); ?>" required="required">
							</div>
						</div>
					</div>
		   		<div class="row">
			   		<div class="col-xs-12 col-md-6">
			   			<div class="form-group">
							  <label for="adresse"><?= l("Adresse", "artiza");?></label>
							  <p>
							  <input type="text" class="form-control" name="adresse" value="<?= (isset($CurrentUser['addresse']) && !empty($CurrentUser['addresse'])) ? $CurrentUser['addresse'] : htmlentities($_POST['adresse']); ?>">
							  <p>
							  	<!-- <span class="form_info">Numéro dans la rue, boîte postale, nom de la société</span> -->
								</p>
								</p>
							</div>
						</div>
			   	</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <p>
							    	<label for="codep"><?= l("Code postal", "artiza");?></label>
							    </p>
							    <p>
							    	<input type="text" class="form-control" name="zipcode" value="<?= (isset($CurrentUser['codepostal']) && !empty($CurrentUser['codepostal'])) ? $CurrentUser['codepostal'] : htmlentities($_POST['zipcode']); ?>">
							  	</p>
							  </div>
							</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="city"><?= l("Ville", "artiza");?></label>
							    <p>
							    	<input type="text" class="form-control" name="city" value="<?= (isset($CurrentUser['city']) && !empty($CurrentUser['city'])) ? $CurrentUser['city'] : htmlentities($_POST['city']); ?>">
							  	</p>
							  </div>
			   			</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="pays"><?= l("Pays", "artiza");?><sup>*</sup></label>
							    <p>
							    	<select id="pays" name="id_country" >
							    		<?php
							    			$contry = getAllContry();
							    			$iso_code = getCurrentCountrycode();
							    			$uc = (isset($CurrentUser['id_country']) && !empty($CurrentUser['id_country'])) ? $CurrentUser['id_country'] : htmlentities($_POST['id_country']);
							    			if ($contry) {
							    			 	foreach ($contry as $key => $value) {
							    			 		if ($uc ==$value['id']) {
							    			 			echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
							    			 		}else if ($iso_code ==$value['iso_code']) {
							    			 			echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
							    			 		}
							    			 		else
							    			 		 	echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
							    			 	}
							    			 } 
							    		?>
							    	</select>
							    </p>
							  </div>
							</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="telp"><?= l("Téléphone", "artiza");?> <sup>*</sup></label>
							    <p>
							    	<input type="text" class="form-control" name="mobile" value="<?=  (isset($CurrentUser['mobile']) && !empty($CurrentUser['mobile'])) ? $CurrentUser['mobile'] : htmlentities($_POST['mobile']); ?>" required="required">
							  	</p>
							  </div>
			   			</div>
			   		</div>

			   		
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="infos"><?= l("Message", "artiza");?> <sup>*</sup></label>
							    <textarea class="form-control" rows="3" name="message" required="required"><?=  htmlentities($_POST['message']); ?></textarea>
							  </div>
							  <div class="form-group">
							    <label for="Fichier"><?= l("Fichier joint", "artiza");?> </label>
							    <p>
							    	<input type="file" name="attachement" style="width:50%">
							    </p>
							  </div>
			   			</div>
			   		</div>
			   		
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="captcha"><?= l("Captcha", "artiza");?> <sup>*</sup></label>
							    <p>
							    <?php
						   			$_SESSION['captcha'] = simple_php_captcha();
										echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="'.l("CAPTCHA", "artiza").'" />';  
						   		?>
						   		</p>
						   		<p><input type="text" name="captcha"  required="required"></p>
						   		
							  </div>
							</div>
						</div>
				  <p class="submit-btn">
				  	<input type="submit" name="submitContact" id="submitContact" value="<?= l("Envoyer", "artiza");?>" class="exclusive btn btn-sm btn-default button_large" style="float: right;">
					</p>
				</form>
		  </div>
		</div>
	</div>
	<?php endif ?>
	<?php $messages = getUserContactMsg($_SESSION['user']); ?>
	<?php if ($messages && !empty($messages)): ?>
		<div class="panel panel-default">
			<div class="container">
			   <div class="row">
			      <div class="message-wrap col-lg-8">
			         <div class="msg-wrap">
			         	<?php foreach ($messages as $key => $msg): ?>
			         		<div class="media msg " id="msg_num_<?= $msg['id'];  ?>">
				               <div class="media-body">
				                  <small class="pull-right time"><i class="fa fa-clock-o"></i> <?= $msg['cdate'];  ?></small>
				                  <h5 class="media-heading" style="color: #003bb3;font-weight: 700;"><?= $msg['sender'];  ?></h5>
				                  <small class="col-lg-10"><b><?= $msg['message'];  ?></b> <br>
				                  	<?php if (!empty($msg['attachement'])): ?>
					                  	<b>Fichier Joint : </b>
					                  	<a download="<?= $msg['attachement']; ?>" href="<?= WebSite.'files/attachments/contact/'.$msg['id'].'/'.$msg['attachement']; ?>"><?= $msg['attachement']; ?></a>
					                  <?php endif ?>
				                  </small>
				               </div>
				            </div>
			         	<?php endforeach ?>
			         </div>
			      </div>
			   </div>
			</div>
		</div>
	<?php endif ?>
	