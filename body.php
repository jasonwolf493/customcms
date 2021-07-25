<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$short_link = "$_SERVER[REQUEST_URI]";
$localurl = strtok($short_link, '?');
$pos = strrpos($localurl, '/', );
$localurl = substr($localurl, $pos+1);
//$url = strtok($short_link, '?');
//echo "<h1>$actual_link</h1><br>$short_link<br>$localurl";






//use the localurl to search the DB for the content for this specific URL
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `page` WHERE href = '$localurl'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $title = $row['title'];
    $pagename = $row['pagename'];
    $content = $row['content'];
    echo "
      <div>
        <h1>$pagename</h1>
      </div>
      <div class=content>
        $content
      </div>";
    if ($row == $result->num_rows) {
      echo "$row == $result->num_rows";
    }
  }
} else {
  //header('Location: /404.php?updateComplete');
  echo "<h1>404</h1><br><h2>Page not found.</h2>";
}





//display this content
 ?>
