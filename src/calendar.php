<?php
session_start();
//echo $_SESSION['id'];
if (isset($_SESSION['id'])) {
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <!-- Modified Bootstrap CSS -->
    <link rel="stylesheet" href="css/main_page.css">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>

    <!-- Our JavaScript -->
    <script type="text/javascript" src="javascript/log_out.js"></script>
    <script type="text/javascript" src="javascript/calendar.js"></script>
  <title>Page of Ondrej Richnak</title>
</head>
<body class=" bg-dark container-fluid">


<nav class="navbar navbar-light bg-primary">
  <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"> </span>
  </button>
  <button class="btn btn-default bg-light" onclick="log_out()">Log out</button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="#">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
      <a class="nav-item nav-link " href="#">Kontact</a>
      <a class="nav-item nav-link " href="external_dispatcher.html">xternal dispatcher assigment</a>
      <a class="nav-item nav-link " href="zamestnanci.php">Zamestnanci</a>
      <a class="nav-item nav-link " href="vratnik.html">Vratnik</a>
      <a class="nav-item nav-link " href="objednavka.html">Objednavka</a>
      <a class="nav-item nav-link " href="change_password.php">Chenge password</a>
      <a class="nav-item nav-link " href="index.php">login page</a>
    </div>
  </div>
</nav>

<div class="table-responsive bg-light" style="width: auto; margin-left: -15px;margin-bottom: 0px;
    margin-right: -15px;">
  <table class="table" style="margin-bottom: 0px;" >
    <!--tento Thead je pre pouzivatela interneho dispatchera  -->
    <thead>
    <tr>
      <th class="top_bar td_flex_buttons" scope="col" >
        <input type="date" id="input_date" name="trip-start" value="2020-10-31" min="2020-10-31"  ><!--max="2020-10-31"-->
        <button class="btn btn-default bg-primary"   ><</button>
        <button class="btn btn-default bg-primary last_btn" >></button>

      </th>

      <th class="top_bar" scope="col" style="padding-left: 0px;padding-right: 0px;">
        <!-- tuna bi mailo bit nieco ako select option with chackeboch bez toho aby to poskodilo
        ten riadko a donutilo to usera scolowat  ps. pochopite ked sa budete snazit implementovat nieco take
        toto bude zobrazene len INTERNIM DISPATCHEROM !!! bue tam viacej nakladiek
        -->
        <div class="form-control"  id="select_nakladka_div" style="margin: 0px; padding: 0px;" onclick="roll()">
          <p id="select_nakladka"> &#8628;</p>
        </div>
        <div class="form-group" style="margin: 0px" onclick="roll()"></div>
        <section class="bg-dark text-light"  id="roll_down">
            <div class="form-check ">

              <input class="form-check-input" type="checkbox" value="nakladka1" id="defaultCheck12" checked onclick="dysplay_nakladka(1)">
              <label class="form-check-label" for="defaultCheck1">
                Nakladka 1
              </label>
            </div>
            <div class="form-check">

              <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onclick="dysplay_nakladka(2)">
              <label class="form-check-label" for="defaultCheck1">
                Nakladka 1
              </label>
            </div>
          <div class="form-check">

            <input class="form-check-input" type="checkbox" value="" id="defaultCheck122" onclick="dysplay_nakladka(undefined)">
            <label class="form-check-label" for="defaultCheck1">
              All
            </label>
          </div>

        </section>
      </th>

      <th class="top_bar" scope="col" style="min-width: 100px;max-width: 100px;">
        <input type="text" class="form-control" placeholder="Find by" aria-label="Username" aria-describedby="basic-addon1"  >
      </th>
    </tr>
    </thead>
  </table>
</div>
<div class="table-responsive  bg-light" style="width: auto; margin-left: -15px;margin-bottom: 0px;
    margin-right: -15px;">
  <table id="calendar" class="table "  >
    <thead>
    <tr>
      <th class="days_in_calendar" scope="col"> </th>
      <th class="days_in_calendar" scope="col">1 day</th>
      <th class="days_in_calendar" scope="col">2 day</th>
      <th class="days_in_calendar" scope="col">3 day</th>
      <th class="days_in_calendar" scope="col">4 day</th>
      <th class="days_in_calendar" scope="col">5 day</th>
      <th class="days_in_calendar" scope="col">6 day</th>
      <th class="days_in_calendar last" scope="col">7 day</th>
    </tr>
    </thead>
    <tbody>
    <tr >
      <th class="right_border_time" scope="row">00:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">00:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">01:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">01:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">02:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">02:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">03:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">03:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">04:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">04:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">05:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">05:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">06:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">06:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">07:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">07:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">08:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">08:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">09:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">09:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">10:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">10:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">11:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">11:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">12:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">12:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">13:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">13:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">14:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">14:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">15:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">15:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">16:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">16:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">17:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">17:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">18:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">18:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">19:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">19:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">20:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">20:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">21:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">21:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">22:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">22:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">23:00</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>
    <tr>
      <th class="right_border_time" scope="row">23:30</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border calendar_item" >free</th>
      <th class="right_border_last calendar_item" >free</th>
    </tr>

    </tbody>
  </table>
</div>

</body>

</html>
<?php
}
else{
    include('index.php');
}
?>