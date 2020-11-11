<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Modified Bootstrap CSS -->
  <link rel="stylesheet" href="css/login.css">
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <!-- Our JavaScript -->
    <script type="text/javascript" src="javascript/login_page.js"></script>
  <title>Page of Ondrej Richnak</title>
</head>
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

            <!-- REMEBER SIGN
            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Remember password</label>
            </div>
            -->
            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" onclick="log_in()">Sign in</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>
