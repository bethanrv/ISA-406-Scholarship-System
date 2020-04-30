<?php


if(isset($_POST["darFile"])){
	$target_dir = "./back-end/";
	$dar = $_FILES["darFile"];
	$target_file = $target_dir . basename($_FILES["darFile"]["name"]);
	move_uploaded_file($_FILES["darFile"]["tmp_name"], $target_file);
}


?>
