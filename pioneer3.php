<?php
date_default_timezone_set('America/Los_Angeles');
$curhouse = "pioneer3";

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

function pioneer3 () {
    global $files, $odir, $dir, $curhouse;
    // get the requested files
    $curday = date('Ymd');
    $odir = $curhouse . '/' .$curday . '/images/';
    $dir = '/home/camuser/' . $odir;    
    $files = mscandir ($dir);
}

if (isset ($_GET ["archive"])) {
    $archfiles = [];
    for ($i = 0; $i < count ($files); $i++) {
	if ($files [$i] == '.' || $files[$i] == '..')
	    continue;	
	$file = $odir . '/' . $files [$i];
	$archfiles [] = $file;
    }
}


if (! isset ($_GET['noinit'])) {
    pioneer3 ();
    // finish off the rest
    include ("/home/mike/php-cams/links.php");
    $links = $sflinks;
    include ("/home/mike/php-cams/camcmn.php");
    caminit ();
    include ("/home/mike/php-cams/camhtml.php");
}
?>
