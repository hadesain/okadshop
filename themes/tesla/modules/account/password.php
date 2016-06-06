	
<?php 
	// Create a unique salt. This will never leave PHP unencrypted.
	$salt = "498#2D83B631%3800EBD!801600D*7E3CC13%7114823306";
	if (isset($_POST['recoverUserPassword']) && isset($_POST['email']) && !empty($_POST['email'])){
		//$result = recoverUserPassword($_POST['email']);
		$userExists = getUserMail($_POST['email']);
		$result = $userExists;
		$danger = l('Aucun utilisateur avec cette adresse existe.');
		if ($userExists)
    {
			// Create the unique user password reset key
			$password = hash('sha512', $salt.$_POST['email']);
			// Create a url which we will direct them to reset their password
			$pwrurl = WebSite."account/password/".$password;
			$result = recoverUserPassword($_POST['email'],$pwrurl);
			if ($result) {
				$success =  l('Votre clé de récupération de mot de passe a été envoyé à votre adresse e-mail.');
			}
		}
	}	
	// Was the form submitted?
	if (isset($_POST["ResetPasswordForm"]))
	{
		$result = false;
    // Gather the post data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $hash = $_POST["q"];
    // Generate the reset key
    $resetkey = hash('sha512', $salt.$email);
    // Does the new reset key match the old one?
    if ($resetkey == $hash)
    {
      if ($password == $confirmpassword)
      {
        //has and secure the password
				$password = md5($password);
        // Update the user's password
       	if (changeUserPassword($email,$password)) {
					$success =  l("Votre mot de passe a été réinitialisé avec succès.");
					$result = true;
       	}
      }
			else
				$danger = l("Vos mots de passe ne correspondent pas.");
		}
    else
        $danger = l("Votre clé de réinitialisation de mot est invalide.");
	}

?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="<?= WebSite ?>" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li class="active"><?= l("Mot de passe oublié ?", "artiza");?></li>
	</ol>
	
	 <div class="block-center" id="block-history">
		<h1><?= l("Mot de passe oublié ?", "artiza");?></h1>
		<?php if (isset($result) && $result): ?>
			<div class="alert alert-success" role="alert"><?= $success; ?></div>
		<?php elseif(isset($result) && !$result): ?>
			<div class="alert alert-danger" role="alert"><?= $danger; ?></div>
		<?php endif ?>
		
	<?php if (isset($_GET['ID2']) && !empty($_GET['ID2'])): ?>
		<div class="panel panel-default">
		  <div class="panel-body">
		   	<form role="form" method="POST">
				  <div class="form-group">
				    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?></label>
				    <input type="email" class="form-control" style="border-radius:0px" name="email" required value="<?= htmlentities($_POST['email']); ?>">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1"><?= l("Mot de passe", "artiza");?></label>
				    <input type="password" class="form-control" style="border-radius:0px" name="password" required value="">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1"><?= l("Confiré Mot de passe", "artiza");?></label>
				    <input type="password" class="form-control" style="border-radius:0px" name="confirmpassword" required value="">
				  </div>
				  <input type="hidden" name="q" value="<?= htmlentities($_GET['ID2']) ?>"/>
				  <p class="submit-btn">
				  	<button type="submit" class="btn btn-sm btn-default" name="ResetPasswordForm"><?= l("Valider", "artiza");?></button>
				  </p>	  
				</form>
		  </div>
		</div>
	<?php else: ?>
		<div class="panel panel-default">
		  <div class="panel-body">
		   	<form role="form" method="POST">
		   		<strong><?= l("Veuillez renseigner votre adresse e-mail afin de recevoir votre nouveau mot de passe.", "artiza");?></strong>
				  <div class="form-group">
				    <label for="exampleInputEmail1"><?= l("Adresse e-mail", "artiza");?></label>
				    <input type="email" class="form-control" style="border-radius:0px" name="email" required value="<?= htmlentities($_POST['email']); ?>">
				  </div>
				  <p class="submit-btn">
				  	<button type="submit" class="btn btn-sm btn-default" name="recoverUserPassword"><?= l("Valider", "artiza");?></button>
				  </p>	  
				</form>
		  </div>
		</div>
	<?php endif ?>

	<ul class="footer_links">
		<li><a href="<?= WebSite;?>account/login" title="Retour à la page d'identification"><?= l("Retour à la page d'identification", "artiza");?></a></li>
	</ul>