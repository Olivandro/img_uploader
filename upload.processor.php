<?php
require "core/inc/DB.inc.php";
// filename: upload.processor.php
// first let's set some variables
// make a note of the current working directory, relative to root.
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
// make a note of the directory that will recieve the uploaded files
$uploadsDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'images/';
// make a note of the location of the upload form in case we need it
$uploadForm = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'PILuploader.form.php';
// make a note of the location of the success page
$uploadSuccess = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.success.php';
// name of the fieldname used for the file in the HTML form
$fieldname = 'file';
// Now let's deal with the upload
// possible PHP upload errors
$errors = array(1 => 'php.ini max file size exceeded',
                2 => 'html form max file size exceeded',
                3 => 'file upload was only partial',
                4 => 'no file was attached');

// check the upload form was actually submitted else print form
isset($_POST['submit'])
	or error('the upload form is neaded', $uploadForm);

// check for standard uploading errors
($_FILES[$fieldname]['error'] == 0)
	or error($errors[$_FILES[$fieldname]['error']], $uploadForm);

// check that the file we are working on really was an HTTP upload
// Function is part of PHP 7 core.
@is_uploaded_file($_FILES[$fieldname]['tmp_name'])
	or error('not an HTTP upload', $uploadForm);

// validation... since this is an image upload script we
// should run a check to make sure the upload is an image
// function is part of PHP 7 core
@getimagesize($_FILES[$fieldname]['tmp_name'])
	or error('only image uploads are allowed', $uploadForm);

// make a unique filename for the uploaded file and check it is
// not taken... if it is keep trying until we find a vacant one
$now = time();
/**
* ammendment of filename varible - now file name for input into db
* is = to $fileNametag. Further ammendment in while statement
*/
$fileNametag = $now.'-'.$_FILES[$fieldname]['name'];
while(file_exists($uploadFilename = $uploadsDirectory.$fileNametag))
{
	$now++;
}

// now let's move the file to its final and allocate it with the new filename
@move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename)
	or error('receiving directory insuffiecient permission', $uploadForm);
  /**
  * Beginning of database taxonomy input for uploaded meme
  **/
  $db = new DB;
  // setting varibles for input into database
  // Slight issue with getting the URL link to the downloaded file - right now
  // have set to the file directory path...
  $url_loc = $db->quote('http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'memes/' . $fileNametag);
  // Esstablishing series varible
  if (!isset($_POST['series'])) {
    $series = null;
  }
  $series = $db->quote($_POST['series']);
  // establishing cat1 verible
  if (!isset($_POST['catagory1'])) {
    $cat1 = null;
  }
  $cat1 = $db->quote($_POST['catagory1']);
  // establishing cat2 varible
  if (!isset($_POST['catagory2'])) {
    $cat2 = null;
  }
  $cat2 = $db->quote($_POST['catagory2']);
  // establishing asso1 varible
  if (!isset($_POST['association1'])) {
    $asso1 = null;
  }
  $asso1 = $db->quote($_POST['association1']);
  // establishing asso2 varible
  if (!isset($_POST['association2'])) {
    $asso2 = null;
  }
  $asso2 = $db->quote($_POST['association2']);
  // insert varible values into db table; NOTE: meme_collection(url_loc, series, cat1, cat2, asso1, asso2) pertains to current DB settings, change depending on your 
  // DB table setup and given names.
  $insert = $db->query("INSERT INTO meme_collection(url_loc, series, cat1, cat2, asso1, asso2) VALUES ({$url_loc}, {$series}, {$cat1}, {$cat2}, {$asso1}, {$asso2})");
  if($insert === false) {
    // Handle failure - log the error, notify administrator, etc.
    $error = $db->error();
    echo $error;
  }
  /**
  * End of database taxonomy input for uploaded meme or any type of image.
  **/

// If you got this far, everything has worked and the file has been successfully saved.
// We are now going to redirect the client to the success page.
header('Location: ' . $uploadSuccess);

// make an error handler which will be used if the upload fails
function error($error, $location, $seconds = 5)
{
	header("Refresh: $seconds; URL=\"$location\"");
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'."\n".
	'"http://www.w3.org/TR/html4/strict.dtd">'."\n\n".
	'<html lang="en">'."\n".
	'	<head>'."\n".
	'		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">'."\n\n".
	'		<link rel="stylesheet" type="text/css" href="stylesheet.css">'."\n\n".
	'	<title>Upload error</title>'."\n\n".
	'	</head>'."\n\n".
	'	<body>'."\n\n".
	'	<div id="Upload">'."\n\n".
	'		<h1>Upload failure</h1>'."\n\n".
	'		<p>An error has occured: '."\n\n".
	'		<span class="red">' . $error . '...</span>'."\n\n".
	'	 	The upload form is reloading</p>'."\n\n".
	'	 </div>'."\n\n".
	'</html>';
	exit;
} // end error handler
?>
