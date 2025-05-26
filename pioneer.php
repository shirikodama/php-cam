<?php
date_default_timezone_set('America/Los_Angeles');

// the job of this stub is to produce:
//
// $curhouse -- name of the cam 
// $odir -- the web directory of the pics
// $files -- a list of files for the current day
// $links -- a list of links at the bottom of the cam pic
// $solar -- the url of the iframe for the solar row

$curhouse = "pioneer";

// amccmn provides most of the inputs for cmn
include ('/home/mike/php-cams/amccmn.php');

// finish off the rest
include ("/home/mike/php-cams/links.php");
$links = $plinks;
include ("/home/mike/php-cams/camcmn.php");
include ("/home/mike/php-cams/camhtml.php");
?>
