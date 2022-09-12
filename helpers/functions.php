<?php


//**************************************____UPLOADING____*******************************************************************/

// Defining the max image pixel hight and width
define('UPLOAD_MAX_SIZE', 4096 * 4096 * 2);

// Defining the allowed image formats
static $format = ['jpg', 'jpeg', 'png', 'gif', 'bpm'];


// Validation form submition and error handling
$error = true;
$status = "Please upload an image";

if (isset($_POST['submit'])) {

  if ($_FILES['image']['error'] == 0) {

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

      if ($_FILES['image']['size']) {

        $file_info = pathinfo($_FILES['image']['name']);
        $file_format = strtolower($file_info['extension']);

        if (in_array($file_format, $format)) {
          $error = false;
          $file_name = $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], "images/$file_name");
          $colors = get_colors("images/$file_name", 1);
        }
      }
    }
  }
  if ($error) $status = "Error while uploading - pick a valide file";
}



//**************************************____IMAGE_PROCESSING____*******************************************************************/


// Converting the uploaded image to A string containing the image data
// sorting the data by color abundance in an array
function get_colors($image, $pixel_skip = 1)
{
  
  $colors_arr = [];
  $size = getimagesize($image);
  $width = $size[0];
  $height = $size[1];

  $image = imagecreatefromstring(file_get_contents($image));

  for ($x = 0; $x < $width; $x += $pixel_skip) {

    for ($y = 0; $y < $height; $y += $pixel_skip) {

      $pixel_color = imagecolorat($image, $x, $y);
      $index_of_color = imagecolorsforindex($image, $pixel_color);
      $color_value_hexa = convert_rgb($index_of_color);

      if (array_key_exists($color_value_hexa, $colors_arr)) {
        $colors_arr[$color_value_hexa]++;
      } else {
        $colors_arr[$color_value_hexa] = 1;
      }
    }
  }

  arsort($colors_arr);
  return $colors_arr;
}


//Converting the hexadecimal value of the given color to rgb in a specific format 
function convert_rgb($index_of_color)
{
  $red = round(round(($index_of_color['red'] / 0x33)) * 0x33);
  $green = round(round(($index_of_color['green'] / 0x33)) * 0x33);
  $blue = round(round(($index_of_color['blue'] / 0x33)) * 0x33);
  return sprintf('%02X%02X%02X', $red, $green, $blue);
}

// Processing the array returned from "get_colors" function and emmiting an array containing the five most abundant colors info 
//to be used by the app
$display_image = false;
$color_precent = [];

if (isset($colors) && isset($file_name)) {

  $display_image = true;
  $sum = array_sum($colors);

  foreach ($colors as $key => $amount) {
    $color_precent["#" . $key] = round(($amount / $sum) * 100, 2);
  }

  $color_precent  = array_splice($color_precent, 0, 5, true);
}
