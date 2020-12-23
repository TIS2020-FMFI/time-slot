<?php
session_start();
if (! isset($_SESSION['id']) ){


?>
<!doctype html>
<html lang="en">
<?php
$page = 'log_in';
include('html_head_component.php');
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto ">
      <div class="card card-signin my-5">
        <div class="card-body">
          <h5 class="card-title text-center">GEFCO EXPORTS</h5>
          <form class="form-signin" onsubmit="return false;">
            <div class="form-label-group" style="margin-bottom: 20px" >
              <label for="inputEmail"></label>
              <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            </div>

            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
              <label for="inputPassword"></label>
            </div>
            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" onclick="log_in()">Sign in</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>
<?php
}else{
    if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND'){
        ?>
        <script>window.open('internal_dispatcher.php',"_self");</script>
        <?php
    }else if($_SESSION['role'] == 'EXD'){
        ?>
        <script>window.open('external.php',"_self");</script>
        <?php
    }else if ($_SESSION['role'] == 'GM'){
        ?>
        <script>window.open('gate_man.php',"_self");</script>
        <?php
    }else{
        echo "<h1>Neznami pouzivatel</h1>";
    }
}?>