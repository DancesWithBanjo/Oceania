<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

$query = "select * from states where name = '".$_SESSION["username"]."';";
$result = mysqli_query($link, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="sindex.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"> </script>
    <script>
      function tempAlert(msg,duration){
         var el = document.createElement("div");
         el.setAttribute("style","position:absolute;top:40%;left:20%;background-color:white;");
         el.innerHTML = msg;
         setTimeout(function(){
          el.parentNode.removeChild(el);
         },duration);
         document.body.appendChild(el);
      }
    </script>

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
    </div>

  <div class="columns">
    <div class="column_left" >
      <h2>Nation Info</h2>
        <table border="1" align="center">
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
      <br>
      <p id="news" align="left">
        <textarea readonly="readonly" name="newsbox" rows="30" cols="20" align="left"><?php echo $_POST['news']; ?></textarea>
      </p>
    </div>

    <div class= "column_middle" >

<?php

  echo "<div class='content_section floating_element'>";
  echo "   <svg viewBox='0 0 1000 1000'>";
  echo "  <defs>";
  echo "     <g id='pod'>";
  echo "       <polygon stroke='white' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "     </g>";
  echo "  </defs>";
  echo "<g class='pod-wrap'>";

  $ystart = 15;
  $xstart = 10;
  $xind = 0;

  $result = mysqli_query($link, "SELECT * FROM hexes");
  while ($row = mysqli_fetch_assoc($result))
  {

          if($xind == 55)
          {

                  if($xstart == 1000)
                  {
                          $xstart = 18.5;
                  }
                  else
                  {
                          $xstart = 10;
                  }
                  $xind =0;
                  $ystart = $ystart + 15;
          }
          if($row["state"] == 'ocean')
          {
                  $color = "#d2fff7";
          }
          if($row["state"] == 'ice')
          {
                  $color = "#ffffff";
          }
          if($row["state"] == 'Taiga')
          {
                  $color = "#92c4d1";
          }
          if($row["state"] == 'Boreala')
          {
                  $color = "#ecbf84";
          }
          if($row["state"] == 'Highlands')
          {
                  $color = "#96a2e8";
          }
          if($row["state"] == 'Archipelagia')
          {
                  $color = "#ef81cb";
          }
          if($row["state"] == 'Riparia')
          {
                  $color = "#d9d3ea";
          }
          if($row["state"] == 'Lowlands')
          {
                  $color = "#e8fa8c";
          }
	  if($row["state"] == 'Desicca')
          {
                  $color = "#d1bc8b";
          }
          if($row["state"] == 'frozen isles')
          {
                  $color = "#e8e5e7";
          }
          if($row["state"] == 'Arborea')
          {
                  $color = "#75d59d";
          }

          echo "  <use xlink:href='#pod' onclick='top.tempAlert(\"$row[state]\", 2000)' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
          $xstart = $xstart + 18;
          $xind = $xind +1;

  }
  echo "</g>";
  echo "</svg>";
  echo "</div class='content_section_text'>";
  ?>
    </div>

    <div class="column_right" >
      <h2 align="right">Actions<br/></h2>
      <button onclick="window.location.href = 'actions/allocate.php';">Allocate</button><br/>
      <button onclick="window.location.href = 'actions/war.php';">War</button><br/>
      <button onclick="window.location.href = 'actions/trade.php';">Trade</button><br/>
      <button onclick="window.location.href = 'actions/agreements.php';">Trade Agreements</button><br/>
      <button onclick="window.location.href = 'actions/nat_info.php';">Nation Information</button>
    </div>
  </div>

    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>
