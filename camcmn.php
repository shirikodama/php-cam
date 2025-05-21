<?php
// the job of the stubs that include this is to produce:
// $curhouse -- name of the cam calling this module
// $dir -- the file system directory where the pics are
// $odir -- the web directory of the pics
// $files -- a list of files for the current day
// $links -- a list of links at the bottom of the cam pic
// $solar -- a row for the solar info (if any)


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

$houses = array (
    'pioneer7' => array ('title' => 'Sugar Pine Dr', 'ip' => '192.168.1.197'),    
    'pioneer5' => array ('title' => 'Morningwood Driveway', 'ip' => '192.168.1.109'),
    'pioneer4' => array ('title' => 'Morningwood Carport', 'ip' => '192.168.1.169'),
    'pioneer6' => array ('title' => 'Morningwood Farms', 'ip' => '192.168.1.237'),
    'pioneer8' => array ('title' => 'Summit Haus', 'ip' => '192.168.1.235'),    
    'pioneer2' => array ('title' => 'Summit East', 'ip' => '192.168.1.199'),
    'pioneer3' => array ('title' => 'Morningwood North', 'ip' => '192.168.1.230'), 
    'pioneer'  => array ('title' => 'Deer Court', 'ip' => '192.168.1.198'),
);
    
$curpath = "/home/mike/public_html";
$house = $houses [$curhouse];
$title = $house['title'];
$url = 'http://' . $house['ip'];
$archpath = "/home/mike/public_html/${curhouse}.arch";
$curdate = date ("Ymd");
$curframe = isset ($http['curframe']) ? $http['curframe'] : 0;
$fno = 0;
if (! is_array ($files))
    $files = array ();
if ($curframe > 0)
    $fno = $curframe;
else if ($files && is_array ($files))
    $fno = count ($files)-1+$curframe;

if ($fno <= 0) $fno = 0;
if ($fno >= count($files)-1) $fno = count ($files)-1;
$camfile = $odir . '/'. $files[$fno];
//error_log ("o=$odir cam=$camfile");
$cf = $curpath . '/' . $camfile;
if (strpos ($cf, ".jpg") || strpos ($cf, ".jpeg")) {
    //error_log ($cf);
    // sometimes the file is corrupt presumably because it's still in the middle of writing it so check to see if it's ok
    $idout = `identify -verbose $cf 2>&1`;
    $is_corrupt = strpos ($idout, "Corrupt JPEG data", 0);
    if ($is_corrupt !== false) {
	error_log ("$cf is corrupt sleeping... l=" . filesize($cf));
	// sleep a bit so it's hopefully there this time
	usleep (1*1000*1000);
	$idout = `identify -verbose $cf 2>&1`;
	$is_corrupt = strpos ($idout, "Corrupt JPEG data", 0) !== false ? "true" : 'false';
	error_log ("done. new corrupt = $is_corrupt. l=" . filesize($cf));
    } else {
	//error_log ("jpg ok");
    }
}

if (isset ($http['camfile'])) {
    die($camfile);
}

if (isset ($http['archive'])) {
    $jfiles = [];
    $i = 0;
    foreach ($archfiles as $file) {
	$time = @filemtime($file);
	$jfiles[$i] = array('file' => $file, 'time' => $time);
	$i++;
    }
    die(json_encode(array ("curodir" => $odir, "files" => $jfiles)));
}

print <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Upgrade-Insecure-Requests" content="0">    
EOF;
print "<title>$title Cam</title>\n";
print '<link rel="stylesheet" href="cam.css">';
print "</head><body>";

?>


<SCRIPT type="text/javascript">

var last_time = new Date ().getTime ();
var hidden, visibilityState, visibilityChange;
hidden = "hidden", visibilityChange = "visibilitychange", visibilityState = "visibilityState";
var document_hidden = document[hidden];
      
