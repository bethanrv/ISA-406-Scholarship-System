<?php

$students = $_POST['studentInfo'];

foreach($students as $student){
	$uid = explode(", ", $student)[0];
	$dirname = "./back-end/Report/".$uid;

	/*
	if (is_dir($dirname)) {
          $dir_handle = opendir($dirname);
	}
        if ($dir_handle) {
          while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
              if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
              else {
                delete_directory($dirname.'/'.$file);
	      }
            }
          }
         closedir($dir_handle);
         rmdir($dirname);
	}
	*/

	mkdir("./back-end/Report/" . $uid);
	$myfile = fopen("./back-end/Report/". $uid . "/" . $uid . ".csv", "w") or die("Unable to open file!");
	fwrite($myfile, PHP_EOL . "$student");
	fclose($myfile);

	//copy dars and cv
	copy( "./back-end/Dars/" . $uid . ".html","./back-end/Report/" . $uid . "/" . $uid . ".html");
	copy( "./back-end/CV/" . $uid . ".pdf","./back-end/Report/" . $uid . "/" . $uid . ".pdf");

}

?>
