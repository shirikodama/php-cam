<?php
date_default_timezone_set('America/Los_Angeles');
$curhouse = "pioneer2";


function pioneer2 () {
    global $odir, $files;
    $curday = date('Ymd');
    $odir =  'pioneer2/' . $curday . '/IMG001';
    $dir = '/home/camuser/home/camuser/' . $odir;
    $files = scandir ($dir, SCANDIR_SORT_ASCENDING);
}

if (isset ($_GET ["archive"])) {
    $archfiles = [];
    for ($i = 0; $i < count ($files); $i++) {
	if ($files [$i] == '.' || $files[$i] == '..')
	    continue;	
	$file = $odir . '/' . $files [$i];
	$archfiles [$i] = $file;
    }
}

if (! isset ($_GET['noinit'])) {
    pioneer2 ();
    // finish off the rest
    include ("/home/mike/php-cams/links.php");
    $links = $sflinks;
    include ("/home/mike/php-cams/camcmn.php");
    caminit ();
    include ("/home/mike/php-cams/camhtml.php");
}
?>

