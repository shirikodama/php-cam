<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Upgrade-Insecure-Requests" content="0">    
    <title><?php print($houses[$curhouse]['title']); ?></title>
    <link rel="stylesheet" href="cam.css">
  </head>
  <body>
     
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
         var house = JSON.parse(req.responseText);
	 img.src = house.camfile;
     });
     req.open ("GET", curhouseurl+"?house=true");
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
	 top.location = curhouseurl;
     else 
	 top.location = curhouseurl + '?curframe=' + curframe;
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
     req.open ("GET", curhouseurl+"?archive=true");
     req.send ();
  }

  function archEnlarge (file, entno) { 
     var img = document.getElementById('camfile');
     img.src = file;
     window.scrollTo(0, 0);
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
     window.location.href = href;
  }

  function lastDay (file) {
     var el = document.getElementById ('camdiv');
     var html = '';
     html += '<video width=640 height=480 controls><source src="'+file+'"></video>';
     el.innerHTML = html;
     
  }
 
  var curhouse = '<?php print $curhouse; ?>';
  var curhouseurl = curhouse+'.php';
  var curframe = parseInt ('<?php print $houses[$curhouse]['curframe']; ?>') || 0;
  var houses = '<?php print json_encode($houses) ?>';
 

</SCRIPT>

    <div class="maindiv">
      <table  width=100% cellpadding=0 cellspacing=0 style="border-spacing:0px;"><tr>

<?php

// INPUTS
//
// $curhouse -- name of the cam calling this module
// $houses -- array of houses and their properties
// $links -- a list of links at the bottom of the cam pic
// $solar -- a row for the solar info (if any)
	   

$setup_url = 'http://' . $houses[$curhouse]['ip'];
$camfile = 'http://' . $houses[$curhouse]['camfile']; 
$title = $houses[$curhouse]['title'];
echo ("<th class=\"navbg bigred\" style=\"font-size:25px\">Cameras</th><th valign=center class=\"navbg\" style=\"padding:10px;\"><a class=\"bigred\" style=\"font-size: 30px\"href=$setup_url target=_blank>$title</a></th>");


echo "</tr><tr><td align=center rowspan=2 valign=top class=\"navbg\">";
echo "<table><tr><td align=center class=\"bigred\"></td></tr>\n";
foreach ($houses as $house => $value) {
    $ti = $value['title'];
    echo "<tr><td style=\"padding-bottom: 10px;\"><button class=\"nav\" title=\"$house.php\" onclick=\"bgoto(this, '$house.php')\">$ti</button></td></tr>\n";    
}
echo "</tr></table></td></tr>\n";

// bottom utility nav
$camfile = $houses[$curhouse]['camfile'];;
echo "<tr><td align=center class=\"navbg\">";
echo ("<div id=\"camdiv\"><img id=\"camfile\" src=\"$camfile\" alt=\"$title Cam\" class=\"main\" onload=\"setCamSize ()\" onclick=\"toggleCamSize()\" title=\"click for full size\"><br></div>");
echo ("</td></tr><tr>");
echo ("<td align=left class=\"navbg navbar\">");
echo ("<button class=\"paging\" name=Movie onclick=\"lastDay('${curhouse}.mp4')\">Last Day</button>");
echo ("</td>");
echo ("<td colspan=1 class=\"navbg navbar\" style=\"padding: 5px; text-align:center\">");
echo ("<button class=\"paging\" name=Previous onclick=\"prevNext(-1)\">Previous</button>");
echo ("<button class=\"paging\" name=Current onclick=\"prevNext(0)\">Current</button>");		
if ($houses[$curhouse]['curframe'] < 0)
    echo ("<button class=\"paging\" name=Next onclick=\"prevNext(1)\">Next</button>");
echo ("<button class=\"paging\" name=Archive onclick=\"showArchive()\" style=\"float:right\">Archive</button>");
echo "</td></tr>";
echo "<tr><td align=center colspan=2 class=\"bigred navbg navbar\"><span class=\"navlinks\">$links</span></td></tr>";
//echo "<tr><td colspan=2 cellpadding=0 cellspacing=0>$solar</td></tr>";

?>
    </table>
    </div>
    <div id=archive></div>
  </body>
</html>

