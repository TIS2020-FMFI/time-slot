<?php
session_start();
if (isset($_SESSION['id'])) {
?><!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="   bootstrap-4.3.1/css/bootstrap.min.css" >
    <!-- Modified Bootstrap CSS -->
    <link rel="stylesheet" href="css/gate_man.css">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="javascript/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>

    <!-- Our JavaScript -->
    <script src="javascript/Time_slot.js"></script>
    <script src="javascript/Gate.js"></script>
    <script src="javascript/Calendar.js"></script>
    <script type="text/javascript" src="javascript/gate_man.js"></script>

  <title>Page of Ondrej Richnak</title>
</head>
<body class=" bg-dark container-fluid">


<nav class="navbar navbar-light bg-primary">
  <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"> </span>
  </button>
  <button class="btn btn-default bg-light" >Log out</button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="internal_dispatcher.php">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
      <a class="nav-item nav-link " href="#">Kontact</a>
      <a class="nav-item nav-link " href="#">Statistika</a>
      <a class="nav-item nav-link " href="#">Zamestnanci</a>
      <a class="nav-item nav-link " href="#">Objednavka</a>
      <a class="nav-item nav-link " href="change_password.php">Chenge password</a>
      <a class="nav-item nav-link " href="index.php">login page</a>
    </div>
  </div>
</nav>

<div class="table-responsive bg-light" style="width: auto; margin-left: -15px;margin-bottom: 0px;
    margin-right: -15px;">
  <table class="table" style="margin-bottom: 0px;" >
    <thead>
    <tr>
      <th class="top_bar" scope="col" >
        <input type="text" class="form-control" placeholder="Find by" aria-label="Username" aria-describedby="basic-addon1" oninput="find_by(this)" >
      </th>

    </tr>
    </thead>
  </table>
</div>
<table id='finished' class="table table-striped  table-responsive bg-light table_of_customers ">
  <thead>
     <tr>
         <th scope="col">Truck Drivers</th>
         <th scope="col">EČV</th>
         <th scope="col">Time</th>
         <th scope="col">Commodity</th>
         <th scope="col">Ramp</th>
         <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <tr class="finished_tr">
      <td >Ondrej Richnak</td>
      <td>BA-345-DS</td>
      <td>10:00 - 12:30</td>
      <td>9x BMW</td>
      <td>5</td>
      <td>
          <button class="btn btn-default bg-success" style="" onclick="confirm_time_slot()" >Confirm of arrive</button>
      </td>
  </tr>
  </tbody>
</table>

</body>
</html>
<?php
}
else{
    include('index.php');
}
?>