document.addEventListener(visibilityChange, function() {
     if(document_hidden != document[hidden]) {
        if(document[hidden]) {
            // Document hidden
	    last_time = new Date ().getTime ();
	} else {
	    var d = new Date ().getTime ();
            // Document shown
            if (d > last_time + 60 * 1000) {
		updateImg ();
	    }
        }
        document_hidden = document[hidden];
     }
});

function updateImg () {
     var id = 'camfile';
     var req = new XMLHttpRequest ();
     req.addEventListener("load", function () {
	 var img = document.getElementById(id);
	 var src = req.responseText;
	 img.src = src;
     });
     req.open ("GET", curhouse+"?camfile=true");
     req.send ();
 }


function refresh () {
     var tmo = 60*1000;
     var start = function () {         
         var d = new Date ();
	 if (! document.hidden) {
	     updateImg ();
	 } 
         setTimeout (start, tmo);

     }
     setTimeout (start, tmo);
 }

function prevNext (inc) {     
     curframe += inc;
     if (inc == 0 || curframe == 0)
	 top.location = curhouse;
     else 
	 top.location = curhouse + '?curframe=' + curframe;
 }

function acmp (a, b) {
    return a.time - b.time;
 }

var jresp;
var archfiles;

function showArchive () {
     var id = 'archive';
     var req = new XMLHttpRequest ();
     req.addEventListener("load", function () {
	 var arch = document.getElementById(id);
	 var src = req.responseText;
	 var resp = JSON.parse(src);
	 jresp = resp;
	 var files = resp.files;
	 var jodir = resp.odir;
	 archfiles = files;	 
//	 console.log ("archive=", jodir);
	 var html = '<table><tr>';
	 var n = 0;
	 files.sort (acmp);
	 for (var i in files) {
	     if (files [i] == '.' || files[i] == '..')
		 continue;
	     //var file = jodir+'/'+files[i].file;
	     var file = files[i].file;
	     var time = new Date (files[i].time*1000);
	     var hours = time.getHours();
	     if (hours == 0) hours = 12;
	     var ftime = hours+':'+time.getMinutes()+':'+time.getSeconds();
	     html += '<td class="thumb"><div class="thumb"><figure><img class="thumb" src="'+file+'" onclick="archEnlarge(\''+file+'\', '+i+')"><figcaption><a  class="thumb" href='+file+' target=_blank>'+ftime+'</a></figcaption></figure></div></td>';
	     n++;
	     if (n > 7) {
		 n = 0;
		 html += '</tr><tr>';
	     }
	 }
	 html += '</tr></table>';
	 arch.innerHTML = html;
	 // scroll to the top of the archive
	 window.scrollTo(0, arch.offsetTop);	 
     });
     req.open ("GET", curhouse+"?archive=true");
     req.send ();
}

 function archEnlarge (file, entno) {
     console.log ("entno=", entno);
     if (1) {
	 var img = document.getElementById('camfile');
	 img.src = file;
	 window.scrollTo(0, 0);
     } else {
	 console.log ("al=", archfiles.length, archfiles.length-entno);
//	 return;
	 if (entno)
	     window.location.href = curhouse+'?curframe='+entno;
	 else
	     window.location.href = curhouse;
     }
     
}

function toggleCamSize () {
     var el = document.getElementById ('camfile');
     if (! el.size) {
	 el.style.width = 'auto';
	 el.size = 'full';	 
	 el.title = 'click for normal size ('+ el.owidth + 'x' + el.oheight + ')'; 	 
     } else {
	 el.style.width = '100%';
	 el.size = null;
	 el.title = 'click for full size (' + el.naturalWidth + 'x' + el.naturalHeight + ')'; 	 
     }
}

function setCamSize () {
     var el = document.getElementById ('camfile');
     el.title = 'click for full size (' + el.naturalWidth + 'x' + el.naturalHeight + ')';
     el.owidth = el.width;
     el.oheight = el.height;     
}

refresh ();

 var gt;
function bgoto (self, href) {
     gt = self;
     console.log ("href=", href);
     window.location.href = href;
}

