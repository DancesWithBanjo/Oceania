<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["username"] == "godmode"){
    header("location: skyegod.php");
    exit;
}
require_once "config.php";

$query = "select * from states where name = '".$_SESSION["username"]."';";
$result = mysqli_query($link, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo htmlspecialchars($_SESSION["username"]); ?></title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="eindex.css">
  <script>
    function notify(evt, message){alert(message)}
  </script>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->

    <div class="border-right bg-dark" id="sidebar-wrapper">
      <div class="sidebar-heading bg-dark text-light"><?php echo htmlspecialchars($_SESSION["username"]); ?> </div>
      <div class="list-group bg-dark list-group-mine list-group-flush">
        <a href="/actions/invest.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Invest</a>
        <a href="/actions/trade.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade</a>
        <a href="/actions/agreements.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade Agreements</a>
        <a href="logout.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Logout</a>
      </div>
      <br>
      <div class="list-group bg-dark list-group-mine list-group-flush">
      <table border="1" align="center" style="color: white;">
        <?php
          $array=mysqli_fetch_row($result);

          echo '<tr>';
          echo '<th>Name</th>';
                      echo '<td>' . $array[0] . '</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<th>Military</th>';
                      echo '<td>' . $array[1] . '</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<th>Public Approval</th>';
                      echo '<td>' . $array[2] . '</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<th>Credits</th>';
                      echo '<td>' . $array[3] . '</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<th>Research</th>';
          echo '<td>' . $array[4] . '</td>';
          echo '</tr>';

          echo '</table>';
        ?>
      </table>

      <div class="news" align="center">
        <br>
      <?php
      $query = "select * from news order by date desc;";
      $result = mysqli_query($link, $query);
      while($array=mysqli_fetch_row($result))
      {
              echo $array[0]."<br>".$array[1];
              echo "<br><br>";
      }
      ?>
    </div>
    </div>
  </div>

<div class="container-fluid">
<?php
$servername = "localhost";
$username = "root";
$password = "Changeme01!";
$dbname = "oceania";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}
  include "map.php";
?>
</div>
    </div>
  </div>
</body>
</html>
