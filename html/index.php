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

    <div class="border-right bg-dark" id="sidebar-wrapper">
      <div class="sidebar-heading bg-dark text-light">Oceania </div>
      <div class="list-group bg-light list-group-mine list-group-flush">
        <a href="index.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Home</a>
        <a href="login.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">Login</a>
        <a href="about.php" class="text-light bg-dark border-top border-bottom list-group-item list-group-item-mine list-group-item-action">About</a>
      </div>
    </div>

    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

    <!--  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

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
              <a class="nav-link" href="about.php">About</a>
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
      </nav> -->

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
    //calls map.php with when clicked on returns hexID
      include 'map.php';

      ?>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

</body>

</html>
