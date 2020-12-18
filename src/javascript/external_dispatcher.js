function loop(){
    console.log(window.innerWidth);
    if (window.innerWidth < 500){
        let all_elements_p = document.querySelectorAll('p');
        for (let i = 0 ;i < all_elements_p.length;i++){
            all_elements_p[i].style.fontSize = "10px";
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "0px";
        }
    }else{
        let all_elements_p = document.querySelectorAll('p');
        for (let i = 0 ;i < all_elements_p.length;i++){
            all_elements_p[i].style.fontSize = "18px";
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "10px";
        }
    }
    setTimeout(loop,500);
}
loop();


let role_down = false;
function role_down_navigation(){
    if (role_down === false){
        document.getElementById('role_down').style.display = 'none';
        role_down = true;
    }else{
        document.getElementById('role_down').style.display = 'revert';
        role_down = false;
    }
}


let selected_date ; // dolezita premena pre dalsie selecti a posuni pmocou sipiek pri minicalendari a samotnom calendari
/**
 * funkica ktora nacita akutalni datum dnesneho dna a prradi ho do mini calendaru
 */
window.onload= function() {
    let new_date = new Date();

    document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
    document.getElementById('input_date').min=new_date.toISOString().substr(0,10);

    new_date.setDate(new_date.getDate() + 7); // maximum vyditelnich dni +7 EXD
    document.getElementById('input_date').max=new_date.toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);
    //console.log(selected_date);
    document.getElementById('date_number').innerHTML = selected_date;

}
/**
 * mini calendar arrows onclick event a zaroven mini calendar onchange event
 * @how_many_or_elem  :HTML/:integer
 */
function make_date(how_many_or_elem){
    if (how_many_or_elem !== 1 && how_many_or_elem !== -1 ){ // pkial sa klika na sipky pri minicalendari
        let new_date = how_many_or_elem.value;
        if (new_date <  document.getElementById('input_date').min || new_date >  document.getElementById('input_date').max ){
            console.log('chybni');
            document.getElementById('date_number').innerHTML = "date is not valid";

        }else{
            document.getElementById('date_number').innerHTML = new_date;
            generate_HTML();
            find_by(document.getElementById('input_text'))
        }
    }else{ // onchange pri minicalendari
        let new_date = new Date((document.getElementById('input_date').value));
        new_date.setDate(new_date.getDate() + how_many_or_elem);
        // nepusti externeho dispatchera pokial je datum invalid to znamena mensi ako akutalni datum
        if (new_date.toISOString().substr(0,10) < document.getElementById('input_date').min
            || new_date.toISOString().substr(0,10)  >  document.getElementById('input_date').max){
            document.getElementById('input_date').value=(new Date()).toISOString().substr(0,10);
        }else{
            document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
            document.getElementById('date_number').innerHTML = new_date.toISOString().substr(0,10);
            generate_HTML();
            find_by(document.getElementById('input_text'))
        }
    }
}
function generate_HTML(){
    make_table_for_external_dispatcher('prepared','prepared_tr','prepared');
    make_table_for_external_dispatcher('requested','requested_tr','requested');
    make_table_for_external_dispatcher('booked','booked_tr','booked');
    make_table_for_external_dispatcher('finished','finished_tr','finished');
}


let array_of_options = ['prepared','requested','booked','finished'];

/**
 * obstaranie pola find by
 * @param elem :HTML
 */
function find_by(elem){
    let text = elem.value;
    let founded = false;
    let display_only = document.getElementById('select_only').value.split(" ");
    // funkcia spracovava data aj podala selectoru ktori sa nachadza vedla find by
    if (display_only[0] === 'all'){
        for (let i = 0 ;i < array_of_options.length;i++){
            let table_rows_with_class_name = document.getElementsByClassName(array_of_options[i]+"_tr");
            for (let row = 0 ; row < table_rows_with_class_name.length; row++){
                founded = false;
                for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
                    if (table_rows_with_class_name[row].childNodes[column].innerHTML.includes(text)) {
                        founded = true;
                    }
                }
                if (founded === false){
                    table_rows_with_class_name[row].style.display = 'none';
                }else{
                    table_rows_with_class_name[row].style.display = 'revert';
                }
            }
        }
    }else{
        let table_rows_with_class_name = document.getElementsByClassName(display_only[1]+"_tr");
        for (let row = 0 ; row < table_rows_with_class_name.length; row++){
            founded = false;
            for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
                if (table_rows_with_class_name[row].childNodes[column].innerHTML.includes(text)) {
                    founded = true;
                }
            }
            if (founded === false){
                table_rows_with_class_name[row].style.display = 'none';
            }else{
                table_rows_with_class_name[row].style.display = 'revert';
            }
        }
    }
}

