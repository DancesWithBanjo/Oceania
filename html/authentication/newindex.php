<!DOCTYPE html>
<style type="text/css" media="screen">

use {
  transition: 0.4s;
  cursor: pointer;
  fill: transparent;
}
.pod-wrap use:hover {
  fill: #000000 !important;
}
svg {
  width: 600px;
  flex: 1;
}
body {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 0;
  height: 100vh;
  font-weight: 700;
  font-family: sans-serif;
}
</style>

<html>
<head>
<title>I'm alive!</title>
</head>
<body>
<h1></h1>
<p></p>

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

if (isset($_POST['update'])) {
	$sql = $_POST['sql']; //get the sql
	$result = mysqli_query($conn, $sql); //query the DB with the SQL
	while ($row = $result->fetch_row()) {
		echo '<br>' . $row[0] . $row[1] . $row[2] . $row[3] . $row[4]; //display them
		}

}


echo '<form action="newindex.php" method="post">'; //make update button
echo '<input type="text" name="sql">';
echo '<input type="submit" name="update" value="update"></form><br>'; //trigger update

 // if you have a delete action
if (isset($_POST['delete'])) {
	$pID = $_POST['pID']; //get the playerID
        $sql = sprintf("DELETE FROM players WHERE playerID = '".$pID."'"); //use it to create the sql for delete event
        $result = mysqli_query($conn, $sql); //query the DB with the SQL

        }


$result = mysqli_query($conn, "SELECT * FROM players"); //get all from the players table
echo 'Players <br>pID, rID, state, LP';
//while there are more results
while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>' . $row["playerID"] .  " : " . $row["roleID"] . " : " . $row["state"] . " : " . $row["legacyPoints"] . '<br>'; //display them
        echo '<form action="newindex.php" method="post">'; //make delete button
        echo '<input type="hidden" name="pID" value= ' . $row["playerID"] . '>'; //hide but retain the pID as input
        echo '<input type="submit" name="delete" value="delete player"></form><br>'; //trigger delete
}


?>

<!--form to input new player-->
<form action="newindex.php" method="post">
<label>pID:</label>
<input type="number" name="pID" id="pID" required="required"/><br />
<label>rID :</label>
<input type="number" name="rID" id="rID" required="required"/><br />
<label>state :</label>
<input type="text" name="state" id="state" required="required"/><br />
<label>legacyPoints :</label>
<input type="number" name="lp" ide="lp" required="required"/><br />
<input type="submit" value=" Submit " name="submit"/><br />
</form>

<?php

$result = mysqli_query($conn, "SELECT * FROM hexes");
//while ($row = mysqli_fetch_assoc($result))
//{
//	$ystart = 0;
//	$xstart = 0;
//
//	$xind = 0;
//	if($row["state"] == 'Taiga')
//	{
//		$color = "darkorchid";
//	}
//	if($row["state"] == 'Boreala')
//	{
//		$color = "maroon";
//	}
//	if($xind == 41)
//	{
//		if($ystart == 0)
//		{
//			$ystart = 9;
//		}
//		else
//		{
//			$ystart = 0;
//		}
//		$xind =1;
//	}
//	echo "  <use xlink:href='#pod' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
//	$start = $start + 18;

//}
echo "<div class='content_section floating_element'>";
echo "   <svg viewBox='0 0 1000 1000'>";
echo "  <defs>";
echo "     <g id='pod'>";
echo "       <polygon stroke='black' stroke-width='0.5' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
echo "     </g>";
echo "  </defs>";
echo "<g class='pod-wrap'>";

$ystart = 15;
$xstart = 10;
$xind = 0;

$result = mysqli_query($conn, "SELECT * FROM hexes");
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
                $color = "aqua";
        }
        if($row["state"] == 'ice')
        {
                $color = "azure";
        }
        if($row["state"] == 'Taiga')
        {
                $color = "cornflowerblue";
        }
        if($row["state"] == 'Boreala')
        {
                $color = "coral";
        }
        if($row["state"] == 'Highlands')
        {
                $color = "darkmagenta";
        }
        if($row["state"] == 'Archipelagia')
        {
                $color = "deeppink";
        }
        if($row["state"] == 'Riparia')
        {
                $color = "maroon";
        }
        if($row["state"] == 'Lowlands')
        {
                $color = "gold";
        }
        if($row["state"] == 'Dessica')
        {
                $color = "khaki";
        }
        if($row["state"] == 'frozen isles')
        {
                $color = "gainsboro";
        }
        if($row["state"] == 'Boreala')
        {
                $color = "maroon";
        }

        echo "  <use xlink:href='#pod' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
        $xstart = $xstart + 18;
	$xind = $xind +1;

}

//echo "	<use xlink:href='#pod' transform='translate(35, 50)' style='fill:darkorchid'/>" ;
//echo "	<use xlink:href='#pod' transform='translate(35, 68)' style='fill:darkorchid'/>";
//echo "	<use xlink:href='#pod' transform='translate(50, 41)' style='fill:lightcyan'/>";
//echo "	<use xlink:href='#pod' transform='translate(50, 59)' style='fill:lightgreen'/>";
//echo "	<use xlink:href='#pod' transform='translate(50, 77)' style='fill:sandybrown'/>";
//echo "	<use xlink:href='#pod' transform='translate(65, 50)' style='fill:lightsteelblue'/>";
//echo "	<use xlink:href='#pod' transform='translate(65, 68)' style='fill:maroon'/>";
echo "</g>";
echo "</svg>";
echo "<div class='content_section_text'>";
?>


<?php
// Prepare the SQL to prevent vulnerabilities
$stmt = $conn->prepare("INSERT INTO players (playerID, roleID, state, legacyPoints) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $_POST["pID"], $_POST["rID"], $_POST["state"], $_POST["lp"]);
$stmt-> execute(); //and execute to add the new entry
mysqli_close($conn); //close the DB connection
?>

</body>
</html>
