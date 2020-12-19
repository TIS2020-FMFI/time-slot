<?php
session_start();
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'EXD' || $_SESSION['role'] == 'GM'  ) {
?>
<!doctype html>
<html lang="en">
    <?php
    $page = 'change_password';
    include('html_head_component.php');
    ?>
<body>
<?php
include('html_nav_component.php');
?>

<div class="container">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card card-signin my-5">
        <div class="card-body">
          <h3 class="card-title text-center">Change Password</h3>
          <form class="form-signin" onsubmit="return false;">
            <div class="form-label-group" style="margin-bottom: 20px">
              <label for="inputEmail"></label>
              <label for="inputOldPassword"></label>
              <input type="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $_SESSION['email']?>" required disabled>
            </div>

            <div class="form-label-group"style="margin-bottom: 20px">

              <input type="password" id="inputOldPassword" class="form-control" placeholder="Old password" required>

            </div>

            <div class="form-label-group">
              <input type="password" id="inputNewPassword" class="form-control" placeholder="New password" required>
              <label for="inputNewPassword"></label>
            </div>
            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" onclick="change_password()">Change</button>
            </form>
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
    echo "<h1>Your are not valid user , you must first try to log <a class='nav-item nav-link'  href='index.php'> in</a></h1>";
}
?>