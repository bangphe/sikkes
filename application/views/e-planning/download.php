<?php
if( ! empty($download_path))
{
	$data = file_get_contents($download_path); // Read the file's contents
	$name = $file_name;
	force_download($name, $data);
}
?>