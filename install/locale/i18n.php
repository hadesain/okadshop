<?php
/*
   Copyright (c) 2003,2004,2005,2009 Danilo Segan <danilo@kvota.net>.
   Copyright (c) 2005,2006 Steven Armstrong <sa@c-area.ch>

   This file is part of PHP-gettext.

   PHP-gettext is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   PHP-gettext is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP-gettext; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

error_reporting(E_ALL | E_STRICT);

// define constants
define('DEFAULT_LOCALE', 'en_GB');


require_once('../languages/gettext/gettext.inc');

$supported_locales = array('ar_AR', 'en_GB', 'fr_FR');
$encoding = 'UTF-8';

$locale = (isset($_SESSION['code_lang'])) ? $_SESSION['code_lang'] : DEFAULT_LOCALE;
$direction = (isset($_SESSION['code_lang']) && $_SESSION['code_lang'] == "ar_AR") ? 'rtl' : "ltr";
putenv("LANGUAGE=$locale");

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'messages';
T_bindtextdomain($domain, 'locale');
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);

header("Content-type: text/html; charset=$encoding");
?>
