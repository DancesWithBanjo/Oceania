<!DOCTYPE html>
<html>
<head>
<style>
.column {
  float: left;
  width: 33%;
}

/* Column CSS */
.row:after {
  content: "";
  display: table;
  clear: both;
}
use {
  transition: 0.4s;
  cursor: pointer;
  fill: transparent;
}
.pod-wrap use:hover {
  fill: #000000 !important;
}
svg {
    width: 30vw;
    height: 30vw;
    display: inline-flex;
    margin: auto;
  }

</style>
<link rel="stylesheet" href="style.css">
<title>God Mode</title>

  <script type="text/JavaScript">
    function showMessage(){
      var message = document.getElementById("newsbox").value;
      display_message.innerHTML= message;
    }

    // Gets current time and formats it for news log update
    function getTime(){
      n =  new Date();
      y = n.getFullYear();
      m = n.getMonth() + 1;
      d = n.getDate();
      document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
    }

    // Gets hex id from selected hex
    function getHexID(id) {
      document.getElementById("hexID").value = id;
    }
  </script>

  <?php
    // Initialize the session
    session_start();

    // Check if the user is logged in, if not then redirect him to login page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["username"] == "godmode"){
      echo "you are god";
    } else {
      header("location: login.php");
      echo "you arent god!";
      exit;
    }
    require_once "config.php";

  ?>



</head>

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

  if (isset($_POST['updateStates'])) {
          // Prepare the SQL to prevent vulnerabilities
  	$m = $_POST['military'];
  	$p = $_POST['public_op'];
  	$e = $_POST['economy'];
  	$r = $_POST['research'];
  	$n = $_POST['nation'];
  	$f = $_POST['FTbonus'];
  	$g = $_POST['growthRate'];
  	$o = $_POST['giveableOil'];
	$sc = $_POST['startCredits'];

    // Prepare and attempt new data writing
  	$stmt = "UPDATE states SET military = ".$m.", pubApproval =".$p.", credits =".$e.", research ='".$r."', growthRate = ".$g.", FTbonus = ".$f.", giveableOil = ".$o.", startCredits = ".$sc." WHERE name ='".$n."';";
  	if (mysqli_query($conn, $stmt)) {
      echo "Record updated successfully!";
  	} else {
      echo "Error updating record.";
  	}

  }

  if (isset($_POST['updateHexes'])) {
    // Prepare the SQL to prevent vulnerabilities
    $hid = $_POST['hexID'];
    $nu = $_POST['nuked'];
    $nf = $_POST['numFish'];
    $no = $_POST['numOil'];
    $n = $_POST['nation'];
    $numCoal = $_POST['numCoal'];
    $numGas = $_POST['numGas'];
    $capital = $_POST['capital'];
    $city = $_POST['city'];
    $mountain = $_POST['mountain'];

    $stmt = "UPDATE hexes SET state = '".$n."', nuked =".$nu.", numFish =".$nf.", numOil =".$no.", mountains =".$mountain.", city = ".$city.", capital = ".$capital.", nGas = ".$numGas.", coal = ".$numCoal." WHERE hexID = ".$hid.";";
    //echo $stmt;
    if (mysqli_query($conn, $stmt)) {
      echo "Record updated successfully!";
    } else {
      //echo "STMT".$stmt."";
      echo "Error updating record.";
    }
  }

  if(isset($_POST['resDeltas'])){
  	$stmt = "UPDATE allocations set delta = 0;";
    if (mysqli_query($conn, $stmt)) {
      echo "Record updated successfully!";
    } else {
      echo "Error updating record.";
    }
  }

  if(isset($_POST['resTurn'])){
        $stmt = "UPDATE turn set number = 0;";
      if (mysqli_query($conn, $stmt)) {
      	echo "Record updated successfully!";
      } else {
      	echo "Error updating record.";
      }
  }

  if (isset($_POST['inputNews'])) {
    // Prepare the SQL to prevent vulnerabilities
    $news = $_POST['news'];
    $stmt = "insert into news (body, date) VALUES ('".$news."',now());";
    if (mysqli_query($conn, $stmt)) {
      echo "Record updated successfully!";
    } else {
      echo "STMT".$stmt."";
      echo "Error updating record.";
    }
  }

  if (isset($_POST['delNews'])) {
    // Prepare the SQL to prevent vulnerabilities
    $time = $_POST['time'];
    $stmt = "delete from news where date ='".$time."';";
    if (mysqli_query($conn, $stmt)) {
      echo "Record updated successfully!";
    } else {
      echo "STMT".$stmt."";
      echo "Error updating record.";
    }
  }

