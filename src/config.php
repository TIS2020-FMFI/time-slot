<?php
session_start();
if (isset($_SESSION['id']) && ($_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND')){
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="   bootstrap-4.3.1/css/bootstrap.min.css" >
    <!-- Modified Bootstrap CSS -->
    <link rel="stylesheet" href="css/login.css">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="javascript/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>

    <!-- Our JavaScript -->
    <script type="text/javascript" src="javascript/config.js"></script>
    <title>Page of Ondrej Richnak</title>
</head>
<body>

<div class="container">
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
            <h6>Zmeni sa prejavia okazmite po kliknuti nagenerovane time-sloti budu odstranene bez ohladu nato ci uz niekto bol prihlaseni nane vytvorene nanovo s prislusini datami uvedenimi visie</h6>
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

</body>

</html>
<?php
}
else{
    echo "<h1>Your are not valid user , you must first try to log <a class='nav-item nav-link'  href='index.php'> in</a></h1>";
}
?>