<?php
$cUser = getCurrentUser();
header('Cache-Control: max-age=900');
$floatdir = "right";
?>

<!DOCTYPE html>
<html dir="<?= $direction ?>" lang="<?= $lang_sign; ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex">
  <meta name="generator" content="OKADshop" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= get_meta_data('description'); ?>" />
  <meta name="keywords" content="<?= get_meta_data('keywords'); ?>" />
  <link rel="icon" type="image/png" href="<?= $themeDir; ?>images/favicon.png" /> 
  <title><?= get_meta_data('title'); ?></title>
  <!-- CSS -->
  <link href="<?=$themeDir;?>css/bootstrap.min.css" rel="stylesheet">
  
  
  
  <link href="<?=$themeDir;?>css/font-awesome.min.css" rel="stylesheet">
   <link href="<?=$themeDir;?>css/datepicker/datepicker3.min.css" rel="stylesheet" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="<?=$themeDir;?>css/flexslider.css" type="text/css" media="screen" />
  <link href="<?=$themeDir;?>css/theme.css" rel="stylesheet">
  <link href="<?=$themeDir;?>css/footer.css" rel="stylesheet">
  <link href="<?=$themeDir;?>css/order.css" rel="stylesheet">
  <link href="<?=$themeDir;?>css/responsive.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Federo' rel='stylesheet' type='text/css'>
 
  <link rel="stylesheet" href="<?=$themeDir;?>css/fancybox/jquery.fancybox.css" type="text/css" media="screen" />

  <?php if ($lang_sign == 'ar'): ?>
    <?php $floatdir = "left"; ?>
    <!-- Load Bootstrap RTL theme from RawGit -->
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <!-- Load Bootstrap RTL theme from RawGit -->
    <link rel="stylesheet" href="<?=$themeDir;?>css/arabic-style.css">
  <?php endif ?>
   <link rel="stylesheet" href="<?=$themeDir;?>css/tesla.css">
  <script type="text/javascript">
    //Global JavaScript variable
    WebSite = '<?= WebSite; ?>';
    CURRENCY  = '<?= CURRENCY; ?>';
  </script>
  <script src="<?= $themeDir;?>js/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js" integrity="sha256-mFypf4R+nyQVTrc8dBd0DKddGB5AedThU73sLmLWdc0=" crossorigin="anonymous"></script>

  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-62016326-1', 'auto');
    ga('send', 'pageview');

  </script>

  <?=os_header();?>
