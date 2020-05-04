<?php

include('./front-end/goodbye.html');

$cv_file = '';
$dar_file= '';
$uid = $_POST['uid'];



if(isset($_POST['submitFiles'])){

	$target_dir_cv = "./back-end/CV/";
	$target_dir_dar = "./back-end/Dars/";
	$cv_file = $target_dir_cv . basename($uid . '.pdf');
	$dar_file = $target_dir_dar . basename($uid . '.html');

	move_uploaded_file($_FILES["statementFile"]["tmp_name"], $cv_file);
	move_uploaded_file($_FILES["darFile"]["tmp_name"], $dar_file);


	//read from dars file and save info
	$dars = fopen("./back-end/Dars/" . $uid . ".html", "r") or die("Unable to open file!");


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
	fclose($dars);

	
}






?>
