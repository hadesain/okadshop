<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	  <li class="active"><?= l("Identifiant", "tesla");?></li>
	</ol>
	<div class="authentication">
		<h1><?= l("Identifiez-vous", "tesla");?></h1>
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Créez votre compte", "tesla");?></strong>
				  	</h3>
				  </div>
				  <div class="panel-body">
				   	<form role="form" action="<?= WebSite;?>account/register" method="POST">
				   		<h4><?= l("Saisissez votre adresse e-mail pour créer votre compte :", "tesla");?></h4>
						  <div class="form-group">
						    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "tesla");?></label>
						    <input type="email" class="form-control" style="border-radius:0px" name="email"  required="required">
						  </div>
						  <p class="submit-btn">
						  	<button type="submit" class="btn btn-sm btn-default button_large"><?= l("Créez votre compte", "tesla");?></button>
							</p>
						</form>
				  </div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<h3 class="panel-title">
				  		<strong><?= l("Déjà enregistré", "tesla");?> ?</strong>
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
						    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "tesla");?></label>
						    <input type="email" class="form-control" style="border-radius:0px" name="email" required>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1"><?= l("Mot de passe", "tesla");?></label>
						    <input type="password" class="form-control" style="border-radius:0px" name="password" required>
						  </div>
						  <div class="form-group">
						  	<br><p><a href="<?= WebSite.'account/password'; ?>"><span style="color: #8A8A8B;"><?= l("Mot de passe oublié ?", "tesla");?></span></a></p><br>
							<?php if (isset($loginresult['error'])): ?>
								<p><div class="alert alert-warning" role="alert"><?= l("Attention : si vous venez de créer votre compte, un délai de 24 à 48 h ouvrées est nécessaire.", "tesla");?></div></p>	
							<?php endif ?>
							
						  </div>
						  <p class="submit-btn">
						  	<button type="submit" class="btn btn-sm btn-default" name="submitlogin"><?= l("Identifiez-vous", "tesla");?></button>
						  </p>	  
						</form>
				  </div>
				</div>
			</div>
		</div>
	</div>