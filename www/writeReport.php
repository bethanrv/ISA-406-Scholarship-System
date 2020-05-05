<?php

$students = $_POST['studentInfo'];

foreach($students as $student){
	$uid = explode(", ", $student)[0];
	mkdir("./back-end/Report/" . $uid);
	$myfile = fopen("./back-end/Report/". $uid . "/" . $uid . ".csv", "w") or die("Unable to open file!");
	fwrite($myfile, PHP_EOL . "$student");
	fclose($myfile);
}

?>
