<?php
// get the current file requested

function amcinit ($curhouse, $camdir = NULL) {
    global $odir, $files, $camfile;
    $amcdir = glob ($curhouse . '/AMC*');
    if (count ($amcdir) == 0 || strpos ($amcdir [0], "AMC") === false) {
	if ($camdir)
	    $days = $curhouse . $camdir;
	else
	    $days = $curhouse . '/XXX';	
    } else {
	$days = $amcdir[0];
    }
    $curday = date('Y-m-d');
    $odir = $days . '/' . $curday . '/001/jpg';
    if (! file_exists ($odir)) {
	die ("<br>Can't find Amcrest device directory for '$curhouse' od=$odir.");
    }
    $adir = $odir;
    // the amcrest creates directories for hours and minutes
    $camuser = 'camuser';
    $dir = "/home/$camuser/" . $odir;
    $archdir = $odir;
    $path = '';
    // this is getting the current hours and minutes in the day directory and appending it to path
    $files = scandir ($dir . $path, SCANDIR_SORT_ASCENDING);
    $path .= '/' . end ($files);
    // this is a hack because the old cams write a minutes dir too
    if ($curhouse == 'pioneer') {
	$files = scandir ($dir . $path, SCANDIR_SORT_ASCENDING);
	$path .= '/' . end ($files);
    }
    $odir .= $path;
    $dir .= $path;
    $files = array_slice (scandir ($dir, SCANDIR_SORT_ASCENDING), 2);
}

if (isset ($_GET["archive"])) {
    $it = new RecursiveDirectoryIterator($archdir);
    $archfiles = Array ();
    $pics = Array ( 'jpeg', 'jpg' );
    foreach(new RecursiveIteratorIterator($it) as $file => $cur) {
	if(! in_array(substr($file, strrpos($file, '.') + 1), $pics))
	    continue;
	$archfiles[] = $file; 	
    }
}

?>
