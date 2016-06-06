<?php   
	if (!isset($_POST['submitAccount']) && isset($_POST['email'])) {
		if(getUserMail($_POST['email']))
			$resultregister['error'][] = l('E-mail déjà enregistré','artiza').', <a href="'.WebSite.'account/login">'.l('connectez-vous','artiza').'</a> !';
	}
?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Identifiant", "artiza");?></li>
	</ol>
	<?php 
		if (isset($resultregister) && !empty($resultregister)) {
			if (isset($resultregister['login']) && $resultregister['login'] >0) {
				//goHome();
				?>
				<div class="alert alert-success" role="alert">
					<?php $ifCongé = select_mete_value("shop_is_vacance", "artiza");?>
					<p>
					<?php if ($ifCongé && $ifCongé == 1): ?>
					<?= l("Nous sommes actuellement en congés, <br>
					nous procéderons à la validation de votre compte dès notre retour prévu le :", "artiza");?> <?= select_mete_value("shop_is_vacance_return_date", "artiza");?><br>
					<?= l("Merci de votre compréhension", "artiza");?> <br>	
					<?php else: ?>
					<?= l("Bonjour", "artiza");?> « <?= htmlentities($_POST['lastname']); ?> »,  <?= l("nous vous remercions de vous être inscrit(e) chez OKADSHOP. <br><br>
					Après vérification des données fournies, nous vous enverrons un e-mail de confirmation contenant vos identifiants et mot de passe. (sous 24h à 48h ouvrées)<br><br>
					Vous pourrez alors vous connecter, découvrir nos tarifs réservés aux professionnels et effectuer votre première demande de devis en ligne.<br><br>
					Dans l’attente, nous vous invitons à prendre connaissance des différentes rubriques d’informations :", "artiza");?><br><br>
					<ul class="list-inline">
						<li><a href="<?=WebSite ?>cms/56-devis"><?= l("Demander une devis", "artiza");?></a></li>
						<li><a href="<?=WebSite ?>cms/51-Transport"><?= l("Transport et Taxes", "artiza");?></a></li>
						<li><a href="<?=WebSite ?>cms/55-Paiement"><?= l("Paiement sécurisé", "artiza");?></a></li>
						<li><a href="<?=WebSite ?>cms/57-Programme"><?= l("Programme de fidélité", "artiza");?></a></li>
						<li><a href="<?=WebSite ?>cms/53-Conditions"><?= l("Conditions d’utilisation", "artiza");?></a></li>
					</ul>
				 	<?php endif ?>
				 	</p>
				  <?php unset($_POST); ?>
				</div>
				<?php
			}else {
				echo '<div class="alert alert-danger" role="alert">';
	  		if (isset($resultregister['login']) && !$resultregister['login']) {
	  			echo l("Error d'inscription");
	  		}else if (isset($resultregister['errorSecurity'])) {
	  			foreach ($resultregister['errorSecurity'] as $key => $value) {
	  				echo $value."<br>";
	  			}
	  		}else if (isset($resultregister['error'])) {
	  			foreach ($resultregister['error'] as $value) {
	  				echo $value.'<br>';
	  			}
	  		}
	  		echo "</div>";
			}
		}
	?>
<?php if (!isset($resultregister['login']) || (isset($resultregister['login']) && $resultregister['login'] <=0)): ?>
	
	<div class="authentication">
		<h1><?= l("Créez votre compte", "artiza");?></h1>
		<form role="form" method="POST" id="registerForm" enctype="multipart/form-data"><!-- begin form -->
			<div class="user-info"><!-- user info -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Vos informations personnelles", "artiza");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<span><?= l("Civilité", "artiza");?></span><sup>*</sup>
			   		<label for="gender1">
			   				<input type="radio" name="id_gender" id="id_gender1" value="1" required="required" <?= (htmlentities($_POST['id_gender']) == '1') ? 'checked="checked"':''; ?>> <?= l("Mr", "artiza");?>
			   		</label>
			   		<label for="gender2">
			   				<input type="radio" name="id_gender" id="id_gender2" value="2" <?= (htmlentities($_POST['id_gender']) == '2') ? 'checked="checked"':''; ?>> <?= l("Mme", "artiza");?> 	
			   		</label>
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label ><?= l("Prénom", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="lastname" id="lastname" required="required" value="<?php if(isset($_POST['lastname'])) echo htmlentities($_POST['lastname']); ?>" onkeyup="cloneText('#lastname','#adresse_lastname')">
							  </div>
			   			</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label ><?= l("Nom", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="firstname" id="firstname"  required="required" value="<?php if(isset($_POST['firstname'])) echo  htmlentities($_POST['firstname']); ?>" onkeyup="cloneText('#firstname','#adresse_firstname')">
							  </div>
							</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
							  <div class="form-group">
							    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?><sup>*</sup></label>
							    <input type="email" class="form-control" name="email" required="required" value="<?= htmlentities($_POST['email']); ?>" >
							  </div>
							  <div class="form-group">
							    <label for="exampleInputEmail1"><?= l("Mot de passe", "artiza");?><sup>*</sup></label>
							    <input type="password" class="form-control" name="password" required="required" value="<?= htmlentities($_POST['password']); ?>">
							    <span class="form_info"><?= l("(5 caractères min.)", "artiza");?></span>
							  </div>
							  <!-- birthday -->
							   <!-- <div class="form-group">
							    <label for="birthday">Date de naissance</label>
							    <?php $cutoff = 1900; $now = date('Y');?>
							    <p>
							    	<select id="days" name="birthday_day">
								    	<?php
										for ($d=1; $d<=31; $d++) {
											if(htmlentities($_POST['birthday_day']) == $d) {
												echo '  <option value="' . $d . '" selected>' . $d . '</option>' . PHP_EOL;
											}
											else
							     				echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
							  			}
										?>
								    </select>
								    <select id="mounth" name="birthday_mounth" value="<?= htmlentities($_POST['birthday_mounth']); ?>">
								     	<?php
										  for ($m=1; $m<=12; $m++) {
										  	if(htmlentities($_POST['birthday_mounth']) == $m) {
												 echo '<option value="' . $m . '" selected>' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
											}
							     			else 
							     				echo '<option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
										   
										  }
										?>
								    </select>
								    <select id="years" name="birthday_year" value="<?= htmlentities($_POST['birthday_year']); ?>">
								      	<?php
										  for ($y=$now; $y>=$cutoff; $y--) {
							     			if(htmlentities($_POST['birthday_year']) == $y) {
												echo '  <option value="' . $y . '" selected>' . $y . '</option>' . PHP_EOL;
											}
											else
											 	echo '  <option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
							  			}
										?>
								    </select>
							    </p>
							  </div> -->
								<!-- <div class="form-group">
								  <label class="control-label" for="checkboxes">
								  	<input type="checkbox" name="offresRecevez" id="checkboxes-0" value="1">
								  	Recevez les offres spéciales de nos partenaires
								  </label>
								</div> -->
							</div>
						</div>
				  </div>
				</div>
			</div><!-- ./user-info -->
			
			<div class="user-societe"><!-- user-societe -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Votre société", "artiza");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="row" id="statuts">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="statuts"><?= l("Statuts", "artiza");?> <sup>*</sup></label>
							    <p>   
							    <label><input type="checkbox" class="form-control" name="statuts" id="statuts1" required="required"  value="2"><?= l("Je suis un professionnel", "artiza");?></label></p>
									<p><label>  
									<input type="checkbox" class="form-control" name="statuts" id="statuts2"   value="3"><?= l("Je suis en création d’entreprise", "artiza");?> </label> </p>
								</div>
							</div>
						</div>
						<script></script>
						<div id="company_bloc1" style="display:none;">
				   		<div class="row">
				   			<div class="col-xs-12 col-md-6">
				   				<div class="form-group">
								    <label for="Soci"><?= l("Société", "artiza");?> <sup>*</sup></label>
								    <input type="text" class="form-control required_statu" name="company"  value="<?= htmlentities($_POST['company']); ?>">
									</div>
								</div>
							</div>
				   		<div class="row">
				   			<div class="col-xs-12 col-md-6">
				   				<div class="form-group">
								    <label for="activite"><?= l("Activité", "artiza");?> <sup>*</sup></label>
								    <input type="text" class="form-control required_statu" name="activite"  value="<?= htmlentities($_POST['activite']); ?>">
									</div>
								</div>
							</div>
							<div class="row">
				   			<div class="col-xs-12 col-md-6">
				   				<div class="form-group">
								    <label for="website"><?= l("Site web", "artiza");?></label>
								    <input type="text" class="form-control required_statu" name="website" value="<?= htmlentities($_POST['website']); ?>">
									</div>
								</div>
							</div>
							<div class="row">
				   			<div class="col-xs-12 col-md-6">
				   				<div class="form-group">
								    <label for="siret_tva"><?= l("N° de siret / TVA", "artiza");?><sup>*</sup></label>
								    <input type="text" class="form-control required_statu" name="siret_tva" value="<?= htmlentities($_POST['siret_tva']); ?>">
								  </div>
								</div>
				   		</div>	
							<div class="row">
				   			<div class="col-xs-12">
				   				<div class="form-group">
				   					<div><br><b><?= l("Pour les pays hors U.E, veuillez joindre votre registre du commerce (obligatoire)", "artiza");?></b></div>
								    <label for="joindre"><?= l("Registre du commerce", "artiza");?> </label>
								    <input type="file" class="form-control" name="attachement" value="<?= htmlentities($_POST['attachement']); ?>">
									</div>
								</div>
							</div>
							<div style="margin-top: 12px;" class="alert alert-warning" role="alert"><?= l("Ces données seront vérifiées, veillez donc à nous communiquer un numéro d’entreprise correct (le votre et non celui d’un tiers) auquel cas votre demande ne pourra aboutir.", "artiza");?></div>
						</div>
						<div id="company_bloc2" style="display:none;">
							<div class="row">
				   			<div class="col-xs-12">
				   				<div class="form-group">
				   					<div><br><b><?= l("Si vous êtes en création d’entreprise", "artiza");?> </b></div>
								    <label for="siret"><?= l("Indiquez « en cours » dans les champs société, activité et siret", "artiza");?></label>
									</div>
								</div>
							</div>	
				   		<div class="row">
				   			<div class="col-md-6">
				   					<label for="join-file"><?= l("Préciser la date de début de votre activité", "artiza");?><sup>*</sup></label>
				   				<div class="input-group date" data-provide="datepicker">
										<input type="text" class="form-control required_statu" name="date_activite" value="<?= htmlentities($_POST['date_activite']); ?>">
										<div class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</div>
									</div>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-xs-12">
				   				<div class="form-group">
				   					<label for="join-file"><?= l("Parlez nous de votre projet :", "artiza");?><sup>*</sup></label>	
								   	<textarea class="form-control required_statu" rows="3" name="info" ><?= htmlentities($_POST['info']); ?></textarea>
				   				</div>
				   			</div>
				  		</div>
				  		<div style="margin-top: 12px;" class="alert alert-warning" role="alert"><?= l("Attention ! Votre demande d’ouverture de compte fera l’objet d’une étude. Dans le cas où votre demande serait acceptée, la création de votre entreprise devra nous être confirmée 15 jours avant la date prévue de votre début d’activité. Si tel n’était pas le cas, votre compte sera alors suspendu jusqu’à réception de votre confirmation.", "artiza");?></div>
			  		</div>
			   	</div>
			  </div>
			</div>


			<div class="user-adress"><!-- user-adress -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Votre adresse", "artiza");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="name"><?= l("Prénom", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="adresse_lastname" id="adresse_lastname" required="required" value="<?= htmlentities($_POST['adresse_lastname']); ?>">
							  </div>
			   			</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="lname"><?= l("Nom", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="adresse_firstname" id="adresse_firstname" required="required" value="<?= htmlentities($_POST['adresse_firstname']); ?>">
							  </div>
							</div>
			   		</div>	
						<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="adress"><?= l("Adresse", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="adress" required="required" value="<?= htmlentities($_POST['adress']); ?>">
							    
							  </div>
							</div>
			   			<!-- <div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="adrss2">Adresse (Ligne 2)</label>
							    <input type="text" class="form-control" name="adress2" value="<?= htmlentities($_POST['adress2']); ?>">
							    <span class="form_info"></span>
							  </div>
			   			</div> -->
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="codep"><?= l("Code postal", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="zipcode" required="required" value="<?= htmlentities($_POST['zipcode']); ?>">
							  </div>
							</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="city"><?= l("Ville", "artiza");?><sup>*</sup></label>
							    <input type="text" class="form-control" name="city" required="required" value="<?= htmlentities($_POST['city']); ?>">
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
							    			/*$iso_code = ip_info("Visitor", "Country Code");*/
							    			$iso_code = getCurrentCountrycode();
							    			if ($contry) {
							    			 	foreach ($contry as $key => $value) {
							    			 		if (htmlentities($_POST['id_country'])==$value['id']) {
							    			 			echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
							    			 		}else if ($iso_code == $value['iso_code']) {
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
			   			<div class="col-xs-12"></label></div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="teld"><?= l("Téléphone fixe", "artiza");?></label>
							    <input type="text" class="form-control" name="phone" value="<?= htmlentities($_POST['phone']); ?>">
							  </div>
							</div>
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="telp"><?= l("Téléphone portable", "artiza");?> <sup>*</sup></label>
							    <input type="text" class="form-control" name="mobile" required="required" value="<?= htmlentities($_POST['mobile']); ?>">
							  </div>
			   			</div>
			   		</div>
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="adr"><?= l("Nom de l'adresse", "artiza");?><sup>*</sup></label>
							     <input type="text" class="form-control" name="adresse_name" required="required" value="Facturation" value="<?= htmlentities($_POST['adresse_name']); ?>">
							  </div>
			   			</div>
			   		</div>	
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
							    <label for="infos"><?= l("Informations complémentaires", "artiza");?></label>
							    <textarea class="form-control" rows="3" name="info_sup"></textarea>
							  </div>
			   			</div>
			   		</div>
				  </div>
				</div>
			</div><!-- user adresse -->

			<?php //$UsersGroup = getUsersGroup(); ?>
			
			<!-- Compte type -->
			<!-- <div class="user-type">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong>Type de Compte</strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-xs-12">
			   				<div class="form-group">
			   					<label for="join-file">Choisir le type de compte <sup>*</sup></label>
			   					<select name="user-type"  id="user_type">
			   						<?php 
			   						foreach ($UsersGroup as $key => $value){
			   							echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
			   						}
			   						?>
			   					</select>
			   				</div>

			   				<div class="row">
			   					<div class="col-md-6">
			   						<div class="form-group">
									     <input type="file" class="form-control" name="user_type_file" value="<?= htmlentities($_POST['user_type_file']) ?>"/>
									</div>
			   					</div>
			   				</div>
			   				
							<div class="form-group" id="">
			   				<h1>Informations complémentaires</h1>
			   				<div class="row">
			   					<div class="col-md-6">
			   						<label for="join-file">Préciser la date de début de votre activité <sup>*</sup></label>
			   						<div class="input-group date" data-provide="datepicker">
										  <input type="text" class="form-control">
										  <div class="input-group-addon">
										    <span class="glyphicon glyphicon-th"></span>
										  </div>
										</div>
			   					</div>
			   				</div>
			   				<div class="form-group">
			   					<label for="join-file">Parlez nous de votre projet :</label>	
							   	<textarea class="form-control" rows="3" name="usertype_info_sup"></textarea>
			   				</div>
			   			</div>
			   			</div>
			   		</div>	
				  </div>
				</div>
			</div> -->
			<!-- parrainage -->
			<!-- <div class="parrainage">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong>Programme de parrainage</strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-xs-12 col-md-6">
			   				<div class="form-group">
							    <label for="adr">Adresse mail de votre parrain</label>
							     <input type="email" class="form-control" name="parinage">
							  </div>
			   			</div>
			   		</div>	
				  </div>
				</div>
			</div> -->
			<!-- ./parrinage -->
			<div class="submitform"><!-- submitform -->
				<div class="panel panel-default">
				  <div class="panel-body">
			   		<div class="row">
			   			<div class="col-md-6">
							   <label for="champ"><sup>*</sup><?= l("Champs requis", "artiza");?></label>
			   			</div>
			   			<div class="col-md-6">
			   				<input type="submit" name="submitAccount" id="submitAccount" value="S'inscrire" class="exclusive" style="float: right;">
			   			</div>
			   		</div>	
				  </div>
				</div>
			</div><!-- ./submitform -->
		</form><!-- ./end form -->
	</div>

	<?php endif ?>
	<?php if (isset($_POST['statuts']) && !empty($_POST['statuts'])): ?>
		<script type="text/javascript">
			var id_statuts = "<?= $_POST['statuts'] ?>";
				$(document).ready(function () {
					$('#statuts'+id_statuts).click();
					if (id_statuts == 2) {
	            $('#company_bloc1').css("display","block");
	            $('#company_bloc2').css("display","none");
	            $('#company_bloc1 .required_statu').prop("required", true);
	            $('#company_bloc2 .required_statu').prop("required", false);
	        }else if (id_statuts == 3) {
	            $('#company_bloc1').css("display","block");
	            $('#company_bloc2').css("display","block");
	            $('#company_bloc1 .required_statu').prop("required", true);
	            $('#company_bloc2 .required_statu').prop("required", true);
	        }
				});

		</script>
	<?php endif ?>