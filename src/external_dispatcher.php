<?php
session_start();
if ($_SESSION['role'] == 'EXD' ) {
?>
<!doctype html>
<html lang="en">
    <?php
    $page = 'external_dispatcher_main_page';
    include('html_head_component.php');
    include('exception_handler.php');
    ?>
<body class=" bg-dark container-fluid">

<?php
include('html_nav_component.php');
?>


<div class=" bg-light fixed-top" id="role_down">
  <table class="table"  >
    <thead>
    <tr>
      <th class="top_bar d-flex" >
        <input type="date" id="input_date" name="trip-start"  onchange="make_date(this)"><!--max="2020-10-31"-->
          <button class="btn btn-default bg-primary" id="back_date" onclick="make_date(-1)" ><</button>
          <button class="btn btn-default bg-primary last_btn" id="next_date" onclick="make_date(1)">></button>
      </th>
      <th class="top_bar">
        <h3 id="date_number"  class="text-primary" >21.12.2020</h3>
      </th>
      <th class="top_bar th_top_float_bar d-flex w-auto" scope="col">
          <label for="input_text"></label><input type="text" id="input_text" class="form-control " placeholder="Find by" oninput="find_by(this)"  >

          <label for="select_only"></label>
          <select class="form-control" id="select_only" onchange="select_only(this)">
            <option>all</option>
              <option>Only prepared</option>
            <option>Only requested</option>
            <option>Only booked</option>
            <option>Only finished</option>
          </select>
          <label for="select_only_new_old"></label><select class="form-control" id="select_only_new_old" onchange="select_only_new_old(this.value)">
              <option>Newest</option>
              <option>Oldest</option>
          </select>
          <label for="select_only_day"></label><select class="form-control" id="select_only_day" onchange="select_only_day(this.value)">
              <option>One day</option>
              <option>All days</option>
          </select>
      </th>
    </tr>
    </thead>
  </table>
</div>

<p id="offset_element"></p>
<h3  id="prepared_title"  class="text-success"  >Prepared</h3 >
<table id="prepared" class="table table-striped   bg-light table_of_customers" >
  <thead>
  <tr>
    <th  scope="col">Time</th>
    <th  scope="col"></th>
    <th scope="col"></th>
      <th scope="col"></th>
      <th  scope="col"></th>
    <th  scope="col"></th>
  </tr>
  </thead>
  <tbody>
  <tr class="prepared_tr">
    <td >10:00 - 12:30</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="td_flex_buttons">
        <button class="btn btn-default bg-success only_one"  onclick="" >Apply</button>
    </td>
  </tr>
  </tbody>
</table>

<h3 id="requested_title" class="text-warning">Requested</h3>
<table id="requested" class="table table-striped  bg-light table_of_customers">
  <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">Registration number</th>
        <th scope="col">Destination</th>
        <th scope="col">Cargo</th>
        <th scope="col"></th>
     </tr>
  </thead>
  <tbody>
  <tr class="requested_tr">
      <td >10:00  (11.12.2020)</td>
      <td>Ondrej Richnak2</td>
      <td>BA-345-DS</td>
      <td>BA-345-DS</td>
      <td>BA-345-DS</td>
      <td class="td_flex_buttons">
        <button class="btn btn-default bg-primary only_one"  onclick="" >Show</button>
      </td>
  </tr>
  </tbody>
</table>

<h3 id="booked_title"  class="text-danger">Booked</h3>
<table id="booked" class="table table-striped bg-light table_of_customers">
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">Registration number</th>
        <th scope="col">Destination</th>
        <th scope="col">Cargo</th>
        <th scope="col"></th>
    </tr>
    </thead>
  <tbody>
  <tr class="booked_tr">
      <td >10:00  (11.12.2020)</td>
      <td>Ondrej Richnak2</td>
      <td>BA-345-DS</td>
      <td>BA-345-DS</td>
      <td>BA-345-DS</td>
      <td>
          <button class="btn btn-default bg-danger" onclick="" >Cancel</button>
      </td>
  </tr>
  </tbody>
</table>

<h3 id="finished_title" class="text-finished">Finished</h3>
<table id="finished" class="table table-striped bg-light table_of_customers">
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">Registration number</th>
        <th scope="col">Destination</th>
        <th scope="col">Cargo</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="finished_tr">
        <td >10:00  (11.12.2020)</td>
        <td>Ondrej Richnak2</td>
        <td>BA-345-DS</td>
        <td>BA-345-DS</td>
        <td>BA-345-DS</td>
        <td>
            <button class="btn btn-default bg-danger" onclick="" >Cancel</button>

        </td>

    </tr>
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