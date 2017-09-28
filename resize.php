<?php

/**
* Author - idiotdeveloper.tk
*
* Its the main (core) file for resizing the image. Its really simple. Just follow some steps:
* $img = new Image(file_name.png);
* $img->open();
* $img->resize(width, height, mode);
* Here width & height are the dimension of the resize image. Their are two modes -
*   exact = resize image same as the dimension provided.
*   auto = resize image try to keep the original image ascept ratio.
* $img->save();
**/

class Image{
  private $img;             //image file name.
  private $height;          //image height.
  private $width;           //image width.
  private $type;            //image type.
  private $resource_id;     //resource id of the original image.
  private $new_img;         //resource id new image.

  function __construct($img_file){
    $this->img = $img_file;
    $img_array = getimagesize($this->img);
    $this->width = $img_array[0];
    $this->height = $img_array[1];
    $this->type = $img_array['mime'];
  }

  //checking the image orientation
  function image_orientation(){
    if($this->width > $this->height){
      return 'landscape';
    }else if($this->width < $this->height){
      return 'potrait';
    }else if($this->width == $this->height){
      return 'square';
    }else{
      return 'none';
    }
  }

  //opening the image according to its type.
  function open(){
    $type = $this->type;

    switch ($type) {
        case 'image/png':
          $img = imagecreatefrompng($this->img);
          break;
        case 'image/jpg':
        case 'image/jpeg':
          $img = imagecreatefromjpeg($this->img);
          break;
        case 'image/gif':
          $img = imagecreatefromgif($this->img);
          break;
        default:
          $img = false;
          break;
    }
    $this->resource_id = $img;
  }

  /**
  * Resize the image. It has only two modes
  * exact = resize image same as the dimension provided.
  * auto = resize image try to keep the original image ascept ratio.
  **/
  function resize($width, $height, $opt){
    if($opt == 'exact'){
      $this->create_new_image($width, $height);

    }else if($opt == 'auto'){
      $image_orientation = $this->image_orientation();

      if($image_orientation == 'landscape'){
        $p = ($width / $this->width);
        $new_width = $this->width * $p;
        $new_height = $this->height * $p;

      }else if($image_orientation == 'potrait'){
        $p = ($height / $this->height);
        $new_width = $this->width * $p;
        $new_height = $this->height * $p;

      }else if($image_orientation == 'square'){
        $p = ($height / $this->height);
        $new_width = $this->width * $p;
        $new_height = $this->height * $p;
      }else{
        echo 'Some Error Encountered!';
        exit();
      }

      $this->create_new_image($new_width, $new_height);
    }
  }

  //Create the new image of the give height width.
  function create_new_image($width, $height){
    $new_img = imagecreatetruecolor($width, $height);
    imagealphablending($new_img, false);
    imagesavealpha($new_img, true);
    imagecopyresampled($new_img, $this->resource_id, 0,0,0,0, $width, $height, $this->width, $this->height);
    $this->new_img = $new_img;
  }

  //Finally save the image.
  function save(){
    switch ($this->type) {
        case 'image/png':
          imagepng($this->new_img, 'new-img.png');
          break;
        case 'image/jpg':
        case 'image/jpeg':
          imagejpeg($this->new_img, 'new-img.jpg');
          break;
        case 'image/gif':
          imagegif($this->new_img, 'new-img.gif');
          break;
        default:
          break;
    }
  }

}
?>
