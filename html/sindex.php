<!DOCTYPE html>
<html land="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="skye.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  <title>Skye's page</title>
  <script>
function myFunction(id) {
	alert("That is HexID: " + id);
}
</script>
</head>

<body>
<div class="panel panel-default">
  <h1>Welcome to Oceania</h1>
</div>


  <div class="rows">
    <div class="col-md-12" >
      <h2>Please Login to your Nation</h2>
      <!--
      <div class=button1 >
      <button class="btn" onclick="window.location.href = 'register.php';">Register</button><br/>
      </div>
        -->
      <div class=button1 >
      <button class="btn" onclick="window.location.href = 'login.php';">Login</button><br/>
      </div>
      <!--
      <div class=button1 >
      <button class="btn" onclick="window.location.href = 'reset_password.php';">Reset Password</button><br/>
        </div>
        -->
        </div>
    </div>

    <div class= "col-md-12" >
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
//calls map.php with when clicked on returns hexID
  include 'map.php';
 
  ?>
    </div>

    <!-- <div class="column_right" >
      <h2 align="right">Actions<br/></h2>
      <button onclick="window.location.href = 'allocate.php';">Allocate</button><br/>
      <button onclick="window.location.href = 'war.php';">War</button><br/>
      <button onclick="window.location.href = 'trade.php';">Trade</button><br/>
      <button onclick="window.location.href = 'agreements.php';">Trade Agreements</button><br/>
      <button onclick="window.location.href = 'nat_info.php';">Nation Information</button>
    </div> -->
  </div>

</body>
</html>