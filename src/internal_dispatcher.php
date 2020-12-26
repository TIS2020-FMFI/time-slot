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
    <div id="only_requested" class="fixed-top bg-warning justify-content-center" style="min-width: 100px;max-width: 100px;left: 100px;display: flex" onclick="show_requested()">
        <img src="request_sign.png" width="32" style="position: relative;right: 10px" alt="fotoo">
        <p id="only_requested_count" class="text-danger" style="margin: 0px;margin-top: 5px;">pocet</p>
    </div>

<div class="table-responsive bg-light fixed-top " id="role_down" style="margin-top: 56px;">
  <table class="table" style="margin-bottom: 0px;" >
    <!--tento Thead je pre pouzivatela interneho dispatchera  -->
    <thead>
    <tr>
      <th class="top_bar td_flex_buttons" scope="col" >
          <label for="input_date"></label><input type="date" id="input_date" value="" onchange="display_time_slot_for_this_date(this)">
        <button class="btn btn-default bg-primary" id="back_date" onclick="make_date_arrows_mini_calendar(-1)" ><</button>
        <button class="btn btn-default bg-primary last_btn" id="next_date" onclick="make_date_arrows_mini_calendar(1)">></button>
          <h4 id="ramp_title" class="text-primary">Ramps 1 - 7</h4>
      </th>

      <th class="top_bar" scope="col" style="padding-left: 0px;padding-right: 0px;">

      </th>

      <th class="top_bar" scope="col" style="min-width: 100px;max-width: 100px">
          <label for="input_text"></label><input id="input_text" type="text" class="form-control" placeholder="Find by"  style="display: inherit" oninput="find_by(this)"  >

      </th>
        <th class="top_bar" scope="col" style="max-width: 10px">
        <img src="request_sign_info.png" width="32" style="display: flex" onmouseenter="show_info()" onmouseleave="hide_info()" alt="info">
        </th>
    </tr>
    </thead>
  </table>
</div>

<div class="table-responsive  bg-light" style="padding-top:126px;width: auto; margin-left: -15px;margin-bottom: 0px;
    margin-right: -15px;">
    <table id="calendar" class="table table-striped"  >
        <thead>
        <tr>
            <th class=" th_top_float_bar right_border_state" scope="col" style="display: flex">
                <button class="btn btn-default bg-primary"   ><</button>

                <div class="form-group" style="margin: 0px;width: 120px">
                    <select class="form-control" id="select_gate" onchange="generate_gate_selector(this)"  style="display: block;"> <!-- onclick="generate_gate_selector(this)"-->
                        <option>1 - 7</option>
                        <option>8 - 14</option>
                        <option>15 - 21</option>
                        <option>22 - 28</option>
                        <option>29 - 35</option>
                        <option>36 - 42</option>
                        <!-- Treba pridat html podla poctu ramp  ovsem vzdy po rozdiele 6-->
                    </select>
                </div>
                <button class="btn btn-default bg-primary last_btn" >></button>
            </th>
            <th class="days_in_calendar" scope="col">1 gate</th>
            <th class="days_in_calendar" scope="col">2 gate</th>
            <th class="days_in_calendar" scope="col">3 gate</th>
            <th class="days_in_calendar" scope="col">4 gate</th>
            <th class="days_in_calendar" scope="col">5 gate</th>
            <th class="days_in_calendar" scope="col">6 gate</th>
            <th class="days_in_calendar last" scope="col">7 gate</th>
        </tr>
        </thead>
        <tbody>
        <tr >
            <th class="right_border_state text-success" scope="row">Prepared</th>
            <th class="right_border calendar_item 1 prepared_occupied "  >None</th>
            <th class="right_border calendar_item 2 prepared_occupied"  >None</th>
            <th class="right_border calendar_item 3 prepared_occupied"  >None</th>
            <th class="right_border calendar_item 4 prepared_occupied"  >None</th>
            <th class="right_border calendar_item 5 prepared_occupied"  >None</th>
            <th class="right_border calendar_item 6 prepared_occupied"  >None</th>
            <th class="right_border_last calendar_item 7 prepared_occupied"  >None</th>
        </tr>
        <tr >
            <th class="right_border_state text-warning" scope="row">Requested</th>
            <th class="right_border calendar_item 1 requested "  >None</th>
            <th class="right_border calendar_item 2 requested"  >None</th>
            <th class="right_border calendar_item 3 requested"  >None</th>
            <th class="right_border calendar_item 4 requested"  >None</th>
            <th class="right_border calendar_item 5 requested"  >None</th>
            <th class="right_border calendar_item 6 requested"  >None</th>
            <th class="right_border_last calendar_item 7 requested"  >None</th>
        </tr>
        <tr >
            <th class="right_border_state text-danger" scope="row">Booked</th>
            <th class="right_border calendar_item 1 booked "  >None</th>
            <th class="right_border calendar_item 2 booked"  >None</th>
            <th class="right_border calendar_item 3 booked"  >None</th>
            <th class="right_border calendar_item 4 booked"  >None</th>
            <th class="right_border calendar_item 5 booked"  >None</th>
            <th class="right_border calendar_item 6 booked"  >None</th>
            <th class="right_border_last calendar_item 7 booked"  >None</th>
        </tr>
        <tr >
            <th class="right_border_state text-finished" scope="row">Finished</th>
            <th class="right_border calendar_item 1 finished "  >None</th>
            <th class="right_border calendar_item 2 finished"  >None</th>
            <th class="right_border calendar_item 3 finished"  >None</th>
            <th class="right_border calendar_item 4 finished"  >None</th>
            <th class="right_border calendar_item 5 finished"  >None</th>
            <th class="right_border calendar_item 6 finished"  >None</th>
            <th class="right_border_last calendar_item 7 finished"  >None</th>
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


    <table id="calendar_dates" class="table " style="display: none"  >
        <thead>
        <tr>
            <th class=" th_top_float_bar right_border_state" scope="col" style="text-align: center">
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


<h3 id="prepared_h3" class="text-success " style="padding-top:5px;display: none">PREPARED</h3 >
<table id="prepared" class="table table-striped  table-responsive bg-light table_of_customers " style="display: none" >
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
            <button class="btn btn-default bg-success only_one" style="" onclick="" >edit</button>
        </td>
    </tr>
    </tbody>
</table>

<h3 id="requested_h3" class="text-warning " style="padding-top:5px;display: none">Requested time-slot</h3>
<table id="requested" class="table table-striped  table-responsive bg-light table_of_customers " style="display: none">
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th  scope="col">Company</th>
        <th  scope="col">EVC</th>
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
            <button class="btn btn-default bg-primary only_one" style="" onclick="" >edit</button>
        </td>
    </tr>
    </tbody>
</table>

<h3 id="booked_h3" class="text-danger " style="padding-top:5px;display: none">BOOKED</h3>
<table id="booked" class="table table-striped  table-responsive bg-light table_of_customers " style="display: none">

    <thead>
        <tr>
            <th scope="col">Time</th>
            <th  scope="col">Company</th>
            <th  scope="col">EVC</th>
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


<h3 id="finished_h3" class="text-finished" style="padding-top:5px;display: none">Finished time-slot</h3>
<table id="finished" class="table table-striped  table-responsive bg-light table_of_customers" style="display: none" >
    <thead>
    <tr>
        <th scope="col">Time</th>
        <th  scope="col">Company</th>
        <th  scope="col">EVC</th>
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
            <button class="btn btn-default bg-primary only_one" style="" onclick="" >edit</button>
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