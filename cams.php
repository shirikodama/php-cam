<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
	<meta http-equiv="Upgrade-Insecure-Requests" content="0">    
	<title>Pioneer Cams</title>
	<link rel="stylesheet" href="cam.css">
    </head>
    <body>
	<div class=maindiv>
	    <table align=center width=100% border=0 class=navbg>
		<tr>
		    <td colspan=4 width=100% align=center valign=middle class="bigred navbg" style="font-size:50px;">Pioneer Cams</td>
		</tr>
		<tr>
<?php
		
$_GET['noinit'] = true;    		
include ("amccmn.php");
include ('pioneer2.php');
include ('pioneer3.php');
include ('camcmn.php');

$n = 0;
foreach ($houses as $house => $hdata) {
    $curhouse = $house;
    if ($hdata['amc']) {
	amcinit ($curhouse, $hdata['dir']);
    } else {
	$curhouse ();
    }
    $h = caminit ();    
    $f = $h['camfile'];
    $title = $h['title'];
    print '<td align=center valign=bottom class="bigred"  style="padding-top:30px">';
    print "<a href=\"$curhouse.php\" target=_blank>";
    print "<div class=bigred style=\"font-size:30px\">$title</div>";
    print "<img src=\"$f\" style=\"border:4px solid red; border-radius:12px; width:256px; min-height:200px\"><br>($curhouse)";
    print '</a></td>';	    
    if ($n++ >= 2) {
	$n = 0;
	print "</tr><tr>";
    }
}
?>
		</tr>
	    </table>
	</div>
    </body>
</html>
