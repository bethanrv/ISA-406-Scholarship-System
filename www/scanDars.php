<?php

//read from dars file...
$uid = $_POST['uid'];
$dars = fopen("back-end/Dars/" . $uid . ".csv", "r") or die("Unable to open file!");

//save info into the following fields (currently populated with dummy data)
$year = "1";
$majors = "ISA";
$minors = "";
$cumGPA = "2.9";
$isaGPA = "3.0";
$majGPA = "3.0";
$isaGrades = "ISA 406: A, ISA 203: B, ISA 102: A"; //could also store in a data structure 


//stores info into student info csv and grades csv
$studentInfoFile = fopen("./back-end/studentInfo.csv", "a+") or die("Unable to open file!");
$gradesFile = fopen("./back-end/studentGrades.csv", "a+") or die("Unable to open file!");

fwrite($studentInfoFile, PHP_EOL . "$uid,$year,$majors,$minors,$cumGPA,$isaGPA,$majGPA");
fwrite($gradesFile, PHP_EOL . "$uid,$isaGrades");


fclose($studentInfoFile);
fclose($gradesFile);

?>
