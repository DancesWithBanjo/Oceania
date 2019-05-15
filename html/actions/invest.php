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
                        	echo '<script>alert("Succesfully submitted!")</script>';
                	}
                	else
                	{
				echo $stmt;
                        	echo "alert('Error updating record.')";
                	}
		}
		else{
			$stmt = "INSERT INTO allocations (name, econStart, milStart, econInv, milInv, resInv, research, delta, gwInv) VALUES ('".$_SESSION["username"]."',".$totalEcon.",".$totalMil.",".$econCreds.",".$milCreds.",".$resCreds.",'".$res."', 0, ".$climCreds.");";
                        if (mysqli_query($link, $stmt))
                        {
                                echo "<script>alert('Succesfully submitted!')</script>";
                        }
                        else
                        {
				echo $stmt;
                                echo "alert('Error updating record.')";
                        }

		}
	}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Invest</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="../eindex.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>
  <div class="d-flex" id="wrapper">
    <div class="border-right bg-dark" id="sidebar-wrapper">
      <div class="sidebar-heading bg-dark text-light"><?php echo htmlspecialchars($_SESSION["username"]); ?></div>
      <div class="list-group bg-light list-group-mine list-group-flush">
        <a href="../home.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Home</a>
        <a href="trade.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade</a>
        <a href="agreements.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade Agreements</a>
        <a href="../logout.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Logout</a>
      </div>
    </div>
    <div class="col">
      <div class="text-center">
    <h1>Invest</h1>
    <b>Decide how to invest your credits. Multiple submissions in the same turn don't add together.
      <br>Only your most recent submission is counted.</b><br><br>
    <b>Current number of credits: <?php echo $myArray[3]; ?></b><br><br>
    <b>Number of credits at start of turn: <?php echo $myArray[8]; ?></b><br>
    </div>

    <div class="form-group row justify-content-center">
    <form action="invest.php" method = "post">
      <div class="row">
      <input type="number" name="econCreds" value=0> <label class ="col-form-label">Credits to invest in the economy</label>
    </div>
    <div class="row">
      <input type="number" name="milCreds" value=0> <label class ="col-form-label">Credits to invest in the military</label>
    </div>
    <div class="row">
      <input type="number" name="climCreds" value=0> <label class ="col-form-label">Credits to invest in global warming abatement</label>
    </div>
    <div class="row">
      <input type="number" name="resCreds" value=0> <label class ="col-form-label">Credits to invest in research</label>
    </div>
    <div class="row">
      <input type="text" name="res" value = "" style="width: 37.8%;"> <label class ="col-form-label">What you would like to research?</label>
    </div>
    <div class="row justify-content-center">
      <input type="submit" value = "Submit" name="allocateEvent">
    </div>
    </form>
    </div>
</div>

</div>

</body>
</html>
