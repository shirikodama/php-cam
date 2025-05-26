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
include ('amccmn.php');


// finish off the rest
include ("links.php");
$links = $plinks;
include ("camcmn.php");
include ("camhtml.php");
?>
