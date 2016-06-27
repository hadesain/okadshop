<?php
//register module infos
require_once('php/function.php'); 
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "os-footer",
	"description" => "os-footer",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "others",
	"version" => "1.0.0",
	"config" => "footer_settings"
);
$hooks->register_module('os-footer', $data);

function os_footer_install(){
	global $DB;
		  $query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."footer_menu_links` (
		  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		  `title` varchar(255) NOT NULL,
		  `link` varchar(255) NOT NULL,
		  `block` int NOT NULL,
		  `position` int NOT NULL,
		  `cdate` DATE NOT NULL,
		  `udate` DATE NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$DB->query($query);
		  $query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."footer_menu` (
		  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		  `title` varchar(255) NOT NULL,
		  `block` INT NOT NULL,
		  `cdate` DATE NOT NULL,
		  `udate` DATE NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$DB->query($query);
}

function footer_displaycompany(){
	$output = "";
	$img = "";
 	$footer_image = select_mete_value('footer_image');
 	$footer_company_title = select_mete_value('footer_company_title');
 	$footer_company_address1 = select_mete_value('footer_company_address1');
 	$footer_company_address2 = select_mete_value('footer_company_address2');
 	$footer_company_phone = select_mete_value('footer_company_phone');
 	$footer_company_mail = select_mete_value('footer_company_mail');

 	if ($footer_image) {
 		$img = WebSite.'modules/os-footer/assets/images/'.$footer_image;
 	}
	$output .=' 
			<img alt="" src="'.$img.'">
            <p class="title">'.$footer_company_title.'</p>
            <p class="address1">'.$footer_company_address1.'</p>
            <p class="address2">'.$footer_company_address2.'</p>
            <p class="phone">'.$footer_company_phone.'</p>
            <p class="mail">'.$footer_company_mail.'</p>';
	echo $output;
}
add_hook('sec_footercompany', 'os-footer', 'footer_displaycompany', 'Display footer company');

function footer_displayblocks(){
	$output = "";
	$blocks = getFooterMenuByBlock();
	foreach ($blocks as $key => $block) {
		$output .= '<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
          <ul class="'.$block['title'].'">
            <li class="title">'.$block['title'].'</li>';
   $block_Links = getFooterMenuLinksByBlock($block['block']);
   foreach ($block_Links as $key => $link) {
   	if ($link['title'] == "Tarifs & Remises"){
    	 	if (isConnected()) {
    	 		$output .= '<li><a href="'.WebSite.$link['link'].'" title="'.$link['title'].'">'.$link['title'].'</a></li>';
    	 	}
        continue;
     }

   	$output .= '<li><a href="'.WebSite.$link['link'].'" title="'.$link['title'].'">'.$link['title'].'</a></li>';
   }  
    $output .= '</ul>
        </div>
        <span class="devider hidden-xs hidden-sm"></span>';
	}

	echo $output;
}
add_hook('sec_footerblocks', 'os-footer', 'footer_displayblocks', 'Display footer blocks');

global $p_theme;
$p_theme->add( l('Footer Configuration','osfooter'), '?module=modules&slug=os-footer&page=footer_settings');


