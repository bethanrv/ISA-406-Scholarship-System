<?php

if(isset($_POST['submitFiles'])){

	$target_dir = "./back-end/CV/";
	$cv_file = $target_dir . basename($_FILES["statementFile"]["name"]);
	$dar_file = $target_dir . basename($_FILES["darFile"]["name"]);

	if(move_uploaded_file($_FILES["statementFile"]["tmp_name"], $cv_file)) {
        echo "The file ". basename( $_FILES["statementFile"]["name"]). " has been uploaded.";
	} 

	if(move_uploaded_file($_FILES["darFile"]["tmp_name"], $dar_file)) {
        echo "The file ". basename( $_FILES["darFile"]["name"]). " has been uploaded.";
	} 
}
else{
	echo "File not found";
}
?>
