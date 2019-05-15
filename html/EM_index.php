<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Welcome to Oceania!</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="eindex.css">
  <script>
  function myFunction(id) {
	alert("That is HexID: " + id);
  }
  </script>
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->

    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Oceania </div>
      <div class="list-group list-group-flush">
        <a href="register.php" class="list-group-item list-group-item-action bg-light">Register</a>
        <a href="login.php" class="list-group-item list-group-item-action bg-light">Login</a>
        <a href="reset_password.php" class="list-group-item list-group-item-action bg-light">Reset Password</a>
      </div>
    </div>

    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <span class="navbar-brand mb-0 h1">Oceania</span>
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="EM_index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Login
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="register.php">Register</a>
                <a class="dropdown-item" href="login.php">Login</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="reset_password.php">Reset Password</a>
              </div>
            </li>
            <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
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

      $result = mysqli_query($conn, "SELECT * FROM hexes;");

      echo "<div class='content_section floating_element'>";
      echo "   <svg width='1000' height='625'>";
      echo "  <defs>";
      echo "     <g id='pod'>";
      echo "       <polygon stroke='black' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
      echo "     </g>";
      echo "     <g id='oilPod1'>";
      echo "       <polygon stroke='black' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
      echo "       <polygon stroke='black' stroke-width='4' points='0,4 0,-4'/>";
      echo "     </g>";

      echo "     <g id='oilPod2'>";
      echo "       <polygon stroke='black' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
      echo "       <polygon stroke='black' stroke-width='3' points='-3,4 -3,-4'/>";
      echo "       <polygon stroke='black' stroke-width='3' points='3,4 3,-4'/>";
      echo "     </g>";

      echo "     <g id='oilPod3'>";
      echo "       <polygon stroke='black' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
      echo "       <polygon stroke='black' stroke-width='3' points='-3,-1 -3,-5'/>";
      echo "       <polygon stroke='black' stroke-width='3' points='3,-1 3,-5'/>";
      echo "       <polygon stroke='black' stroke-width='3' points='0,1 0,5'/>";
      echo "     </g>";

      echo "  </defs>";
      echo "<g class='pod-wrap'>";

      $ystart = 15;
      $xstart = 10;
      $xind = 0;

     // $result = mysqli_query($conn, "SELECT * FROM hexes");
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

              //echo "  <use xlink:href='#pod' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
              $hid = $row["hexID"];
              echo "  <use xlink:href=$oil transform='translate($xstart, $ystart)' onclick='myFunction($hid)' style='fill: $color'/>" ;
              $xstart = $xstart + 18;
              $xind = $xind +1;

      }
      echo "</g>";
      echo "</svg>";
      echo "</div class='content_section_text'>";
      ?>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
