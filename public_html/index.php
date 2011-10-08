<?php

/*
+--------------------------------------
| Quickshop
+--------------------------------------
| Bob DeVeaux
| 8th Ocotober 2011
+--------------------------------------
*/

require_once ("../_private/classes/class.config.php");
require_once ("../_private/classes/class.template.php");
require_once ("../_private/classes/class.quickshopbase.php");



//require_once ("../../_private/class.sitebuilder.functions.php");
//require_once ("min/utils.php");
//require_once ("min/lib/Minify/HTML.php");


Session_Start();

$sb = new quickshop;
$sb->direct();
$sb->draw();

?>
