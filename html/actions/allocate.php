<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
require_once "../config.php";

$query = "select * from states where name = '".$_SESSION["username"]."';";
$result = mysqli_query($link, $query);
$myArray=mysqli_fetch_row($result);


if(isset($_POST['allocateEvent'])){
	$econCreds = $_POST['econCreds'];
        $milCreds = $_POST['milCreds'];
	$climCreds = $_POST['climCreds'];
	$resCreds = $_POST['resCreds'];
	$res = $_POST['res'];

	$totalEcon = $myArray[3];
	$totalMil = $myArray[1];

	if($econCreds + $milCreds + $climCreds + $resCreds > $totalEcon){
		echo "This allocation exceeds your total credits, try again.";

	}
	elseif($econCreds < 0 || $milCreds < 0 || $climCreds < 0 || $resCreds < 0){
		echo "You cannot allocate negative credits, try again.";
	}
	else{
		$query2 = "select * from allocations where name = '".$_SESSION["username"]."';";
		$result2 = mysqli_query($link, $query2);
		if(mysqli_fetch_row($result2)){
			$stmt = "UPDATE allocations SET econInv = ".$econCreds.", milInv = ".$milCreds.", resInv = ".$resCreds.", research = '".$res."', gwInv = ".$climCreds." where name = '".$_SESSION["username"]."';";
			if (mysqli_query($link, $stmt))
                	{
                        	echo "Record updated successfully!</br>";
                	}
                	else
                	{
				echo $stmt;
                        	echo "Error updating record.";
                	}
		}
		else{
			$stmt = "INSERT INTO allocations (name, econStart, milStart, econInv, milInv, resInv, research, delta, gwInv) VALUES ('".$_SESSION["username"]."',".$totalEcon.",".$totalMil.",".$econCreds.",".$milCreds.",".$resCreds.",'".$res."', 0, ".$climCreds.");";
                        if (mysqli_query($link, $stmt))
                        {
                                echo "Record updated successfully!</br>";
                        }
                        else
                        {
				echo $stmt;
                                echo "Error updating record.";
                        }

		}
	}

}
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="/sindex.css">
    <title>Allocate</title>
  </head>


  <body>
    <h1>Allocate</h1>

<b>Decide how to invest your credits.</b>
<b>Current number of credits: <?php echo $myArray[3]; ?></b><br>
<b>Number of credits at start of turn: <?php echo $myArray[8]; ?></b>


                <form action="allocate.php" method = "post">
                <input type="number" name="econCreds" value=0> Credits to invest in the economy<br>
                <input type="number" name="milCreds" value=0> Credits to invest in the military<br>
                <input type="number" name="climCreds" value=0> Credits to invest in global warming abatement<br>
                <input type="number" name="resCreds" value=0> Credits to invest in research<br>
                <input type="text" name="res" value= " "> What you would like to research<br>
                <input type="submit" value = "submit" name="allocateEvent">
                </form>

<button onclick="window.location.href = 'trade.php';">Trade</button><br/>
<button onclick="window.location.href = 'war.php';">War</button><br/>
<button onclick="window.location.href = 'agreements.php';">Trade Agreements</button><br/>
<button onclick="window.location.href = 'nat_info.php';">Nation Information</button><br/>
<button onclick="window.location.href = '../home.php';">Home</button>
  </body>
</html>
