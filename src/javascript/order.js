let evc ;
let kam1 ;
let kam2 ;
let time_of_time_slot ;
let cargo ;
let destination ;
let ramp ;
let company;
let time ;
let html_timer ;
let company_email;


function make_html_order(data){
    console.log(data);
    evc =document.getElementById('EVC');
    kam1 =document.getElementById('inputNameKamionist1');
    kam2 =document.getElementById('inputNameKamionist2');
    company =document.getElementById('inputNameDopravca');
    company_email = document.getElementById('inputNameDopravca_email');
    time_of_time_slot =document.getElementById('inputTimeSlot');
    cargo =document.getElementById('inputCargo');
    destination =document.getElementById('inputDestination');
    ramp =document.getElementById('inputNakladka');

    time = Math.abs(new Date(data['now_time']) - new Date(data['ocupide_end_time'])   );
    if (new Date(data['now_time']) > new Date(data['ocupide_end_time'])){
        time = 0;
    }else{
        time = time -5000; // 5 sekud preto aby bolo validne sql to znamena ze sa naozaj aj upravia time sloti do DEFFOULT PODOBY
        html_timer = document.getElementById('timer');
        timer();
        setInterval(timer,1000);
    }
    //console.log(data['state']);
    if (data['state'] !== 'prepared' && data['state'] !== 'occupied'){
        evc.disabled = true;
        kam1.disabled = true;
        kam2.disabled = true;
        cargo.disabled = true;
        destination.disabled = true;
        cargo.disabled = true;
        company.disabled = true;
        if (company_email !== null){
            company_email.disabled = true;
        }
    }

    time_of_time_slot.value =  data['start_date_time'];
    ramp.value = 'ramp '+data['id_gate'];
    if (data['evc_truck'] !== null){
        evc.value = data['evc_truck'];
    }
    if (data['employee'] !== null){
        company.value = data['employee'];
    }
    if (data['employee_email'] !== null){
        if (company_email !== null){
            company_email.value = data['employee_email'];
        }

    }

    if (data['truck_driver_1'] !== null){
        kam1.value = data['truck_driver_1']
        document.getElementById('add_employee').style.display = 'none';
        document.getElementById('kamionist2').style.display = 'revert';
    }
    if (data['truck_driver_2'] !== null){
        kam2.value = data['truck_driver_2'];


    }
    if (data['cargo'] !== null){
        cargo.value = data['cargo'];
    }
    if (data['destination'] !== null){
        destination.value = data['destination'];
    }
    if (company_email !== null) {
        select_company(company);
        select_email(company_email);
    }


}

