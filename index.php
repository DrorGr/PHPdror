<?php
require_once 'helpers/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Color Detection</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- -------------------------Image container and error notice---------------------------------------->
      <div class="col-sm-9 text-center mt-3 content">
        <?php if (!$display_image) : ?>
          <div class="center">
            <p class="text-white"><?=$status?></p>
          </div>
        <?php else : ?>
          <img src="images/<?= $file_name ?>" class="img-fluid" alt="image_to_detect">
        <?php endif ?>
      </div>
      <!-- -------------------------------------------------------------------------------------------------->

      <!-- ---- Main colors display and info-looping through the array emited by the functions--------------->
      <div class="col-md-3">
        <?php if ($color_precent) : ?>
          <?php foreach ($color_precent as $key => $val) : ?>
            <div style="background-color:<?= $key ?>  " ; class="card sm-1">
              <div class="card-body">
                <h5 class="card-title text-color text-center mt-3" style=<?= $key ?>><?= $val ?>%</h5>
               <?php list($red, $green, $blue) = sscanf($key, "#%02x%02x%02x"); ?>
                <p class="m-3 text-center text-color" >R:<?= $red ?> G:<?= $green ?> B:<?= $blue ?></p>
              </div>
            </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
    <!-- ---------------------------------------------------------------------------------------------------->


    <!-- -----------------Header containing functional buttons for uploading and analyzing------------------->
    <div class="row">
      <div class="col-sm-12 buttons">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row mt-2">
            <div class="col-md-6">
              <input class="btn " type="file" name="image" id="fileToUpload">
            </div>
            <div class="col-md-6 pr-5 ">
              <div class="">
                <button class="btn  bt-lg w-100" type="submit" name="submit" > analize</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- --------------------------------------------------------------------------------------------------->
  </div>
</body>
</html>