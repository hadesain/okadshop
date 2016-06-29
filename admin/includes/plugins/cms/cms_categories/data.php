<?php
function Add()
{

	$user=new FORMS();
	$form = array(   

  array('DIVSTART','','col-sm-12 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-user"></i> Ajouter une categories d\'une page'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('users'),
      array('HIDDEN','module','50','module','module','cms_categories'),
      array('HIDDEN','redirect','50','redirect','redirect','cms_categories'),
      array('HIDDEN','mdir','50','mdir','mdir','cms'),
      array('DIVSTART','','form-horizontal inline-custom'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title','form-control','form-control','title','title','','title'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','description','form-control','form-control','description','description','','description'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','User Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),
    array('DIVEND'),
    array('DIVEND'),//END PANEL BODY

    array('DIVSTART','','panel-footer clearfix'),
      array('DIVSTART','','pull-right'),
        array('BUTTON','Ajouter','send','btn btn-primary','send'),
        array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
      array('DIVEND'),
    array('DIVEND'),//PANEL FOOTER
      
  array('DIVEND'),//END PANEL

                   
  );
  $user->Draw($form);

//END USER ADD FUNCTION
}
function PADD()
{
  $Post = array(
    array(_DB_PREFIX_.'cms_categories'),
    array('title','title','text','100','text'),
    array('description','description','text','1000','text'),
    array('id_lang','id_lang','text','45','text'),
  );
  return $Post;
}


function EDIT($ID)
{				

  $tags = new FORMS();
  $form=array(

  array(_DB_PREFIX_.'cms_categories'/*table*/,'id'/*id table*/,$ID),
  array('HIDDEN','test','test',50,'module','module','cms_categories'),
  array('HIDDEN','test','test',50,'mdir','mdir','cms'),
  array('DIVSTART'/*first div*/,''/*class*/,'form-horizontal'/*id*/),

    array('DIVSTART','','col-sm-6 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-pencil"></i> Edit User'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title'/*name field*/,'title'/*name post*/,'100'/*size post*/,'form-control'/*class*/,'title'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 right0'),
        array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','description'/*name field*/,'description'/*name post*/,'1000'/*size post*/,'form-control'/*class*/,'description'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),


    array('DIVEND'),//END PANEL BODY

    array('DIVSTART','','panel-footer clearfix'),
      array('DIVSTART','','pull-right'),
        array('BUTTON','Modifier','send','btn btn-primary','send'),
        array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
      array('DIVEND'),
    array('DIVEND'),//PANEL FOOTER
      
  array('DIVEND'),//END PANEL



		);
	$tags->EDraw($form);

//END EDIT USER
}


function PEDIT()
{
  $Post = array(
    array(_DB_PREFIX_.'cms_categories'),
    array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/),
    array('title'/*name field*/,'title'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('description'/*name field*/,'description'/*name post*/,'text'/*type verification*/,'1000'/*size post*/),
    array('id_lang','id_lang','text','45','text'),

  );
  return $Post;
}


function DELETE($ID) {
  global $common;
  $common->delete('cms_categories', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=cms_categories"</script>';
}
?>