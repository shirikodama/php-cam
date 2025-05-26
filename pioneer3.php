<?php
date_default_timezone_set('America/Los_Angeles');
$curhouse = "pioneer3";

// get the requested files
$curday = date('Ymd');
$odir = $curhouse . '/' .$curday . '/images/';
$dir = '/home/camuser/' . $odir;

function mscandir($dir) {
    $files = array();
    foreach (scandir($dir) as $file) {
	if ($file == '.' || $file == '..') continue;
	$files[$file] = filemtime($dir . '/' . $file);
    }
    arsort($files);
    $files = array_reverse (array_keys($files));
    return $files;
}

$files = mscandir ($dir);

if (isset ($_GET ["archive"])) {
    $archfiles = [];
    for ($i = 0; $i < count ($files); $i++) {
	if ($files [$i] == '.' || $files[$i] == '..')
	    continue;	
	$file = $odir . '/' . $files [$i];
	$archfiles [] = $file;
    }
}

// finish off the rest
include ("links.php");
$links = $sflinks;
include ("camcmn.php");
include ("camhtml.php");
?>
