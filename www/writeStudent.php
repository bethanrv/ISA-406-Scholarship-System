<?php
$myfile = fopen("./back-end/db.csv", "a+") or die("Unable to open file!");
fwrite($myfile, $_POST['student']);
fclose($myfile);
?>
