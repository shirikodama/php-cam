<?php

$gmd = gmdate("Ymd");
$solarfile = "https://monitoring.solaredge.com/solaredge-web/p/site/593702";
$pge = "https://pge.opower.com/ei/x/energy-usage-details#!/usage/electricity/year/2017-04-12?accountUuid=c451a76e-d22b-11e3-9228-22ec3b633f13";
$Wunderground = "https://www.wunderground.com/dashboard/pws/KCAPIONE3";
$clat = 38.469576;
$clon = -120.543977;
$nwsurl = "http://ifps.wrh.noaa.gov/cgi-bin/dwf?outFormat=xml&duration=72hr&interval=1&citylist=Select+City%2C%2Cnone&latitude=$clat&longitude=$clon&latlon=Go&ZOOMLEVEL=1&XSTART=&YSTART=&XC=&YC=&X=&Y=&siteID=STO";


// links expects row(s) of data for the bottom of the pics
$plinks = <<<EOF
    <a href=http://forecast.weather.gov/MapClick.php?site=sto&smap=1&textField1=38.47&textField2=-120.54 target=_blank>Pioneer NWS</a>
    <a href="https://www.wunderground.com/forecast/us/ca/pioneer/KCAPIONE3" target=_blank>Wunderground</a>
    <a href=http://forecast.weather.gov/MapClick.php?site=sto&smap=1&textField1=38.70278&textField2=-120.07167 target=_blank>K-NWS</a>
    <a href=http://www.kirkwood.com/the-mountain/mountain-conditions/mountain-cams.aspx target=_blank>K-Cam</a>
    <a href="$pge" target=_blank>PGE</a>
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

$clat = 37.75943;
$clon = -122.43067;
$nwsurl = "http://ifps.wrh.noaa.gov/cgi-bin/dwf?outFormat=table&duration=72hr&interval=1&citylist=Select+City%2C$clat%2C$clon&latitude=$clat&longitude=$clon&latlon=Go&ZOOMLEVEL=1&XSTART=&YSTART=&XC=&YC=&X=&Y=&siteID=MTR";    

// links expects row(s) of data for the bottom of the pics
$sflinks = <<<EOF
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

?>
