<?php
//$loginusername = $_POST['username'];
//$loginpassword = $_POST['password'];

$servername = "localhost";
$username = "admin";
$password = "password";
$dbname = "pages";

echo '<nav class="top-bar topbar-responsive">
  <div class="top-bar-title">
    <span data-responsive-toggle="topbar-responsive" data-hide-for="medium">
      <button class="menu-icon" type="button" data-toggle></button>
    </span>
    <a class="topbar-responsive-logo" href="index.php"><strong>Home</strong></a>
  </div>
  <div id="topbar-responsive" class="topbar-responsive-links">
    <div class="top-bar-right">
      <ul class="menu simple vertical medium-horizontal">';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `page` WHERE 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<li><a href='"."$row[href]"."'>"."$row[pagename]"."</a></li>";
    echo "";
    //$_SESSION['loggedin'] = "true";
    //header("Refresh:0");
    if ($row == $result->num_rows) {
      echo "$row == $result->num_rows";
    }
  }
} else {
  echo "<span class='label alert' style='width:100%;'>No pages.</span>";
}

echo '';
        if (isset($_SESSION['loggedin'])) {
          if ($_SESSION['loggedin'] == "true") {
            echo "<li><a href='logout.php'>Logout</a></li>";
          }
        }

        echo'

      </ul>
    </div>
  </div>
</nav>
';
 ?>