if(isset($_POST['warEvent'])) {

	$na = $_POST['nationA'];
	$nd = $_POST['nationD'];
	$numA = $_POST['numA'];
	$numD = $_POST['numD'];
	$sh = $_POST['sHexes'];
	$oh = $_POST['oHexes'];
	$mh = $_POST['mHexes'];

	$attackers = $numA - (($sh*3) + ($oh*1) + ($mh*10));
	$defenders = $numD;
	$deadA = 0;
	$deadD = 0;
	While($attackers != 0 && $defenders != 0){
		$attackRoll = rand(1,6);
		$defenseRoll = rand(1,6);
		if($defenseRoll >= $attackRoll){
			$attackers = $attackers -1;
			$deadA = $deadA + 1;
		}
		else{
			$defenders = $defenders - 1;
			$deadD = $deadD + 1;
		}
	}
	$query = "select * from states where name = '".$na."';";
	$result = mysqli_query($conn, $query);
	$aArray = mysqli_fetch_row($result);
        $query2 = "select * from states where name = '".$nd."';";
        $result2 = mysqli_query($conn, $query2);
        $dArray = mysqli_fetch_row($result2);

	$aStartMil = $aArray[1];
	$dStartMil = $dArray[1];

	$aEndMil = $aStartMil - $deadA;
	$dEndMil = $dStartMil - $deadD;


	if($attackers == 0)
	{
		echo $na." the attackers have failed their conquest of ".$nd." losing ".$deadA." units. ".$nd." succesfully defended their country, losing ".$deadD." units.";
	}
	else{
		echo $na." the attackers have succesfully battled ".$nd." but lost ".$deadA." units. In their failure, ".$nd." lost ".$deadD." units.";
	}


	$stmt = "UPDATE states set military = ".$aEndMil." where name = '".$na."';";
        if (mysqli_query($conn, $stmt)) {
        	echo "Record updated successfully!";
        }
	else {
        	echo "STMT:".$stmt."";
      		echo "Error updating record.";
        }
	$stmt2 = "UPDATE states set military = ".$dEndMil." where name = '".$nd."';";
	if (mysqli_query($conn, $stmt2)) {
                echo "Record updated successfully!";
        }
        else {
                echo "STMT:".$stmt2."";
                echo "Error updating record.";
        }

}


if(isset($_POST['triggerTurn'])){

	$query = "select * from allocations;";
        $allocResult = mysqli_query($conn, $query);
        while($array=mysqli_fetch_row($allocResult)){

		$q2 = "select * from states where name = '".$array[0]."';";
		$stateResult = mysqli_query($conn, $q2);
		$stateArray = mysqli_fetch_row($stateResult);

		$endowment = $_POST[$array[0]];
		$econ = $stateArray[3]/1000;
		$mil = $stateArray[1]/100;
		$oilNeeded = $econ + $mil;
		$delta = $array[5];
		$end = $endowment + $delta;
		$budPerc = $array[1]/$stateArray[3];
		$shortfall = $oilNeeded - $end;
		if($shortfall < 0){
			$shortfall = 0;
		}

		if($shortfall == 0){
			$oilSlowdown = 0;
		}
		else{
			$oilSlowdown = ($econ/($oilNeeded * $shortfall))/100;
		}
		$actualGR = ($stateArray[5] + ($budPerc/10)+ $stateArray[6] - $oilSlowdown);

		if($oilSlowdown != 0){
			$nextBudget = round($stateArray[3]*(1+$actualGR));
		}
		else{
			$nextBudget = round(($stateArray[3] * (1+$stateArray[5] + $stateArray[6])) + ($stateArray[3]*($budPerc/10)));
		}
		//next budget is set

		$q3 = "select * from turn;";
		$turnResult = mysqli_query($conn, $q3);
		$turnArray = mysqli_fetch_row($turnResult);

		$milPerc = $array[2]/$stateArray[1];

		if($turnArray[0] == 0){
			$milRequest = $stateArray[1] * .9 + $array[2];
		}
		else{
			$oilDepr = ($stateArray[1]/($oilNeeded * $shortfall))/100;
			if ($shortfall == 0){
				$oilDepr = 0;
			}
			$milDepr = .1 + $oilDepr;
                	$milRequest = $stateArray[1] * (.9 - $milDepr) * $milPerc * $stateArray[3];
		}
		$milMax = 1.5 * $stateArray[1];
		$milDdwt = $array[2] - $milMax;
		$nextMil = round($milMax - $milDdwt);
		//query here
		$stmt = "UPDATE states set credits =".$nextBudget.", startCredits =".$nextBudget.", military =".$nextMil." where name = '".$array[0]."';";
		//echo $stmt;
		if (mysqli_query($conn, $stmt)) {
     			echo "Record updated successfully!";
    		} else {
      			echo "Error updating record.";
		}
	}
	$nextTurn = $turnArray[0] + 1;
        $stmt = "UPDATE turn set number =".$nextTurn.";";
        if (mysqli_query($conn, $stmt)) {
        	echo "Record updated successfully!";
        } else {
                echo "Error updating record.";
        }
}

