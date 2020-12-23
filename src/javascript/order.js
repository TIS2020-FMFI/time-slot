/*
function add_next_employee(){
    document.getElementById('add_employee').style.display = 'none';
    document.getElementById('kamionist2').style.display = 'block';
}
function update_time_slot(){
    //console.log("dasdasdsaasdas");
    document.getElementsByClassName('edit_button')[0].disabled = false;
    document.getElementsByClassName('update_button')[0].disabled = true;
    document.getElementById('EVC').disabled = true;
    document.getElementById('inputNameKamionist1').disabled = true;
    document.getElementById('inputNameKamionist2').disabled = true;
//    if ()

    // ajax poust
}
function edit_time_slot(){
    document.getElementsByClassName('update_button')[0].disabled = false;
    document.getElementsByClassName('edit_button')[0].disabled = true;
    document.getElementById('EVC').disabled = false;
    document.getElementById('inputNameKamionist1').disabled = false;
    document.getElementById('inputNameKamionist2').disabled = false;
}

function update_evc(elem){
    console.log(elem.value);
}

function update_kamionist(elem){
    console.log(elem.value);
}

function request_time_slot(){
    let evc =document.getElementById('EVC');
    let kam1 =document.getElementById('inputNameKamionist1');
    let kam2 =document.getElementById('inputNameKamionist2');
    if (evc.value === '' ){

        evc.style.borderColor = 'red';
    }
    if(kam1.value === ''){
        kam1.style.borderColor = 'red';
    }
    if (evc.value !== '' && kam1.value !== ''){
        $.post('objednavka AJAX/request_time_slot.php',{
            evc:evc.value,
            truck_driver1:kam1.value,
            truck_driver2:kam2.value,
        },function(data){
            if (data){
                if (data === '1111' || data === '111' ){
                    console.log('PRESIEL SUPER V POHODE');
                    window.open('internal_dispatcher.php',"_self");
                }else{
                    console.log('chyba servera');
                }

            }else{
                console.log("chyba v kode");
            }
        });
    }

}
let only_one_request = true;
function close_time_slot(){
    if (only_one_request === true){
        $.post('objednavka AJAX/close_order.php',{
        },function(data){
            if (data){
                //alert("dsadasdsa");
                if (data === '1' ){
                    console.log(1)
                    window.open('internal_dispatcher.php',"_self");
                }else if (data === '2'){
                    console.log(2)
                }else if (data === '4'){
                    console.log(4)
                    window.open('internal_dispatcher.php',"_self");
                    //console.log('sesion nexistuje');
                }else {
                    console.log(3)
                }

            }else{
                console.log(5)
            }
        });
        only_one_request = false;
    }
}

window.addEventListener('beforeunload', (event) => {
    // tento event vie detekovat opustenie stranky nuz funguje len na sipku dopredu a spet nie inak ...
    close_time_slot();
});
*/
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


