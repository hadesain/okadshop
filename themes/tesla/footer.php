
    </div><!--/ .row -->
    </div><!--/ .container -->
  </div><!--/ #main -->

  <!-- Footer -->
  <footer id="footer">
    <?php 
     // execute_section_hooks( 'section_footer');
     ?> 
    <div class="container padding0">
      <div class="row links">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
          <div class="company_infos">
            <?php execute_section_hooks('sec_footercompany'); ?>

          </div>
        </div><!--/ .col-md-2 --> 
         <?php execute_section_hooks('sec_footerblocks'); ?>

        <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 cm-center padding0">

          <div class="clear" style="clear:both"></div>
        </div><!--/ .col-md-2 -->

      </div><!--/ .row -->
    </div><!--/ .container  -->

    <section id="services">
    <div class="container padding0">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"  style="padding: 0 5px;">
          <div class="box text-center">
            <p class="title"><!-- <a href="<?= WebSite; ?>cms/1-Livraison"></a> --><?=l("Livraison", "tesla");?></p>
            <p class="content"><?=l("Où que vous soyez, nous pouvons vous livrer !", "tesla");?></p>
            <!-- <p class="link"><a href="<?= WebSite; ?>cms/1-Transport" title="<?=l("Cliquez ici pour en savoir plus", "tesla");?>"><?=l("En savoir plus", "tesla");?></a></p> -->
          </div>
        </div><!--/ .col-md-3 -->

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"  style="padding: 0 5px;">
          <div class="box text-center">
            <p class="title"><!-- <a href="<?= WebSite; ?>cms/5-Paiement"></a> --><?=l("Paiement sécurisé ", "tesla");?></p>
            <p class="content"><?=l("Règlement 100% sécurisé !", "tesla");?></p>
           <!--  <p class="link"><a href="<?= WebSite; ?>cms/5-Paiement" title="<?=l("Cliquez ici pour en savoir plus", "tesla");?>"><?=l("En savoir plus", "tesla");?></a></p> -->
          </div>
        </div><!--/ .col-md-3 -->

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"  style="padding: 0 5px;">
          <div class="box text-center">
            <p class="title"><?=l("Programme fidélité", "tesla");?></p>
            <p class="content"><?=l("Votre fidélité récompensée ! ", "tesla");?></p>
          </div>
        </div><!--/ .col-md-3 -->

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"  style="padding: 0 5px;">
          <div class="box text-center">
            <p class="title"><?=l("Service client", "tesla");?></p>
            <p class="content"><?=l("Notre service client est à votre disposition du Lundi au vendredi de 10h à 17h et le Samedi de 10 à 12h.", "tesla");?></p>
          </div>
        </div><!--/ .col-md-3 -->

        <p class="description text-center">
          <!-- <span><?=l("Grossiste/ fournisseur", "tesla");?></span> -->
        </p>
        <p class="text-center"><img src="<?= themeDir; ?>images/logo_payment.png" alt="payment"></p>

        </div><!--/ .row -->
      </div><!--/ .container  -->
      </section><!--/ #services  -->

      <div class="container" id="copyright">
        &copy; OKADSHOP 2004-<?= date("Y");  ?>. <?=l("Tous droits réservés", "tesla");?>
      </div>


  </footer><!--/ #footer --> 
  
  <?php 
    $os_quick_sales_active = select_mete_value('os_quick_sales');
    if ($os_quick_sales_active && !isset($_SESSION['home_popup'])) {
      $_SESSION['home_popup'] = 'true';
      echo "<script>$('#home_popup_block').modal('show');</script>";
    }
  ?>
  <?php if (!isset($_SESSION['home_popup'])): ?>
  <?php $home_popup_block_content = select_mete_value('home_popup_block_content'); ?>
      <div class="modal fade" tabindex="-1" role="dialog" id="home_popup_block">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Promotion</h4>
            </div>
            <div class="modal-body">
              <?= $home_popup_block_content; ?>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
  <?php endif ?>



  <!-- JAVASCRIPT  -->
  <script src="<?= $themeDir;?>js/bootstrap.min.js"></script>
  <script src="<?= $themeDir;?>js/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
  <script src="<?= $themeDir;?>js/theme.js"></script>
  <script src="<?= $themeDir;?>js/jquery.flexslider-min.js"></script>

  <script type="text/javascript" src="<?= $themeDir;?>js/fancybox/jquery.fancybox.js"></script>


  <script src="<?= $themeDir;?>js/app.js"></script>
  <script src="<?= $themeDir;?>js/cart.js"></script>
  <script src="<?= $themeDir;?>js/order.js"></script>
  <?php  execute_section_hooks( 'sec_footer_link'); ?>


  <script>
  $(document).ready(function(){
    $.ajax({
      type: "POST",
      url: "<?=$website_url;?>./modules/os-relance-bienvenue/ajax/send-emails.php",
      success: function(data){
        //console.log(data);
      }
    });
  });
  </script>
  <?php

  if (isset($_POST['lang_list'])) {

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $lang = explode('_', $_SESSION['code_lang']);
    $lang = $lang[0];
    $module = $_GET['Module'];
    if (empty($module)) {
      if (isset($_GET['lang'])){
        $actual_link = str_replace('/'.$_GET['lang'].'/', '/'.$lang.'/', $actual_link);
      }
      else
        $actual_link .= $lang.'/';
    }else{
    if (isset($_GET['lang'])) {
       $actual_link = str_replace('/'.$_GET['lang'].'/', '/'.$lang.'/', $actual_link);
    }else{
      $pos = strpos($actual_link, $module);
      $actual_link = substr_replace($actual_link,'/'. $lang.'/', $pos, 0);
    }

    }
    //echo  $actual_link;
   echo '<script> window.location.replace("'.$actual_link.'"); </script>';
  }

//addLangToUrl();
   ?>

  <?php if (isset($_GET['lang'])): ?>
    <script>
      var lang = "<?= $_GET['lang']; ?>";
      var old_link = "<?= WebSite; ?>";
      var new_link = "<?= WebSite; ?>"+lang+"/";
      if( lang != null ){
        $("a:not([href*='javascript:;']):not(.product_image_galery)").each(function(){
          var href = $(this).attr("href"); 
          if( href != undefined )
          {
              $(this).attr("href", href.replace(old_link,new_link));
          }
        });
      }
    </script>
  <?php endif ?>
<?=os_footer();?>
</body>
</html>