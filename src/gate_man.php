<?php
session_start();
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'GM') {
?><!doctype html>
<html lang="en">
<?php
$page = 'gate_man_main_page';
include('html_head_component.php');
?>
<body class=" bg-dark container-fluid">

<?php
include('html_nav_component.php');
?>


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
          <button class="btn btn-default bg-success" style="" onclick="confirm_time_slot()" >Confirm</button>
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