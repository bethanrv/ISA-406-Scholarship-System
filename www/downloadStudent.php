<?php

$students = $_POST['students'];

echo $students;

$filename="./download.txt";
header("Content-disposition: attachment;filename=$filename");
readfile($filename);

?>
