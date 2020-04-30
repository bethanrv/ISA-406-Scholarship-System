<?php
$myfile = fopen("./db.csv", "a+") or die("Unable to open file!");

//fwrite($myfile, $_POST['student']);
$email = $_POST['email'];
$name = $_POST['name'];
$date = $_POST['date'];
$darFile = $_POST['darFile'];
$statementFile = $_POST['statementFile'];
$address = $_POST['address'];

fwrite($myfile, PHP_EOL . "$name,$email,$darFile,$statementFile,$date,$address");
fclose($myfile);
?>
