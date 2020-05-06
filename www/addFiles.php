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

        //  ------------------  //
        /*
         * Done (I think): $majors, $minors, $cumGPA, $isaGrades, $year
         * $isaGPA: Find field in file
         * $majGPA: Find field in file
         */
        
        $file_string = file_get_contents("back-end/Dars/" . $uid . ".html");
        
        //  Find Major  //
        $start_index = strpos($file_string, "-->", strpos($file_string, "Request Audit") + 17) + 3;
        $end_index = strpos($file_string, "<!--", $start_index);
        $start_index = strpos($file_string, "<br>", $end_index) + 4;
        $end_index = strpos($file_string, "<br>", $start_index + 4);
        $majors = trim(substr($file_string, $start_index, $end_index - $start_index));
        
	
        //  Find Minor  //
	$minors = "none";
        $minor_index = strpos($file_string, " Minor");
	if ($minor_index) {
	  $minors = substr($file_string, $minor_index - 30, 36);  // Find the minor, but include extra leading characters
	  $minors_start = strlen($minors) - strpos(strrev($minors), ">");  // Reverse the string to find the last index of ">"
	  $minors = substr($minors, $minors_start);
	}

        //  Find Graduation Date  //
        $gradyear_index = strpos($file_string, "CANDIDATE FOR:") + 25;
        if ($gradyear_index) {
	  $gradyear = substr($file_string, $gradyear_index, 2);  // Exampple: this variable contains "19" for gradyear 2019
          $year = $gradyear;
	}
        
        //  Find Cumulative GPA  //
        $gpa_index = strpos($file_string, ";\">", strpos($file_string, "graphGPALabel") + 150) + 3;
        $cumGPA = substr($file_string, $gpa_index, 3);
        
        $index = 1;
        $isaGrades = "";
        $isaGPACount = 0;
        $isaCourseCount = 0;
        $majGPACount = 0;
        $majCourseCount = 0;
        while ($index != FALSE) {
          $index = strpos($file_string, "takenCourse", $index + 2);
          
          //  Find Course Data  //
          //  (course = "CSE448", credit = "3.0", grade = "B+")  //
          if ($index != FALSE) {
            $course_pos = strpos($file_string, "class=\"course\"", $index);
            $credit_pos = strpos($file_string, "class=\"credit\"", $index);
            $grade_pos = strpos($file_string, "class=\"grade\"", $index);
            
            $course = substr($file_string, $course_pos + 35, 6);
            $credit = substr($file_string, $credit_pos + 36, 3);
            $grade = substr($file_string, $grade_pos + 33, 2);
        
            //  Add course to ISA list
            if (substr($course, 0, 3) == "ISA" && !strpos($isaGrades, $course)) {
              //  Append to end of $isaGrades
              if (strlen($isaGrades) > 0) {
                $isaGrades = $isaGrades.", ";
              }
              $isaGrades = $isaGrades.$course.": ".$grade;
          }
        }
      }
        
        //  Find ISA GPA..?  //
        
        //  Find Major GPA..?  //
//  ------------------  //
  
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
