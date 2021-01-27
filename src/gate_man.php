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
include('exception_handler.php');
?>


<div class="table-responsive bg-light fixed-top" id="role_down" >
  <table class="table"  >
    <thead>
    <tr>
      <th class="top_bar" scope="col" >
        <input type="text" class="form-control" placeholder="Find by" aria-label="Username" aria-describedby="basic-addon1" oninput="find_by(this)" >
      </th>
        <th class="top_bar" scope="col" >
            <label for="change_select_time"></label>
            <select class="form-control" id="change_select_time" onchange="select_by(this.value)">
                <option>Oldest</option>
                <option>Newest</option>
            </select>
        </th>


    </tr>
    </thead>
  </table>
</div>

<table id='finished' class="table table-striped  table-responsive bg-light table_of_customers " >
  <thead>
     <tr>
<!--         <th scope="col">Time</th>-->
<!--         <th  scope="col">Destination</th>-->
<!--         <th  scope="col">Company</th>-->
<!--         <th scope="col">Plate number</th>-->
<!--         <th scope="col">Cargo</th>-->
<!--         <th scope="col"></th>-->
         <th scope="col">Time</th>
         <th  scope="col">Destination</th>-->
         <th  scope="col">Company</th>
         <th scope="col">Plate number</th>
         <th scope="col">Truck Drivers</th>
         <th scope="col">Cargo</th>
         <th scope="col">Ramp</th>
         <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

</body>
</html>
<?php
}else{
    ?>
    <script>window.open('index.php',"_self");</script>
    <?php
}
?>