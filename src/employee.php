<?php
session_start();
if ($_SESSION['role'] == 'AD') {
?>
<!doctype html>
<html  lang="en">
<?php
$page = 'employee';
include('html_head_component.php');
?>
<body class=" bg-dark container-fluid">
<?php
include('html_nav_component.php');
include('exception_handler.php');
?>

<div class="table-responsive bg-light fixed-top" id="role_down" >
  <table class="table"   >
    <thead>
    <tr>
      <th class="top_bar" scope="col" >
        <input type="text" class="form-control" id="find_by" placeholder="Find by" aria-label="Username" aria-describedby="basic-addon1" oninput="select_only()" >
      </th>

      <th class="top_bar" scope="col">
        <div class="form-group m-0" >
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
            <div class="form-group m-0" >
                <select class="form-control" id="change_select_type_working" onchange="select_only()">
                    <option>Only working</option>
                    <option>Only not working</option>
                    <option>All employee</option>
                </select>
            </div>
        </th>
      <th class="top_bar" scope="col" >

          <button id="new" class="btn btn-default bg-success"  onclick="add_new_customer()" >Add new</button>

      </th>
        <th class="top_bar" scope="col" >

            <button id="edit" class="btn btn-default bg-primary"  onclick="edit_employees()" >Edit</button>
            <button id="update" class="btn btn-default bg-success"  onclick="update_employees()" >Update</button>

        </th>
    </tr>
    </thead>
  </table>
</div>
<table class="table table-striped  table-responsive bg-light table_of_customers" >
  <thead>
  <tr>
    <th scope="col">First</th>
    <th scope="col">Last</th>
    <th scope="col">Firm</th>
    <th scope="col">Email</th>
    <th scope="col">role</th>
    <th scope="col">working</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>


<div class="container add_customer">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card card-signin my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-9"><h5 class="card-title text-left text-primary">New employee</h5></div>
                <div class="col-0"> <button class="btn  btn-danger text-right  text-uppercase " type="button" onclick="close_new_customer()">close</button>
                </div>
            </div>

          <form id="form" class="form-sign" onsubmit="return false;"   >
            <div class="form-label-group">
              <label for="inputNewName"></label>
              <input type="text" id="inputNewName" class="form-control" placeholder="First name"  autofocus>
            </div>
            <div class="form-label-group">
              <label for="inputNewLastName"></label>
              <input type="text" id="inputNewLastName" class="form-control" placeholder="Surname names"  autofocus>
            </div>

            <div class="form-label-group" >
              <label for="inputEmail"></label>
              <input type="email" id="inputEmail" class="form-control" placeholder="* Email address" required autofocus>
            </div>
            <div class="form-label-group" >
                <label for="inputFirm"></label>
                <input type="text" id="inputFirm" class="form-control" placeholder="* Firm name" required autofocus>
            </div>

            <div class="form-label-group">
              <label for="inputPassword"></label>
              <input type="password" id="inputPassword" class="form-control" placeholder="* Password" required>

            </div>
            <div class="form-label-group">
              <label for="inputConfirmPassword"></label>
              <input type="password" id="inputConfirmPassword" class="form-control" placeholder="* Repeat password" required>

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
<?php
}else{
    ?>
    <script>window.open('index.php',"_self");</script>
    <?php
}
?>