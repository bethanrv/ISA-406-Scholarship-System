<?php

include('./front-end/goodbye.html');

$cv_file = '';
$dar_file= '';
$name = $_POST['uid'];



if(isset($_POST['submitFiles'])){

	$target_dir_cv = "./back-end/CV/";
	$target_dir_dar = "./back-end/Dars/";
	$cv_file = $target_dir_cv . basename($name . '.pdf');
	$dar_file = $target_dir_dar . basename($name . '.html');

	move_uploaded_file($_FILES["statementFile"]["tmp_name"], $cv_file);
	move_uploaded_file($_FILES["darFile"]["tmp_name"], $dar_file);

	
}






?>
