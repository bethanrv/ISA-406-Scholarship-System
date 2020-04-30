<?php

	$target_dir = "./back-end/";
	move_uploaded_file($_FILES['darFile']['tmp_name'], "./back-end/" . $_FILES['file']['name']);
?>
