<?php
session_start();
include('db.php');
// $_SESSION['active_time_slot2'] != []
//if ($_SESSION['active_time_slot'] != []){
//    include('objednavka AJAX/alert_if_occupied.php');
//}
if ($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'EXD'  ) {

        if (!$mysqli->connect_errno) {
            // komplexne sql ktorim sa da ziskat vsetky dedene data s
            $sql = "SELECT 
                    t.id as `id_of_time_slot`,
                    t.id_gate as `ramp_number`,
                    (select CONCAT(e.meno,' ',e.priezvisko) as `meno` from `employee` as e  where id=t.id_external_dispatcher) as `full_name_of_dispatcher` ,
                    CONCAT((select CONCAT(meno,' ',priezvisko) from `employee` where id=id_truck_driver_1),'$',(select CONCAT(meno,' ',priezvisko) from `employee` where id=id_truck_driver_2)) as `all_names_of_truck_drivers`,
                    t.evc_truck as `truck_evc`,
                    CONCAT(date_format(t.start_date_time, '%Y %M %D  ( %H:%i -'),' ',date_format(t.end_date_time, '%H:%i )')) as `time_of_time_slot`,
                    t.state as `time_slot_state`
                    FROM `time_slot` as t  WHERE id={$_SESSION['active_time_slot']}";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                $vystup = $result->fetch_assoc(); //result->fetch_all(); --> returns arrry object
                $result->free();

                $sql2 = "SELECT * FROM `time_slot`  WHERE id={$_GET['id_of_time_slot']}";
                if ($result2 = $mysqli->query($sql2)) {
                    $vystup2 = $result2->fetch_assoc(); //result->fetch_all();
                    //json_encode($vystup2[0]);

                    $_SESSION['active_time_slot'] = $vystup2;

                    //echo $_SESSION['active_time_slot']['id'];
                }else{
                    echo "CHyBA";
                }
                if ($vystup['time_slot_state'] == 'prepared'){
                    //echo $vystup['time_slot_state'];
                    $sql3 = "UPDATE `time_slot`  SET state='occupied' WHERE id={$_GET['id_of_time_slot']}";
                    if ($result3 = $mysqli->query($sql3)) {

                        //echo "occupied";
                    }else{
                        echo "CHyBA";
                    }
                }
                //echo $vystup['id_of_time_slot'];

                //echo json_encode($result);




?>
<!doctype html>
<html lang="en">
                <?php
                $page = 'order_page';
                include('html_head_component.php');
                ?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card card-signin my-5 ">
        <div class="card-body">
            <div class="row">
                <div class="col-9"><h5 class="card-title text-center text-primary">PRODUCT EXPORT DOCUMENT</h5></div>
                <div class="col-1"> <button class="btn  btn-danger  text-uppercase " type="button" onclick="close_time_slot()" style="width: auto;margin: auto;">close</button>
                </div>
            </div>
            <!--<div class="row" style="display:flex;">
                <h6 class="card-title text-center text-primary" style="margin-left: 20px;">PRODUCT EXPORT DOCUMENT</h6>
            </div> -->

          <form class="form-sign" onsubmit="return false" >
            <div class="form-label-group">
              <label for="inputNameDopravca"></label>
              <input type="text" id="inputTimeSlot" class="form-control" placeholder="DATE (HH:MM - HH:MM)" value="<?php echo $vystup['time_of_time_slot']?>" disabled required >
            </div>
              <?php
              if ($vystup['full_name_of_dispatcher'] != '' && $vystup['time_slot_state'] == 'prepared'){
                  ?>
                  <div class="form-label-group">
                      <label for="inputNameDopravca"></label>
                      <input type="text" id="inputNameDopravca" class="form-control" placeholder="Meno Dopravcu" value="<?php echo $vystup['full_name_of_dispatcher']?>" disabled required >
                  </div>
                  <?php
              }else{
                  ?>
                  <div class="form-label-group">
                      <label for="inputNameDopravca"></label>
                      <input type="text" id="inputNameDopravca" class="form-control" placeholder="Meno Dopravcu" value="<?php echo $_SESSION['meno'].' '.$_SESSION['priezvisko'] ?>" disabled required >
                  </div>
                  <?php
              }
              ?>

            <div class="form-label-group">
              <label for="inputNakladka"></label>
              <input type="text" id="inputNakladka" class="form-control" placeholder="Nakldka" value="<?php echo 'ramp number '.$vystup['ramp_number']?>" oninput=update_evc(this) disabled required >
            </div>
              <?php
              if ($vystup['truck_evc'] != '' &&  $vystup['time_slot_state'] == 'requested' ){
                  ?>
                  <div class="form-label-group">
                      <label for="EVC"></label>
                      <input type="text" id="EVC" class="form-control" placeholder="Evidencne cislo kamionu"  value="<?php echo $vystup['truck_evc']?>" oninput=update_evc(this) disabled required autofocus>
                  </div>
                  <?php
              }else if ($vystup['time_slot_state'] == 'prepared'){
                  ?>
                  <div class="form-label-group">
                      <label for="EVC"></label>
                      <input type="text" id="EVC" class="form-control" placeholder="Evidencne cislo kamionu"  value="" required autofocus>
                  </div>
                  <?php
              }else{
                  ?>
                  <div class="form-label-group">
                      <label for="EVC"></label>
                      <input type="text" id="EVC" class="form-control" placeholder="Evidencne cislo kamionu"  value="<?php echo $vystup['truck_evc']?>" oninput=update_evc(this) disabled required autofocus>
                  </div>
                  <?php
              }
              ?>
              <?php
              if ($vystup['time_slot_state'] == 'prepared' ){
                  ?>
                  <div class="form-label-group" >
                      <label for="inputNameKamionist1"></label>
                      <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value=""  required autofocus>
                  </div>

                  <div id="kamionist2" class="form-label-group" >
                      <label for="inputNameKamionist2"></label>
                      <input type="text" id="inputNameKamionist2" class="form-control" placeholder="Meno Kamionistu" value="" required autofocus>
                  </div>

                  <button id="add_employee" class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="add_next_employee()">+</button>
                  <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="request_time_slot()">Create</button>


                  <?php
              }else if($vystup['time_slot_state'] == 'requested' ){
                  if (strpos($vystup['all_names_of_truck_drivers'], '$')){
                      $first_full_name = explode("$", $vystup['all_names_of_truck_drivers'])[0];
                      $second_full_name = explode("$", $vystup['all_names_of_truck_drivers'])[1];
                      ?>
                      <div class="form-label-group" >
                          <label for="inputNameKamionist1"></label>
                          <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $first_full_name?>" oninput=update_kamionist(this) disabled required autofocus>
                      </div>

                      <div id="kamionist2" class="form-label-group"  style="display: revert">
                          <label for="inputNameKamionist2"></label>
                          <input type="text" id="inputNameKamionist2" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $second_full_name?>" oninput=update_kamionist(this) disabled required autofocus>
                      </div>
                      <?php
                      if (($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND') == false){
                      ?>
                      <div class="row buttons">
                          <div class="col">
                              <button class="btn  btn-primary  text-uppercase internal_dispatcher edit_button" type="submit" onclick="edit_time_slot()">edit</button>
                          </div>
                          <div class="col">
                              <button class="btn  btn-success  text-uppercase internal_dispatcher update_button" type="submit" onclick="update_time_slot()" disabled>update</button>
                          </div>
                          <div class="col">
                              <button class="btn  btn-danger  text-uppercase internal_dispatcher" type="submit" onclick="delete_time_slot()">delete</button>
                          </div>
                      </div>
                      <?php
                      }
                  }else{
                      ?>
                      <div class="form-label-group" >
                          <label for="inputNameKamionist1"></label>
                          <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $vystup['all_names_of_truck_drivers']?>" oninput=update_kamionist(this) disabled required autofocus>
                      </div>

                      <div id="kamionist2" class="form-label-group" >
                          <label for="inputNameKamionist2"></label>
                          <input type="text" id="inputNameKamionist2" class="form-control" placeholder="Meno Kamionistu" value=""   oninput=update_kamionist(this) required autofocus>
                      </div>
                      <div class="row buttons">
                          <div class="col">
                              <button id="add_employee" class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="add_next_employee()">+</button>
                          </div>
                          <?php
                            if (($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND') == false){
                          ?>
                          <div class="col">
                              <button class="btn  btn-primary  text-uppercase internal_dispatcher edit_button" type="submit" onclick="edit_time_slot()">edit</button>
                          </div>
                          <div class="col">
                              <button class="btn  btn-success  text-uppercase internal_dispatcher update_button" type="submit" onclick="update_time_slot()" disabled>update</button>
                          </div>
                          <div class="col">
                              <button class="btn  btn-danger  text-uppercase internal_dispatcher" type="submit" onclick="delete_time_slot()">delete</button>
                          </div>
                          <?php
                            }
                          ?>
                      </div>

                      <?php
                  }
              }else{
                  if (strpos($vystup['all_names_of_truck_drivers'], '$')){
                      $first_full_name = explode("$", $vystup['all_names_of_truck_drivers'])[0];
                      $second_full_name = explode("$", $vystup['all_names_of_truck_drivers'])[1];
                      ?>
                      <div class="form-label-group" >
                          <label for="inputNameKamionist1"></label>
                          <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $first_full_name?> " oninput=update_kamionist(this) disabled required autofocus>
                      </div>

                      <div id="kamionist2" class="form-label-group"  style="display: revert">
                          <label for="inputNameKamionist2"></label>
                          <input type="text" id="inputNameKamionist2" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $second_full_name?>" oninput=update_kamionist(this) disabled required autofocus>
                      </div>
                      <?php
                  }else{
                      ?>
                      <div class="form-label-group" >
                          <label for="inputNameKamionist1"></label>
                          <input type="text" id="inputNameKamionist1" class="form-control" placeholder="Meno Kamionistu" value="<?php echo $vystup['all_names_of_truck_drivers']?>" oninput=update_kamionist(this) disabled required autofocus>
                      </div>
                      <?php
                  }
              }
              ?>

                <?php if (($_SESSION['role'] == 'AD' || $_SESSION['role'] == 'IND') && $vystup['time_slot_state'] != 'prepared'){
                    ?>
                    <!-- Tato cast je zobrazena adminovi alebo internemu dispatcherovi-->
                    <div class="row buttons">
                        <?php if ($vystup['time_slot_state'] == 'requested'){
                            ?>
                            <div class="col">
                                <button class="btn  btn-success  text-uppercase internal_dispatcher" type="submit" onclick="">Verify</button>
                            </div>
                            <div class="col">
                                <button class="btn  btn-primary  text-uppercase internal_dispatcher edit_button" type="submit" onclick="edit_time_slot()">edit</button>
                            </div>
                            <div class="col">
                                <button class="btn  btn-danger  text-uppercase internal_dispatcher" type="submit" onclick="delete_time_slot()">delete</button>
                            </div>
                        <?php
                        }else if($vystup['time_slot_state'] == 'booked') {?>
                        <div class="col">
                            <button class="btn  btn-primary  text-uppercase internal_dispatcher edit_button" type="submit" onclick="edit_time_slot()">edit</button>
                        </div>
                        <div class="col">
                            <button class="btn  btn-danger  text-uppercase internal_dispatcher" type="submit" onclick="delete_time_slot()">delete</button>
                        </div>
                    </div>
                    <?php
                    }
                    }
              ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<!-- Our JavaScript -->
<script type="text/javascript" src="javascript/order.js"></script>
</html>
<?php
    } else {
        echo '<h1 class="text-danger">Nastala chyba pri získavaní údajov z DB.</h1>' . "\n";
    }
}else{
        echo '<h1 class="text-danger">Nastala chyba MYSQLY databzaza nieje k dispoziciji</h1>' . "\n";
    }
}
?>