?>


<h1> God Mode</h1>
<hr>

<!-- Try using an aside tag to create a vert line -->
<div class = "row">
  <div class = "column">

    <!-- Create Table for each nations values -->
    <table border="1">
    <tr>
    <th> Name </th>
    <th> Military </th>
    <th> Public Approval </th>
    <th> Credits </th>
    <th> Research </th>
    <th> Growth Rate</th>
    <th> Free Trade Bonus</th>
    <th> Giveable Oil </th>
    <th> Credits at Start of Turn
    </tr>

                <?php
                  $query = "select * from states;";
                  $result = mysqli_query($conn, $query);
                  while($array=mysqli_fetch_row($result))
                  {
                    echo '<tr>';
                    echo '<td>' . $array[0] . '</td>';
                    echo '<td>' . $array[1] . '</td>';
                    echo '<td>' . $array[2] . '</td>';
                    echo '<td>' . $array[3] . '</td>';
                    echo '<td>' . $array[4] . '</td>';
                    echo '<td>' . $array[5] . '</td>';
                    echo '<td>' . $array[6] . '</td>';
    		    echo '<td>' . $array[7] . '</td>';
                    echo '<td>' . $array[8] . '</td>';
		    echo '</tr>';
                  }

                  echo '</table>';
                ?>

<br>
<br>

<!-- Display nation value manipulation form -->
<a>Select the nation whose values you want to alter</a>
	<!-- Need to specify action type -->
		<form action="godmode.php" method = "post">
  		<input type="radio" name="nation" value="Taiga"> Taiga<br>
  		<input type="radio" name="nation" value="Boreala"> Boreala<br>
  		<input type="radio" name="nation" value="Highlands"> The Highlands<br>
  		<input type="radio" name="nation" value="Archipelagia"> Archipelagia<br>
  		<input type="radio" name="nation" value="League"> The League<br>
  		<input type="radio" name="nation" value="Riparia"> Riparia<br>
  		<input type="radio" name="nation" value="Arborea"> Arborea<br>
  		<input type="radio" name="nation" value="Desicca"> Desicca<br>
  		<input type="submit" value = "submit">
		</form>
	  	<br>

<?php
  $nation = $_POST['nation']; //get the nation
  $sql = "SELECT * from states WHERE name = '".$nation."';"; //use it to create the sql $
  $stateInfo = mysqli_query($conn, $sql); //query the DB with the SQL
  $row = mysqli_fetch_array($stateInfo, MYSQLI_ASSOC);

    // Display manipulation forms
  	echo '<form action ="godmode.php" method = "post">';
  	echo 'Input Military modification:<br>';
  	echo '<input type="number" name="military" value = ' .$row['military']. '><br>';
  	echo 'Input Public Opinion modification:<br>';
  	echo '<input type="number" name="public_op" value = ' .$row['pubApproval']. '><br>';
	echo 'Input Economy modification:<br>';
    	echo '<input type="number" name="economy" value = ' .$row['credits']. '><br>';
	echo 'Input Research modification:<br>';
    	echo '<input type="text" name="research" value = ' .$row['research']. '><br><br>';
	echo 'Input Growth Rate modification:<br>';
    	echo '<input type="number" name="growthRate" value = ' .$row['growthRate']. '><br>';
	echo 'Input Free Trade Bonus modification:<br>';
    	echo '<input type="number" name="FTbonus" value = ' .$row['FTbonus']. '><br>';
 	echo 'Input Giveable Oil modification:<br>';
    	echo '<input type="number" name="giveableOil" value = ' .$row['giveableOil']. '><br>';
        echo 'Input Credits at Turn Start modification:<br>';
        echo '<input type="number" name="startCredits" value = ' .$row['startCredits']. '><br>';
	echo '<input type = "hidden" name = "nation" value = '.$nation. '>';
	echo '<input type="submit" value="Submit" name = "updateStates">';
	echo '</form>';

?>

		<br>
<h2>Reset Deltas to 0:</h2>
<form action ="godmode.php" method = "post">
<input type="submit" value="Reset" name = "resDeltas">
</form>



