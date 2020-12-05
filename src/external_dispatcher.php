<?php
session_start();
if (isset($_SESSION['id'])) {
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.min.css" >
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/external_dispatcher.css">

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script> -->
        <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/Time_slot.js"></script>
        <script src="javascript/Gate.js"></script>
        <script src="javascript/Calendar.js"></script>
        <script src="javascript/external_dispatcher.js"></script>


        <title>Page of Ondrej Richnak</title>
    </head>

<body class=" bg-dark container-fluid">


<nav class="navbar navbar-light bg-primary">
  <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" onclick="role_down_navigation()">
    <span class="navbar-toggler-icon"> </span>
  </button>
  <button class="btn btn-default bg-light" onclick="log_out()">Log out</button>
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