function make_html_order(data){
    console.log(data);
    evc =document.getElementById('EVC');
    kam1 =document.getElementById('inputNameKamionist1');
    kam2 =document.getElementById('inputNameKamionist2');
    company =document.getElementById('inputNameDopravca');
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
        timer()
        setInterval(timer,1000);
    }
    // console.log(time);
    // let sekundy = time/1000%60+""
    // let minuti = Math.floor(time/1000/60)+"";
    // minuti = minuti.padStart(2, "0");
    // sekundy = sekundy.padStart(2, "0");
    //
    console.log(data['state']);
    if (data['state'] !== 'prepared' && data['state'] !== 'occupied'){
        evc.disabled = true;
        kam1.disabled = true;
        kam2.disabled = true;
        cargo.disabled = true;
        destination.disabled = true;
        cargo.disabled = true;
        company.disabled = true;
    }

    time_of_time_slot.value =  data['start_date_time'];
    ramp.value = 'ramp '+data['id_gate'];
    if (data['evc_truck'] !== null){
        evc.value = data['evc_truck']
    }
    if (data['employee'] !== null){
        company.value = data['employee']
        console.log();

    }

    if (data['truck_driver_1'] !== null){
        kam1.value = data['truck_driver_1']
        document.getElementById('add_employee').style.display = 'none';
        document.getElementById('kamionist2').style.display = 'revert';
    }
    if (data['truck_driver_2'] !== null){
        kam2.value = data['truck_driver_2']


    }
    if (data['cargo'] !== null){
        cargo.value = data['cargo']
    }
    if (data['destination'] !== null){
        destination.value = data['destination']
    }


}
function close_time_slot(){
    $.post('order_AJAX/close_order.php',{
    },function(data){
        console.log(data);
        if (data ){
            //alert("dsadasdsa");
            if (data === '1' ){
                window.open('internal_dispatcher.php',"_self");
            }else if (data === '2'){
                window.open('external_dispatcher.php',"_self");
            }else if (data === '3'){
                console.log('nieco je tuna podivne sem by si nemal nigdy dojst!!! ,  Najskor viprsala session')
            }else if (data === '4'){
                console.log('zle sql')
            }else{
                console.log('niekto sa snazi robit reqest na time slot z vonka')
            }

        }else{
            console.log('VAZNA CHYBA')
        }
    });

}
let go_to_page_by_ro = "";
function load_order(){
    $.post('order_AJAX/load_order.php',{
    },function(data){
        if (data){
            if (data === '2'){
                console.log('wrong sql')
            }else if (data === '3'){
                go_to_page_by_ro = 'external_dispatcher.php';
                //window.open('external_dispatcher.php',"_self");
            }else if (data === '4'){
                go_to_page_by_ro = 'internal_dispatcher.php';
                //window.open('internal_dispatcher.php',"_self");
            }else if (data === '5'){
                go_to_page_by_ro = 'index.php';
            }else{
                // console.log(data);
                setTimeout(make_html_order,250,data);
            }
            console.log("LOAD PAGE ",go_to_page_by_ro)
        }else{
            console.log(5)
        }
    });

}
load_order()
let company_names = [];
function load_all_company(){
    // console.log('dsadsdas');
    $.post('order_AJAX/load_all_company_names.php',{
    },function(data){
        if (data){
            //company_names = data
            if (data === '2'){
                console.log("ZLE SQL")
            }else if (data === '3'){
                console.log("Nemas aktivni time slot")
            }else if (data === '4'){
                console.log("nieco zle sem doslo netusime co / asi niesi prihlaseni")
            }else{
                let elem_selector = document.getElementById('change_select_company');
                for (let i = 0 ;i  < data.length; i++){
                    company_names.push(data[i][0])
                    let option = document.createElement("option");
                    option.className = 'option';
                    option.text = data[i][0];
                    elem_selector.appendChild(option);
                }
                //company_names = data
                //console.log(company_names);
            }
        }
    });

}
load_all_company()
function go_to_role_page(){
    window.open(go_to_page_by_ro,"_self");
}
function add_next_employee(){
    document.getElementById('add_employee').style.display = 'none';
    document.getElementById('kamionist2').style.display = 'block';
}
function show_info(){
    console.log('info');
}
function select_company(elem){
    let input_company = document.getElementById('inputNameDopravca');
    input_company.value = elem.value;
    is_valid_company_name(input_company)
    //console.log(elem.value);
    // change_select_company
    // console.log('select_company');
}
function is_valid_company_name(elem){
    console.log(company_names);
    let elem_selector = document.getElementsByClassName('option');
    for (let index = 0 ; index < elem_selector.length; index++){
        if (elem_selector[index].innerHTML.toLowerCase().includes(elem.value.toLowerCase())){
            elem_selector[index].style.display = 'revert';
        }else{
            elem_selector[index].style.display = 'none';
        }
    }
    if (company_names.indexOf(elem.value) >= 0){
        document.getElementById('correct').style.display = 'revert';
        document.getElementById('incorrect').style.display = 'none';
    }else{
        document.getElementById('correct').style.display = 'none';
        document.getElementById('incorrect').style.display = 'revert';
    }
}
function delete_time_slot(){
    // console.log('dsadsdas');
    console.log(go_to_page_by_ro);
    $.post('order_AJAX/delete_time_slot.php',{
    },function(data){
        if (data){
            //company_names = data
            if (data === '1') {
                console.log("uspesne odstranenie time slotu");
                go_to_page_by_ro = 'internal_dispatcher.php';
                go_to_role_page();
            }else if (data === '2'){
                console.log(" chybne sql");
            }else if (data === '3'){
                console.log("Nemas aktivni time slot alebo niesi Clovek zvnutra (interni dispatcher / administrator)");
            }else{
                console.log("neocakavana chyba nemala by nastat");
            }

        }
    });
}
function request_time_slot(){
    if (evc.value !== '' && kam1.value !== '' && destination.value !== '' && cargo.value !== '' && time !== 0){
        let ramp_value = ramp.value.split(' ');
        $.post('order_AJAX/request_time_slot.php',{
            evc:evc.value,
            kam1:kam1.value,
            kam2:kam2.value,
            destination:destination.value,
            cargo:cargo.value,
            ramp:ramp_value[1],
            company_name:company.value,
        },function(data){
            if (data){
                console.log("DATAAAAA  ",data);
                if (data === '1'  ){
                    console.log('PRESIEL SUPER V POHODE');
                    go_to_page_by_ro = 'external_dispatcher.php';
                    go_to_role_page();
                }else if (data === '11'  ){
                    console.log('PRESIEL SUPER V POHODE');
                    go_to_page_by_ro = 'internal_dispatcher.php';
                    go_to_role_page();
                }else{
                    console.log('chyba servera');
                }

            }else{
                console.log("chyba v kode");
            }
        });
    }else{
        console.log('vypln chybajuce kolonky')
    }
}
function timer(){
    if (time === 0){
        // spusti funkciu na zrusenie time slotu
        console.log('spusti funkciu na zrusenie time slotu');
        // prame otvorenie prislusnej strnky ak je cas uplinie neviem ci je to spravne
        // condition  v close_time_slot == false teda nezmeni stranku ale odstrani time slot s active time slotu
        // cize po refresfi uz buede prazdna stranka
        close_time_slot(false);
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
    evc.disabled = false;
    kam1.disabled = false;
    kam2.disabled = false;
    cargo.disabled = false;
    destination.disabled = false;
    cargo.disabled = false;

    let fro_internal_dispatcher = document.getElementById('change_select_company');
    if (fro_internal_dispatcher !== null){
        console.log('Zmena pre interneho');
        fro_internal_dispatcher.disabled = false;
        company.disabled = false;
    }else{
        console.log('nexistuje');
    }
}

function update_requested_time_slot(){
    if (evc.value !== '' && kam1.value !== '' && destination.value !== '' && cargo.value !== '' && time !== 0){
        let ramp_value = ramp.value.split(' ');
        $.post('order_AJAX/update_request_time_slot.php',{
            evc:evc.value,
            kam1:kam1.value,
            kam2:kam2.value,
            destination:destination.value,
            cargo:cargo.value,
            ramp:ramp_value[1],
            company_name:company.value,
        },function(data){
            if (data){
                console.log("DATAAAAA  ",data);
                if (data === '1'  ){
                    //console.log('PRESIEL SUPER V POHODE');
                    go_to_page_by_ro = 'external_dispatcher.php';
                    go_to_role_page();
                }else if (data === '11'  ){
                    //console.log('PRESIEL SUPER V POHODE');
                    go_to_page_by_ro = 'internal_dispatcher.php';
                    go_to_role_page();
                }else{
                    console.log('chyba servera');
                }

            }else{
                console.log("chyba v kode");
            }
        });
    }else{
        console.log('vypln chybajuce kolonky')
    }
}
function delete_requested_time_slot(){

    $.post('order_AJAX/delete_requested_time_slot.php',{
    },function(data){
        if (data){
            //console.log("DATAAAAA  ",data);
            if (data === '1'  ){
                go_to_page_by_ro = 'external_dispatcher.php';
                go_to_role_page();
            }else if (data === '2'  ){
                go_to_page_by_ro = 'internal_dispatcher.php';
                go_to_role_page();
            }else if (data === '3'  ){
                console.log('neznami pouzivatel');
            }else if (data === '4'  ){
                console.log('neznami pouzivatel');
            }else if (data === '5'  ){
                console.log('neznami pouzivatel');
            }else if (data === '6'  ){
                console.log('neznami pouzivatel');
            }else{
                console.log("chyba v kode    ",data);
            }

        }else{
            console.log("nepresiel request");
        }
    });

}
function confirm_requested_time_slot(){
    $.post('order_AJAX/confirm_requested_time_slot.php',{
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