<?php
//go to install
if(!file_exists('../config/config.inc.php'))
{
 header('location:../install/index.php');
}
define("_OS_ADMIN_", true);
require '../config/bootstrap.php';
require 'includes/classes/forms/forms.class.php';
//require'includes/classes/tables/tables.class.php';
require 'includes/functions/functions.php';
require 'includes/controller.php';
require 'includes/views.php';
?>