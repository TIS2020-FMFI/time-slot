<?php
session_start();
include('db.php');
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
    <link rel="stylesheet" href="css/order.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="javascript/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>
    <!-- Our JavaScript -->
    <script type="text/javascript" src="javascript/order.js"></script>
    <title>Page of Ondrej Richnak</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9"><h5 class="card-title text-center text-primary">PRODUCT EXPORT DOCUMENT</h5></div>
                        <div class="col-1"> <button class="btn  btn-danger  text-uppercase " type="button" onclick="close_time_slot()" style="width: auto;margin: auto;">close</button>
                        </div>
                    </div>
                    <!--<div class="row" style="display:flex;">
                        <h6 class="card-title text-center text-primary" style="margin-left: 20px;">PRODUCT EXPORT DOCUMENT</h6>
                    </div> -->
                    <form class="form-sign" onsubmit="return false" >
                        <div class="form-label-group">
                            <label for="inputNameDopravca"></label>
                            <input type="text" id="inputTimeSlot" class="form-control" placeholder="DATE (HH:MM - HH:MM)" value="<?php echo $vystup['time_of_time_slot']?>" disabled required >
                        </div>
                        <div class="form-label-group">
                            <label for="inputNameDopravca"></label>
                            <input type="text" id="inputNameDopravca" class="form-control" placeholder="Meno dopravcu" value="" disabled required >
                        </div>
                        <div class="form-label-group">
                            <label for="inputNakladka"></label>
                            <input type="text" id="inputNakladka" class="form-control" placeholder="Nákladka" value="<?php echo 'Ramp number: '.$vystup['ramp_number']?>" oninput=update_evc(this) disabled required >
                        </div>
                        <div class="form-label-group">
                            <label for="EVC"></label>
                            <input type="text" id="EVC" class="form-control" placeholder="Evidenčné číslo kamiónu"  value="" required autofocus>
                        </div>
                        <div class="form-label-group" >
                            <label for="inputNameKamionist1"></label>
                            <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value=""  required autofocus>
                        </div>
                        <div id="kamionist2" class="form-label-group" >
                            <label for="inputNameKamionist2"></label>
                            <input type="text" id="inputNameKamionist2" class="form-control" placeholder="Meno Kamionistu" value="" required autofocus>
                        </div>
                        <button id="add_employee" class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="add_next_employee()">+</button>
                        <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="request_time_slot()">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>