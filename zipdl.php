<?php
 //Get the directory to zip
$filename_no_ext="backup-adppoland";
// we deliver a zip file
header("Content-Type: archive/zip");

// filename for the browser to save the zip file
header("Content-Disposition: attachment; filename=$filename_no_ext".".zip");

// get a tmp name for the .zip
$tmp_zip = tempnam ("tmp", "tempname") . ".zip";

// zip the stuff (dir and all in there) into the tmp_zip file
exec('zip -r '.$tmp_zip.' *');

// calc the length of the zip. it is needed for the progress bar of the browser
$filesize = filesize($tmp_zip);
header("Content-Length: $filesize");

// deliver the zip file
$fp = fopen("$tmp_zip","r");
echo fpassthru($fp);

// clean up the tmp zip file
unlink($tmp_zip);
?>