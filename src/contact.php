<?php
session_start();
if ($_SESSION['role'] == 'EXD') {
?>
<!doctype html>
<html lang="en">
<?php
$page = 'contact';
include('html_head_component.php');
?>

<body>
<?php
include('html_nav_component.php');
?>
<div id="role_down">
<div class="container" >
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Contact us</h3>
                    <div class="form-group" >
                        <p class="text-center w-responsive mx-auto mb-5">Do you have any problem? Please do not
                            hesitate to contact us directly. Our team will help you.</p>
                    </div>

                    <div class="form-group">
                        <p class="text-center w-responsive mx-auto mb-5">E-mail: expedition.trnava@gefco.net
                            <br>Tel. +421 33 590 85 77, +421 33 590 85 76
			    <br>Mob. +421 918 742 125, +421 905 206 200</p>
                    </div>
                </div>
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