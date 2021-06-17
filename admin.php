<?php
session_start();
include 'head.php';
include 'header.php';
include 'footer.php';

//$_SESSION['loggedin'] = "false";
if (isset($_SESSION['loggedin'])) {
  $loggedin = $_SESSION['loggedin'];
}else {
  $_SESSION['loggedin'] = false;
}
$loggedin = $_SESSION['loggedin'];

//echo "$loggedin";
if ($loggedin!="true" || empty($loggedin)){
  echo '
<div id="loginfield" class="grid-x grid-padding-x" style="margin-top: 25px;">
  <div class="cell small-2"></div>
    <div class="cell small-8">
      <div class="translucent-form-overlay">
        <form action="admin.php" method="POST">
          <h3>Log In</h3>
          <div class="row columns">
            <label>
              <input type="text" name="username" placeholder="Username">
            </label>
          </div>
          <div class="row columns">
            <label>
              <input type="password" name="password" placeholder="Password">
            </label>
          </div>

          <button type="submit" name="submitted" value="true" class="primary button expanded search-button">
            Log In
          </button>
       </form>
      </div>';
      if (isset($_POST['submitted'])) {
        if ($_POST['username']!='' && $_POST['password']!='' && $_POST['submitted']!='') {
          //LOGIN INFO Var
          $loginusername = $_POST['username'];
          $loginpassword = $_POST['password'];

          $servername = "localhost";
          $username = "admin";
          $password = "password";
          $dbname = "users";

          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT id, username, password, email, verified FROM users WHERE username='$loginusername' AND password='$loginpassword'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. " " . $row["email"]. " " . $row["verified"]. "<br>";
              if ($row["verified"] == 0) {
                echo "Please verify email.";
              }
              $_SESSION['loggedin'] = "true";
              header("Refresh:0");
            }
          } else {
            echo "<span class='label alert' style='width:100%;'>Username or password incorrect.</span>";
          }
          $conn->close();
        }else {
          echo "<span class='label alert' style='width:100%;'>missing field</span>";
        }
      }else {
        echo "";
      }
      echo'
    </div>
    <div class="cell small-2"></div>

  </div>

  ';



}else {
  echo "
  <!DOCTYPE html>
  <html>
    <head>
      <script src='https://cdn.tiny.cloud/1/qiicceiwhvlqpefwujfkncty6igkuiqkmajsrli3raisjf3q/tinymce/5/tinymce.min.js' referrerpolicy='origin'></script>
    </head>
    <body>
      <div class='container'>";

      $servername = "localhost";
      $username = "admin";
      $password = "password";
      $dbname = "pages";

      //use the localurl to search the DB for the content for this specific URL
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM `page`";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<ul>";
        $i = 0;
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $i++;
          echo '<li><a href="/admin.php?editID='.$row['id'].'">'.$row['pagename'].' - ID: '.$row['id'].'</a></li>';

          if ($i == $result->num_rows) {
            echo "</ul>";
          }
        }
      } else {}
      $conn->close();

      echo"
      <input class='add-button' type='submit' value='Create New Page'>";

//update function
          if(isset($_GET['update'])){
            echo "<br>Page updated.";
            $servername = "localhost";
            $username = "admin";
            $password = "password";
            $dbname = "pages";


            //use the localurl to search the DB for the content for this specific URL
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            $pageID = $_GET['update'];
            $postContent = $_GET['post-content'];
            $sql = "UPDATE `page` SET `content` = '$postContent' WHERE `id` = $pageID";
            $result = $conn->query($sql);
            $conn->close();
          }


          if(isset($_GET['editID'])){
            $servername = "localhost";
            $username = "admin";
            $password = "password";
            $dbname = "pages";
            echo "        <form method='GET' action='/admin.php'>
                      <textarea name='post-content' id='content-editor' class='content-editor'>";

            //use the localurl to search the DB for the content for this specific URL
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            $pageID = $_GET['editID'];
            $sql = "SELECT * FROM `page` WHERE `id` = $pageID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

              // output data of each row
              while($row = $result->fetch_assoc()) {

                echo $row['content'];
                echo "
                </textarea>
                <button class='submit-button' name='update' type='submit' value='$pageID'>Submit</button>
              </form>
              <script>
                  tinymce.init({
                    selector: 'textarea',
                    plugins: 'autolink lists media table',
                    toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
                    toolbar_mode: 'floating',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name'
                  });
              </script>";

                if ($i == $result->num_rows) {
                  echo "</ul>";
                }
              }
            } else {}
            $conn->close();

          }

//this will be for checking if there has been content posted
  //if so then post to DB
  /*
          if (isset($_POST['post-content'])) {
            $postContent = $_POST['post-content'];
            echo $postContent;
          }else{
            echo 'no content';
          }

*/





          echo "
      </div>
    </body>
  </html>";


}
?>
