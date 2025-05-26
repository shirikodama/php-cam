#!/usr/bin/php
<?php

function camclean ($days, $curday) {
    $path = "/home/camuser/$days";
    $files = scandir ($path);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..')
            continue;
        $dir = $path . '/' . $file;
        if (is_dir ($dir) && $file != $curday) {
            system ("rm -rf $dir");
        }
    }
}

system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer2/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer3/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer4/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer5/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer6/");
system("~mike/php-cams/util/jpg2mp4 ~camuser/pioneer7/");
system("~mike/sh/jpg2mp4 ~camuser/pioneer8/");
camclean ('pioneer/AMC0185M6LPHH7Y60K', date('Y-m-d'));
camclean ('pioneer2/', date('Ymd'));
camclean ('pioneer3/', date('Ymd'));
camclean ('pioneer4/AMC06679EA626CB319', date('Y-m-d'));
camclean ('pioneer5/AMC066C474CC963723', date('Y-m-d'));
camclean ('pioneer6/garden', date('Y-m-d'));
camclean ('pioneer7/sugarpine', date('Y-m-d'));
camclean ('pioneer8/AMC066C3942A4E4E54', date('Y-m-d'));

?>