</head>
<body class="wrapper">
  <header id="header">
    <?php execute_section_hooks('sec_header');?>
    <div id="header_top_nav">
      <div class="container">
        <?php if ($top_header_description = $hooks->select_meta_value("top_header_description")): ?>
          <h1 style="text-align: center;"><?=$top_header_description; ?></h1>
        <?php endif ?>   
      </div>
    </div>
    <div class="container padding0">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="float:left;">
          <ul class="links">
            <li><a href="<?= WebSite;?>" title="<?=l("Accueil", "tesla");?>" class="selected"><?=l("Accueil", "tesla");?></span></a></li><!-- <i class="fa fa-home"></i><span>  -->
            <li><a href="<?= WebSite;?>contact" title="<?=l("Contact", "tesla");?>"><span> <?=l("Contact", "tesla");?></span></a></li><!-- <i class="fa fa-envelope"></i> -->
            <li><a href="<?= WebSite;?>sitemap" title="<?=l("Plan du site", "tesla");?>"><span> <?=l("Plan du site", "tesla");?></span></a></li><!-- <i class="fa fa-sitemap"></i> -->
          </ul>

          <?php 
            $langs = $hooks->select('langs',array('*'),'WHERE active=1');
            $currencies = $hooks->select('currencies',array('*'),'WHERE active=1');
          ?>

          <div class="selectbox">
            <form action="" id="setCurrency" method="post">
              <select id="currency">
                <?php if ($currencies): ?>
                  <?php foreach ($currencies as $key => $cur): ?>
                    <option value="<?=$cur['id'] ?>"><?=$cur['sign'] ?></option>
                  <?php endforeach ?>
                <?php endif ?>
              </select>
            </form>
          </div>
          <!--/ .selectbox  -->
          
          <div class="selectbox">
            <form action="" id="lang_list_form" method="post">
              <select id="lang_list" name="lang_list">
                <?php foreach ($langs as $key => $lang): ?>
                  <option value="<?= $lang['code'] ?>" <?= (isset($_SESSION['code_lang'] ) && $_SESSION['code_lang'] == $lang['code']) ? 'selected':''; ?>><?= $lang['short_name'] ?></option>
                <?php endforeach ?>
              </select>
            </form>
          </div>
          <!--/ .selectbox  -->
        </div><!--/ .col-sm-6  -->
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <ul class="links pull-right">
            <?php if ($cUser): ?>
              <li><?= $cUser['first_name'].' ' .$cUser['last_name'] ; ?></li>
              <li><a href="<?=  WebSite;?>account/logout" title="" class=""><?=l("Déconnexion", "tesla");?></a></li>
            <?php else: ?>
              <li><?=l("Bienvenue", "tesla");?></li>
              <li><a href="<?=  WebSite;?>account/login" title="" class="selected"><?=l("Identifiez-vous", "tesla");?></a></li>
            <?php endif ?>
            <li><a href="<?php if($cUser) echo WebSite.'account'; else  echo WebSite.'account/login'; ?>" title="" class="selected"><?=l("Mon compte", "tesla");?></a></li>
          </ul><!--/ .links  -->
        </div><!--/ .col-sm-6  -->
      </div><!--/ .row -->
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <a href="<?= WebSite;?>" id="logo" title="">
            <img class="logo" src="<?= $themeDir;?>images/logo.png" alt="">
          </a>
        </div><!--/ .col-sm-6  -->
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div id="shopping_cart">
              <a href="<?= WebSite;?>cart" title="<?=l("Panier", "tesla");?>">
                <span class="cart_title"><?=l("Panier", "tesla");?></span> 
                <span class="product_total_montant product_total" style="font-size: 16px; ">
                <?php 
                  if (function_exists('MontantGlobal')) {
                     echo MontantGlobal();
                  }
                ?> 
                </span>
                <span class="CURRENCY" style="font-size: 16px; "><?=CURRENCY; ?></span>
                </span>
              </a>
            </div>
          
          <!--/ .shopping_cart -->
          <form action="<?= WebSite;?>search" class="searchbox pull-<?=$floatdir; ?>" method="POST">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="<?=l("Rechercher un produit...", "tesla");?>" name="search_query" value="<?= htmlentities($_POST['search_query']) ?>">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-default" value="OK"></input>
              </span>
            </div>
          </form><!--/ .form -->
        </div><!--/ .col-sm-6  -->
      </div><!--/ .row -->

      <div class="row">
        <div class="col-sm-12">
          <nav class="navbar navbar-default navbar-custom">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-brand-home-menu" href="<?= WebSite;?>" class="active"><i class="fa fa-home"></i></a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <?php $homeCategory = getcategoryByParent(1); ?>
                <ul class="nav navbar-nav">
                  <?php 
                  if ($homeCategory){
                    foreach ($homeCategory as $key => $value){
                      $subCategory = getcategoryByParent($value['id']); 
                      if ($subCategory && !empty($subCategory)) {
                          echo '<li class="dropdown"><a href="'.WebSite.'category/'.$value['id'].'-'.$value['permalink'].'" class="" data-toggle="" role="button" aria-haspopup="true" aria-expanded="false">'.$value['name'].'<span class="caret"></span></a><ul class="dropdown-menu">';
                         foreach ($subCategory as $key => $value2){
                                $subSubCategory = getcategoryByParent($value2['id']); 
                                if ($subSubCategory && !empty($subSubCategory)) {
                                  echo '<li class="dropdown-submenu"><a tabindex="-1" href="'.WebSite.'category/'.$value2['id'].'">'.$value2['name'].'</a><ul class="dropdown-menu">';
                                  foreach ($subSubCategory as $key => $value3) {
                                   echo '<li><a href="'.WebSite.'category/'.$value3['id'].'-'.$value3['permalink'].'">'.$value3['name'].'</a></li>';
                                  }
                                   echo '</ul></li>';
                                }else{
                                  echo '<li><a href="'.WebSite.'category/'.$value2['id'].'-'.$value2['permalink'].'">'.$value2['name'].'</a></li>';
                                }

                         }
                         echo '</ul></li>';

                      }else{
                        echo '<li><a href="'.WebSite.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a></li>';
                      }
                    } 
                  } 
                  ?>
                 
                 <!--  <li class=""><a href="<?= WebSite; ?>views/new-products"><?=l("Nouveautés", "tesla");?></a></li>
                  <li><a href="<?= WebSite; ?>views/promos"><?=l("Promotions", "tesla");?></a></li> -->
                </ul>
                <ul class="nav navbar-nav navbar-<?=$floatdir;?>">
                  <?php if (!$cUser): ?>
                    <li><a href="<?= WebSite; ?>account/login"><?=l("Créer un compte", "tesla");?></a></li>
                  <?php else: ?>
                    <li><a href="<?= WebSite; ?>account"><?=l("Mon compte", "tesla");?></a></li>
                  <?php endif ?>
                  <li><a href="<?= WebSite; ?>contact"><?=l("Contact", "tesla");?></a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
          </nav>
        </div><!--/ .col-sm-12 -->
      </div><!--/ .row -->

    </div><!--/ .container -->

    <?php execute_section_hooks('sec_header_buttom'); ?>
  </header>

  <!-- MAIN CONTENT -->
  <div class="container" id="main">
    <div class="row">
      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 hidden-xs hidden-sm" id="sidebar">
        <div class="block">
          <?php //include_once('includes/sidebar.php'); ?>
          <?php  execute_section_hooks('sec_sidebar');
                // execute_hooks_by_section('sec_sidebar');
                 //execute_hooks_by_section('sec_front_footer');
           ?>
        </div>
      </div><!--/ .sidebar -->
      <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" id="content">