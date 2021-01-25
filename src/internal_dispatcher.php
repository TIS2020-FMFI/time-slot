<?php
session_start();
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND') {
?>

<!doctype html>
<html lang="en">
    <?php
    $page = 'internal_dispatcher_main_page';
    include('html_head_component.php');
    include('exception_handler.php');
    ?>
<body class=" bg-dark container-fluid">
    <?php
    include('html_nav_component.php');
    ?>
    <div id="only_requested" class="fixed-top bg-warning justify-content-center curs" onclick="show_requested()">
        <img src="request_sign.png" width="32" alt="info_sign">
        <p id="only_requested_count" class="text-danger" >count</p>
    </div>

<div class="table-responsive bg-light fixed-top " id="role_down" >
  <table class="table" >
    <thead>
    <tr>
      <th class="top_bar td_flex_buttons" scope="col" >
          <label for="input_date"></label><input type="date" id="input_date" value="" onchange="display_time_slot_for_this_date(this)">
        <button class="btn btn-default bg-primary" id="back_date" onclick="make_date_arrows_mini_calendar(-1)" ><</button>
        <button class="btn btn-default bg-primary last_btn" id="next_date" onclick="make_date_arrows_mini_calendar(1)">></button>
          <h4 id="ramp_title" class="text-primary">Ramps 1 - 7</h4>
      </th>

      <th class="top_bar" scope="col" >

      </th>

      <th id="find_by_th" class="top_bar" scope="col" >
          <label for="input_text"></label><input id="input_text" type="text" class="form-control" placeholder="Find by"   oninput="find_by(this)"  >

      </th>
        <th id="find_by_img_info" class="top_bar" scope="col" >
            <img class="d-flex" src="request_sign_info.png" width="32" onmouseenter="show_info()" onmouseleave="hide_info()" alt="info">
        </th>
    </tr>
    </thead>
  </table>
</div>

<div id="info" class="container w-50 fixed-top bg-dark" >
    <p class="text-center text-light" >You can search by time-slot states (prepared, requested, booked, finished),<br>starting time of time-slot, company name, truck registration number (EVC), cargo and destination.<br>Any time-slot data can be used for searching.</p>
    <p class="text-center text-light" ><b>Time-slot states description:</b></p>
    <p class="text-center text-success"><b>Prepared</b> - free time-slot, that is not occupied by any dispatcher yet</p>
    <p class="text-center text-warning"><b>Requested</b> - waiting for the confirmation by an internal dispatcher</p>
    <p class="text-center text-danger"><b>Booked</b> - request confirmed by an internal dispatcher</p>
    <p class="text-center text-finished"><b>Finished</b> - time-slot whose truck drivers arrival has been confirmed</p>
</div>

<div id="global_view" class="table-responsive  bg-light" >
    <table id="calendar" class="table table-striped"  >
        <thead>
        <tr>
            <th class=" th_top_float_bar right_border_state d-flex" scope="col" >
                <button class="btn btn-default bg-primary" onclick="generate_gate_selector(-1)"><</button>

                <div class="form-group m-0" >
                    <select class="form-control" id="select_gate" onchange="generate_gate_selector(this)"  > <!-- onclick="generate_gate_selector(this)"-->
                        <option class="option_ramp">1 - 7</option>
                        <option class="option_ramp">8 - 14</option>
                        <option class="option_ramp">15 - 21</option>
                        <option class="option_ramp">22 - 28</option>
                        <option class="option_ramp">29 - 35</option>
                        <option class="option_ramp">36 - 42</option>
                        <!-- Treba pridat html podla poctu ramp  ovsem vzdy po rozdiele 6-->
                    </select>
                </div>
                <button class="btn btn-default bg-primary last_btn" onclick="generate_gate_selector(1)">></button>
            </th>
            <th class="days_in_calendar" scope="col">1 ramp</th>
            <th class="days_in_calendar" scope="col">2 ramp</th>
            <th class="days_in_calendar" scope="col">3 ramp</th>
            <th class="days_in_calendar" scope="col">4 ramp</th>
            <th class="days_in_calendar" scope="col">5 ramp</th>
            <th class="days_in_calendar" scope="col">6 ramp</th>
            <th class="days_in_calendar last" scope="col">7 ramp</th>
        </tr>
        </thead>
        <tbody>
        <tr >
            <th class="right_border_state text-success" scope="row">Prepared</th>
            <th class="right_border calendar_item 1 prepared_occupied "  >loading</th>
            <th class="right_border calendar_item 2 prepared_occupied"  >loading</th>
            <th class="right_border calendar_item 3 prepared_occupied"  >loading</th>
            <th class="right_border calendar_item 4 prepared_occupied"  >loading</th>
            <th class="right_border calendar_item 5 prepared_occupied"  >loading</th>
            <th class="right_border calendar_item 6 prepared_occupied"  >loading</th>
            <th class="right_border_last calendar_item 7 prepared_occupied"  >loading</th>
        </tr>
        <tr >
            <th class="right_border_state text-warning" scope="row">Requested</th>
            <th class="right_border calendar_item 1 requested "  >loading</th>
            <th class="right_border calendar_item 2 requested"  >loading</th>
            <th class="right_border calendar_item 3 requested"  >loading</th>
            <th class="right_border calendar_item 4 requested"  >loading</th>
            <th class="right_border calendar_item 5 requested"  >loading</th>
            <th class="right_border calendar_item 6 requested"  >loading</th>
            <th class="right_border_last calendar_item 7 requested"  >loading</th>
        </tr>
        <tr >
            <th class="right_border_state text-danger" scope="row">Booked</th>
            <th class="right_border calendar_item 1 booked "  >loading</th>
            <th class="right_border calendar_item 2 booked"  >loading</th>
            <th class="right_border calendar_item 3 booked"  >loading</th>
            <th class="right_border calendar_item 4 booked"  >loading</th>
            <th class="right_border calendar_item 5 booked"  >loading</th>
            <th class="right_border calendar_item 6 booked"  >loading</th>
            <th class="right_border_last calendar_item 7 booked"  >loading</th>
        </tr>
        <tr >
            <th class="right_border_state text-finished" scope="row">Finished</th>
            <th class="right_border calendar_item 1 finished "  >loading</th>
            <th class="right_border calendar_item 2 finished"  >loading</th>
            <th class="right_border calendar_item 3 finished"  >loading</th>
            <th class="right_border calendar_item 4 finished"  >loading</th>
            <th class="right_border calendar_item 5 finished"  >loading</th>
            <th class="right_border calendar_item 6 finished"  >loading</th>
            <th class="right_border_last calendar_item 7 finished"  >loading</th>
        </tr>
        <tr >
            <th class="right_border_state text-finished" scope="row"></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 1" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 2" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 3" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 4" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 5" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 6" onclick="show_full_gate(this)" >show</button></th>
            <th class="right_border_last calendar_item " ><button class="btn btn-default bg-primary last_btn text-light 7" onclick="show_full_gate(this)" >show</button></th>
        </tr>
        </tbody>
    </table>


    <table id="calendar_dates" class="table "  >
        <thead>
        <tr>
            <th class=" th_top_float_bar right_border_state text-center" scope="col" >
                <button class="btn btn-default bg-danger"  onclick="show_full_gate('close')" >back </button>
            </th>
            <th class="days_in_calendar_closer" scope="col">1 date</th>
            <th class="days_in_calendar_closer" scope="col">2 date</th>
            <th class="days_in_calendar_closer" scope="col">3 date</th>
            <th class="days_in_calendar_closer" scope="col">4 date</th>
            <th class="days_in_calendar_closer" scope="col">5 date</th>
            <th class="days_in_calendar_closer" scope="col">6 date</th>
            <th class="days_in_calendar_closer last" scope="col">7 date</th>
        </tr>
        </thead>
        <tbody>
        <tr class="time">
            <th class="right_border_time" scope="row">00:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">00:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">01:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">01:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">02:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">02:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">03:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">03:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">04:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">04:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">05:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">05:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">06:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">06:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">07:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">07:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">08:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">08:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">09:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">09:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">10:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">10:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">11:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">11:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">12:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">12:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">13:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">13:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">14:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">14:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">15:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">15:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">16:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">16:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">17:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">17:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">18:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">18:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">19:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">19:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">20:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">20:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">21:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">21:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">22:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">22:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">23:00</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        <tr class="time">
            <th class="right_border_time" scope="row">23:30</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border calendar_item item_in_hours" >free</th>
            <th class="right_border_last calendar_item item_in_hours" >free</th>
        </tr>
        </tbody>
    </table>
