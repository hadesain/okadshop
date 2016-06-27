<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
function page_view_message(){

	if ( 
		empty($_GET['email']) || empty($_GET['id_dir'])
		&& !is_numeric($_GET['email']) || intval($_GET['email']) <= 0
		&& !is_numeric($_GET['id_dir']) || intval($_GET['id_dir']) <= 0
	) return;

	$email = $_GET['email'];
	$from = intval($_GET['from']);
	$id_dir = intval($_GET['id_dir']);
	$contact = new Contact_Form();
	$allowed_tags = allowed_tags();
	$messages_list = '<script>window.location.href="?module=modules&slug=os-contact&page=messages"</script>';

	//sender data
	$sender = $contact->get_sender_info($email);


	// send message
	if( isset($_POST['send_message']) && !empty($_POST['message'])){

		global $common;

		$message_data = array(
			'from' 				 => $sender['from'],  
			'id_sender' 	 => $_SESSION['user'], 
			'id_receiver'  => $sender['from'], 
			'id_directory' => 1, 
			'object' 			 => $_POST['object'], 
			'firstname' 	 => $sender['firstname'], 
			'lastname' 		 => $sender['lastname'], 
			'company' 		 => $sender['company'], 
			'siret_tva' 	 => $sender['siret_tva'], 
			'email' 			 => $sender['email'], 
			'adresse' 		 => $sender['adresse'], 
			'adresse2' 		 => $sender['adresse2'], 
			'zipcode' 		 => $sender['zipcode'], 
			'city' 				 => $sender['city'], 
			'id_country' 	 => $sender['id_country'], 
			'mobile' 			 => $sender['mobile'], 
			'ip' 					 => $sender['ip']
		);
		$msg_signature = $common->select_mete_value('msg_signature');
		$signature = strip_tags($msg_signature, $allowed_tags);
		$signature = addslashes($signature);
		$message_data['message'] = strip_tags($_POST['message'], $allowed_tags) ."<div id='signature'>". $signature ."</div>";	

		// insert message
		$id_message = $common->save('contact_messages', $message_data);
		if( $id_message ){
			// upload attachement
		  if( isset($_FILES['attachement']) && $_FILES['attachement']['size'] > 0 ){
		  	$file_name 	 = time() . '_' . $_FILES['attachement']['name'][0];
		  	$file_name 	 = md5($file_name);
		    $uploadDir 	 = '../files/attachments/contact/'. $id_message .'/';
		    $extensions  = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt');
		    $file_target = $common->uploadDocument($_FILES['attachement'], $file_name, $uploadDir, $extensions);
		    $attachement = str_replace( $uploadDir , '', $file_target[0] );
		    if( $attachement != "" ){
		    	$common->update('contact_messages', array('attachement' => $attachement), "WHERE id=".$id_message );
		    }
		  }
		}
	  
	}


	


	


	$messages = $contact->get_message_by_directory($email, $id_dir);
	//if( empty($message) ) echo $messages_list;
	//var_dump($message);

	global $common;
	//$from = $messages[0]['from'];
	$viewed = $common->update(
		'contact_messages', 
		array('viewed' => "1", 'vdate' => date('Y-m-d H:s:m') ), 
		"WHERE `email`='$email' AND `id_receiver` NOT IN ($from) AND `viewed`=0"
	);
	//var_dump($viewed);
	//SELECT * FROM `contact_messages` WHERE `from`=3802 AND `id_sender` NOT IN (3802) AND `viewed`=0

	$directories = $common->select('contact_directories', array('id', 'name'));
	

	//customer exist
	$customer_exist = $common->select('users', array('email'), "WHERE email='". $sender['email'] ."'");



/*echo "<pre>";
print_r($messages);
echo "</pre>";*/
?>
<style>
#messages>tbody>tr>td, 
#messages>tbody>tr>th
{
 vertical-align: top !important;
}


.links{
	margin-bottom: 0px;
	display: none;
}
.message_row:hover .links{
	display: block;
}
.links li{
	display: inline-block;
	float: left;
	font-size: 12px;
}
.links li.hove_link:after{
	content: ".";
	font-size: 18px;
	padding: 10px;
	vertical-align: text-bottom;
	color: #A5245E;
}
.links li.hove_link:last-child:after{
	content: "";
}
.links li.hove_link a{
	color: #A5245E;
}

.nav-tabs{
	border-bottom: 2px solid #A5245E !important;
}
.alert-info{
	margin-top: 10px;
}

.dropdown-menu>li {
  display: block;
  float: none;
}
.nav-tabs .dropdown-menu>li>a{
	color: #000 !important;
}
.nav-tabs .dropdown-menu>li>a:hover{
	color: #fff !important;
}
.hove_link a{
	cursor: pointer;
}
.form-group {
    margin-bottom: 5px;
}

#message_wrap{
	margin-bottom: 20px;
    padding: 10px;
    margin-right: 0px;
    margin-left: 0px;
    background-color: rgba(165, 36, 94, 0.2);
}
.jFiler-theme-default .jFiler-input{
	width: 100%;
}

