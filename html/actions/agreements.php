<?php
session_start();
require_once "../config.php";


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

if (isset($_POST['ftEvent'])) {
	$states = array(" ", "Arborea", "Archipelagia", "Boreala", "Desicca", "Highlands", "League", "Riparia", "Taiga");

	$arb = $_POST['ArboreaA'];
	$arc = $_POST['ArchipelagiaA'];
        $bor = $_POST['BorealaA'];
        $des = $_POST['DesiccaA'];
        $hig = $_POST['HighlandsA'];
        $lea = $_POST['LeagueA'];
        $rip = $_POST['RipariaA'];
        $tai = $_POST['TaigaA'];
	if(!isset($arb))
	{
		$arb = 0;
	}
        if(!isset($arc))
        {
                $arc = 0;
        }
        if(!isset($bor))
        {
                $bor = 0;
        }
        if(!isset($des))
        {
                $des = 0;
        }
        if(!isset($hig))
        {
                $hig = 0;
        }
        if(!isset($lea))
        {
                $lea = 0;
        }
        if(!isset($rip))
        {
                $rip = 0;
        }
        if(!isset($tai))
        {
                $tai = 0;
        }


	$updateQuery = "update ftAgreements set Arborea = ".$arb.", Archipelagia = ".$arc.", Boreala = ".$bor.", Desicca = ".$des.", Highlands = ".$hig.", League = ".$lea.", Riparia = ".$rip.", Taiga = ".$tai." where name = '".$_SESSION["username"]."';";
	if (mysqli_query($link, $updateQuery))
        {
        	//echo "Record updated successfully!</br>";
        }
        else
        {
                //echo "Error updating record.";
		//echo $updateQuery;
        }


	$query = "select * from ftAgreements;";
	$result = mysqli_query($link, $query);
	while($array = mysqli_fetch_row($result)){ //for each ftAgreements entry
		$ftBonus = 0;
		for ($i = 1; $i < 9; $i++) // for each one way agreement in that entry
		{
			if($array[$i] == 1) //if they have a 1 way agreement
			{
				$query2 = "select * from ftAgreements where name = '".$states[$i]."';";
				$result2 = mysqli_query($link, $query2);
				$array2 = mysqli_fetch_assoc($result2);
				if($array2[$array[0]] == 1) // we have a 2 way match
				{
					$ftBonus += 1;
				}
			}
		}
		echo $array[0]."has a bonus of".$ftBonus."<br>";
		$ftQuery = "update states set FTbonus = ".$ftBonus." where name = '".$array[0]."';";
		if (mysqli_query($link, $ftQuery))
        	{
                	//echo "Record updated successfully!</br>";
        	}
        	else
        	{
                	//echo "Error updating record.";
			//echo $ftQuery;
        	}

	}


}


$query = "select * from states where name = '".$_SESSION["username"]."';";
$result = mysqli_query($link, $query);
$stateArray=mysqli_fetch_row($result);

$query2 = "select * from ftAgreements where name = '".$_SESSION["username"]."';";
$result2 = mysqli_query($link, $query2);
$ftArray = mysqli_fetch_assoc($result2);
?>

<!DOCTYPE html>
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
      <a href="trade.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Trade</a>
      <a href="../logout.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Logout</a>
    </div>
  </div>
  <div class="col">
    <div class="text-center">
  <h1>Trade Agreements</h1>
  <hr>


<h2>Current Free Trade bonus: <?php echo $stateArray[6];?> %</h2>
<h2>Estimated Benefit from each trade Agreement: <?php echo ($stateArray[3]*.01); ?> Credits</h2><br>
</div>
<h2>Proposed Agreements</h2>
<table border = "1" style="text-align:center;">
<tr>
<?php
if($_SESSION["username"] != 'Arborea'){echo "<th>Arborea</th>";}
if($_SESSION["username"] != 'Archipelagia'){echo "<th>Archipelagia</th>";}
if($_SESSION["username"] != 'Boreala'){echo "<th>Boreala</th>";}
if($_SESSION["username"] != 'Desicca'){echo "<th>Desicca</th>";}
if($_SESSION["username"] != 'Highlands'){echo "<th>Highlands</th>";}
if($_SESSION["username"] != 'League'){echo "<th>League</th>";}
if($_SESSION["username"] != 'Riparia'){echo "<th>Riparia</th>";}
if($_SESSION["username"] != 'Taiga'){echo "<th>Taiga</th>";}
?>
</tr>
<tr>
<?php
if($_SESSION["username"] != 'Arborea'){echo "<td>".$ftArray["Arborea"]."</td>";}
if($_SESSION["username"] != 'Archipelagia'){echo "<td>".$ftArray["Archipelagia"]."</td>";}
if($_SESSION["username"] != 'Boreala'){echo "<td>".$ftArray["Boreala"]."</td>";}
if($_SESSION["username"] != 'Desicca'){echo "<td>".$ftArray["Desicca"]."</td>";}
if($_SESSION["username"] != 'Highlands'){echo "<td>".$ftArray["Highlands"]."</td>";}
if($_SESSION["username"] != 'League'){echo "<td>".$ftArray["League"]."</td>";}
if($_SESSION["username"] != 'Riparia'){echo "<td>".$ftArray["Riparia"]."</td>";}
if($_SESSION["username"] != 'Taiga'){echo "<td>".$ftArray["Taiga"]."</td>";}
?>
</tr>
</table>

