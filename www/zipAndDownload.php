<?php

function zipFilesAndDownload($file_names, $archive_file_name, $file_path)
	{
	    $zip = new ZipArchive();
	
	    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
	        exit("cannot open <$archive_file_name>\n");
	    }
		
	    // add each file
	    foreach($file_names as $files)
	    {
	        $zip->addFile($file_path.$files,$files);
	    }
	    $zip->close();
		
	    header("Content-type: application/zip"); 
	    header("Content-Disposition: attachment; filename=$archive_file_name"); 
	    header("Pragma: no-cache"); 
	    header("Expires: 0"); 
	    readfile("$archive_file_name");
	    exit;
	}

?>
