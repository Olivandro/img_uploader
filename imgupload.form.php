<?php
// filename: upload.form.php
// first let's set some variables
// make a note of the current working directory relative to root.
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
// make a note of the location of the upload handler script
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php';
// set a max file size for the html upload form
$max_file_size = 5000000; // size in bytes; Currently approx. 5MB
// now echo the html page
?>
<html>
    <head>
      <title>Upload form</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width">
    </head>
    <body>
      <form id="Upload" action="<?php echo $uploadHandler ?>" enctype="multipart/form-data" method="post">
              <h1>
                  Upload form Backend of application
              </h1>
              <p>
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>">
              </p>
              <p>
                  <label for="file">File to upload:</label>
                  <input id="file" type="file" name="file">
              </p>
              <!-- cat and asso inputs - specific to PIL application - Note: Inputs can change depending on your own DB columns -->
              <p>
                <label for="series">Series:</label>
                <input type="text" name="series" />
              </p>
              <p>
                <label for="catagory1">Catagory 1:</label>
                <input type="text" name="catagory1" />
              </p>
              <p>
                <label for="catagory2">Catagory 2:</label>
                <input type="text" name="catagory2" />
              </p>
              <p>
                <label for="association1">Association 1:</label>
                <input type="text" name="association1" />
              </p>
              <p>
                <label for="association2">Association 2:</label>
                <input type="text" name="association2" />
              </p>
              <!-- end of cat and asso inputs -->
              <p>
                  <label for="submit">Press to...</label>
                  <input id="submit" type="submit" name="submit" value="Upload me!">
              </p>
          </form>
    </body>
</html>
