<?php

include('connect.php');

$lang ='includes/languages/'; 
$tpl  ='includes/templates/';
$func ='includes/functions/';
$css  ='layout/css/';
$js   ='layout/js/';
// Include The Important Files

include($lang.'English.php');
include($func.'functions.php');
include($tpl.'header.php') ;
if(!isset($nonavbar)){ include($tpl.'navbar.php') ; }