</div>


<h3 id="prepared_h3" class="text-success find_by_divs_and_titles" >Prepared</h3 >
<table id="prepared" class="table table-striped  table-responsive bg-light table_of_customers find_by_divs_and_titles" >
    <thead>
        <tr>
            <th scope="col">Time</th>
            <th  scope="col"></th>
            <th  scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <tr class="prepared_tr">
        <td >6:00 - 8:30</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="td_flex_buttons">
            <button class="btn btn-default bg-success only_one" onclick="" >edit</button>
        </td>
    </tr>
    </tbody>
</table>

<h3 id="requested_h3" class="text-warning find_by_divs_and_titles" >Requested</h3>
<table id="requested" class="table table-striped  table-responsive bg-light table_of_customers find_by_divs_and_titles" >
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th  scope="col">Company</th>
        <th  scope="col">Plate number</th>
        <th scope="col">Destination</th>
        <th scope="col">Cargo</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="requested_tr">
        <td >10:00 (11.12.2020)</td>
        <td>Ondrej Richnak</td>
        <td>BA-435-SC</td>
        <td>Bratislava</td>
        <td class="td_flex_buttons">
            <button class="btn btn-default bg-primary only_one"  onclick="" >edit</button>
        </td>
    </tr>
    </tbody>
</table>

<h3 id="booked_h3" class="text-danger find_by_divs_and_titles">Booked</h3>
<table id="booked" class="table table-striped  table-responsive bg-light table_of_customers find_by_divs_and_titles">

    <thead>
        <tr>
            <th scope="col">Time</th>
            <th  scope="col">Company</th>
            <th  scope="col">Plate number</th>
            <th scope="col">Destination</th>
            <th scope="col">Cargo</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <tr class="booked_tr">
        <td >10:00 (11.12.2020)</td>
        <td>Ondrej Richnak</td>
        <td>BA-435-SC</td>
        <td>Bratislava</td>
        <td class="td_flex_buttons">
            <button class="btn btn-default bg-primary only_one" style="" onclick="" >edit</button>
        </td>
    </tr>
    </tbody>
</table>


<h3 id="finished_h3" class="text-finished find_by_divs_and_titles">Finished</h3>
<table id="finished" class="table table-striped  table-responsive bg-light table_of_customers find_by_divs_and_titles" >
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th  scope="col">Company</th>
        <th  scope="col">Plate number</th>
        <th scope="col">Destination</th>
        <th scope="col">Cargo</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="finished_tr">
        <td >10:00 (11.12.2020)</td>
        <td>Ondrej Richnak</td>
        <td>BA-435-SC</td>
        <td>Bratislava</td>
        <td class="td_flex_buttons">
            <button class="btn btn-default bg-primary only_one"  onclick="" >edit</button>
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