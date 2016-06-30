<?php
require "../config/bootstrap.php"
?>
<!DOCTYPE html>
<html dir="<?=$os_direction;?>" lang="<?=$os_lang;?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="<?=$os_encoding;?>">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?=l("Admin Aria", "admin");?></title>
  <!-- Boosttrap -->
  <link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <!-- http://bootsnipp.com/snippets/featured/google-style-login-extended-with-html5-localstorage -->
  <link href="assets/css/login_form.css" rel="stylesheet" type="text/css" />
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

  <div class="container">
    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="assets/images/avatar.png" />
      <center>
        <strong>OkadShop <?=_OS_VERSION_;?></strong>
      </center>
      <p id="profile-name" class="profile-name-card"></p>
      <div class="alert alert-danger" id="alert" style="display:none;">
        <a type="button" class="close" data-dismiss="alert">x</a>
        <strong>fdsfd</strong>
      </div>


      <form method="post" action="" role="login" class="form-signin">
        <input type="hidden" name="class" value="login">
        <span id="reauth-email" class="reauth-email"></span>
        <input type="email" id="inputEmail" name="email" placeholder="<?=l("Email address", "admin");?>" class="form-control"  required autofocus />
        <input type="password" id="inputPassword" name="password" placeholder="<?=l("Password", "admin");?>" class="form-control" required />
        <div id="remember" class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> <?=l("Remember me", "admin");?>
          </label>
        </div>
        <button type="submit" id="con" value="connexion" class="btn btn-lg btn-primary btn-block btn-signin"><?=l("Sign in", "admin");?></button>
        <a class="retoure" href="../"><i class="fa fa-long-arrow-left"></i><?=l("My shop", "admin");?></a>
        <a id="forgot-password" class="pull-right"><?=l("Forgot the password?", "admin");?></a>
      </form><!-- /form -->

      <form method="post" action="" class="form-password hidden">
        <div class="alert alert-info">
          <h4>Forgot your password?</h4>
          <p>In order to receive your access code by email, please enter the address you provided during the registration process.</p>
        </div>
        <input type="email" id="email" placeholder="<?=l("Email address", "admin");?>" class="form-control" required />
        <a id="back-login"><i class="fa fa-long-arrow-left"></i><?=l("Back to login", "admin");?></a>
        <a id="send-password" class="btn btn-default btn-xs pull-right"><?=l("Send", "admin");?></a>
      </form><!-- /form -->

    </div><!-- /card-container -->

    <div id="login-footer">
      <p class="text-center text-muted">
        <a href="http://www.okadshop.com/" target="_blank">
          <?=l("© OkadShop 2016 - All rights reserved", "admin");?>
        </a>
      </p>
      <p class="text-center">
        <a href="https://twitter.com/OKADshop" target="_blank" title="Twitter">
          <i class="fa fa-twitter tw_color"></i>
        </a>
        <a href="https://www.facebook.com/OKADshop/" target="_blank" title="Facebook">
          <i class="fa fa-facebook fb_color"></i>
        </a>
        <a href="https://github.com/softhightech/okadshop" target="_blank" title="Github">
          <i class="fa fa-github git_color"></i>
        </a>
        <a href="https://plus.google.com/112035582044146693504" target="_blank" title="Google">
          <i class="fa fa-google-plus gp_color"></i>
        </a>
        <a href="https://www.youtube.com/channel/UC_NLvUcKRmqUq_arEKn7KlA" target="_blank" title="Youtube">
          <i class="fa fa-youtube yt_color"></i>
        </a>
      </p>
    </div>


  </div><!-- /container -->


  <!-- jQuery Library -->
  <script src="assets/js/jquery.min.js" type="text/javascript"></script>
  <script>
  $( document ).ready(function() {

    //forgot password form
    $("#forgot-password").on('click', function(){
      $(".form-signin").addClass('hidden');
      $(".form-password").removeClass('hidden');
    });

    //back to login form
    $("#back-login").on('click', function(){
      $(".form-signin").removeClass('hidden');
      $(".form-password").addClass('hidden');
    });

    //send password by email
    $("#send-password").on('click', function(){
      recover_user_password( $("#email").val() );
    });



  });

  function recover_user_password(email){
    var valid_email = ckeck_email_address(email);
    if( email == "" ){
      show_alert_message("<?=l('Address email is required.');?>", "danger");
      return false;
    }else if(!valid_email){
      show_alert_message("<?=l('Please enter a valid email address.');?>", "danger");
      return false;
    }
    $.ajax({
      type: "POST",
      data: {email:email},
      url: 'ajax/users/recover-password.php',
      success: function(response){
        try {
          var data = JSON.parse(response);
          if( data.error ){
            show_alert_message(data.error, "danger");
          }else if( data.success ){
            show_alert_message(data.success, "success");
          }else{
            show_alert_message("<?=l('An error has occurred !');?>", "danger");
          }
        }catch (e) {
          show_alert_message("<?=l('An error has occurred !');?>", "danger");
        }
      }
    });
  }

  function show_alert_message(message, type){
    if( type == "danger" ){
      $("#alert").removeClass("alert-success").addClass("alert-danger");
    }else{
      $("#alert").removeClass("alert-danger").addClass("alert-success");
    }
    $("#alert").show();
    $("#alert strong").text(message);
    $("#alert").fadeTo(2000, 500).slideUp(500);
    return false;
  }

  function ckeck_email_address(email) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email);
  }
  </script>
</body>
</html>