/**
 * zobrazuje iba tie kolonky ktore su validne voci selectoru ktori sa nachadza vedla find by
 * @param elem je element ktori prichadza pramo s html(this)
 */
function select_only(elem){
    let display_only = elem.value.split(" ");
    if (display_only[0] !== 'all'){
        for (let i = 0 ;i < array_of_options.length;i++){
            if (array_of_options[i] !== display_only[1]){
                document.getElementById(array_of_options[i]).style.display ='none';
            }else{
                document.getElementById(array_of_options[i]).style.display ='revert';
            }
        }
    }else{
        for (let i = 0 ;i < array_of_options.length;i++){
            document.getElementById(array_of_options[i]).style.display ='revert';
        }

    }
    find_by(document.getElementById('input_text'));

}



let gates = new Gate();
/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    for(let i =0 ; i < data.length;i ++){
        // data format [0] == id |
        // [1] == id_calendar  // gate_number|
        // [2] == real_time |
        // [3] == s_time |
        // [4] == e_time |
        // [5] == state |
        // [6] == evc_truck |
        // [7] == id_truck_driver_1 |
        // [8] == id_truck_driver_2 |
        // [9] == commodity |
        // [10] == order
        let index = gates.get_index_by_id(data[i][1])
        //  console.log('index ',index);
        if (index >= 0){
            let index_real_time = gates.array_of_calendars[index].get_index_by_real_time(data[i][2]);
            if (index_real_time >= 0){
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_external_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_external_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }

        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_external_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }

    }
}

/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function  load_all_time_slots(){
    $.post('external AJAX/load_all_time_slots.php',{
    },function(data){
        if (data){
            parse_data(data);

        }else{
            alert("chyba nacitana dat s db");
        }
    });
    setTimeout(generate_HTML,250); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom

}
load_all_time_slots();

/**
 * funkcia na vitvorenie tables 'prepared'/'requested'/'booked'/'finished'
 * @param id_of_table HTML.id table ktori sa ide spracovat :string
 * @param row_class_name HTML.class_name rows ktore sa idu spracovat :string
 * @param state parameter kontoli pri vibere time slotov :string
 */
function make_table_for_external_dispatcher(id_of_table , row_class_name , state){
    let table_witch_contains_id = document.getElementById(id_of_table);
    let table_rows_with_class_name = document.getElementsByClassName(row_class_name);
    while (table_rows_with_class_name.length){ // delete all row of certain table
        table_rows_with_class_name[0].remove();
    }
    // generator html pre dani table
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
        let index_for_this_date = gates.array_of_calendars[calendar].get_index_by_real_time(document.getElementById('input_date').value); // da sa pouzit premena 'selected_date'
        if (index_for_this_date !== -1){
            for (let certain_time_slot = 0; certain_time_slot < gates.array_of_calendars[calendar].time_slots[index_for_this_date].states.length ; certain_time_slot++){
                if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].states[certain_time_slot] === state){
                    // pokial je row prepared negenegrovat s rovnakim casom ak sa uz cas nachada v
                    let row = table_witch_contains_id.insertRow();
                    row.className = row_class_name;
                    let cell1 = row.insertCell(0);
                    cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot].split(" ")[1];
                    // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);
                    if (state !== 'prepared'){
                        if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot] !== null){
                            console.log(gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot],gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot]);
                            cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot]
                                +"<br>"+gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot];
                        }else{
                            cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot];
                        }


                        cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].evcs[certain_time_slot];
                        cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].destinations[certain_time_slot];
                        cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].commoditys[certain_time_slot];
                    }

                    let cell6 = row.insertCell(5);

                    // treba pridat funkcionalitu buutonom
                    if (state === 'prepared'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-success only_one";
                        apply_button.innerHTML="apply";
                        cell6.className="td_flex_buttons";
                        cell6.appendChild(apply_button);
                    }else if(state === 'requested'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-primary only_one";
                        apply_button.innerHTML="edit";
                        cell6.className="td_flex_buttons";
                        cell6.appendChild(apply_button);
                    }
                }
            }
        }
    }
}
