<?php
include_once('resize.php');
$title = 'Image Resizing in PHP';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo $title; ?> </title>
<style type="text/css">
body{
  font-family: sans-serif;
}
input[type="number"]{
  border:1px solid #ccc;
  padding:10px 15px;
}

button{
  background: #333;
  border:1px solid #333;
  color: #fff;
  padding: 10px 15px;
}
button:hover{
  background: #fff;
  color: #333;
  cursor: pointer;
  transition: ease all 0.5s;
}
</style>
</head>

<body>

<?php include('../header.php'); ?>

<div align="center" style="font-size: 30px;margin-top:10px;"> <?php echo $title; ?></div>
<br/>
<div align="center">

Original Image: <br/>
<img src="img.png">
<br/>

<br/><br/>
<b>Enter dimension of the new image. </b><br/>
<b>auto</b> - resize image try to keep the original image ascept ratio.
<b>exact</b> - resize image same as the dimension provided.<br/><br/>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<label for="width">Width: </label>
<input type="number" name="width" placeholder="Width">

<label for="height">Height: </label>
<input type="number" name="height" placeholder="Height">

<select name="opt">
  <option value="auto"> Auto </option>
  <option value="exact"> Exact </option>
</select>

<button type="submit">SUBMIT</button>
</form>

<?php
if(isset($_GET['width'])):
  $w = $_GET['width'];
  $h = $_GET['height'];
  $opt = $_GET['opt'];

  $image_file = "img.png";
  $img = new Image($image_file);
  $img->open();
  $img->resize($w, $h, $opt);
  $img->save();
?>

<br/><br/>
Resized Image: <br/>
<img src="new-img.png">
</div>

<?php endif ?>

</body>
</html>