function close_time_slot_in_order(){
    $.post('order_AJAX/close_order.php',{
    },function(data){
        if (data ){
            if (data === '1' ){
                window.open('internal_dispatcher.php',"_self");
            }else if (data === '2'){
                window.open('external_dispatcher.php',"_self");
            }else{
                create_exception(data,5,'danger');
            }

        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });

}
let go_to_page_by_ro = "";
function load_order(){
    $.post('order_AJAX/load_order.php',{
    },function(data){
        if (data){
            if (typeof data === 'object'){
                setTimeout(make_html_order,250,data);
            }else if (data === '1' ){
                create_exception('You do not have any time-slot opened at the moment. You can <a href="#" onclick="window.open(\'internal_dispatcher.php\',\'_self\')">choose one</a>.',9999,'warning');
            }else if (data === '2'){
                create_exception('You do not have any time-slot opened at the moment. You can <a href="#" onclick="window.open(\'external_dispatcher.php\',\'_self\')">choose one</a>.',9999,'warning');
            }else{
                create_exception(data,5,'danger');
            }

            }else{
                create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
            }
    });

}
setTimeout(load_order,250);
let company_names = [];
let company_employee_email_address = [];
let jason_object_of_email_and_employee_company = undefined
function load_all_company(){
    // console.log('dsadsdas');
    $.post('order_AJAX/load_all_company_names.php',{
    },function(data){
        console.log(data);
        if (typeof data === 'object'){
            let set_of_employee_company = new Set();
            for (let i = 0 ;i  < data.length; i++){
                set_of_employee_company.add(data[i][0]);
                company_employee_email_address.push(data[i][1]);
            }
            company_names  = Array.from(set_of_employee_company);
            let elem_selector = document.getElementById('change_select_company');
            for (let i = 0 ;i  < company_names.length; i++){
                let option = document.createElement("option");
                option.className = 'option';
                option.checked = false;
                option.text = company_names[i];
                elem_selector.appendChild(option);
            }
            console.log(company_employee_email_address);
            let elem_selector_email = document.getElementById('change_select_company_email');
            for (let i = 0 ; i  < company_employee_email_address.length; i++){
                let option = document.createElement("option");
                option.className = 'option_email';
                option.checked = false;
                option.text = company_employee_email_address[i];
                elem_selector_email.appendChild(option);
            }
            console.log(company_names);
            jason_object_of_email_and_employee_company = data;

        }else if(data.includes('*')){
            create_exception(data ,23,'warning');
        }else if(data !== ''){

        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });

}
setTimeout(load_all_company,250);

function go_to_role_page(){
    window.open(go_to_page_by_ro,"_self");
}
function add_next_employee(){
    document.getElementById('add_employee').style.display = 'none';
    document.getElementById('kamionist2').style.display = 'block';
}
function reset_selected_value(){
    document.getElementsByClassName('option')[0].selected = true;
    document.getElementsByClassName('option_email')[0].selected = true;
}
function select_company(elem){
    console.log('SELECTED BY COMPANY NAME  ',elem.value);
    let input_company = document.getElementById('inputNameDopravca');
    input_company.value = elem.value;
    is_valid_company_name(input_company);
    reset_selected_value();

}
function select_email(elem){
    console.log('SELECTED BY COMPANY NAME EMAIL ');
    let input_email = document.getElementById('inputNameDopravca_email');
    input_email.value = elem.value;
    is_valid_company_email(input_email);
    reset_selected_value();

}
function is_valid_company_name(elem){
    console.log("CHCEK VALIDITI NAME COMPANY");
    let elem_selector = document.getElementsByClassName('option');
    for (let index = 0 ; index < elem_selector.length; index++){
        if (elem_selector[index].innerHTML.toLowerCase().includes(elem.value.toLowerCase())){
            elem_selector[index].style.display = 'revert';
        }else{
            elem_selector[index].style.display = 'none';
        }
    }
    if (company_names.indexOf(elem.value) < 0){
        document.getElementById('correct').style.display = 'none';
        document.getElementById('incorrect').style.display = 'revert';
    }else{
        document.getElementById('correct').style.display = 'revert';
        document.getElementById('incorrect').style.display = 'none';
    }
    // compare_bout(elem.value,document.getElementById('inputNameDopravca_email').value);
    select_company_email_only(elem.value);
    reset_selected_value();

}
function is_valid_company_email(elem){
    console.log("CHCEK VALIDITI EMAIL");
    let elem_selector = document.getElementsByClassName('option_email');
    for (let index = 0 ; index < elem_selector.length; index++){
        if (elem_selector[index].innerHTML.toLowerCase().includes(elem.value.toLowerCase())){
            elem_selector[index].style.display = 'revert';
        }else{
            elem_selector[index].style.display = 'none';
        }
    }
    if (company_employee_email_address.indexOf(elem.value) < 0){
        document.getElementById('correct_email').style.display = 'none';
        document.getElementById('incorrect_email').style.display = 'revert';
    }else{
        document.getElementById('correct_email').style.display = 'revert';
        document.getElementById('incorrect_email').style.display = 'none';
    }
    // compare_bout(document.getElementById('inputNameDopravca').value,elem.value);
    set_company_name(elem.value);
    reset_selected_value();
}
function set_company_name(email){
    if (company_names.includes(document.getElementById('inputNameDopravca').value) ){ // && email === ''
        console.log('NASTAV MENO EMPTY EMAIL AND INCLUDES');
        let elem_selector_for_email = document.getElementsByClassName('option_email');
        for (let index = 0; index < jason_object_of_email_and_employee_company.length; index++) {
            if (jason_object_of_email_and_employee_company[index][0] === document.getElementById('inputNameDopravca').value &&
                elem_selector_for_email[index + 1].innerHTML.toLowerCase().includes(email.toLowerCase())) {
                elem_selector_for_email[index + 1].style.display = 'revert';
            } else {
                elem_selector_for_email[index + 1].style.display = 'none';
            }
        }
    }else if (email === ''){
        console.log('NASTAV MENO EMPTY EMAIL');
        let elem_selector_for_company_name = document.getElementsByClassName('option');
        for (let index = 0 ; index < elem_selector_for_company_name.length; index++) {
            elem_selector_for_company_name[index].style.display = 'revert';
        }
    }else{
        console.log('NASTAV MENO ',email,jason_object_of_email_and_employee_company);
        let elem_selector_for_email = document.getElementsByClassName('option');
        for (let index = 0 ; index < jason_object_of_email_and_employee_company.length; index++) {
            if (jason_object_of_email_and_employee_company[index][1] === email ) {
                elem_selector_for_email[index].style.display = 'revert';
                console.log('SELECTED BY EMAIL   ',elem_selector_for_email[index].innerHTML , company_names.indexOf(jason_object_of_email_and_employee_company[index][0]) , elem_selector_for_email[company_names.indexOf(jason_object_of_email_and_employee_company[index][0])]);

                let selector_of_company_name = document.getElementById('change_select_company');
                selector_of_company_name.selectedIndex  = company_names.indexOf(jason_object_of_email_and_employee_company[index][0]) +1;
                select_company(selector_of_company_name);// magic constant 1  because one empty option

            }else{
                //elem_selector_for_email[index].style.display = 'none';
            }
        }
    }

}
function select_company_email_only(company_name){
    if (company_names.includes(company_name) ) {
        console.log("VIBER LEN EMAIL S DANIMI FIRMAMI");
        let elem_selector_for_email = document.getElementsByClassName('option_email');
        for (let index = 0; index < jason_object_of_email_and_employee_company.length; index++) {
            if (jason_object_of_email_and_employee_company[index][0] === company_name) {
                elem_selector_for_email[index + 1].style.display = 'revert';
            } else {
                elem_selector_for_email[index + 1].style.display = 'none';
            }
        }
    }else if (company_name === ''){
        console.log("NASTAV MENO EMPTY EMAIL SELECTOR");
        let elem_selector_for_email = document.getElementsByClassName('option_email');
        for (let index = 0 ; index < elem_selector_for_email.length; index++) {
            elem_selector_for_email[index].style.display = 'revert';
        }
    }
    else{
        console.log("NASTAV MENO ELSE  EMAIL SELECTOR");
        let elem_selector_for_email = document.getElementsByClassName('option_email');
        for (let index = 0 ; index < elem_selector_for_email.length; index++) {
            elem_selector_for_email[index].style.display = 'revert';
        }
    }

}
function restart_inputs_company_name_email(){
    company.value = '';
    company_email.value = '';
    let elem_selector_for_email = document.getElementsByClassName('option_email');
    for (let index = 0 ; index < elem_selector_for_email.length; index++) {
        elem_selector_for_email[index].style.display = 'revert';
    }
    let elem_selector_company_name = document.getElementsByClassName('option');
    for (let index = 0 ; index < elem_selector_company_name.length; index++) {
        elem_selector_company_name[index].style.display = 'revert';
    }
}
function delete_time_slot(){
    $.post('order_AJAX/delete_time_slot.php',{
    },function(data){
        if (data ){
            if (data === '1' ){
                window.open('internal_dispatcher.php',"_self");
            }else if (data !== ''){
                create_exception(data,55,'danger');
            }
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
}
function request_time_slot(){
    if (evc.value !== '' && kam1.value !== '' && destination.value !== '' && cargo.value !== '' && time !== 0 ){
        if (is_correct_name_for_driver(kam1.value) || is_correct_name_for_driver(kam2.value)){ // sem treba pridat kontroli na evc destinaciu a cargo
            return ;
        }

        if (company_names.length > 0){
            if (company_names.includes(company.value) === false){
                create_exception("The <strong>company name</strong> you entered was not found.",13,'warning');
                return ;
            }
            if (company_employee_email_address.includes(company_email.value) === false){
                create_exception("The <strong>company name</strong> you entered was not found.",13,'warning');
                return ;
            }
        }
        let ramp_value = ramp.value.split(' ');
        console.log(((company_email === null) ? 'null' : company_email.value ) );
        $.post('order_AJAX/request_time_slot.php',{
            evc:evc.value,
            kam1:kam1.value,
            kam2:kam2.value,
            destination:destination.value,
            cargo:cargo.value,
            ramp:ramp_value[1],
            company_name:company.value,
            company_email:((company_email === null) ? 'null' : company_email.value )
        },function(data){
            if (data){
                if (data === '1' ){
                    window.open('internal_dispatcher.php',"_self");
                }else if (data === '2'){
                    window.open('external_dispatcher.php',"_self");
                }else if (data.includes( '*')){
                    create_exception(data.slice(1,data.length),8,'warning');
                    restart_inputs_company_name_email();

                }else{
                    create_exception(data,65,'danger');
                }

            }else{
                create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
            }
        });
    }else{
        create_exception("All fields marked with <strong>*</strong> are required.",13,'warning');
    }
}
function timer(){
    if (time === 0){
        // spusti funkciu na zrusenie time slotu
        console.log('spusti funkciu na zrusenie time slotu');
        // prame otvorenie prislusnej strnky ak je cas uplinie neviem ci je to spravne
        // condition  v close_time_slot == false teda nezmeni stranku ale odstrani time slot s active time slotu
        // cize po refresfi uz buede prazdna stranka
        close_time_slot_in_order(false);
        time -= 1000;
    }else if (time > 1){
        console.log('timer ')
        time -= 1000;
        let sekundy = time/1000%60+""
        let minuti = Math.floor(time/1000/60)+"";

        if (minuti < 3){
            html_timer.className = 'text-danger';
        }else if (minuti < 5){
            html_timer.className = 'text-warning';
        }else{
            html_timer.className = 'text-success';
        }
        minuti = minuti.padStart(2, "0");
        sekundy = sekundy.padStart(2, "0");
        html_timer.innerHTML = minuti +':'+sekundy;
    }else{
        console.log('somthing went wrong');
    }
    // odrataj po kazdej sekunde s
}
function edit_requested_time_slot(){
    document.getElementById('update_button').disabled = false;
    document.getElementById('edit_button').disabled = true;
    if (document.getElementById('confirm_button') !== null){
        document.getElementById('confirm_button').disabled = true;
    }
    evc.disabled = false;
    kam1.disabled = false;
    kam2.disabled = false;
    cargo.disabled = false;
    destination.disabled = false;
    cargo.disabled = false;
    if (document.getElementById('confirm_button') !== null){
        company_email.disabled = false;
    }

    let for_internal_dispatcher_company_name = document.getElementById('change_select_company');
    if (for_internal_dispatcher_company_name !== null){
        console.log('Zmena pre interneho');
        for_internal_dispatcher_company_name.disabled = false;
        company.disabled = false;
    }else{
        console.log('nexistuje');
    }
    let for_internal_dispatcher_email = document.getElementById('change_select_company_email');
    if (for_internal_dispatcher_email !== null){
        console.log('Zmena pre interneho');
        for_internal_dispatcher_email.disabled = false;
        company.disabled = false;
    }else{
        console.log('nexistuje');
    }
}

function update_requested_time_slot(){
    if (evc.value !== '' && kam1.value !== '' && destination.value !== '' && cargo.value !== '' && time !== 0){
        if (is_correct_name_for_driver(kam1.value) || is_correct_name_for_driver(kam2.value)){ // sem treba pridat kontroli na evc destinaciu a cargo
            return ;
        }
        if (company_names.length > 0){
            if (company_names.includes(company.value) === false){
                create_exception("The <strong>company name</strong> you entered was not found.",13,'warning');
                return ;
            }
            if (company_employee_email_address.includes(company_email.value) === false){
                create_exception("The <strong>company name</strong> you entered was not found.",13,'warning');
                return ;
            }
        }
        let ramp_value = ramp.value.split(' ');
        $.post('order_AJAX/update_request_time_slot.php',{
            evc:evc.value,
            kam1:kam1.value,
            kam2:kam2.value,
            destination:destination.value,
            cargo:cargo.value,
            ramp:ramp_value[1],
            company_name:company.value,
            company_email:((company_email === null) ? 'null' : company_email.value )
        },function(data){
            if (data){
                if (data === '1' ){
                    window.open('internal_dispatcher.php',"_self");
                }else if (data === '2'){
                    window.open('external_dispatcher.php',"_self");
                }else if (data.includes( '*')){
                    create_exception(data.slice(1,data.length),8,'warning');
                    restart_inputs_company_name_email();
                }else{
                    create_exception(data,65,'danger');
                }

            }else{
                create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
            }
        });
    }else{
        create_exception("prosim vypln chybajuce kolonky z <strong>*</strong>",13,'warning');
    }
}
function delete_requested_time_slot(){
    $.post('order_AJAX/delete_requested_time_slot.php',{
    },function(data){
        if (data ){
            if (data === '1' ){
                window.open('internal_dispatcher.php',"_self");
            }else if (data === '2'){
                window.open('external_dispatcher.php',"_self");
            }else{
                create_exception(data,5,'danger');
            }

        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });

}
function confirm_requested_time_slot(){
    $.post('order_AJAX/confirm_requested_time_slot.php',{
    },function(data){
        if (data ){
            if (data === '1' ){
                window.open('internal_dispatcher.php',"_self");
            }else if (data !== ''){
                create_exception(data,55,'danger');
            }
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
}
function confirm_booked_time_slot(){
    $.post('order_AJAX/confirm_booked_time_slot.php',{
    },function(data){
        if (data){
            if (data === '1'  ){
                go_to_page_by_ro = 'internal_dispatcher.php';
                go_to_role_page();
            }else if (data === '2'  ){
                console.log('chyba sql');
            }else if (data === '3'  ){
                console.log('chyba user');
            }

        }else{
            console.log("chyba servera");
        }
    });
}
