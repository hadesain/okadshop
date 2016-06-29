<?php
require_once 'header.php';
$Security = new Security();
$DB = Database::getInstance();
?>
<style>
@CHARSET "UTF-8";

* {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
    outline: none;
}

html {
  height: 100%;
}

body {
    background: #A5245E !important;
    min-height: 100%;
}


.login-form {
    max-width: 400px;
    margin: 0 auto;
}

form[role=login] {
    font: 16px/1.6em Lato, serif;
    color: #A5245E;
    background: #fff;
    margin-top: 100px;
    padding: 0 50px 25px 50px;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
}
form[role=login] > section {
    text-align: center;
    font-size: 14px;
    margin-top: 2em;
}
    form[role=login] section a {
        color: #A5245E;
    }
form[role=login] h3 {
    font-size: 30px;
    text-align: center;
    color: #c0c0c0;
    padding: 35px 0 12px 0;
}
    form[role=login] h3 b {
        color: #A5245E;
    }

    form[role=login] span.glyphicon {
        color: #adadad;
    }
    form[role=login] input,
    form[role=login] button {
        font-size: 16px;
        margin: 5px 0;
    }
    form[role=login] input {
        color: #c1c4c5;
        background: #fafafa;
        border: none;
        padding-left: 40px;
        border: 1px solid #EDEDED;
    }
        form[role=login] input::-webkit-input-placeholder {
            color: #c1c4c5;
        }
        form[role=login] input:-moz-placeholder {
            color: #c1c4c5;
        }
        form[role=login] input::-moz-placeholder {
            color: #c1c4c5;
        }
        form[role=login] input:-ms-input-placeholder {  
            color: #c1c4c5;
        }
    form[role=login] button {
        line-height: 30px;
        font-weight: bold;
        -webkit-box-shadow: 0px 3px 0px 0px rgba(24, 121, 158, 1);
           -moz-box-shadow: 0px 3px 0px 0px rgba(24, 121, 158, 1);
                box-shadow: 0px 3px 0px 0px rgba(24, 121, 158, 1);
        background: #3796ba;
        border: none;
    }
    form[role=login] button:hover {
        background: #4eaccf;
    }
    
    .btn.btn-success {
        background-color: #3E9E28;
    }

.login-form .form-control {
    padding-left: 40px;
}
.login-form .form-control + .glyphicon {
    position: absolute;
    left: 0;
    top: 22%;
    padding: 6px 0 0 27px;
}

    h5{
        color: white;
        font-size: 40px;
        margin-top: 39px;
        margin-left: 68px;
        position: absolute;
        opacity: 0.2;
        font-weight: bold;
    }
</style>

<section class="container">
    <section class="login-form">
    <form method="post" action="" role="login">
      <input type="hidden" name="class" value="login">
        <h3><b><?=l("OkadShop", "admin");?></b> <?=l("Connexion", "admin");?></h3>
        <div class="row">
            <div class="col-xs-12">
                <input type="email" name="email" placeholder="Adresse &eacute;lectronique" required class="form-control input-lg" />
                <span class="glyphicon glyphicon-user"></span>
            </div>
            <div class="col-xs-12">
                <input type="password" name="password" placeholder="Mot de passe" required class="form-control input-lg" />
                <span class="glyphicon glyphicon-lock"></span>
            </div>
        </div>
        <button type="submit" id="con" value="connexion" class="btn btn-lg btn-block btn-success"><?=l("SE CONNECTER", "admin");?></button>
        <section>
            <a class="retoure" href="../"><?=l("Retour au Site", "admin");?></a>
        </section>
    </form>
    </section>
</section>
<?php
die();
?>