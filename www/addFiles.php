<?php

include('./front-end/goodbye.html');

if(isset($_POST['submitFiles'])){

	$target_dir_cv = "./back-end/CV/";
	$target_dir_dar = "./back-end/Dars/";
	$cv_file = $target_dir_cv . basename($_FILES["statementFile"]["name"]);
	$dar_file = $target_dir_dar . basename($_FILES["darFile"]["name"]);

	move_uploaded_file($_FILES["statementFile"]["tmp_name"], $cv_file);
	move_uploaded_file($_FILES["darFile"]["tmp_name"], $dar_file);
}
?>
