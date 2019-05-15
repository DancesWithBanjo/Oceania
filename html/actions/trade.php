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

$allocQuery = "select * from allocations where name = '".$_SESSION["username"]."';";
$allocResult = mysqli_query($link, $allocQuery);
$allocArray=mysqli_fetch_row($allocResult);


if (isset($_POST['oilEvent'])) {

        $amount = $_POST['oilAmount'];
        $destination = $_POST['nation'];
	if($amount > $myArray[7]){
		echo "You don't have that much oil to give.";
	}
	elseif($amount < 0){
		echo "You cannot give negative oil.";
	}
	else{
		$oilLeft = $myArray[7] - $amount;
		$stmt = "UPDATE states SET giveableOil = ".$oilLeft." where name = '".$_SESSION["username"]."';";
		if (mysqli_query($link, $stmt)) // decrement giveable oil on self
                {
                        echo "Record updated successfully!</br>";
                }
                else
                {
                        echo "Error updating record.";
                }

		$delta = $allocArray[7] - $amount;
		$stmt = "UPDATE allocations SET delta = ".$delta." where name = '".$_SESSION["username"]."';";
                if (mysqli_query($link, $stmt)) // decrement delta on self
                {
                        echo "Record updated successfully!</br>";
                }
                else
                {
                        echo "Error updating record.";
                }

		$destQuery = "select * from allocations where name = '".$destination."';";
		$destResult = mysqli_query($link, $destQuery);
		$destArray=mysqli_fetch_row($destResult);

		$destDelta = $destArray[7] + $amount;
		$stmt = "UPDATE allocations SET delta = ".$destDelta." where name = '".$destination."';";
                if (mysqli_query($link, $stmt)) // increase delta on destination
                {
                        echo "Record updated successfully!</br>";
                }
                else
                {
                        echo "Error updating record.";
                }

	}


}


if (isset($_POST['giveEvent'])) {
        // Prepare the SQL to prevent vulnerabilities
        $amount = $_POST['giftAmount'];
        $destination = $_POST['nation'];
	$query = "select * from states where name = '".$destination."';";
	$result = mysqli_query($link, $query);
	$destArray = mysqli_fetch_row($result);
	$destCreds = $destArray[3] + $amount;
	$myCreds = $myArray[3] - $amount;

	if($amount > $myArray[3])
	{
		echo "You don't have that many credits.";
	}
	elseif($amount < 0)
	{
		echo "Nice try, but please enter a positive number.";
	}
	else
	{
		$stmt = "UPDATE states SET credits = ".$destCreds." where name = '".$destination."';";
        	if (mysqli_query($link, $stmt))
		{
        		echo "Record updated successfully!</br>";
        	}
		else
		{
        		echo "Error updating record.";
        	}
                $stmt = "UPDATE states SET credits = ".$myCreds." where name = '".$myArray[0]."';";
                if (mysqli_query($link, $stmt))
                {
                        echo "Record updated successfully!";
                }
                else
                {
                        echo "Error updating record.";
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

  <title>Trade Agreements</title>

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
      <a href="invest.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Invest</a>
      <a href="agreements.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade Agreements</a>
      <a href="../logout.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Logout</a>
    </div>
  </div>

  <div class="col">
    <div class="text-center">
  <h1> Trade</h1>
</div>
<b>Give credits to another nation.</b>

              <form action="trade.php" method = "post">

              <input type="radio" name="nation" value="Taiga"> Taiga<br>
              <input type="radio" name="nation" value="Boreala"> Boreala<br>
              <input type="radio" name="nation" value="Highlands"> The Highlands<br>
              <input type="radio" name="nation" value="Archipelagia"> Archipelagia<br>
              <input type="radio" name="nation" value="League"> The League<br>
              <input type="radio" name="nation" value="Riparia"> Riparia<br>
              <input type="radio" name="nation" value="Arborea"> Arborea<br>
              <input type="radio" name="nation" value="Desicca"> Desicca<br>
  <input type ="number" name="giftAmount" value=0>
              <input type="submit" value = "submit" name="giveEvent">
              </form>

<br><b>Give oil to another nation.</b>

              <form action="trade.php" method = "post">
              <input type="radio" name="nation" value="Taiga"> Taiga<br>
              <input type="radio" name="nation" value="Boreala"> Boreala<br>
              <input type="radio" name="nation" value="Highlands"> The Highlands<br>
              <input type="radio" name="nation" value="Archipelagia"> Archipelagia<br>
              <input type="radio" name="nation" value="League"> The League<br>
              <input type="radio" name="nation" value="Riparia"> Riparia<br>
              <input type="radio" name="nation" value="Arborea"> Arborea<br>
              <input type="radio" name="nation" value="Desicca"> Desicca<br>
              <input type ="number" name="oilAmount" value=0>
              <input type="submit" value = "submit" name="oilEvent">
              </form>

      </div>
</body>
