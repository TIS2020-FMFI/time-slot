<?php
//session_start();
?>
<?php if ($_SESSION['role'] == 'GM' ){ ?>
    <nav class="navbar navbar-light fixed-top bg-primary" style="z-index: 100;">
        <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" onclick="role_down_navigation()">
            <span class="navbar-toggler-icon"> </span>
        </button>
        <div>
            <button class="btn btn-default bg-light" style="margin-right:50px;"onclick="log_out()">Log Out</button>
            <img  src="GEFCO.svg" width="48" style="margin-left: 10px;right:8px;top: 5px;position: absolute;">
        </div>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link " href="gate_man.php">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
                <a class="nav-item nav-link " href="change_password.php">Change password</a>
            </div>
        </div>
    </nav>

<?php }?>
<?php if ($_SESSION['role'] == 'EXD' ){ ?>
    <nav class="navbar navbar-light fixed-top bg-primary" style="z-index: 100;">
        <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" onclick="role_down_navigation()">
            <span class="navbar-toggler-icon"> </span>
        </button>
        <div>
            <button class="btn btn-default bg-light" style="margin-right:50px;"onclick="log_out()">Log Out</button>
            <img  src="GEFCO.svg" width="48" style="margin-left: 10px;right:8px;top: 5px;position: absolute;">
        </div>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link " href="external_dispatcher.php">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
                <a class="nav-item nav-link " href="contact.php">Contact</a>
                <a class="nav-item nav-link " href="change_password.php">Change password</a>

            </div>
        </div>
    </nav>

<?php }?>
<?php if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND'){ ?>
    <nav class="navbar navbar-light fixed-top bg-primary" style="z-index: 100;">
        <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" onclick="role_down_navigation()">
            <span class="navbar-toggler-icon"> </span>
        </button>
        <div>
            <button class="btn btn-default bg-light" style="margin-right:50px;"onclick="log_out()">Log Out</button>
            <img  src="GEFCO.svg" width="48" style="margin-left: 10px;right:8px;top: 5px;position: absolute;">
        </div>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link " href="internal_dispatcher.php">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
                <?php if ($_SESSION['role'] == 'AD'){ ?>
                    <a class="nav-item nav-link " href="employee.php">Employee</a>
                <?php }?>
                <a class="nav-item nav-link " href="config.php">Config</a>
                <a class="nav-item nav-link " href="gate_man.php">Gate man</a>
                <a class="nav-item nav-link " href="statistic.php">Statistics</a>
                <a class="nav-item nav-link " href="change_password.php">Change password</a>

            </div>
        </div>
    </nav>
<?php }?>

