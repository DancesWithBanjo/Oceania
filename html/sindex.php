<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="sindex.css">
<title>Skye's page</title>
</head>

<body>
<h1>Skye's Page</h1>


<div class="columns">
  <div class="column_left" >
    <h2>Nation Info</h2>
    <p>Some text..</p>
  </div>

  <div class= "column_middle" >
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

$result = mysqli_query($conn, "SELECT * FROM hexes");

echo "<div class='content_section floating_element'>";
echo "   <svg viewBox='0 0 1000 1000'>";
echo "  <defs>";
echo "     <g id='pod'>";
echo "       <polygon points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
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

        echo "  <use xlink:href='#pod' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
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
    <button onclick="window.location.href = 'allocate.php';">Allocate</button><br/>
    <button onclick="window.location.href = 'trade.php';">Trade</button><br/>
    <button onclick="window.location.href = 'war.php';">War</button><br/>
    <button onclick="window.location.href = 'agreements.php';">Trade Agreements</button><br/>
    <button onclick="window.location.href = 'nat_info.php';">Nation Information</button>
  </div>
</div>

</body>
</html>