.note-editor .note-editable{
	background-color: #fff;
}

#signature{
	margin-top: 15px;
}
</style>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-envelope"></i> <?=l("Mesagerie", "contact");?></h3>
  </div>
  <div class="top-menu-button">
    <button type="button" class="btn btn-primary" onclick="window.location='index.php?module=modules&slug=os-contact&page=messages';"><?=l("Liste des messages", "contact");?></button>
  	<?php //if( !$customer_exist[0]['email'] ) : ?>
  		<!--a class="btn btn-success create_acount" data-email="<?//= $sender['email'];?>" data-from="<?//= $sender['from'];?>">Créer un compte</a-->
  	<?php //endif; ?>
  </div>
</div>
<br>

<div class="col-sm-3 left0">
	<table class="table table-bordered bg-white">
		<tr><th><?=l("Expéditeur", "contact");?></th><td><?php echo $sender['firstname']. ' ' .$sender['lastname'];?></td></tr>
		<tr><th><?=l("Société", "contact");?></th><td><?php echo $sender['company'];?></td></tr>
		<tr><th><?=l("Numéro d’entreprise", "contact");?></th><td><?php echo $sender['siret_tva'];?></td></tr>
		<tr><th><?=l("E-mail", "contact");?></th><td><?php echo $sender['email'];?></td></tr>
		<tr><th><?=l("Adresse", "contact");?></th><td><?php echo $sender['adresse'];?></td></tr>
		<tr><th><?=l("Code Postal", "contact");?></th> <td><?php echo $sender['zipcode'];?></td></tr>
		<tr><th><?=l("Ville", "contact");?></th><td><?php echo $sender['city'];?></td></tr>
		<tr><th><?=l("Pays", "contact");?></th><td><?php echo $sender['country'];?></td></tr>
		<tr><th><?=l("Addresse IP", "contact");?></th><td><?php echo $sender['ip'];?></td></tr> 
		<tr><th><?=l("Téléphone", "contact");?></th><td><?php echo $sender['mobile'];?></td></tr>
	</table>
	<div class="alert alert-info">
		<?php if( !$customer_exist[0]['email'] ) : ?>
			<h4><?=l("Ce client est un nouveau prospect.", "contact");?></h4>
  		<a class="btn btn-success btn-xs create_acount" data-email="<?= $sender['email'];?>" data-from="<?=$from;?>"><?=l("Créer un compte", "contact");?></a>
  	<?php else : ?>
  		<h4><?=l("Ce client est en compte.", "contact");?></h4>
  		<a target="_blank" href="?module=users&action=edit&id=<?=$from;?>" class="btn btn-success btn-xs"><?=l("Voir le profile", "contact");?></a>
  	<?php endif; ?>
	</div>
</div>


