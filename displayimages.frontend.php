<!-- This file pertains to a display page, for instances an archive display page, etc. -->
<?php
require 'core/inc/DBQuerySelector.inc.php';
$pil = new PILwall;
 ?>
<html>
    <head>
      <title>PIL meme wall</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width">
    </head>
    <body>
      <h1>Full Db</h1>
      <pre>
          <?php
          $collection = $pil->Getmemes();
            foreach ($collection as $row) {
              echo  print_r($row);
            }
           ?>
      </pre>
      <hr>
      <h1>Catagory 1</h1>
      <pre>
          <?php
          $catagories1 = $pil->Getcatagories1();
            foreach ($catagories1 as $row) {
              echo  print_r($row);
            }
           ?>
      </pre>
      <hr>
      <h1>Catagory 2</h1>
      <pre>
          <?php
          $catagories2 = $pil->Getcatagories2();
            foreach ($catagories2 as $row) {
              echo  print_r($row);
            }
           ?>
      </pre>
      <hr>
      <h1>Association 1</h1>
      <pre>
          <?php
          $asso1 = $pil->Getasso1();
            foreach ($asso1 as $row) {
              echo  print_r($row);
            }
           ?>
      </pre>
      <hr>
      <h1>Complex query test ground</h1>
      <pre>
          <?php
          $getImgLoc = $pil->getImgLoc();
            foreach ($getImgLoc as $meme) {
              echo  print_r($meme);
              echo "<img src='<?php $meme ?>' alt='' style='width:304px;height:228px;' />";
            }
           ?>
      </pre>
        <img src='memes/1497363715-obama1.jpg' alt='' style='width:304px;height:228px;' />
    </body>
</html>
