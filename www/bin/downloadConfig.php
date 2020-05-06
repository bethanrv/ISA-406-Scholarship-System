<?php
$myfile = fopen("./downloadConfig.txt", "w") or die("Unable to open file!");
$uid = $_POST['uid'];
fwrite($myfile, PHP_EOL . "$uid");
fclose($myfile);
?>