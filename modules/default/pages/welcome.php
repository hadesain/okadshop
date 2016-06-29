<?php
function page_welcome(){
  //get welcome message
  global $common;
  $message = $common->select_mete_value('default_welcome_message');
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-plus-circle"></i> <?=l("Message de Bienvenue", "default");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="default_form" method="post" action="<?=_BASE_URL_.'modules/default/ajax/form.php';?>">
  <div class="panel-heading"><?=l("Message", "default");?></div>
  <div class="panel-body">

    <div class="form-group">
      <label class="control-label col-lg-3" for="message"><?=l("Message *", "default");?></label>
      <div class="col-lg-4">
        <input type="text" name="message" id="message" value="<?=$message;?>" class="form-control" required autofocus>     
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="<?=go_dashboard();?>" class="btn btn-default"><?=l("Fermer", "default");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder", "default");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //default form
  $("form#default_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("default_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>

<?php
}