<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Identifiant", "artiza");?></li>
	</ol>
	<div class="authentication">
		<h1><?= l("Identifiez-vous", "artiza");?></h1>
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Créez votre compte", "artiza");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
				   	<form role="form" action="<?= WebSite;?>account/register" method="POST">
				   		<h4><?= l("Saisissez votre adresse e-mail pour créer votre compte :", "artiza");?></h4>
						  <div class="form-group">
						    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?></label>
						    <input type="email" class="form-control" style="border-radius:0px" name="email"  required="required">
						  </div>
						  <p class="submit-btn">
						  	<button type="submit" class="btn btn-sm btn-default button_large"><?= l("Créez votre compte", "artiza");?></button>
							</p>
						</form>
				  </div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Déjà enregistré", "artiza");?> ?</strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
				  	<?php 
				  	if (isset($loginresult) && !empty($loginresult)) {
				  		if (isset($loginresult['login']) && $loginresult['login'] >0) {
				  			if (isset($_SESSION['fromcart'])) {
				  				unset($_SESSION['fromcart']);
				  				goTolink(WebSite.'cart/adresse/');
				  			}
				  			goHome();
				  		}else {
				  			echo '<div class="alert alert-danger" role="alert">';
					  		if (isset($loginresult['error'])) {
					  			foreach ($loginresult['error'] as $value) {
					  				echo $value.'<br>';
					  			}
					  		}else {
					  			echo l("Vérifier votre champ");
					  		}
					  		echo "</div>";
				  		}
				  		
				  	}
				  	?>
				   	<form role="form" method="POST">
						  <div class="form-group">
						    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?></label>
						    <input type="email" class="form-control" style="border-radius:0px" name="email" required>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1"><?= l("Mot de passe", "artiza");?></label>
						    <input type="password" class="form-control" style="border-radius:0px" name="password" required>
						  </div>
						  <div class="form-group">
						  	<br><p><a href="<?= WebSite.'account/password'; ?>"><span style="color: #C38468;"><?= l("Mot de passe oublié ?", "artiza");?></span></a></p><br>
							<?php if (isset($loginresult['error'])): ?>
								<p><div class="alert alert-warning" role="alert"><?= l("Attention : si vous venez de créer votre compte, un délai de 24 à 48 h ouvrées est nécessaire.", "artiza");?></div></p>	
							<?php endif ?>
							
						  </div>
						  <p class="submit-btn">
						  	<button type="submit" class="btn btn-sm btn-default" name="submitlogin"><?= l("Identifiez-vous", "artiza");?></button>
						  </p>	  
						</form>
				  </div>
				</div>
			</div>
		</div>
	</div>