function page_footer_settings(){
	$os_common = new os_common();
	$output = "";
	$msg = "";

	//update hooks position
	if(isset($_POST['update_footer_links'])){
	  $position_links = json_decode($_POST['position_links']);
	  if(!empty($position_links)){
	    foreach ($position_links as $key => $link) {
	      //set new position
	      $os_common->update('footer_menu_links', array('position' => $link->position), "WHERE id=".$link->id_link );
	    }
	  }
} 


	if (isset($_POST['footer_add_link']) && isset($_POST['block']) && !empty($_POST['footer_block_title'])) {
		$data = array(
			"title" => $_POST['footer_block_title'],
			"link" => $_POST['footer_block_link'],
			"block" => $_POST['block']
		);
		$os_common->save('footer_menu_links',$data);
	}
	if (isset($_POST['validate_footer_blocks'])) {
		if (isset($_POST['footer_block1_title'])) {
				$params = array(
					"title" => $_POST['footer_block1_title']
				);
			$res = $os_common->select('footer_menu', array('id'),"where block = 1");
				if (!$res || empty($res)) {
					$params['block'] = 1;
					$os_common->save('footer_menu',$params);
				}else{
					$os_common->update('footer_menu',$params,"where block = 1");
				}
		}
		if (isset($_POST['footer_block2_title'])) {
				$params = array(
					"title" => $_POST['footer_block2_title']
				);
				$res = $os_common->select('footer_menu', array('id'),"where block = 2");
				if (!$res || empty($res)) {
					$params['block'] = 2;
					$os_common->save('footer_menu',$params);
				}else{
					$os_common->update('footer_menu',$params,"where block = 2");
				}
		}
		if (isset($_POST['footer_block3_title'])) {
				$params = array(
					"title" => $_POST['footer_block3_title']
				);
				$res = $os_common->select('footer_menu', array('id'),"where block = 3");
				if (!$res || empty($res)) {
					$params['block'] = 3;
					$os_common->save('footer_menu',$params);
				}else{
					$os_common->update('footer_menu',$params,"where block = 3");
				}
		}
		
	}
	if ($_POST['validate_footer_company']) {
		$os_common->save_mete_value('footer_company_title',$_POST['footer_company_title']);
		$os_common->save_mete_value('footer_company_address1',$_POST['footer_company_address1']);
		$os_common->save_mete_value('footer_company_address2',$_POST['footer_company_address2']);
		$os_common->save_mete_value('footer_company_phone',$_POST['footer_company_phone']);
		$os_common->save_mete_value('footer_company_mail',$_POST['footer_company_mail']);

		if (isset($_FILES['footer_image']) && $_FILES['footer_image']['size']>0) {
			$allowed =  array('gif','png' ,'jpg',);
			$filename = $_FILES['footer_image']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed) ) {
				$uploaddir = "../modules/os-footer/assets/images/";
				$uploadfile = $uploaddir . basename($_FILES['footer_image']['name']);
				if (move_uploaded_file($_FILES['footer_image']['tmp_name'], $uploadfile)) {
					$attachement = basename($_FILES['footer_image']['name']);
					$os_common->save_mete_value('footer_image',$attachement);
				}
			}
		}

	}
	$footer_image = $os_common->select_mete_value('footer_image');
 	$footer_company_title = $os_common->select_mete_value('footer_company_title');
 	$footer_company_address1 = $os_common->select_mete_value('footer_company_address1');
 	$footer_company_address2 = $os_common->select_mete_value('footer_company_address2');
 	$footer_company_phone = $os_common->select_mete_value('footer_company_phone');
 	$footer_company_mail = $os_common->select_mete_value('footer_company_mail');

 	if ($footer_image) {
 		$img = WebSite.'modules/os-footer/assets/images/'.$footer_image;
 	}

	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
					<div class="top-menu padding0">
					  <div class="top-menu-title">
					    <h3><i class="fa fa-config" style="color: #002F86;"></i> Footer : '.l('Configuration','osfooter').'</h3>
					  </div>
					</div>
					<div class="panel panel-default" style="margin-top:10px;">
					  <div class="panel-heading">
					    <h3 class="panel-title">'.l('Footer Company Details','osfooter').'</h3>
					  </div>
					  <div class="panel-body">'.$msg .'
					  	
					  	<div class="form-group">
							<label for="owner">'.l('Changer Image footer','osfooter').'</label>
							<p><input class="form-control" type="file" name="footer_image" value=""/></p>
							<img class="form-control" alt="" src="'.$img.'" style="width:180px;height:50px;">
						</div>

					    <div class="form-group">
								<label for="owner">'.l('Title','osfooter').'</label>
								<p><input class="form-control" type="text" name="footer_company_title" value="'.$footer_company_title.'"/></p>
							</div>
							<div class="form-group">
								<label for="owner">'.l('Address1','osfooter').'</label>
								<p><input type="text" name="footer_company_address1" class="form-control" value="'.$footer_company_address1.'"/></p>
							</div>
							<div class="form-group">
								<label for="owner">'.l('Address2','osfooter').'</label>
								<p><input type="text" name="footer_company_address2" class="form-control" value="'.$footer_company_address2.'"/></p>
							</div>

							<div class="form-group">
								<label for="owner">'.l('Phone','osfooter').'</label>
								<p><input type="text" name="footer_company_phone" class="form-control" value="'.$footer_company_phone.'"/></p>
							</div>
							<div class="form-group">
								<label for="owner">'.l('Mail','osfooter').'</label>
								<p><input type="text" name="footer_company_mail" class="form-control" value="'.$footer_company_mail.'"/></p>
							</div>

							<div class="form-group">
								<input type="submit" class="btn btn-primary add-product" class="form-control" name="validate_footer_company" value="'.l('Enregistrer','osfooter').'"/>
							</div>
					  </div>
					</div>
	          
					</form>';
	$block1 = getFooterMenuByBlock(1);
	$block1_Links = getFooterMenuLinksByBlock(1);
	//var_dump($block1_Links);
	
	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
							<input type="hidden" name="position_links" value="" id="position_links">
					<div class="panel panel-default" style="margin-top:10px;">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.l('Footer Block','osfooter').'</h3>
				  </div>
				  <div class="panel-body">';
	$output .= '<h4><b>Footer Block 1</b></h4>
				    <div class="form-group">
							<label for="owner">'.l('Title','osfooter').'</label>
							<p><input class="form-control" type="text" name="footer_block1_title" value="'.$block1['title'].'"/></p>
						</div>
						
						<div row>
							<div class="panel panel-default col-md-3">
							   <div class="panel-body">
							      <ul class="sortable list">';
    foreach ($block1_Links as $key => $link) {
    	 $output .= '<li id="'.$link['id'].'" draggable="true">
							            <i class="fa fa-ellipsis-v"></i> '.$link['title'].'
							            <a href="javascript:;" class="btn btn-danger btn-sm pull-right disable_link"><i class="fa fa-trash"></i></a>
							         </li>';
    }
							      
	$output .= '</ul>
							   </div>
							   <!--/ .panel-body -->
							   <div class="panel-footer">
							      <input type="submit" name="update_footer_links" class="btn btn-primary btn-block" value="'.l('Souvegarder','osfooter').'">
							   </div>
							</div>
							<div class="col-md-6">
							<form class="" method="POST" action=""  enctype="multipart/form-data">
								<input type="hidden" name="block" value="1"/>
								<div class="form-group">
									<label for="Title">'.l('Title','osfooter').'</label>
									<p><input class="form-control" type="text" name="footer_block_title" value=""/></p>
									<label for="lien">'.l('lien','osfooter').'</label>
									<p><input class="form-control" type="text" name="footer_block_link" value=""/></p>
									<input type="submit" class="btn btn-primary" class="form-control" name="footer_add_link" value="'.l('Ajouter lien','osfooter').'"/>
								</div>
								</form>
							</div>
						</div>

						<div  style="clear: both;"></div>';
						
	$block2 = getFooterMenuByBlock(2);
	$block2_Links = getFooterMenuLinksByBlock(2);
	//var_dump($block1_Links);
	$output .= '<h4><b>'.l('Footer Block 2','osfooter').'</b></h4>
				    <div class="form-group">
							<label for="owner">'.l('Title','osfooter').'</label>
							<p><input class="form-control" type="text" name="footer_block2_title" value="'.$block2['title'].'"/></p>
						</div>
						
						<div row>
							<div class="panel panel-default col-md-3">
							   <div class="panel-body">
							      <ul class="sortable list">';
    foreach ($block2_Links as $key => $link) {
    	 $output .= '<li id="'.$link['id'].'" draggable="true">
							            <i class="fa fa-ellipsis-v"></i> '.$link['title'].'
							            <a href="javascript:;" class="btn btn-danger btn-sm pull-right disable_link"><i class="fa fa-trash"></i></a>
							         </li>';
    }
							      
	$output .= '</ul>
							   </div>
							   <!--/ .panel-body -->
							   <div class="panel-footer">
							      <input type="submit" name="update_footer_links" class="btn btn-primary btn-block" value="'.l('Souvegarder','osfooter').'">
							   </div>
							</div>
							<div class="col-md-6">
							<form class="" method="POST" action=""  enctype="multipart/form-data">
								<input type="hidden" name="block" value="2"/>
								<div class="form-group">
									<label for="Title">'.l('Title','osfooter').'</label>
									<p><input class="form-control" type="text" name="footer_block_title" value=""/></p>
									<label for="lien">lien</label>
									<p><input class="form-control" type="text" name="footer_block_link" value=""/></p>
									<input type="submit" class="btn btn-primary" class="form-control" name="footer_add_link" value="'.l('Ajouter lien','osfooter').'"/>
								</div>
								</form>
							</div>
						</div>

						<div  style="clear: both;"></div>';
	$block3 = getFooterMenuByBlock(3);
	$block3_Links = getFooterMenuLinksByBlock(3);
	//var_dump($block1_Links);
	
	$output .= '<h4><b>Footer Block 3</b></h4>
				    <div class="form-group">
							<label for="owner">'.l('Title','osfooter').'</label>
							<p><input class="form-control" type="text" name="footer_block3_title" value="'.$block3['title'].'"/></p>
						</div>
						
						<div row>
							<div class="panel panel-default col-md-3">
							   <div class="panel-body">
							      <ul class="sortable list">';
    foreach ($block3_Links as $key => $link) {
    	 $output .= '<li id="'.$link['id'].'" draggable="true">
							            <i class="fa fa-ellipsis-v"></i> '.$link['title'].'
							            <a href="javascript:;" class="btn btn-danger btn-sm pull-right disable_link"><i class="fa fa-trash"></i></a>
							         </li>';
    }
							      
	$output .= '</ul>
							   </div>
							   <!--/ .panel-body -->
							   <div class="panel-footer">
							      <input type="submit" name="update_footer_links" class="btn btn-primary btn-block" value="'.l('Souvegarder','osfooter').'">
							   </div>
							</div>
							<div class="col-md-6">
							<form class="" method="POST" action=""  enctype="multipart/form-data">
								<input type="hidden" name="block" value="3"/>
								<div class="form-group">
									<label for="Title">'.l('Title','osfooter').'</label>
									<p><input class="form-control" type="text" name="footer_block_title" value=""/></p>
									<label for="lien">'.l('lien','osfooter').'</label>
									<p><input class="form-control" type="text" name="footer_block_link" value=""/></p>
									<input type="submit" class="btn btn-primary" class="form-control" name="footer_add_link" value="'.l('Ajouter lien','osfooter').'"/>
								</div>
								</form>
							</div>
						</div>

						<div  style="clear: both;"></div>';


		$output .= '<div class="form-group">
							<input type="submit" class="btn btn-primary add-product" class="form-control" name="validate_footer_blocks" value="'.l('Enregistrer','osfooter').'"/>
						</div>
				  </div>
				</div>
			</form>';							
	echo $output;
	?>
<script type="text/javascript">
	$('a.disable_link').click(function(){
		var id_link = $(this).parent().attr('id');
		jQuery.ajax({
					url: "<?= WebSite ?>modules/os-footer/php/ajax.php",
					data:{action:'delete_footer_link',id_link:id_link},
					type: "POST",
					success:function(data){
						if (data == 1) {
							location.reload();
						}else
							alert("Non Suprimé");
					},
						error:function (){}
				});
	});

	 //sortable
  $('.sortable').bind('sortupdate', function() {
    var json = '';
    $(this).find('li').each(function(){
      json += ('{ "id_link":"'+ $(this).attr('id') +'", "position":"'+ ($(this).index()+1) +'" },');
    });
    json = json.slice(0,-1);
    json = json.replace(json, '['+json+']');
    $('#position_links').empty().val(json);
  });

</script>
	<?php
}