<h2>Reset turn to 0:</h2>
<form action = "godmode.php" method = "post">
<input type = "submit" value="Reset" name = "resTurn">
</form>
<?php
$query = "select * from turn;";
$result = mysqli_query($conn, $query);
$array=mysqli_fetch_row($result);
echo "It is turn: ".$array[0];
?>

	</div>
	<div class = "column"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<h2 align='center'>OCEANIA FROM ABOVE</h2>
		<?php

		$result = mysqli_query($conn, "SELECT * FROM hexes;");

		//echo "<div class='content_section floating_element'>";
		echo "   <svg viewBox='0 0 1000 1000'>";
		echo "  <defs>";
		echo "     <g id='pod'>";
		echo "       <polygon stroke='white' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
		echo "     </g>";
		echo "     <g id='oilPod1'>";
		echo "       <polygon stroke='white' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='7,0 7,-3'/>";
		echo "     </g>";

		echo "     <g id='oilPod2'>";
		echo "       <polygon stroke='white' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='7,0 7,-3'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='4,0 4,-3'/>";
		echo "     </g>";

		echo "     <g id='oilPod3'>";
		echo "       <polygon stroke='white' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='7,0 7,-3'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='4,0 4,-3'/>";
		echo "       <polygon stroke='black' stroke-width='2' points='1,0 1,-3'/>";
		echo "     </g>";

		echo "  </defs>";
		echo "<g class='pod-wrap'>";

		$ystart = 15;
		$xstart = 10;
		$xind = 0;
		//$result = mysqli_query($conn, "SELECT * FROM hexes;");
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
          if($row["state"] == 'League')
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
          if($row["numOil"] == 0)
          {
                  $oil = '#pod';
          }
          if($row["numOil"] == 1)
          {
                  $oil = '#oilPod1';
          }
          if($row["numOil"] == 2)
          {
                  $oil = '#oilPod2';
          }
          if($row["numOil"] == 3)
          {
                  $oil = '#oilPod3';
          }

	  $hid = $row["hexID"];
          echo "  <use xlink:href=$oil transform='translate($xstart, $ystart)' onclick='getHexID($hid)' style='fill: $color'/>" ;
          $xstart = $xstart + 18;
          $xind = $xind +1;

  }



  echo "</g>";
  echo "</svg>";

?>
		<h2>War</h2>
                <form action="godmode.php" method = "post">
		Attacker:<br>
                <input type="radio" name="nationA" value="Taiga"> Taiga<br>
                <input type="radio" name="nationA" value="Boreala"> Boreala<br>
                <input type="radio" name="nationA" value="Highlands"> The Highlands<br>
                <input type="radio" name="nationA" value="Archipelagia"> Archipelagia<br>
                <input type="radio" name="nationA" value="League"> The League<br>
                <input type="radio" name="nationA" value="Riparia"> Riparia<br>
                <input type="radio" name="nationA" value="Arborea"> Arborea<br>
                <input type="radio" name="nationA" value="Desicca"> Desicca<br>
		Number of military units expended:<br>
		<input type="number" name = "numA"><br><br>
                Defender:<br>
		<input type="radio" name="nationD" value="Taiga"> Taiga<br>
                <input type="radio" name="nationD" value="Boreala"> Boreala<br>
                <input type="radio" name="nationD" value="Highlands"> The Highlands<br>
                <input type="radio" name="nationD" value="Archipelagia"> Archipelagia<br>
                <input type="radio" name="nationD" value="League"> The League<br>
                <input type="radio" name="nationD" value="Riparia"> Riparia<br>
                <input type="radio" name="nationD" value="Arborea"> Arborea<br>
                <input type="radio" name="nationD" value="Desicca"> Desicca<br>
		Number of Military unites expended:<br>
		<input type = "number" name = "numD"><br>
		Standard hexes to travel:<br>
		<input type="number" name = "sHexes"><br>
                Ocean hexes to travel:<br>
                <input type="number" name = "oHexes"><br>
		Mountain hexes to travel:<br>
                <input type="number" name = "mHexes"><br>
                <input type="submit" name="warEvent" value = "submit">
                </form>




<?php

