<?php
//session_start();
if (! isset($page)){
    echo "<h1>ERROR HAS OCCURED</h1>";
}else{
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="   bootstrap-4.3.1/css/bootstrap.min.css" >

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="javascript/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1/js/bootstrap.min.js" ></script>

    <!-- Our JavaScript Exception handler-->
    <script src="javascript/exception_handler.js"></script>
    <script src="javascript/global_functions.js"></script>



    <?php if ($page == 'log_in'){?>
        <!-- Our JavaScript -->
        <script src="javascript/login_page.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/login.css">
        <title>Login Page</title>
    <?php }?>
    <?php if ($page == 'employee'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/employee.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/employee.css">
        <title>Employee Page</title>
    <?php }?>
    <?php if ($page == 'contact'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <!-- <script src="javascript/change_password.js"></script>     TOTOT SA MI NEZDA ZE TU MA BYT-->
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/login.css">
        <title>Contact Page </title>
    <?php }?>
    <?php if ($page == 'config'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script  src="javascript/config.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/config.css">
        <title>Config Page </title>
    <?php }?>
    <?php if ($page == 'change_password'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/change_password.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/login.css">
        <title>Change Password Page</title>
    <?php }?>
    <?php if ($page == 'external_dispatcher_main_page'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/Time_slot.js"></script>
        <script src="javascript/Gate.js"></script>
        <script src="javascript/Calendar.js"></script>
        <script src="javascript/external_dispatcher.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/external_dispatcher.css">
        <title>Main External Dispatcher Page </title>
    <?php }?>
    <?php if ($page == 'gate_man_main_page'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/Time_slot.js"></script>
        <script src="javascript/Gate.js"></script>
        <script src="javascript/Calendar.js"></script>
        <script type="text/javascript" src="javascript/gate_man.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/gate_man.css">
        <title>Main Gate Man Page </title>
    <?php }?>
    <?php if ($page == 'internal_dispatcher_main_page'){ ?>
        <!-- Our JavaScript -->
        <script src="javascript/log_out.js"></script>
        <script src="javascript/Time_slot.js"></script>
        <script src="javascript/Gate.js"></script>
        <script src="javascript/Calendar.js"></script>
        <script src="javascript/internal_dispatcher.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/internal_dispatcher.css">
        <title>Main Internal Dispatcher Page </title>
    <?php }?>
    <?php if ($page == 'order_page'){ ?>
        <!-- Our JavaScript -->
        <script type="text/javascript" src="javascript/order.js"></script>
        <!-- Modified Bootstrap CSS -->
        <link rel="stylesheet" href="css/order.css">
        <title>Order </title>
    <?php }?>
</head>
<?php }?>