<?php
session_start();
include('db.php');
if ($_SESSION['role'] == "EXD" || $_SESSION['role'] == "AD" ||$_SESSION['role'] == "IND"){
?>
<!doctype html>
<html lang="en">
<?php
$page = 'order_page';
include('html_head_component.php');
?>
<body>
<?php
include('exception_handler.php');
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5 ">
                <div class="card-body">
                    <div id="top_timer_text" class="justify-content-center" >
                        The document will be closed once the timer reaches <span class="text-danger" >00:00</span> and your changes will not be saved. You will be redirected to the main page in: <span id="timer" class="text-danger" >00:00</span>
                    </div>
                    <div class="row">
                        <div class="col-9"><h5 class="card-title text-center text-primary">PRODUCT EXPORT DOCUMENT</h5></div>
                        <div class="col-1"> <button class="btn  btn-danger  text-uppercase " type="button" onclick="close_time_slot_in_order()" >close</button>
                        </div>
                    </div>


                        <?php
                        include('html_order_component.php');
                        ?>

                </div>
            </div>
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