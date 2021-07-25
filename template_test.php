<?php




include 'head.php';
include 'header.php';
//include 'body.php';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$short_link = "$_SERVER[REQUEST_URI]";
$localurl = strtok($short_link, '?');
$pos = strrpos($localurl, '/', );
$localurl = substr($localurl, $pos+1);
//$url = strtok($short_link, '?');
//echo "<h1>$actual_link</h1><br>$short_link<br>$localurl";



//below is temlate
?>
<link rel="stylesheet" href="css/template_test.css">
<div class="hero">
  <img src="img/hero.jpg" alt="hero image">
</div>
<div class="container">
  <?php include 'body.php';?>
  <div class="footer">
    <?php include 'footer.php';?>
  </div>
</div>
