<?php
//prepare datatable default language
if (isset($_POST['lang_list'])) {
  $_SESSION['code_lang'] = $_POST['lang_list'];
  //datatable lang
  switch ( $_POST['lang_list'] ) {
    case "fr_FR":
      $dt_lang = "French";
      break;
    case "en_US":
      $dt_lang = "English";
      break;
    case "ar_AR":
      $dt_lang = "Arabic";
      break;
    case "es_ES":
      $dt_lang = "Spanish";
      break;
    case "de_DE":
      $dt_lang = "German";
      break;
    case "it_IT":
      $dt_lang = "Italian";
      break;
    case "pt_PT":
      $dt_lang = "Portuguese";
      break;
    case "pl_PL":
      $dt_lang = "Polish";
      break;
    case "nl_NL":
      $dt_lang = "Dutch";
      break;
    default:
      $dt_lang = "French";  
  } 
  $_SESSION['dt_lang'] = $dt_lang;
}

//set language session
if (!isset($_POST['lang_list']) && ( (isset($_GET['lang']) && !isset($_SESSION['code_lang'])) || (isset($_GET['lang']) && isset($_SESSION['code_lang']) && $_SESSION['code_lang'] != $_GET['lang']) )) {
  global $common;
  $res = $common->select('langs',array("code")," WHERE short_name ='".$_GET['lang']."'");
  if (isset($res[0])) {
    $_SESSION['code_lang'] = $res[0]['code'];
  }
}
//echo $_SESSION['code_lang'];
//some vars
$os_encoding = 'UTF-8';
$os_lang = (isset($_SESSION['code_lang'])) ? $_SESSION['code_lang'] : "fr_FR";
putenv("LANGUAGE=$os_lang");
$direction = (isset($_SESSION['code_lang']) && $_SESSION['code_lang'] == "ar_AR") ? 'rtl' : "ltr";
$lang_sign = isset($_SESSION['code_lang']) ? explode('_', $_SESSION['code_lang'])[0] : 'fr';
$os_direction = "ltr";

// gettext setup
T_setlocale(LC_MESSAGES, $os_lang);

//select translations file
function select_tr_file($os_file) {
  T_bindtextdomain($os_file, DOMAIN); // The constant being the path of you translations file directory
  T_bind_textdomain_codeset($os_file, "UTF-8");
  T_textdomain($os_file);
}

//function to translate strings
function l($msgid, $os_domain="okadshop"){ // called l() to make it very short to type
  select_tr_file($os_domain); // Switch the translations file
  return T_($msgid); // Return the translated string
}