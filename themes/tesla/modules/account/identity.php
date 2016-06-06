<?php 
	$UID = goConnected();
	if (isset($_POST['submitIdentity'])) {
    $resEdit = editUserInfo($_POST,$UID);
  }	

	$CUSER = getCurrentUser();

	


?>
<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li><a href="#" title="acount"><?= l("Mon compte", "artiza");?></a></li>
	  <li class="active"><?= l("Vos informations personnelles", "artiza");?></li>
	</ol>

	<h1><?= l("Vos informations personnelles", "artiza");?></h1>
	<?php 
		if (isset($resEdit) && !empty($resEdit)) {
			if (isset($resEdit['editUserInfo']) && $resEdit['editUserInfo'] && $resEdit['editUserInfo'] >0) {
				echo '<div class="alert alert-success" role="alert">'.l('Bien enregistrer','artiza').'</div>';
			}else {
				echo '<div class="alert alert-danger" role="alert">';
	  		if (isset($resEdit['editUserInfo']) && !$resEdit['editUserInfo']) {
	  			echo l("ereur d'enregistrement");
	  		}else if (isset($resEdit['errorSecurity'])) {
	  			echo l("Vérifier votre champ");
	  		}else if (isset($resEdit['error'])) {
	  			foreach ($resEdit['error'] as $value) {
	  				echo $value.'<br>';
	  			}
	  		}
	  		echo "</div>";
			}
		}
	?>
	<form action="" class="std" method="post">
    <fieldset>
      <p class="bold"><?= l("N'hésitez pas à modifier vos informations personnelles si celles-ci ont changé.", "artiza");?></p>

      <div class="form-group radio col-md-12 padding0">
      	<span><?= l("Civilité", "artiza");?></span> 
      	<input id="id_gender1" name="id_gender" type="radio" value="1" <?php if($CUSER['id_gender'] == '1') echo 'checked="checked"'; ?>> 
      	<label for="id_gender1"><?= l("Mr", "artiza");?></label> 
      	<input id="id_gender2" name="id_gender" type="radio" value="2" <?php if($CUSER['id_gender'] == '2') echo 'checked="checked"'; ?>> 
      	<label for="id_gender2"><?= l("Mme", "artiza");?></label>
     	</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="lastname"><?= l("Nom", "artiza");?><sup>*</sup></label>  
				  <input id="lastname" name="firstname" type="text" class="form-control" required="" value="<?= $CUSER['first_name']?>">
				</div>
			</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="firstname"><?= l("Prénom", "artiza");?><sup>*</sup></label>  
				  <input id="firstname" name="lastname" type="text" class="form-control" required="" value="<?= $CUSER['last_name']?>">
				</div>
			</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="email"><?= l("Adresse e-mail", "artiza");?><sup>*</sup></label>  
				  <input id="email" name="email" type="text" class="form-control" required="" value="<?= $CUSER['email']?>">
				</div>
			</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="old_passwd"><?= l("Mot de passe actuell", "artiza");?><sup>*</sup></label>  
				  <input id="old_passwd" name="old_passwd" type="password" class="form-control" required="" >
				</div>
			</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="password"><?= l("Nouveau mot de passe", "artiza");?></label>  
				  <input id="password" name="npassword" type="password" class="form-control">
				</div>
			</div>
			<div class="row">
			 	<div class="col-md-4">
				  <label for="confirmation"><?= l("Confirmation", "artiza");?></label>  
				  <input id="confirmation" name="confirmation" type="password" class="form-control">
				</div>
			</div>


      <div class="row">
			<div class="form-group col-md-4">
				<label for="birthday"><?= l("Date de naissance", "artiza");?></label>  
			  <div class="input-group">
			  	<?php 
			  	$cutoff = 1900; $now = date('Y');
			  	if (validateDate($CUSER['birthday'],'Y-m-d')) {
			  		$birthday = DateTime::createFromFormat('Y-m-d', $CUSER['birthday']);
			  	}
			  	?>
				  <span class="input-group-btn">
				  	<select name="year" class="form-control select">
					  	<option value="">-</option>
							<?php
							  for ($y=$now; $y>=$cutoff; $y--) {
							  	if (isset($birthday) && $birthday->format('Y') == $y) {
							  		 echo '<option selected="selected" value="' . $y . '">' . $y . '</option>' . PHP_EOL;
							  	}else
							         echo '<option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
							  }
							?>
						</select>
					</span>
					<span class="input-group-btn">
				  	<select name="month" class="form-control select">
					  	<option value="">-</option>
							<?php
							  for ($m=1; $m<=12; $m++) {
							  	if (isset($birthday) &&  $birthday->format('m') == $m) {
							  		 echo '<option selected="selected" value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
							  	}else
							    echo '<option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
							  }
							?>
						</select>
					</span>
					<span class="input-group-btn">
				  	<select name="day" class="form-control select">
					  	<option value="">-</option>
							<?php
							  for ($d=1; $d<=31; $d++) {
							  	if ( isset($birthday) &&  $birthday->format('d') == $d) {
							  		echo '  <option selected="selected" value="' . $d . '">' . $d . '</option>' . PHP_EOL;
							  	}else
				     			echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
				  			}
							?>
						</select>
					</span>
			  </div>	
			</div>
		</div>



      <p class="checkbox"><input id="optin" name="optin" type="checkbox" value="1"> <label for="optin"><?= l("Recevez les offres spéciales de nos partenaires", "artiza");?></label></p>
      <p class="submit"><input class="button" name="submitIdentity" type="submit" value="Valider"></p>
      <p class="required"><sup>*</sup><?= l("Champs requis", "artiza");?></p>
      <p id="security_informations"><?= l("Conformément aux dispositions de la loi du n°78-17 du 6 janvier 1978, vous disposez d'un droit d'accès, de rectification et d'opposition sur les données nominatives vous concernant.", "artiza");?></p>
    </fieldset>
  </form>

	<ul class="footer_links">
		<li><a href="" title="Retour à votre compte"><?= l("Retour à votre compte", "artiza");?></a></li>
		<li><a href="/" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	</ul>
