let gates = new Gate();


/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    //console.log('dasdsadsda');
    for(let i =0 ; i < data.length;i ++){
        // data format vystup SQL
        // [0] == id |
        // [1] == id_calendar  // gate_number|
        // [2] == real_time |
        // [3] == s_time |
        // [4] == evc_truck |
        // [5] == full_name truck_driver1 |
        // [6] == full_name truck_driver1 |
        // [7] == commodity |
        // [8] == order
        let index = gates.get_index_by_id(data[i][1])
        if (index >= 0){
            let index_real_time = gates.array_of_calendars[index].get_index_by_real_time(data[i][2]);
            if (index_real_time >= 0){
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }
        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }
    }
}
/**
 * ajax request na ziskanie dat pre vratnika
 */
function load_all_time_slots() {
    $.post('gate_man_AJAX/load_all_time_slots.php',{
    },function(data){
        //console.log(data);
        if (data){
            parse_data(data);

        }else{
            alert("chyba nacitana dat s db");
        }
    });
    setTimeout(generate_gate_selector,250); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom
}
load_all_time_slots()
function generate_gate_selector(){
    //console.log(gates);
    make_table_for_external_dispatcher('finished','finished_tr','finished');
}

/**
 * funkcia na vytvorenie tables 'finished'
 * @param id_of_table HTML.id table ktori sa ide spracovat :string
 * @param row_class_name HTML.class_name rows ktore sa idu spracovat :string
 * @param state parameter kontoli pri vibere time slotov :string
 */
function make_table_for_external_dispatcher(id_of_table , row_class_name , state){
    let table_witch_contains_id = document.getElementById(id_of_table);
    let table_rows_with_class_name = document.getElementsByClassName(row_class_name);
    //console.log(table_witch_contains_id);
    //console.log(table_rows_with_class_name);
    while (table_rows_with_class_name.length){ // delete all row of certain table
        table_rows_with_class_name[0].remove();
    }
    // generator html pre dani table
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
        //console.log(gates.array_of_calendars[calendar].time_slots);
        for (let real_time = 0 ;real_time < gates.array_of_calendars[calendar].time_slots.length;real_time++){
            for (let certain_time_slot = 0; certain_time_slot < gates.array_of_calendars[calendar].time_slots[real_time].start_times.length ; certain_time_slot++) {
                let row = table_witch_contains_id.insertRow();
                row.className = row_class_name;
                let cell1 = row.insertCell(0);
                if (gates.array_of_calendars[calendar].time_slots[real_time].kamionists_2[certain_time_slot] !== null) {
                    cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].kamionists_1[certain_time_slot]
                        + "<br>" + gates.array_of_calendars[calendar].time_slots[real_time].kamionists_2[certain_time_slot];
                } else {
                    cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].kamionists_1[certain_time_slot];
                }
                let cell2 = row.insertCell(1);
                cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].evcs[certain_time_slot];
                let cell3 = row.insertCell(2);
                cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].start_times[certain_time_slot].split(' ')[1];
                let cell4 = row.insertCell(3);
                cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].commoditys[certain_time_slot];
                let cell5 = row.insertCell(4);
                cell5.innerHTML = gates.ids[calendar];
                let cell6 = row.insertCell(5);
                let apply_button = document.createElement("BUTTON")
                apply_button.className = "btn btn-default bg-success only_one";
                apply_button.onclick = function (){
                    let index = gates.array_of_calendars[calendar].time_slots[real_time].ids[certain_time_slot];
                    ajax_post_confirm(row,index);
                }
                apply_button.innerHTML = "Confirm";
                cell6.className = "td_flex_buttons";
                cell6.appendChild(apply_button);

            }
        }
    }
}

/**
 * Potvrdenie time-slotov
 */
function ajax_post_confirm(html_row,id){
    $.post('gate_man_AJAX/confirm_time_slot.php',{
        data:id
    },function(data){
        if (data){
            console.log(data);
            alert("chyba nacitana dat s db");
        }else{
            delete_html_time_slot(html_row);
        }
    });
}

function delete_html_time_slot(html_row){
    html_row.remove();
}


/**
 * Funkcia na vyhladavanie pre vratnika
 */
function find_by(elem){
    let text = elem.value;
    let table_rows_with_class_name = document.getElementsByClassName("finished_tr");
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

/**
 * Funkcia na zobrazenie kamionov, ktore maju prist, pocita aj s meskanim kamionistu
 */
function loop(){
    let delay_of_truck = 20; // meskanie kamionistu, ktoru urcuje admin
    let time = new Date();
    time.setMinutes(time.getMinutes() - delay_of_truck);
    let valid_time = (time.toLocaleTimeString()).split(' ')[0];
    let table_rows_with_class_name = document.getElementsByClassName("finished_tr");
    let list_of_deleted = [];
    for (let row = 0 ; row < table_rows_with_class_name.length; row++){
        for (let column = 0;column < table_rows_with_class_name[row].childElementCount; column++){
            if (table_rows_with_class_name[row].childNodes[column].innerHTML <= valid_time) {
                list_of_deleted.push(table_rows_with_class_name[row]);
            }
        }
    }
    for (let i = 0 ;i < list_of_deleted.length;i++){
        list_of_deleted[i].remove();
    }
    setTimeout(loop,100);
}
loop();
