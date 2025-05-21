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

if (isset ($REQUEST_METHOD)) {
    if ($REQUEST_METHOD == "POST")
	$http = $HTTP_POST_VARS;
    else
	$http = $HTTP_GET_VARS;
} else {
    if ($_SERVER ["REQUEST_METHOD"] == "POST")
	$http = $_POST;
    else
	$http = $_GET;
}

if (isset ($http ["archive"])) {
    $archfiles = [];
    for ($i = 0; $i < count ($files); $i++) {
	if ($files [$i] == '.' || $files[$i] == '..')
	    continue;	
	$file = $odir . '/' . $files [$i];
	$archfiles [] = $file;
    }
}

$clat = 37.75943;
$clon = -122.43067;
$nwsurl = "http://ifps.wrh.noaa.gov/cgi-bin/dwf?outFormat=table&duration=72hr&interval=1&citylist=Select+City%2C$clat%2C$clon&latitude=$clat&longitude=$clon&latlon=Go&ZOOMLEVEL=1&XSTART=&YSTART=&XC=&YC=&X=&Y=&siteID=MTR";
$gmd = gmdate("Ymd");

// links expects row(s) of data for the bottom of the pics
$links = <<<EOF
<a href=http://forecast.weather.gov/MapClick.php?site=mtr&smap=1&textField1=$clat&textField2=$clon target=_blank>NWS SF</a>
<a href="https://www.wunderground.com/forecast/us/ca/pioneer/KCAPIONE3" target=_blank>Wunderground</a>
<a href=http://www.sfgate.com/weather/rainfall.shtml>Rainfall</a>
<a href=http://maps.google.com/maps?f=q&hl=en&geocode=&q=san+francisco,+ca&ie=UTF8&ll=$clat,$clon&spn=0.105286,0.133724&t=p&z=13&iwloc=addr&om=0>Google Terrain</a>
<a href="http://moe.met.fsu.edu/cgi-bin/gfstc2.cgi?time=${gmd}00&field=700mb+Relative+Humidity&hour=Animation">700mb</a>
<a href="http://moe.met.fsu.edu/cgi-bin/gfstc2.cgi?time=${gmd}00&field=500mb+Relative+Humidity&hour=Animation">500mb</a>
<a href="http://moe.met.fsu.edu/tcgengifs/">More GFS</a>
EOF;
$solar = <<<EOF
    <iframe class="solar" src="https://out.mtcc.com:3000/solaredges" scrolling=no></iframe>
EOF;

// finish off the rest
include ("camcmn.php");
?>
