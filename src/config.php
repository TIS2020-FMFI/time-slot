<?php
session_start();
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND'){
?>
<!doctype html>
<html lang="en">
<?php
$page = 'config';
include('html_head_component.php');
?>
<body>
<?php
include('html_nav_component.php');
include('exception_handler.php');
?>
<div id="role_down"></div>>
<div class="container" style="margin-top: 82px;">
    <div class="row">
        <div class="col-sm">
            <h6>DAY
                <br>
                napr. <span class="text-danger">2020-12-23</span> znamena ze vdani  den su prazdniny
                <br>
                napr. <span class="text-success">2020-12-03</span> znamena ze dani je normalni pracovni den
            </h6>
        </div>
        <div class="col-sm">
            <h6>Start working hours format 12.5 == 12:30</h6>
        </div>
        <div class="col-sm">
            <h6>End working hours format 22 == 22:00</h6>
        </div>
        <div class="col-sm">
            <h6>Overwrite holiday timi-sloti sa vitvoria aj ked sa dani den nachadza v holidays</h6>
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_monday">Pondelok:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_monday"></label><input type="number" id="input_start_monday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_monday"></label><input type="number" id="input_end_monday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_monday"></label><input type="checkbox" id="input_special_monday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_tuesday">Utorok:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_tuesday"></label><input type="number" id="input_start_tuesday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_tuesday"></label><input type="number" id="input_end_tuesday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_tuesday"></label><input type="checkbox" id="input_special_tuesday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_wednesday">Streda:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_wednesday"></label><input type="number" id="input_start_wednesday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_wednesday"></label><input type="number" id="input_end_wednesday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_wednesday"></label><input type="checkbox" id="input_special_wednesday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_thursday">stvrtok:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_thursday"></label><input type="number" id="input_start_thursday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_thursday"></label><input type="number" id="input_end_thursday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_thursday"></label><input type="checkbox" id="input_special_thursday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_friday">Piatok:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_friday"></label><input type="number" id="input_start_friday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_friday"></label><input type="number" id="input_end_friday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_friday"></label><input type="checkbox" id="input_special_friday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_saturday">Sobota:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_saturday"></label><input type="number" id="input_start_saturday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_saturday"></label><input type="number" id="input_end_saturday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_saturday"></label><input type="checkbox" id="input_special_saturday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6 id="input_day_sunday">Nedela:</h6>
        </div>
        <div class="col-sm">
            <label for="input_start_sunday"></label><input type="number" id="input_start_sunday" class="form-control" min="0" max="24" step="0.5" placeholder="start time " >
        </div>
        <div class="col-sm">
            <label for="input_end_sunday"></label><input type="number" id="input_end_sunday" class="form-control" min="0" max="24" step="0.5" placeholder="end time " >
        </div>
        <div class="col-sm">
            <label for="input_special_sunday"></label><input type="checkbox" id="input_special_sunday" class="form-control"  >
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h6>Zmeni budu aktivne od dalsieho automatickeho generovania (nasledujuca STREDA 24:00)</h6>
            <button class="btn btn-lg btn-success btn-block text-uppercase"  onclick="set_new_times()">SET</button>
        </div>
        <div class="col-sm">
            <h6>Pred kliknutim nastavte vsetky "SET" tak ako vam to vyhovuje .Zmeni sa prejavia okazmite po kliknuti nagenerovane time-sloti budu odstranene bez ohladu nato ci uz niekto bol prihlaseni nane vytvorene nanovo s prislusini datami uvedenimi visie</h6>
            <button class="btn btn-lg btn-danger btn-block text-uppercase"  onclick="regenerate_new_time_slots()">REGENERATE</button>
        </div>

    </div>
</div>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6>Holidays:</h6> <p>format mesiac-den, napr.(12-04,01-23)</p>
            <div class="form-group">
                <label for="exampleFormControlTextarea1"></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h6>Zaznamenane datumi prazdnin aktivne od dalsieho automatickeho generovania (nasledujuca STREDA 24:00)</h6>
            <button class="btn btn-lg btn-success btn-block text-uppercase" type="submit" onclick="set_new_holidays()">SET</button>
        </div>

    </div>
</div>
<br>
<br>
<div class="container">

    <div class="row">
        <div class="col-sm">
            <h6>Odstranenie rampi na urite dni pomocou kikania na konkretne dni </h6>
            <table id="calendar_dates" class="table " style="display: revert"  >
                <thead>
                <tr>
                    <th class=" th_top_float_bar right_border_state days_in_calendar_closer_last" scope="col" style="text-align: center"></th>
                    <th class="days_in_calendar_closer" scope="col">1 date</th>
                    <th class="days_in_calendar_closer" scope="col">2 date</th>
                    <th class="days_in_calendar_closer" scope="col">3 date</th>
                    <th class="days_in_calendar_closer" scope="col">4 date</th>
                    <th class="days_in_calendar_closer" scope="col">5 date</th>
                    <th class="days_in_calendar_closer" scope="col">6 date</th>
                    <th class="days_in_calendar_closer  " scope="col">7 date</th>
                    <th class="days_in_calendar_closer_last" scope="col">all days check</th>
                    <th class="days_in_calendar_closer_last" scope="col">all days clear</th>
                </tr>
                </thead>
                <tbody>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 1</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(1)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(1)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 2</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(2)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(2)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 3</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(3)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(3)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 4</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(4)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(4)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 5</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(5)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(5)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 6</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(6)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(6)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 7</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(7)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(7)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 8</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(8)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(8)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 9</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(9)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(9)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 10</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(10)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(10)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 11</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(11)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(11)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 12</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(12)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(12)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 13</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(13)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(13)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 14</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(14)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(14)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 15</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(15)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(15)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 16</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(16)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(16)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 17</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(17)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(17)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 18</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(18)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(18)"></label></th>
                </tr><tr class="time">
                    <th class="right_border_time" scope="row">rampa 19</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(19)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(19)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 20</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(20)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(20)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 21</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(21)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(21)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 22</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(22)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(22)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 23</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(23)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(23)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 24</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(24)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(24)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 25</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(25)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(25)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 26</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(26)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(26)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 27</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(27)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(27)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 28</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(28)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(28)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 29</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(29)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(29)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 30</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(30)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(30)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 31</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(31)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(31)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 32</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(32)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(32)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 33</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(33)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(33)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 34</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(34)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(34)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 35</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(35)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(35)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 36</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(36)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(36)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 37</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(37)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(37)"></label></th>
                </tr>
                <tr class="time">
                    <th class="right_border_time" scope="row">rampa 38</th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input class="ramp_in_day" type="checkbox"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="check" onclick="disabled_all_in_ramp(38)"></label></th>
                    <th class="right_border calendar_item " ><label><input type="button" value="clear" onclick="clear_all_in_ramp(38)"></label></th>
                </tr>
                <!-- Treba pridat html podla poctu ramp nezabudnite zmenit aj parametre funkciji prisluchajucich danim novim rampam-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h6>Zaznamenane datumi prazdnin aktivne od dalsieho automatickeho generovania (nasledujuca STREDA 24:00)</h6>
            <button class="btn btn-lg btn-success btn-block text-uppercase" type="submit" onclick="set_ramps()">SET</button>
        </div>

    </div>
</div>
</body>

</html>
<?php
}else{
    ?>
    <script>window.open('index.php',"_self");</script>
    <?php
}
?>