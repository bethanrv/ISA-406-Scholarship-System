<?php

if(isset($_POST['submitCV'])){

	$target_dir = "./back-end/CV/";
	$target_file = $target_dir . basename($_FILES["statementFile"]["name"]);

	if(move_uploaded_file($_FILES["statementFile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["statementFile"]["name"]). " has been uploaded.";
	} 
}
else{
	echo "File not found";
}
?>
