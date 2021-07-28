<?php
session_start();
//include 'head.php';
//include 'header.php';
//include 'body.php';
//include 'footer.php';




//Direct to correct template
$servername = "localhost";
$username = "admin";
$password = "password";
$dbname = "pages";


$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$short_link = "$_SERVER[REQUEST_URI]";
$localurl = strtok($short_link, '?');
$pos = strrpos($localurl, '/', );
$localurl = substr($localurl, $pos+1);


if (isset($_GET['id'])){
  echo "here";
  $pageID = $_GET['id'];
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM `page` WHERE id = '$pageID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      include $row['template'];
      //header("Location: $row[template]");
      //echo "<br>Template: "."$row[template]";
      //$_SESSION['loggedin'] = "true";
      //header("Refresh:0");
      if ($row == $result->num_rows) {
        echo "$row == $result->num_rows";
      }
    }
  } else {
    header('Location: /404.php');
  }
  $conn->close();


}else {
  echo "404";
  //header('Location: /404.php');
}
//$url = strtok($short_link, '?');
//echo "<h1>$actual_link</h1><br>$short_link<br>$localurl";






//use the localurl to search the DB for the content for this specific URL
// Create connection




?>
