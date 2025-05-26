<?php
date_default_timezone_set('America/Los_Angeles');
$curhouse = "pioneer2";

$curday = date('Ymd');
$odir =  'pioneer2/' . $curday . '/IMG001';
$dir = '/home/camuser/home/camuser/' . $odir;
$files = scandir ($dir, SCANDIR_SORT_ASCENDING);
if (isset ($_GET ["archive"])) {
    $archfiles = [];
    for ($i = 0; $i < count ($files); $i++) {
	if ($files [$i] == '.' || $files[$i] == '..')
	    continue;	
	$file = $odir . '/' . $files [$i];
	$archfiles [$i] = $file;
    }
}

// finish off the rest
include ("links.php");
$links = $sflinks;
include ("camcmn.php");
include ("camhtml.php");
?>

