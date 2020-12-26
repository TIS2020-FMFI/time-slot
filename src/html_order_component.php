<?php
//session_start();
if (($_SESSION['role'] == "EXD" || $_SESSION['role'] == "IND" || $_SESSION['role'] == "AD") && $_SESSION['active_time_slot'] != ''  ){
?>

<form class="form-sign" onsubmit="return false" >
    <div class="form-label-group">
        <label for="inputTimeSlot"></label>
        <input type="text" id="inputTimeSlot" class="form-control" placeholder="DATE (HH:MM - HH:MM)" value="time" disabled required >
    </div>
    <?php
    if ($_SESSION['role'] == "EXD" ){
        ?>
        <div class="form-label-group">
            <label for="inputNameDopravca"></label>
            <input type="text" id="inputNameDopravca" class="form-control" placeholder="* Meno spolocnosti" value="" disabled required >
        </div>
    <?php
    }elseif (($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") && $_SESSION['active_time_slot_state'] != 'prepared' && $_SESSION['active_time_slot_state'] != 'occupied'){
        ?>
        <div class="form-label-group" style="display: flex;margin-top: 22px">
            <label for="inputNameDopravca"></label>
            <input type="text" id="inputNameDopravca" class="form-control" placeholder="* Meno spolocnosti" value=""  oninput="is_valid_company_name(this)" disabled required autofocus >
            <label for="change_select_company"></label><select class="form-control" id="change_select_company" onchange="select_company(this)" style="max-width: 5%" disabled>
                <option class="option">''</option>
            </select>
            <img src="incorrect_sign_info.png" width="32" style="display: none" id="incorrect" alt="info">
            <img src="correct_sign_info.png" width="32" style="display: flex;" id="correct" alt="info">
        </div>
        <?php
    }elseif ($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND" && ($_SESSION['active_time_slot_state'] == 'prepared' || $_SESSION['active_time_slot_state'] == 'occupied')    ){
        ?>
        <div class="form-label-group" style="display: flex;margin-top: 22px">
            <label for="inputNameDopravca"></label>
            <input type="text" id="inputNameDopravca" class="form-control" placeholder="* Meno spolocnosti" value=""  oninput="is_valid_company_name(this)" required autofocus >
            <label for="change_select_company"></label><select class="form-control" id="change_select_company" onchange="select_company(this)" style="max-width: 5%">
                <option class="option">''</option>
            </select>
            <img src="incorrect_sign_info.png" width="32" style="display: flex " id="incorrect" alt="info">
            <img src="correct_sign_info.png" width="32" style="display: none;" id="correct" alt="info">
        </div>
    <?php
    }else{
        echo "Something went wrong";
    }
    ?>

    <div class="form-label-group">
        <label for="inputNakladka"></label>
        <input type="text" id="inputNakladka" class="form-control" placeholder="Nákladka" value="ramp_number" disabled required >
    </div>
    <div class="form-label-group">
        <label for="EVC"></label>
        <input type="text" id="EVC" class="form-control" placeholder="* Evidenčné číslo kamiónu"  value="" required autofocus>
    </div>
    <div class="form-label-group" >
        <label for="inputNameKamionist1"></label>
        <input type="text" id="inputNameKamionist1" class="form-control" placeholder="* Meno Kamionistu" value=""  required autofocus>
    </div>
    <div id="kamionist2" class="form-label-group" >
        <label for="inputNameKamionist2"></label>
        <input type="text" id="inputNameKamionist2" class="form-control" placeholder="* Meno Kamionistu 2" value="" required autofocus>
    </div>




    <button id="add_employee" class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="add_next_employee()">+</button>

    <div id="destination" class="form-label-group" >
        <label for="inputDestination"></label>
        <input type="text" id="inputDestination" class="form-control" placeholder="* Destinacia" value="" required autofocus>
    </div>

    <div id="cargo" class="form-label-group" >
        <label for="inputCargo"></label>
        <input type="text" id="inputCargo" class="form-control" placeholder="* Cargo" value="" required autofocus>
    </div>
    <?php
        if (($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") &&  $_SESSION['active_time_slot_state'] == 'prepared'){
            ?>
            <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="request_time_slot()">Create</button>
            <button class="btn btn-lg btn-danger  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="delete_time_slot()">Delete</button>
            <?php
        }else if ($_SESSION['role'] == "EXD" &&  $_SESSION['active_time_slot_state'] == 'prepared'){
            ?>
            <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="request_time_slot()">Create</button>
            <?php
        }else if (($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") &&  $_SESSION['active_time_slot_state'] == 'requested'){
            ?>

            <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="confirm_requested_time_slot()">confirm</button>
            <button class="btn btn-lg btn-primary  text-uppercase internal_dispatcher edit_button buttons" type="button" id="edit_button" onclick="edit_requested_time_slot()">edit</button>
            <button class="btn btn-lg btn-primary  text-uppercase internal_dispatcher edit_button buttons" type="button" id="update_button" onclick="update_requested_time_slot()" disabled>update</button>
            <button class="btn btn-lg btn-danger  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="delete_requested_time_slot()">Delete</button>
            <?php
        }else if ($_SESSION['role'] == "EXD" &&  $_SESSION['active_time_slot_state'] == 'requested'){
            ?>
            <button class="btn btn-lg btn-primary  text-uppercase internal_dispatcher edit_button buttons" type="button" id="edit_button" onclick="edit_requested_time_slot()">edit</button>
            <button class="btn btn-lg btn-primary  text-uppercase internal_dispatcher edit_button buttons" type="button" id="update_button" onclick="update_requested_time_slot()" disabled>update</button>
            <button class="btn btn-lg btn-danger  text-uppercase internal_dispatcher edit_button buttons" type="button" onclick="delete_requested_time_slot()">Delete</button>
            <?php
        }else if (($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") &&  $_SESSION['active_time_slot_state'] == 'booked'){
            ?>
            <button class="btn btn-lg btn-success  text-uppercase internal_dispatcher edit_button buttons" type="button" id="edit_button" onclick="confirm_booked_time_slot()">confirm</button>
            <?php
        }
    ?>
</form>
<?php
}else{
    echo '<h1 class=" text-danger text-center" > ERROR</h1>';
}
?>