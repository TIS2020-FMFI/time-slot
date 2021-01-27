let gates = new Gate();
/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    gates = new Gate();
    linked_id = 0;
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
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }
        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_gate_man(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }
    }
}
/**
 * ajax request na ziskanie dat pre gate_man
 */
function load_all_time_slots() {
    $.post('gate_man_AJAX/load_all_time_slots.php',{
    },function(data){
        if (typeof data === 'object'){
            parse_data(data);
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
    setTimeout(generate_gate_selector,250); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom

}
function update_handler(){
    //console.log('loooop');
    // chyba zobraziea koli tomu ze nepremazavame data tabuliek
    load_all_time_slots();
    setTimeout(update_handler,1000*60*5); ///*60*5 -->1000 je jedna sekunda  teda update bude prebiehat kazdich 5 minut
}
setTimeout(first_load,250);
function first_load() {
    update_handler();
}

function generate_gate_selector(){
    //console.log(gates);
    make_table_for_external_dispatcher('finished','finished_tr','finished');
    select_by('Oldest');
}

function select_by(elem_val){
    let multiplayer = 1;
    if (elem_val === 'Newest'){
        multiplayer *= -multiplayer
    }

    let all = document.getElementsByClassName( "finished_tr");
    let table_rows_with_class_name = Array.prototype.slice.call(all)
    table_rows_with_class_name.sort(function (a, b) {
        if (a.childNodes[0].innerHTML < b.childNodes[0].innerHTML) {
            return -1 * multiplayer;
        }
        if (a.childNodes[0].innerHTML > b.childNodes[0].innerHTML) {
            return 1 * multiplayer;
        }

        return 0;

    });
    let table_rows_with_class_name_copy =  document.getElementsByClassName( "finished_tr");
    let parent = table_rows_with_class_name_copy[0].parentElement;
    while (table_rows_with_class_name_copy.length) {
        table_rows_with_class_name_copy[0].remove();
    }
    for (let elem = 0; elem < table_rows_with_class_name.length; elem++) {
        parent.append(table_rows_with_class_name[elem]);
    }

}
/**
 * funkcia na vitvorenie tables 'prepared'/'requested'/'booked'/'finished'
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
    console.log(gates);
    // generator html pre dani table
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
        //console.log(gates.array_of_calendars[calendar].time_slots);
        //console.log(gates.array_of_calendars[calendar].time_slots[].length);
        for (let real_time = 0 ;real_time < gates.array_of_calendars[calendar].time_slots.length;real_time++){
        //let real_time = gates.array_of_calendars[calendar].get_index_by_real_time(document.getElementById('input_date').value); // da sa pouzit premena 'selected_date'
            //console.log('gates',gates.array_of_calendars[calendar].time_slots[real_time]);
            for (let certain_time_slot = 0; certain_time_slot < gates.array_of_calendars[calendar].time_slots[real_time].start_times.length ; certain_time_slot++) {
                // pokial je row prepared negenegrovat s rovnakim casom ak sa uz cas nachada v
                let row = table_witch_contains_id.insertRow();
                row.className = row_class_name;
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                let cell4 = row.insertCell(3);
                let cell5 = row.insertCell(4);
                let cell6 = row.insertCell(5);
                let cell7 = row.insertCell(6);
                let cell8 = row.insertCell(7);

                if (gates.array_of_calendars[calendar].time_slots[real_time].kamionists_2[certain_time_slot] !== null) {
                    //console.log(gates.array_of_calendars[calendar].time_slots[real_time].kamionists_1[certain_time_slot], gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot]);
                    cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].kamionists_1[certain_time_slot]
                        + "<br>" + gates.array_of_calendars[calendar].time_slots[real_time].kamionists_2[certain_time_slot];
                } else {
                    cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].kamionists_1[certain_time_slot];
                }

                //cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot].split(" ")[1];
                // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC

                cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].evcs[certain_time_slot];

                cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].start_times[certain_time_slot].split(' ')[1];
                cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].destinations[certain_time_slot];
                cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].external_dispatchers[certain_time_slot];


                //cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].commoditys[certain_time_slot];
                if (gates.array_of_calendars[calendar].time_slots[real_time].commoditys[certain_time_slot].length > 40){
                    create_html_linked_text(gates.array_of_calendars[calendar].time_slots[real_time].commoditys[certain_time_slot],cell6)

                }else{
                    cell6.innerHTML = gates.array_of_calendars[calendar].time_slots[real_time].commoditys[certain_time_slot];
                }

                cell7.innerHTML = gates.ids[calendar];

                // treba pridat funkcionalitu buttonom

                let apply_button = document.createElement("BUTTON")
                apply_button.className = "btn btn-default bg-success only_one";
                apply_button.onclick = function (){
                    let index = gates.array_of_calendars[calendar].time_slots[real_time].ids[certain_time_slot];
                    ajax_post_confirm(row,index);
                }
                apply_button.innerHTML = "Confirm arrival";
                cell8.className = "td_flex_buttons";
                cell8.appendChild(apply_button);


            }
        }
    }
}
function ajax_post_confirm(html_row,id){
    $.post('gate_man_AJAX/confirm_time_slot.php',{
        id:id
    },function(data){
        if (data){
            if (data.includes("$")){
                let split = data.split("$")
                if (split[0] === '1'){
                    create_exception(split[1],23,'success');
                    delete_html_time_slot(html_row);
                }else{
                    create_exception(split[1],23,'warning');
                }
            }else{
                create_exception(data,23,'danger');
            }
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
}
function delete_html_time_slot(html_row){
    html_row.remove();
}
function find_by(elem){
    let text = elem.value;
    let table_rows_with_class_name = document.getElementsByClassName("finished_tr");
    let founded = false;
    for (let row = 0 ; row < table_rows_with_class_name.length; row++){
        founded = false;
        for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
            if (table_rows_with_class_name[row].childNodes[column].innerHTML.toLowerCase().includes(text.toLowerCase())) {
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

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function loop(){
    let duration_of_admins_constant = 20; // magic konstant from admin
    let time = new Date();
    time.setMinutes(time.getMinutes() - duration_of_admins_constant);
    //let valid_time = (time.toLocaleTimeString()).split(' ')[0];
    let table_rows_with_class_name = document.getElementsByClassName("finished_tr");
    let list_of_deleted = [];
    let h = time.getHours();
    let m = time.getMinutes();
    let s = time.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    let valid_time_string = h+":"+m+":"+s;
    //console.log(valid_time, "    ",valid_time_string);
    for (let row = 0 ; row < table_rows_with_class_name.length; row++){
            if (table_rows_with_class_name[row].childNodes[2].innerHTML <= valid_time_string) {
                list_of_deleted.push(table_rows_with_class_name[row]);
            }
    }
    for (let i = 0 ;i < list_of_deleted.length;i++){
        //console.log(list_of_deleted[i]);
        list_of_deleted[i].remove();
    }
    setTimeout(loop,100);
}
loop();