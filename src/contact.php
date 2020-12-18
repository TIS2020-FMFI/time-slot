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
        <link rel="stylesheet" href="   bootstrap-4.3.1/css/bootstrap.min.css" >
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/login.css">

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="javascript/jquery-3.5.1.min.js"></script>
        <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>
        <!-- Our JavaScript -->
        <script src="javascript/change_password.js"></script>
        <title>Contact</title>
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Contact us</h3>
                        <div class="form-label-group" style="margin-bottom: 20px">
                            <p class="text-center w-responsive mx-auto mb-5">Do you have any problem? Please do not
                                hesitate to contact us directly. Our team will help you.</p>
                        </div>

                        <div class="form-label-group"style="margin-bottom: 20px">
                            <p class="text-center w-responsive mx-auto mb-5">e-mail: simona.dubekova@gmail.com
                                <br> telephone: +421900 000 000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

    </html>
    <?php
}
else{
    echo "<h1>Your are not valid user, you must first try to log <a class='nav-item nav-link'  href='index.php'> in</a></h1>";
}
?>