<div class="col-sm-9 left0 right0">

	
	<form class="form-horizontal message_form" id="message_wrap" method="post" action="" enctype="multipart/form-data" style="display: flex;" novalidate>
		<div class="col-sm-12 left0">

			<div class="form-group">
				<input type="text" name="object" class="form-control" id="object" placeholder="<?=l("Objet de message", "contact");?>">
			</div> 
			<div class="form-group">
				<textarea name="message" rows="1" class="form-control summernote" id="message" placeholder="<?=l("Message...", "contact");?>" required></textarea>
			</div> 
			<div class="form-group">
				<div class="col-sm-4 left0">
					<input type="file" name="attachement" id="attachement">
				</div>
				<div class="col-sm-2 pull-right right0">
					<button type="submit" name="send_message" class="btn btn-primary btn-block pull-right"><i class="fa fa-send-o"></i> <?=l("Envoyez", "contact");?></button>
				</div>
			</div> 

		</div>
	</form><br>

	<?php if( !empty($directories) ) : ?>
		<ul class="nav nav-tabs">
		<?php 
		$dirs = ""; 
		$dir_count = count($directories);
		?>
		<?php foreach ($directories as $key => $directory) : ?>
			<li <?=($directory['id'] == $id_dir ) ? 'class="active"' : ''; ?>>
				<a href="?module=modules&slug=os-contact&page=view-message&from=<?=$from;?>&email=<?=$email;?>&id_dir=<?=$directory['id'];?>#dir<?php echo $directory['id']; ?>" href="#dir<?php echo $directory['id']; ?>"><?php echo $directory['name']; ?></a>
			</li>

			<?php if( $key == 4 ) : ?>
			<li role="presentation" class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		      Dossiers <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
			<?php endif; ?>
			<?php  if( ($key+1) === $dir_count) : ?>
			</ul></li>
		  <?php endif; ?>

			<!-- prepar directories -->
			<?php $dirs .= '<li><a class="move_to" data-dir="'. $directory['id'] .'">'. $directory['name'] .'</a></li>';?>
		<?php endforeach; ?>
			<li class=" pull-right">
				<a href="" class="btn btn-default btn-sm" data-toggle="modal" data-target="#add_directory"><i class="fa fa-plus"></i> <?=l("Ajouter un Dossier", "contact");?></a>
			</li>
		</ul>
	<?php endif; ?>

	<div class="tab-content">
	  <div id="dir<?php echo $id_directory; ?>" class="tab-pane fade in active">
	  	<table class="table bg-white" id="messages">
				<?php if( !empty($messages) ) : ?>
					<?php foreach ($messages as $key => $message) : ?>
					<tr class="message_row">
						<td align="center" width="150">
							<strong><?php echo ( $message['id_sender'] == $from ) ? "Client" : "Admin"; ?></strong>
							<hr style="margin: 5px 0px;"> 
		          <p><?php echo date('d/m/Y H:m', strtotime($message['cdate']) ); ?></p>
						</td>
						<td style="vertical-align: top;">
							<strong>Sujet :</strong> <span class="message_object"><?=($message['object'] != "" ) ? $message['object'] : l("Sans sujet", "contact");?></span> - <strong><?=l("N°", "contact");?></strong><?php echo $message['id'];?>
							<br>
							<span class="message_body"><?php echo $message['message'];?></span>

							<ul class="links" data-msg="<?php echo $message['id'];?>">
								<li class="hove_link">
									<!-- <a class="move_to" data-dir="<?php //echo $message['id_directory'];?>">Déplacer</a> -->
									<div class="btn-group">
									  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=l("Déplacer", "contact");?> <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu">
									  	<?php echo $dirs; ?>
									  </ul>
									</div>
								</li>
								<li class="hove_link"><a class="replay"><?=l("Répondre", "contact");?></a></li>
								<li class="hove_link"><a class="relocate"><?=l("Transférer", "contact");?></a></li>
								<li class="hove_link"><a class="move_to" data-dir="3"><?=l("Supprimer", "contact");?></a></li>
								<li class="hove_link"><a class="move_to" data-dir="4"><?=l("Spam", "contact");?></a></li>
								<!--li class="hove_link"><a class="create_acount" data-dir="4">Créer un compte</a></li-->
								<?php if( $message['id_sender'] != $from ) : ?>
									<li class="hove_link"><?php echo ( $message['viewed'] == "1" ) ? 'Vue par le client le : '. date('m/d/y H:m:s A', $message['vdate']) : l("Le client ne l'a pas encore lu", "contact");?></li>
								<?php endif; ?>
							</ul>

						</td>
						<td width="20">
							<?php if( !empty($message['attachement']) ) : ?>
								<a download="<?=$message['attachement'];?>" title="<?=$message['file_name'];?>" href="<?php echo '../files/attachments/contact/'. $message['id'] .'/'. $message['attachement'];?>" class="btn btn-primary"><i class="fa fa-file-o"></i></a>
	            <?php endif; ?>
            </td>
					</tr>
					<?php endforeach; ?>
				<?php else : ?>
				<div class="alert alert-info"><?=l("Pas de messages dans ce dossier !", "contact");?></div>
				<?php endif; ?>
			</table>
			<?php 
			$non_allowed = array(1,2,3,4,5);
			if( !in_array($id_dir, $non_allowed) ) : ?>
				<a class="btn btn-danger" id="delete_directory" data-dir="<?php echo $id_dir; ?>"><i class="fa fa-trash"></i> <?=l("Supprimer ce Dossier", "contact");?></a>
	  	<?php endif; ?>
	  </div>
	</div>

	