<br>

<h2>Agreements In Force</h2>
<table border = "1" style="text-align:center;">
<tr>
<?php
if($_SESSION["username"] != 'Arborea'){echo "<th>Arborea</th>";}
if($_SESSION["username"] != 'Archipelagia'){echo "<th>Archipelagia</th>";}
if($_SESSION["username"] != 'Boreala'){echo "<th>Boreala</th>";}
if($_SESSION["username"] != 'Desicca'){echo "<th>Desicca</th>";}
if($_SESSION["username"] != 'Highlands'){echo "<th>Highlands</th>";}
if($_SESSION["username"] != 'League'){echo "<th>League</th>";}
if($_SESSION["username"] != 'Riparia'){echo "<th>Riparia</th>";}
if($_SESSION["username"] != 'Taiga'){echo "<th>Taiga</th>";}
?>
</tr>
<tr>
<?php
if($_SESSION["username"] != 'Arborea')
{
$query = "select * from ftAgreements where name = 'Arborea';";
$result = mysqli_query($link, $query);
$array = mysqli_fetch_assoc($result);
if($array[$_SESSION["username"]] == 1 && $ftArray['Arborea'] == 1){
  echo "<td>1</td>";
}
else{
echo "<td>0</td>";
}
}
if($_SESSION["username"] != 'Archipelagia')
{
      $query = "select * from ftAgreements where name = 'Archipelagia';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Archipelagia'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'Boreala')
{
      $query = "select * from ftAgreements where name = 'Boreala';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Boreala'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'Desicca')
{
      $query = "select * from ftAgreements where name = 'Desicca';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Desicca'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'Highlands')
{
      $query = "select * from ftAgreements where name = 'Highlands';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Highlands'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'League')
{
      $query = "select * from ftAgreements where name = 'League';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['League'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'Riparia')
{
      $query = "select * from ftAgreements where name = 'Riparia';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Riparia'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
if($_SESSION["username"] != 'Taiga')
{
      $query = "select * from ftAgreements where name = 'Taiga';";
      $result = mysqli_query($link, $query);
      $array = mysqli_fetch_assoc($result);
      if($array[$_SESSION["username"]] == 1 && $ftArray['Taiga'] == 1){
              echo "<td>1</td>";
      }
      else{
      echo "<td>0</td>";
      }
}
?>
</tr>
</table>
<br>
<h2>Send Diplomatic Proposals to the following </h2>
<form action ="agreements.php" method="post">
<?php
if($_SESSION["username"] != 'Arborea')
{
echo "<input type = 'checkbox' name='ArboreaA' value=1> Arborea<br>";
}
if($_SESSION["username"] != 'Archipelagia')
{
      echo "<input type = 'checkbox' name='ArchipelagiaA' value=1> Archipelagia<br>";
}
if($_SESSION["username"] != 'Boreala')
{
      echo "<input type = 'checkbox' name='BorealaA' value=1> Boreala<br>";
}
if($_SESSION["username"] != 'Desicca')
{
      echo "<input type = 'checkbox' name='DesiccaA' value=1> Desicca<br>";
}
if($_SESSION["username"] != 'Highlands')
{
      echo "<input type = 'checkbox' name='HighlandsA' value=1> Highlands<br>";
}
if($_SESSION["username"] != 'League')
{
      echo "<input type = 'checkbox' name='LeagueA' value=1> League<br>";
}
if($_SESSION["username"] != 'Riparia')
{
      echo "<input type = 'checkbox' name='RipariaA' value=1> Riparia<br>";
}
if($_SESSION["username"] != 'Taiga')
{
      echo "<input type = 'checkbox' name='TaigaA' value=1> Taiga<br>";
}
?>
<input type="submit" value = "submit" name="ftEvent">
</form>


</div>
</div>
</body>
</html>
