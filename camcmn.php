<?php
// the job of the stubs that include this is to produce:
// INPUTS
//
// $curhouse -- name of the cam calling this module
// $odir -- the web directory of the pics
// $files -- a list of files for the current day
//
// OUTPUTS
//
// $houses -- the houses info array


$houses = array (
    'pioneer7' => array ('cam' => 'pioneer7', 'title' => 'Sugar Pine Dr', 'ip' => '192.168.1.197', 'curframe' => 0, 'camfile' =>''),    
    'pioneer5' => array ('cam' => 'pioneer5','title' => 'Morningwood Driveway', 'ip' => '192.168.1.109', 'curframe' => 0, 'camfile' =>''),
    'pioneer4' => array ('cam' => 'pioneer4','title' => 'Morningwood Carport', 'ip' => '192.168.1.169', 'curframe' => 0, 'camfile' =>''),
    'pioneer6' => array ('cam' => 'pioneer6','title' => 'Morningwood Farms', 'ip' => '192.168.1.237', 'curframe' => 0, 'camfile' =>''),
    'pioneer8' => array ('cam' => 'pioneer8','title' => 'Summit Haus', 'ip' => '192.168.1.235', 'curframe' => 0, 'camfile' =>''),    
    'pioneer2' => array ('cam' => 'pioneer2','title' => 'Summit East', 'ip' => '192.168.1.199', 'curframe' => 0, 'camfile' =>''),
    'pioneer3' => array ('cam' => 'pioneer3','title' => 'Morningwood North', 'ip' => '192.168.1.230', 'curframe' => 0, 'camfile' =>''), 
    'pioneer'  => array ('cam' => 'pioneer','title' => 'Deer Court', 'ip' => '192.168.1.198', 'curframe' => 0, 'camfile' =>''),
);
    

function caminit () {
    global $curhouse, $files, $odir, $houses;
    $fno = 0;
    if (! is_array ($files))
        $files = array ();
    $curframe = isset ($_GET['curframe']) ? $_GET['curframe'] : 0;
    if ($curframe > 0)
        $fno = $curframe;
    else if ($files && is_array ($files))
        $fno = count ($files)-1+$curframe;
    if ($fno <= 0) $fno = 0;
    if ($fno >= count($files)-1) $fno = count ($files)-1;
    $camfile = $odir . '/'. $files[$fno];
    // XXX should probably move this to camuser and just link in my ~mike
    $cf = "/home/mike/public_html/" . $camfile;
    if (strpos ($cf, ".jpg") || strpos ($cf, ".jpeg")) {
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
        }
    }
    $houses[$curhouse]['camfile'] = $camfile;
    $houses[$curhouse]['curframe'] = $curframe;    

}

caminit ();

if (isset ($_GET['house'])) {
    die(json_encode($houses[$curhouse]));
}

if (isset ($_GET['archive'])) {
    $jfiles = [];
    $i = 0;
    foreach ($archfiles as $file) {
        $time = @filemtime($file);
        $jfiles[$i] = array('file' => $file, 'time' => $time);
        $i++;
    }
    die(json_encode(array ("curodir" => $odir, "files" => $jfiles)));
}


?>
