<?php
require_once '../../../../config/bootstrap.php';
require_once('../../../includes/classes/db/dbo.class.php');
$DBO = new DBO;

if(isset($_POST['module']))
{
    $Module = $_POST['module'];
    $DModule = $_POST['mdir'];
}else{
    die('Module indefined in Add');
}
require_once('../../../includes/plugins/'.$DModule.'/'.$Module.'/data.php');

if($Module == 'users' && isset($_POST['active']) && $_POST['active'] === "1"){
	$Mails 		= new Mails();
	$Sender 	= "no-reply@okadshop.com";
	$Receiver = $_POST['email'];
	$Subject 	= "OkadShop - Message confirmation";
	$Content 	= $_POST['last_name'] . ", Nous vous remercions de vous être inscrit(e) chez OkadShop.";
	$sentmail = $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
}


$DBO->UPDATE(PEDIT());
?>