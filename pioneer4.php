<?php
date_default_timezone_set('America/Los_Angeles');

// the job of this stub is to produce:
// $curhouse -- name of the cam 
// $dir -- the file system directory where the pics are
// $odir -- the web directory of the pics
// $files -- a list of files for the current day
// $links -- a list of links at the bottom of the cam pic
// $solar -- the url of the iframe for the solar row

$curhouse = "pioneer4";
$camuser = "camuser";
include('amccmn.php');

$solarfile = "https://monitoring.solaredge.com/solaredge-web/p/site/593702";
$pge = "https://pge.opower.com/ei/x/energy-usage-details#!/usage/electricity/year/2017-04-12?accountUuid=c451a76e-d22b-11e3-9228-22ec3b633f13";
$Wunderground = "https://www.wunderground.com/dashboard/pws/KCAPIONE3";
$nwsurl = "http://ifps.wrh.noaa.gov/cgi-bin/dwf?outFormat=xml&duration=72hr&interval=1&citylist=Select+City%2C%2Cnone&latitude=38.469576&longitude=-120.543977&latlon=Go&ZOOMLEVEL=1&XSTART=&YSTART=&XC=&YC=&X=&Y=&siteID=STO";
$gmd = gmdate("Ymd");

// links expects row(s) of data for the bottom of the pics
$links = <<<EOF
    <a href=http://forecast.weather.gov/MapClick.php?site=sto&smap=1&textField1=38.47&textField2=-120.54 target=_blank>Pioneer NWS</a>
    <a href="https://www.wunderground.com/forecast/us/ca/pioneer/KCAPIONE3" target=_blank>Wunderground</a>
    <a href=http://forecast.weather.gov/MapClick.php?site=sto&smap=1&textField1=38.70278&textField2=-120.07167 target=_blank>Kirkwood NWS</a>
    <a href=http://www.kirkwood.com/the-mountain/mountain-conditions/mountain-cams.aspx target=_blank>Kirkwood Cam</a>
    <a href="$pge" target=_blank>PGE</a>
    <a href="https://www.wunderground.com/dashboard/pws/KCAPIONE3" target=_blank>Station</a>
    <a href="https://ambientweather.net/dashboard" target=_blank>AWN</a>
    <a href="$solarfile" target=_blank>Solar</a>
    <a href=http://squall.sfsu.edu/crws/jetstream.html>Jet</a>
    <a href="http://moe.met.fsu.edu/cgi-bin/gfstc2.cgi?time=${gmd}06&field=700mb+Relative+Humidity&hour=Animation">700mb</a>
    <a href="https://www.accuweather.com/en/us/california/wind-flow" target=_blank>Wind</a>
    <a href="https://www.purpleair.com/map?opt=1/mAQI/a1/cC0#14.13/38.4475/-120.54088" target=_blank>Air</a>
    <a href="https://firms.modaps.eosdis.nasa.gov/usfs/map/#d:24hrs;@-100.0,40.0,4z" target=_blank>Fire</a>
    <a href="https://www.iqair.com/us/usa/california" target=_blank>Smoke</a>
    <a href="https://www.accuweather.com/en/us/california/satellite" target=_blank>Clouds</a>
    <a href="https://www.accuweather.com/en/us/california/weather-radar" target=_blank>Radar</a>
    <a href="https://www.star.nesdis.noaa.gov/GOES/conus.php?sat=G17" target=_blank>Conus</a>
    <a href="https://www.fire.ca.gov/incidents" target=_blank>Calfire</a>
    <a href="https://roads.dot.ca.gov/roadscell.php?roadnumber=88" target=_blank>Hwy 88</a>
EOF;
$solar = <<<EOF
	<iframe class="solar" src="https://out.mtcc.com:3000/solaredges" scrolling=no></iframe>
EOF;

// finish off the rest
include ("camcmn.php");
?>
