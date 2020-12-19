<?php
session_start();
if ($_SESSION['role'] == 'EXD' ) {
?>
<!doctype html>
<html lang="en">
    <?php
    $page = 'external_dispatcher_main_page';
    include('html_head_component.php');
    ?>
<body class=" bg-dark container-fluid">

<?php
include('html_nav_component.php');
?>


<div class="table-responsive bg-light " id="role_down" style="
    position: fixed;
    width: 100%;
    margin-top: 62px;
    margin-right: -15px;
  margin-left: -15px;">
  <table class="table" style="margin-bottom: 0px;" >
    <thead>
    <tr>
      <th class="top_bar" style="display:flex;">
        <input type="date" id="input_date" name="trip-start"  onchange="make_date(this)"><!--max="2020-10-31"-->
          <button class="btn btn-default bg-primary" id="back_date" onclick="make_date(-1)" ><</button>
          <button class="btn btn-default bg-primary last_btn" id="next_date" onclick="make_date(1)">></button>
      </th>
      <th class="top_bar">
        <h3 id="date_number"  class="text-primary" style="margin: 0px;padding: 0px">21.12.2020</h3>
      </th>
      <th class="top_bar th_top_float_bar" scope="col">
        <div class="form-group" style="margin: 0px">
          <select class="form-control" id="select_only" onchange="select_only(this)" style="display: block;">
            <option>all</option>
              <option>Only prepared</option>
            <option>Only requested</option>
            <option>Only booked</option>
            <option>Only finished</option>
          </select>
        </div>
      </th>
      <th class="top_bar" scope="col" >
        <input type="text" id="input_text" class="form-control" placeholder="Find by" oninput="find_by(this)"  >
      </th>


    </tr>
    </thead>
  </table>
</div>


<table id="prepared" class="table table-striped  table-responsive bg-light table_of_customers" >
  <h3 class="text-success" style="padding-top: 160px">PREPARED</h3 >
  <thead>
  <tr>
    <th class="first" scope="col">Time</th>
    <th class="first" scope="col"></th>
    <th class="first" scope="col"></th>
      <th class="first" scope="col"></th>
      <th class="first" scope="col"></th>
    <th class="first" scope="col"></th>
  </tr>
  </thead>
  <tbody>
  <tr class="prepared_tr">
    <td >
      <p> 6:00 - 8:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p>  8:30 - 10:00</p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  <tr class="prepared_tr">
    <td >
      <p> 10:00 - 12:30 </p>
    </td>
    <td>
      <p></p>
      <p></p>
    </td>
    <td>
      <p></p>
    </td>
      <td>
          <p></p>
      </td>
      <td>
          <p></p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-success only_one" style="" onclick="" >apply</button>
    </td>
  </tr>
  </tbody>
</table>

<table id="requested" class="table table-striped  table-responsive bg-light table_of_customers">
  <h3 class="text-warning">Requested time-slot</h3>
  <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">EVC</th>
        <th scope="col">Destination</th>
        <th scope="col">Commodity</th>
        <th scope="col"></th>
     </tr>
  </thead>
  <tbody>
  <tr class="requested_tr">
    <td >
      <p> 10:00 (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak</p>
      <p>Ondrej Richnak2</p>
    </td>
    <td>
      <p>BA-435-SC</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td class="td_flex_buttons">

      <button class="btn btn-default bg-primary only_one" style="" onclick="confirm_time_slot()" >edit</button>
      <button class="btn btn-default bg-danger " style="" onclick="confirm_time_slot()" >zrusit</button>
    </td>
  </tr>
  <tr class="requested_tr">
    <td >
      <p> 10:00  (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak</p>
    </td>
    <td>
      <p>BA-435-SC</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-primary only_one" style="" onclick="confirm_time_slot()" >edit</button>
      <button class="btn btn-default bg-danger " style="" onclick="confirm_time_slot()" >zrusit</button>
    </td>
  </tr>
  <tr class="requested_tr">
    <td >
      <p> 10:00  (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak2</p>
    </td>
    <td>
      <p>BA-435-SC</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td class="td_flex_buttons">
      <button class="btn btn-default bg-primary only_one" style="" onclick="confirm_time_slot()" >edit</button>
      <button class="btn btn-default bg-danger " style="" onclick="confirm_time_slot()" >zrusit</button>

    </td>
  </tr>
  </tbody>
</table>


<table id="booked" class="table table-striped  table-responsive bg-light table_of_customers">
  <h3 class="text-danger">BOOKED</h3>
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">EVC</th>
        <th scope="col">Destination</th>
        <th scope="col">Commodity</th>
        <th scope="col"></th>
    </tr>
    </thead>
  <tbody>
  <tr class="booked_tr">
    <td>
      <p> 10:00  (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak2</p>
    </td>
    <td>
      <p>BA-345-DS</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td>
      <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>

    </td>

  </tr>
  <tr class="booked_tr">
    <td >
      <p> 10:00  (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak2</p>
    </td>
    <td>
      <p>BA-345-DS</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td>
      <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>

    </td>

  </tr>
  <tr class="booked_tr">
    <td >
      <p> 10:00 (11.12.2020) </p>
    </td>
    <td>
      <p>Ondrej Richnak2</p>
    </td>
    <td>
      <p>BA-345-DS</p>
    </td>
      <td>
          <p>BA-345-DS</p>
      </td>
      <td>
          <p>BA-345-DS</p>
      </td>
    <td>
      <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>
    </td>

  </tr>
  </tbody>
</table>

<table id="finished" class="table table-striped  table-responsive bg-light table_of_customers">
    <h3 class="text-finished">Finished time-slot
    </h3>
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th scope="col">Truck drivers</th>
        <th scope="col">EVC</th>
        <th scope="col">Destination</th>
        <th scope="col">Commodity</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="finished_tr">
        <td>
            <p> 10:00  (11.12.2020) </p>
        </td>
        <td>
            <p>Ondrej Richnak2</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>

        </td>

    </tr>
    <tr class="finished_tr">
        <td >
            <p> 10:00  (11.12.2020) </p>
        </td>
        <td>
            <p>Ondrej Richnak2</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>

        </td>

    </tr>
    <tr class="finished_tr">
        <td >
            <p> 10:00 (11.12.2020) </p>
        </td>
        <td>
            <p>Ondrej Richnak2</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <p>BA-345-DS</p>
        </td>
        <td>
            <button class="btn btn-default bg-danger" style="" onclick="delete_time_slot()" >zrusit</button>
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