echo '</div>';
echo '<div class = "column">';


    // Form for hex/map changes

    echo '<h2>Edit Hexes</h2>';
    echo '<form action ="godmode.php" method = "post">';
  		echo 'hexID to modify:<br>';
   		echo '<input id="hexID" type="number" name="hexID"<br><br>';
  		echo 'State for hex to become: <br>';
  		echo '<input type="radio" name="nation" value="Taiga"> Taiga<br>';
      echo '<input type="radio" name="nation" value="Boreala"> Boreala<br>';
      echo '<input type="radio" name="nation" value="Highlands"> The Highlands<br>';
      echo '<input type="radio" name="nation" value="Archipelagia"> Archipelagia<br>';
      echo '<input type="radio" name="nation" value="League"> The League<br>';
      echo '<input type="radio" name="nation" value="Riparia"> Riparia<br>';
      echo '<input type="radio" name="nation" value="Arborea"> Arborea<br>';
      echo '<input type="radio" name="nation" value="Desicca"> Desicca<br>';
      echo '<input type="radio" name="nation" value="ocean"> Ocean<br>';
      echo '<input type="radio" name="nation" value="ice"> Ice<br>';
      echo '<input type="radio" name="nation" value="frozen isles"> Frozen Isles<br>';
      echo 'Change Nuked Status(1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="nuked" value="0"><br>';
      echo 'Change Mountain Status(1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="mountain" value="0"><br>';
      echo 'Change City Status(1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="city" value="0"><br>';
      echo 'Change Capital Status(1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="capital" value="0"><br>';
      echo 'Input Oil modification:<br>';
      echo '<input type="number" name="numOil" value="0"><br>';
      echo 'Input Fish modification:<br>';
      echo '<input type="number" name="numFish" value="0"><br>';
      echo 'Input Natural Gas modification:<br>';
      echo '<input type="number" name="numGas" value="0"><br>';
      echo 'Input Coal modification:<br>';
      echo '<input type="number" name="numCoal" value="0"><br>';
      echo '<input type="submit" value="Submit" name = "updateHexes">';
    echo '</form>';


?>



    <!-- News log updates/input section -->
    <br>
    <h2>News</h2>
    <form action ="godmode.php" method = "post">
    <input type = "text" value = "news..." name = "news">
    <input type="submit" value="Submit" name = "inputNews">
    </form>
    <br>

<?php

$query = "select * from news;";
$result = mysqli_query($conn, $query);
while($array=mysqli_fetch_row($result))
{
	echo $array[0]." : ".$array[1];
	echo "<form action = 'godmode.php' method = 'POST'>";
	echo "<input type = 'hidden' name='time' value ='".$array[0]."'>";
	echo "<input type = 'submit' value='Delete' name = 'delNews'>";
	echo "<br><br>";
}

?>




  <!-- Display current allocation requests for each nation -->
	<h2>Current Allocation Requests</h2>
	<?php
                $query = "select * from allocations;";
                $result = mysqli_query($conn, $query);


                while($array=mysqli_fetch_row($result))
                {
			$query2 = "select * from states where name='".$array[0]."';";
			$result2 = mysqli_query($conn, $query2);
			$array2 = mysqli_fetch_row($result2);

                	echo $array[0]." had ".$array2[8]." Credits and ".$array2[1]." military units to start. They seek to invest ".$array[1]." Credits into their economy, ".$array[2]." Credits to their military, and ".$array[6]." Credits to global warming abatement. They also seek to invest ".$array[3]." Credits towards researching ".$array[4].". Their delta is: ".$array[5].".<br><br>";
                }
	?>
	<br>
	<br>
	<h2>Input endowments and trigger turn flip</h2>
  	<form action ="godmode.php" method = "post">
  	   Input endowment for Arborea:
      <input type="number" name="Arborea" value="0"><br>
      Input endowment for Archipelagia:
      <input type="number" name="Archipelagia" value="0"><br>
      Input endowment for Boreala:
      <input type="number" name="Boreala" value="0"><br>
      Input endowment for Desicca:
      <input type="number" name="Desicca" value="0"><br>
      Input endowment for Highlands:
      <input type="number" name="Highlands" value="0"><br>
      Input endowment for League:
      <input type="number" name="League" value="0"><br>
      Input endowment for Riparia:
      <input type="number" name="Riparia" value="0"><br>
      Input endowment for Taiga:
      <input type="number" name="Taiga" value="0"><br>
      <input type="submit" value="Trigger Turn" name = "triggerTurn">
    </form>


		<?php mysqli_free_result($result); ?>
		<?php mysqli_close($conn); ?>
		<br>
		<br>
		<a href="register.php" class"btn btn-default">REGISTER</a>
    <a href="login.php" class"btn btn-default">LOGIN</a>
		<a href ="reset_password.php" class"btn btn-default">RESET PASSWORD</a>
		<a href = "logout.php" class"btn btn-default"> LOGOUT</a>
	</div>
</div>
