<!DOCTYPE html>
<html land="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="godcss.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>GodMode</title>

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
      //echo "you are god";
    } else {
      header("location: login.php");
      echo "you arent god!";
      exit;
    }
    require_once "config.php";
  ?>
</head>

<!-- Godmode php -->
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
	$sm = $_POST['startMil'];

    // Prepare and attempt new data writing
  	$stmt = "UPDATE states SET military = ".$m.", pubApproval =".$p.", credits =".$e.", research ='".$r."', growthRate = ".$g.", FTbonus = ".$f.", giveableOil = ".$o.", startCredits = ".$sc.", startMil = ".$sm." WHERE name ='".$n."';";
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

if(isset($_POST['resGW']))
{
	$stmt = "UPDATE globalWarming set investment = 0;";
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

	$invaded = $_POST['invaded'];

	$queryTurn = "select * from turn;";
	$turnResult = mysqli_query($conn, $queryTurn);
	$turnArray = mysqli_fetch_row($turnResult);

	$query = "select * from allocations;";
        $allocResult = mysqli_query($conn, $query);

	$gwQuery = "select * from globalWarming;";
	$gwResult = mysqli_query($conn, $gwQuery);
	$gwArray = mysqli_fetch_row($gwResult);
	$gw = $gwArray[0];
	while($array = mysqli_fetch_row($allocResult)){
		$q2 = "select * from states where name = '".$array[0]."';";
		$stateResult = mysqli_query($conn, $q2);
		$stateArray = mysqli_fetch_row($stateResult);


		$m = $stateArray[9];
		$e = $stateArray[8]; //starting economy size
		$b = $stateArray[5]; //baseline growth rate %
		$t = $stateArray[6]; //free trade bonus %

		$gw = $gw + $array[6];
		$oilNeeded = round(($e / 1000) + ($m / 100)); //
		$oilObtained = $_POST[$array[0]];
		$oilObtained = $oilObtained + $array[5];
		//echo $oilObtained;
		$shortfall = $oilNeeded - $oilObtained;
		$s = $shortfall/$oilNeeded;
		$s = $s/10;
		//echo "-".$array[1]."-";
		$i = ($array[1]/$e)/10;
		//echo $b."  ".$t."  ".$i."  ".$s;
		$perc = $b + $t + $i - $s;
		$perc = $perc/100;
		$nextBudget = round($e*(1+$perc)); //
		//echo $nextBudget;
		//next budget is set
		$d = 10;
		if($array[0]=='Highlands' && $invaded==1)
		{
			$d = 0;
		}

		$r = $array[2];

		$attemptedMil = round($m*(1-($d/100)-($s/100)) + $r); //
		if($attemptedMil > ($m*1.25))
		{
			$attemptedMil = round($m*1.25); //
		}

		//query here
		$stmt = "UPDATE states set credits =".$nextBudget.", startCredits =".$nextBudget.", military =".$attemptedMil.", startMil=".$attemptedMil." where name = '".$array[0]."';";
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

	$stmt = "update globalWarming set investment = ".$gw." ;";
	if (mysqli_query($conn, $stmt)) {
                echo "Record updated successfully!";
        } else {
                echo "Error updating record.";
        }

}

?>

<body>
<div class="panel panel-default">
  <h1>CAK God Mode</h1>
</div>
<div class="col-md-12" id="row0" style="text-align: center;">
    <a href="register.php" class="btn btn-default">REGISTER</a>
    <a href="login.php" class="btn btn-default">LOGIN</a>
		<a href ="reset_password.php" class="btn btn-default">RESET PASSWORD</a>
		<a href = "logout.php" class="btn btn-default"> LOGOUT</a>
</div>
    <!-- Create Table for each nations values -->
<div class="col-md-12" id="row1" >
<div class="col-md-9" id="nationValueTable" >
    <table class="table table-striped" border="3">
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
    <th> Military at Start of turn
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
		    echo '<td>' . $array[9] . '</td>';
		    echo '</tr>';
                  }

                  echo '</table>';
                ?>

  <!-- Display nation value manipulation form -->
<p>Select the nation here:</p>
	<!-- Need to specify action type -->
		<form action="skyegod.php" method = "post">
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
</div>

 <div class="col-md-3" >
 <p>Change value here (select nation first):</p>
<?php
  $nation = $_POST['nation']; //get the nation
  $sql = "SELECT * from states WHERE name = '".$nation."';"; //use it to create the sql $
  $stateInfo = mysqli_query($conn, $sql); //query the DB with the SQL
  $row = mysqli_fetch_array($stateInfo, MYSQLI_ASSOC);

    // Display manipulation forms
  	echo '<form action ="skyegod.php" method = "post">';
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
	echo 'Input Military at Turn Start modification:<br>';
        echo '<input type="number" name="startMil" value = ' .$row['startMil']. '><br>';
	echo '<input type = "hidden" name = "nation" value = '.$nation. '>';
	echo '<input type="submit" value="Submit" name = "updateStates">';
	echo '</form>';
