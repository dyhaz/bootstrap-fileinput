<?php

require 'quickstart.php';

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Drive($client);

$filenames = [];
if ($_FILES['fileupload']) {
	// Count # of uploaded files in array
	$total = count($_FILES['fileupload']['name']);

	// Loop through each file
	for( $i=0 ; $i < $total ; $i++ ) {
		$filename = $_FILES['fileupload']['name'][$i];
		array_push($filenames, $filename);
		$file = new Google_Service_Drive_DriveFile();
		$file->setName($filename);
		$result = $service->files->create($file, array(
		  'data' => file_get_contents($_FILES['fileupload']['tmp_name'][$i]),
		  'mimeType' => 'application/octet-stream',
		  'uploadType' => 'multipart'
		));
	}
}
header("Content-Type: application/json; charset=UTF-8");
$response = [];
$response['status'] = 'success';
$response['data'] = $filenames;
$response['message'] = 'Upload succeeded!';

$myJSON = json_encode($response);

echo $myJSON;