</div>


<!-- Modal -->
<div class="modal fade" id="add_directory" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=l("Ajouter un Dossier", "contact");?></h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
					<label class="col-md-3 control-label" for="dir_name"><?=l("Nom de dossier", "contact");?></label>  
					<div class="col-md-6">
						<input id="dir_name" type="text" class="form-control" required>
					</div>
				</div>
				<br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_dir" ><?=l("Souvegarder", "contact");?></button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){


	//$( "#message" ).mouseenter(function() {}).mouseleave(function() {});

	//replay
	$('#delete_directory').on('click', function(){
		var choice = confirm("<?=l('Cette action supprime définitivement le dossier et ces messages de la base de donné. Êtes-vous vraiment sûr ?', 'contact');?>");
		if (choice == false) return;
		var id_dir = $(this).data('dir');
		$.ajax({
	      type: "POST",
	      data: {id_dir:id_dir},
	      url: '../modules/os-contact/ajax/delete-dir.php',
	      success: function(data){
					//message de notif
					$.bootstrapGrowl("<?=l('Le dossier a été supprimer.', 'contact');?>" , {type: 'info',align: 'right'});
					window.location.href="?module=modules&slug=os-contact&page=view-message&from=<?=$from;?>&id_dir=1";
					location.reload();
	      }
	    });
	});


	//replay
	$('.replay').on('click', function(){
		$('html, body').animate({
      scrollTop: $(".message_form").offset().top
    }, 500);
	});

	//Transférer 
	$('.relocate').on('click', function(){
		var message = $(this).closest('.message_row').find('.message_body');
		var object = $(this).closest('.message_row').find('.message_object').text();
		if( object == "sans sujet") object = "";
		$('#message_wrap #message').code(message);
		$('#message_wrap #object').val(object);
		$('html, body').animate({
      scrollTop: $(".message_form").offset().top
    }, 500);
	});



	//move message to directory
	$('.move_to').on('click', function(){
		var id_message = $(this).closest('.links').data('msg');
		var id_directory = $(this).data('dir');
		if( id_message == "" || id_directory == "") return;
    $.ajax({
      type: "POST",
      data: {id_message:id_message,id_directory:id_directory},
      url: '../modules/os-contact/ajax/moveto.php',
      success: function(data){
				//message de notif
				$.bootstrapGrowl("<?=l('Le message a été supprimer.', 'contact');?>" , {type: 'info',align: 'right'});
				location.reload();
      }
    });
	});


	//add new directory
	$('.save_dir').on('click', function(){
		var dir_name = $('#dir_name').val();
		if( dir_name == "" ) return;
    $.ajax({
      type: "POST",
      data: {dir_name:dir_name},
      url: '../modules/os-contact/ajax/new-dir.php',
      success: function(data){
				location.reload();
      }
		});
	});
	

	//create_acount
	$('.create_acount').on('click', function(){
		var email = $(this).data('email');
		var from = $(this).data('from');
		if( email == "" ) return;
    $.ajax({
      type: "POST",
      data: {email:email,from:from},
      url: '../modules/os-contact/ajax/create-acount.php',
      success: function(data){
				location.reload();
      }
		});
	});
	

	//msg_attachement
  $('#attachement').filer({
  	limit: 1,
    maxSize: 1,
    extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt']
  });

});
</script>
<?php
}