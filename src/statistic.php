<?php
session_start();
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND') {
?>
<!DOCTYPE html>
<html lang="en">
<?php
$page = 'statistic_page';
include('html_head_component.php');
include('exception_handler.php');
?>
<body>
<?php
include('html_nav_component.php');
?>
<div class="table-responsive bg-light fixed-top " id="role_down" style="margin-top: 56px; z-index: 200;">
    <table class="table" style="margin-bottom: 0px;" >
        <!--tento Thead je pre pouzivatela interneho dispatchera  -->
        <thead>
        <tr>
            <th class="top_bar" scope="col" >
                <label for="input_text"></label><input id="input_text" type="text" class="form-control" placeholder="Find by"  style="display: inherit" oninput="pre_make_chard()"  >
            </th>
            <th class="top_bar D_S" scope="col" >
            <div class="form-group">
                <label for="direct_select"></label>
                <select class="form-control" id="direct_select" onchange="pre_make_chard(this)" style="max-width: 5%" >
                    <option class="option">''</option>
                </select>
            </div>
            </th>
            <th class="top_bar_date" scope="col" >
                From:
                <label for="input_date1"></label><input type="date" id="input_date1" value="" onchange="pre_make_chard()">
            </th>
            <th class="top_bar_date" scope="col" >
                To:
                <label for="input_date2"></label><input type="date" id="input_date2" value="" onchange="pre_make_chard()">
            </th>
            <th class="top_bar th_top_float_bar" scope="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">show only</label>
                    <select class="form-control" id="exampleFormControlSelect1" onchange="pre_make_chard()">
                        <option>all</option>
                        <option>prepared</option>
                        <option>requested</option>
                        <option>booked</option>
                        <option>finished</option>
                    </select>
                </div>
            </th>

            <th class="top_bar " scope="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect2">type of chard</label>
                    <select class="form-control" id="exampleFormControlSelect2" onchange="pre_make_chard()">
                        <option>bar</option>
                        <option>pie</option>
                        <option>line</option>
                        <option>horizontalBar</option>
                        <option>doughnut</option>
                        <option>radar</option>
                        <option>polarArea</option>
                    </select>
                </div>
            </th>
            <th class="top_bar th_top_float_bar" scope="col">
                <div class="form-group">
                    <label for="intensityFormControlSelect">show only</label>
                    <select class="form-control" id="intensityFormControlSelect" onchange="pre_make_chard()">
                        <option>fill</option>
                        <option>half transparent</option>
                        <option>max prepared</option>
                        <option>max finished</option>
                    </select>
                </div>
            </th>
            <th class="top_bar " scope="col">
                <button class="btn btn-default bg-success only_one" style="" onclick="export_all_statistics()" >export all</button>
            </th>
            <th class="top_bar" scope="col" style="max-width: 10px">
               <img class=""  src="camera.png" width="32" style="display: flex" onclick="take_picture()"  alt="take picture">
            </th>
        </tr>
        </thead>
    </table>
</div>
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col">-->
<!--                    <canvas id="myChart"></canvas>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<img class="fixed-bottom-right float-left"  src="camera.png" width="32" style="display: flex" onclick="take_picture()"  alt="take picture">-->
<div class="container" style="margin-top: 150px;">
    <canvas id="myChart"></canvas>
</div>
<!--<button onclick="make_chard()">  exceitu</button>-->


</body>
</html>
<?php
}else{
    ?>
    <script>window.open('index.php',"_self");</script>
    <?php
}
?>