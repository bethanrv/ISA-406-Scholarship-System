<?php
$myfile = fopen("./back-end/students.csv", "a+") or die("Unable to open file!");

//fwrite($myfile, $_POST['student']);
$uid = $_POST['uid'];
$email = $_POST['email'];
$name = $_POST['name'];
$date = $_POST['date'];
$address = $_POST['address'];

fwrite($myfile, PHP_EOL . "$uid,$name,$email,$date,$address");
fclose($myfile);
?>
