 <?php 

    $UID = goConnected();
	if (isset($_POST['submitAdresse'])) {
    	$resAdd = addUserAdress($_POST,$UID);
    }
    
    $currentUser = getCurrentUser();
    $customGET = customGET();
    if ($customGET['id_address'] && !empty($customGET['id_address'])) {
    	$userAdresses = getUserAdresse($UID,$customGET['id_address']);
    }

    if ($customGET['fromcart']) {
    	$_SESSION['fromcart'] = 1;
    }else{
    	unset($_SESSION['fromcart']);
    }
    if ($customGET['id_address']){
	  	$breadcrumb_active = l("Modifier cette adresse");
	  	$breadcrumb_title = l("Modifier cette adresse")." \"". $userAdresses['name'] ."\"";
	  }else{
	  	$breadcrumb_active = l("Ajouter une nouvelle adresse");
	  	$breadcrumb_title = l("Pour ajouter une nouvelle adresse, merci de remplir ce formulaire.");
	  }
  ?>

  <!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?=l("Accueil", "tesla");?></a></li>
	  <li><a href="#" title="acount"><?=l("Mon compte", "tesla");?></a></li>
	  <li class="active"><?= $breadcrumb_active; ?></li>
	</ol>
	<h1><?= $breadcrumb_title; ?></h1>

	<?php 
		if (isset($resAdd) && !empty($resAdd)) {
			if (isset($resAdd['addUserAdress']) &&  $resAdd['addUserAdress'] >= 0) {
				if (isset($_SESSION['fromcart'])) {
					goTolink(WebSite.'cart/adresse');
				}else{
					goTolink(WebSite.'account/addresses');
				}
				//echo '<div class="alert alert-success" role="alert">Bien enregistrer</div>';
			}else {
				echo '<div class="alert alert-danger" role="alert">';
	  		if (isset($resAdd['addUserAdress']) && !$resAdd['addUserAdress']) {
	  			echo l("ereur d'ajout");
	  		}else if (isset($resAdd['errorSecurity'])) {
	  			echo l("Vérifier votre champ");
	  		}else if (isset($resAdd['error'])) {
	  			foreach ($resAdd['error'] as $value) {
	  				echo $value.'<br>';
	  			}
	  		}
	  		echo "</div>";
			}
		}
	?>

	<form role="form" method="POST"><!-- begin form -->
		<?php if (isset($userAdresses['id'])): ?>
			<input type="hidden" value="<?= $userAdresses['id']; ?>" name="editAdresse"/>
		<?php endif ?>
		<div class="user-adress"><!-- user-adress -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Votre adresse", "tesla");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="name"><?= l("Prénom", "tesla");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="lastname" id="lastname" required="required" value="<?php if(isset($userAdresses['lastname'])) echo $userAdresses['lastname']; else if(isset($_POST['lastname'])) echo htmlentities($_POST['lastname']);  else echo $currentUser['last_name']; ?>">
							  </div>
			   			</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="lname"><?= l("Nom", "tesla");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="firstname" id="firstname" required="required" value="<?php if(isset($userAdresses['firstname'])) echo $userAdresses['firstname']; else if(isset($_POST['firstname'])) echo htmlentities($_POST['firstname']); else echo $currentUser['first_name'];  ?>">
							  </div>
							</div>
			   		</div>
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="Soci"><?= l("Société", "tesla");?></label>
							    <input type="text" class="form-control" name="company" value="<?php if(isset($userAdresses['company'])) echo $userAdresses['company']; else echo htmlentities($_POST['company']); ?>">
							  </div>
							</div>
						</div>	
						<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="adress"><?= l("Adresse", "tesla");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="addresse" required="required" value="<?php if(isset($userAdresses['addresse'])) echo $userAdresses['addresse']; else echo htmlentities($_POST['addresse']); ?>">
							    
							  </div>
							</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="codep"><?= l("Code postal", "tesla");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="codepostal" required="required" value="<?php if(isset($userAdresses['codepostal'])) echo $userAdresses['codepostal']; else echo htmlentities($_POST['codepostal']); ?>">
							  </div>
							</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="city"><?= l("Ville", "tesla");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="city" required="required" value="<?php if(isset($userAdresses['city'])) echo $userAdresses['city']; else echo htmlentities($_POST['city']); ?>">
							  </div>
			   			</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="pays"><?= l("Pays", "tesla");?><sup>*</sup></label>
							    <p>
							    	<select id="pays" name="id_country" >
							    		<?php
						    			$contry = getAllContry();
						    			$iso_code = getCurrentCountrycode();
						    			if ($contry) {
						    			 	foreach ($contry as $key => $value) {
													if ($iso_code == $value['iso_code']) {
						    			 			echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
						    			 		}
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
			   			<div class="col-xs-12"></label></div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="teld"><?= l("Téléphone fixe", "tesla");?></label>
							    <input type="text" class="form-control" name="phone" value="<?php if(isset($userAdresses['phone'])) echo $userAdresses['phone']; else echo htmlentities($_POST['phone']); ?>">
							  </div>
							</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="telp"><?= l("Téléphone portable", "tesla");?> <sup>*</sup></label>
							    <input type="text" class="form-control" name="mobile" required="required" value="<?php if(isset($userAdresses['mobile'])) echo $userAdresses['mobile']; else echo htmlentities($_POST['mobile']); ?>">
							  </div>
			   			</div>
			   		</div>
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="adr"><?= l("Nom de l'adresse", "tesla");?><sup>*</sup></label>
							     <input type="text" class="form-control" name="adresse_name" required="required" value="<?php if(isset($userAdresses['name'])) echo $userAdresses['name']; else echo htmlentities($_POST['adresse_name']); ?>">
							  </div>
			   			</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="infos"><?= l("Informations complémentaires", "tesla");?></label>
							    <textarea class="form-control" rows="3" name="info" ><?php if(isset($userAdresses['info'])) echo $userAdresses['info']; else echo htmlentities($_POST['info']); ?></textarea>
							  </div>
			   			</div>
			   		</div>
				  </div>
				</div>
			</div><!-- user adresse -->


			<div class="submitform"><!-- submitform -->
				<div class="panel panel-default">
				  <div class="panel-body">
			   		<input type="submit" name="submitAdresse" id="submitAdresse" value="Valider" class="button" >
				  </div>
				</div>
				 <label for="champ"><sup>*</sup><?= l("Champs requis", "tesla");?></label>
			</div><!-- ./submitform -->
		</form><!-- ./end form -->

		<ul class="footer_links">
			<?php 
				$cancel_url = "";
				if (isset($_SESSION['fromcart'])) {
					$cancel_url = WebSite.'cart/adresse';
				}else{
					$cancel_url = WebSite.'account/addresses';
				}
			?>
			<li><a href="<?= $cancel_url;?>" title="Annuler"><?= l("Annuler", "tesla");?></a></li>
			<li><a href="<?= WebSite;?>account/" title="Retour à votre compte"><?= l("Retour à votre compte", "tesla");?></a></li>
		</ul>