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

$file_string = file_get_contents("back-end/Dars/" . $uid . ".csv");

//  Find Major  //
$start_index = strpos($file_string, "-->", strpos($file_string, "Request Audit") + 17) + 3;
$end_index = strpos($file_string, "<!--", $start_index);
$start_index = strpos($file_string, "<br>", $end_index) + 4;
$end_index = strpos($file_string, "<br>", $start_index + 4);
$majors = substr($file_string, $start_index, $end_index - $start_index);

//  Find Minor..?  //

//  Find Graduation Date  //
$gradyear_index = strpos($file_string, "Graduation Date") + 30;
$gradyear = substr($file_string, $gradyear_index, 2);  // Exampple: this variable contains "19" for gradyear 2019
//  Convert to Freshman (1), Sophomore (2), Junior (3), Senior (4)?
//  $year = 4 - $gradyear - <thisyear>;

//  Find Cumulative GPA  //
$gpaoverall_index = strpos($file_string, ";\">", strpos($file_string, "graphGPALabel") + 150) + 3;
$cumGPA = substr($file_string, $gpa_index, 3);

$index = 1;
$isaGrades = "";
$isaGPACount = 0;
$isaCourseCount = 0;
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
    if (substr($course, 0, 3) == "ISA") {
      //  Append to end of $isaGrades
      if (strlen($isaGrades) > 0) {
        $isaGrades = $isaGrades.", ";
      }
      $isaGrades = $isaGrades.$course.": ".$grade;
      
      //  Tally up ISA grades
      switch ($grade) {
        case "A+":
          //  4.0 
        break;
        case "A ":
          //  4.0
        break;
        case "A-":
          //  3.7
        break;
        case "B+":
          //  3.3
        break;
        case "B ": 
          //  3.0
        break;
        case "B-":
          //  2.7
        break;
        case "C+":
          //  2.3
        break;
        case "C ":
          //  2.0
        break;
        case "C-": 
          //  1.7
        break;
        case "D+":
          //  1.3
        break;
        case "D ":
          //  1.0
        break;
        default:
          //  0.0
    }
    
    //  Add course to MAJOR list for calculating $majGPA..?
  }
}

//  Find ISA GPA..?  //

//  Find Major GPA..?  //


//stores info into student info csv and grades csv
$studentInfoFile = fopen("./back-end/studentInfo.csv", "a+") or die("Unable to open file!");
$gradesFile = fopen("./back-end/studentGrades.csv", "a+") or die("Unable to open file!");

fwrite($studentInfoFile, PHP_EOL . "$uid,$year,$majors,$minors,$cumGPA,$isaGPA,$majGPA");
fwrite($gradesFile, PHP_EOL . "$uid,$isaGrades");


fclose($studentInfoFile);
fclose($gradesFile);

?>
