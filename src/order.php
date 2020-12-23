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
<div class="container">
    <div class="row">
        <?php
        if ($_SESSION['active_time_slot_state'] == 'prepared'){
            ?>
            <h4>When time hits <span class="text-danger" >00:00 </span> u are no longer able to operate on this this time slot  and u will be retargeted to main page <span id="timer" class="text-danger" >00:00</span></h4>
        <?php
        }else{
            ?>
            <h4>Please make changes before time hitts <span class="text-danger" >00:00 </span> if time is 00:00 the changes will NOT saved and u will be retargeted to main page <span id="timer" class="text-danger" >00:00</span></h4>

        <?php
        }
        ?>
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9"><h5 class="card-title text-center text-primary">PRODUCT EXPORT DOCUMENT</h5></div>
                        <div class="col-1"> <button class="btn  btn-danger  text-uppercase " type="button" onclick="close_time_slot()" style="width: auto;margin: auto;">close</button>
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