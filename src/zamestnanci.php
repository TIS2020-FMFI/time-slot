<!doctype html>
<html  lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <!-- Modified Bootstrap CSS -->
    <link rel="stylesheet" href="css/zamestnanci.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="javascript/zamestnanci.js"></script>

    <title>Page of Ondrej Richnak</title>

    <script src="javascript/zamestnanci.js"></script>

</head>
<body class=" bg-dark container-fluid">


<nav class="navbar navbar-light bg-primary">
  <button class="navbar-toggler navbar-toggler-right bg-light" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"> </span>
  </button>
  <button class="btn btn-default bg-light" >Log out</button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="internal_dispatcher.php">Calendar <span class="sr-only">(current)</span></a> <!-- active -->
      <a class="nav-item nav-link " href="#">Kontact</a>
      <a class="nav-item nav-link " href="#">Statistika</a>
      <a class="nav-item nav-link " href="#">Zamestnanci</a>
      <a class="nav-item nav-link " href="#">Objednavka</a>
      <a class="nav-item nav-link " href="change_password.php">Chenge password</a>
      <a class="nav-item nav-link " href="index.php">login page</a>
    </div>
  </div>
</nav>

<div class="table-responsive bg-light" style="width: auto; margin-left: -15px;margin-bottom: 0px;
    margin-right: -15px;">
  <table class="table" style="margin-bottom: 0px;" >
    <thead>
    <tr>
      <th class="top_bar" scope="col" >
        <input type="text" class="form-control" id="find_by" placeholder="Find by" aria-label="Username" aria-describedby="basic-addon1" oninput="select_only()" >
      </th>

      <th class="top_bar" scope="col">
        <div class="form-group" style="margin: 0px">
          <select class="form-control" id="change_select_role" onchange="select_only()">
            <option>Select Only</option>
            <option>Administrator</option>
            <option>Internal dispatcher</option>
            <option>External dispatcher</option>
            <option>Gate man</option>
          </select>
        </div>
      </th>
        <th class="top_bar" scope="col">
            <div class="form-group" style="margin: 0px">
                <select class="form-control" id="change_select_type_working" onchange="select_only()">
                    <option>Only working</option>
                    <option>Only not working</option>
                    <option>All employee</option>
                </select>
            </div>
        </th>
      <th class="top_bar" scope="col" >

          <button class="btn btn-default bg-success" style="margin-right: 10px; float: right;" onclick="add_new_customer()" >Add new</button>

      </th>
        <th class="top_bar" scope="col" >

            <button class="btn btn-default bg-success" style="margin-right: 10px; float: right;" onclick="add_new_customer()" >Edit</button>

        </th>
    </tr>
    </thead>
  </table>
</div>
<table class="table table-striped  table-responsive bg-light table_of_customers">
  <thead>
  <tr>
    <th scope="col">First</th>
    <th scope="col">Last</th>
    <th scope="col">Email</th>
    <th scope="col">role</th>
    <th scope="col">working</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>


<div class="container add_customer" >
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card card-signin my-3">
        <div class="card-body">

          <div class="form-label-group" >
            <h5 class="card-title text-left">New employee</h5>
            <button class="btn btn-default bg-danger" id="close" onclick="close_new_customer()" >X</button>
          </div>
          <form id="form" class="form-sign" onsubmit="return false;"   >
            <div class="form-label-group">
              <label for="inputNewName"></label>
              <input type="text" id="inputNewName" class="form-control" placeholder="First name" required autofocus>
            </div>
            <div class="form-label-group">
              <label for="inputNewLastName"></label>
              <input type="text" id="inputNewLastName" class="form-control" placeholder="Surname names" required autofocus>
            </div>

            <div class="form-label-group" >
              <label for="inputEmail"></label>
              <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            </div>

            <div class="form-label-group">
              <label for="inputPassword"></label>
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>

            </div>
            <div class="form-label-group">
              <label for="inputConfirmPassword"></label>
              <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Repeat password" required>

            </div>
            <div class="form-label-group">
              <div class="form-group">
                <label for="role_of_new_employee">Select type of employee</label>
                <select class="form-control" id="role_of_new_employee" required>
                  <option>EXD</option>
                  <option>IND</option>
                  <option>GM</option>
                  <option>AD</option>
                </select>
              </div>
            </div><br>


            <button class="btn btn-lg btn-success btn-block text-uppercase" type="submit" onclick="submit_form_new_employee()" >Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


</body>
