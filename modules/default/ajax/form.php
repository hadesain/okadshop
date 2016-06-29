<?php

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

include '../../../config/bootstrap.php';

//prepare data
global $common;
$message = addslashes($_POST['message']);
$update = $common->save_mete_value('default_welcome_message', $message);

if( $update )
{
	$return['msg']  = l("Mise à jour effectué.", "default");
	echo json_encode( $return );
}

