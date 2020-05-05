<?php

$UIDs = $_POST['UIDs'];

$myfile = fopen("./back-end/report.csv", "w") or die("Unable to open file!");
fwrite($myfile, PHP_EOL . "test" . $UIDs);
fclose($myfile);

//open new directory
//... for each student, create a directory 
//...... store info, grades, dars, and cv

$filename="./download.txt";
header("Content-disposition: attachment;filename=$filename");
readfile($filename);

?>