var curhouse = '<?php print "${curhouse}.php"; ?>';
var odir = '<?php print "$odir"; ?>'; 
var curframe = parseInt ('<?php print $curframe; ?>') || 0;

 

</SCRIPT>

<div class="maindiv"><table  width=100% cellpadding=0 cellspacing=0 style="border-spacing:0px;"><tr>

<?php

$curdate = date ("mdY");

if (! isset ($http ["timelapse"])) {
    $mode = 'still';
    echo ("<th valign=center colspan=2 class=\"navbg\" style=\"padding:10px;\"><a class=\"bigred\" style=\"font-size: 30px\"href=$url target=_blank>Viewing $title</a></th>");
} else {
    $mode = $http ['timelapse'];
    if ($mode == 'cur') {
        echo ("<th colspan=2><h1>$title Current Timelapse</h1></th>");
    } else {
        $d = `date +%m%d%Y -d "yesterday"`;
        echo ("<th colspan=2><h1>$title Yesterday Timelapse</h1></th>");
    }
}


echo "</tr><tr><td align=center rowspan=2 class=\"navbg\">";
echo "<table><tr><td align=center class=\"bigred\">House Cams</td></tr>\n";
foreach ($houses as $house => $value) {
    $ti = $value['title'];
    echo "<tr><td style=\"padding-bottom: 10px;\"><button class=\"nav\" title=\"$house.php\" onclick=\"bgoto(this, '$house.php')\">$ti</button></td></tr>\n";    
}
echo "</tr></table></td></tr>\n";

// bottom utility nav
echo "<tr><td align=center class=\"navbg\">";
switch ($mode) {
    case 'still':
	echo ("<img id=\"camfile\" src=$camfile alt=\"$title Cam\" class=\"main\" onload=\"setCamSize ()\" onclick=\"toggleCamSize()\" title=\"click for full size\"><br>");
	echo ("</td></tr><tr><td colspan=2 class=\"navbg\" style=\"padding: 5px; text-align:center\">");
	echo ("<button class=\"paging\" name=Previous onclick=\"prevNext(-1)\">Previous</button>");
	echo ("<button class=\"paging\" name=Current onclick=\"prevNext(0)\">Current</button>");		
	if ($curframe < 0)
	    echo ("<button class=\"paging\" name=Next onclick=\"prevNext(1)\">Next</button>");
	echo ("<button class=\"paging\" name=Archive onclick=\"showArchive()\" style=\"float:right\">Archive</button>");
	break;
    case 'cur':
	$t = $http ["timelapse"];
	$br = 300;
	$fps = 30;
	if (isset ($http ["bitrate"])) {
            $br = $http ["bitrate"];
	}
	if (isset ($http ["fps"])) { 
            $fps = $http ["fps"];
	}
	$cmd = "/usr/local/bin/cam.php --force --encode $archpath --out $archpath/{$curdate}.mov $curhouse --bitrate $br --fps $fps";
	error_log ($cmd);
	system ($cmd);
	echo ("<a href=$curhouse.php><video src=\"${curhouse}.arch/$curdate.mov\" width=1200 height=800 controls>Your browser sucks</video></a><br>");
	break;
    default:   
	echo ("<a href=$$curhouse.php><video src=\"${curhouse}.arch/$curdate.mov\" width=1200 height=800 controls>Your browser sucks</video></a><br>");
	break;
}
//echo ("<form method=\"POST\" action=\"$curhouse.php\"><input type=hidden name=timelapse value=\"cur\">");
//echo ("<input type=submit value=\"Timelapse\"></form>");
echo "</td></tr>";
echo "<tr><td align=center colspan=2 class=\"bigred navbg navbar\"><span class=\"navlinks\">$links</span></td></tr>";
//echo "<tr><td colspan=2 cellpadding=0 cellspacing=0>$solar</td></tr>";

?>
</table>
</div>
<div id=archive></div>
</body>
</html>