?>
</div>
</div>


<div class="col-md-12" id="row2" >
  <div class="col-md-9" >
  <?php
    //calls map.php with when clicked on returns hexID
    include 'map.php';
    //echo "  <use xlink:href=$oil transform='translate($xstart, $ystart)' onclick='getHexID($hid)' style='fill: $color'/>" ;
  ?>
  </div>

  <div class="col-md-3" >
  <?php
    // Form for hex/map changes

    echo '<h2>Edit Hexes</h2>';
    echo '<form action ="skyegod.php" method = "post">';
  		echo 'hexID to modify:<br>';
   		echo '<input id="hexID" type="number" name="hexID"<br><br>';
  		echo 'SELECT STATE FOR HEX TO BECOME: <br>';
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
      echo 'Change Nuked Status (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="nuked" value="0"><br>';
      echo 'Change Mountain Status (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="mountain" value="0"><br>';
      echo 'Change City Status (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="city" value="0"><br>';
      echo 'Change Capital Status (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="capital" value="0"><br>';
      echo 'Input Coal modification (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="numCoal" value="0"><br>';
      echo 'Input Fish modification (1 for Yes, 0 for No):<br>';
      echo '<input type="number" name="numFish" value="0"><br>';
      echo 'Input Natural Gas modification (0-3):<br>';
      echo '<input type="number" name="numGas" value="0"><br>';
      echo 'Input Oil modification (0-3):<br>';
      echo '<input type="number" name="numOil" value="0"><br>';
      echo '<input type="submit" value="Submit" name = "updateHexes">';
    echo '</form>';
    ?>
  </div>
</div>


  <div class="col-md-6" id="war-reset" >
  <div id="war" >
  <h2>War</h2>
                <form action="skyegod.php" method = "post">
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
</div>

<div id="reset" >
<h2>Reset Deltas to 0:</h2>
<form action ="skyegod.php" method = "post">
<input type="submit" value="Reset" name = "resDeltas">
</form>

<h2>Reset turn to 0:</h2>
<form action = "skyegod.php" method = "post">
<input type = "submit" value="Reset" name = "resTurn">
</form>
<?php
$query = "select * from turn;";
$result = mysqli_query($conn, $query);
$array=mysqli_fetch_row($result);

$query2 = "select * from globalWarming;";
$result2 = mysqli_query($conn, $query2);
$array=mysqli_fetch_row($result2);

echo "It is turn: ".$array[0];
echo "<br>";
echo "<h2> The people have donated a total of ".$array[0]." credits to global Warming abatement. </h2>";
?>
<form action ="skyegod.php" method = "post">
<input type="submit" value="Reset" name = "resGW">
</form>


  </div>
</div>

    <div class="col-md-6" id="turn" >
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
      <form action ="skyegod.php" method = "post">
      Input endowment for Arborea:
      <input type="number" name="Arborea" value=0><br>
      Input endowment for Archipelagia:
      <input type="number" name="Archipelagia" value=0><br>
      Input endowment for Boreala:
      <input type="number" name="Boreala" value=0><br>
      Input endowment for Desicca:
      <input type="number" name="Desicca" value=0><br>
      Input endowment for Highlands:
      <input type="number" name="Highlands" value=0><br>
      Has Highlands been invaded? (1 for yes, 0 for no)
      <input type="number" name="invaded" value=0><br>
      Input endowment for League:
      <input type="number" name="League" value=0><br>
      Input endowment for Riparia:
      <input type="number" name="Riparia" value=0><br>
      Input endowment for Taiga:
      <input type="number" name="Taiga" value=0><br>
      <input type="submit" name = "triggerTurn" value="Trigger Turn">
      </form>
    </div>

    <div class="col-md-12" id="news" >
          <!-- News log updates/input section -->

    <h2>News</h2>
    <form action ="skyegod.php" method = "post">
    <input type = "text" value = "news..." name = "news">
    <input type="submit" value="Submit" name = "inputNews">
    </form>
    <?php

$query = "select * from news order by date desc;";
$result = mysqli_query($conn, $query);
while($array=mysqli_fetch_row($result))
{
	echo $array[0]." : ".$array[1];
	echo "<form action = 'skyegod.php' method = 'POST'>";
	echo "<input type = 'hidden' name='time' value ='".$array[0]."'>";
	echo "<input type = 'submit' value='Delete' name = 'delNews'>";
	echo "<br><br>";
}

?>
    </div>
</body>
</html>
