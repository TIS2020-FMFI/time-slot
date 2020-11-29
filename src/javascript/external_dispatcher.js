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
let is_roled = false;
function role_dow(){
    if (is_roled === false){
        //document.getElementById('role_down').style.marginTop = '340px';
        document.getElementById('role_down').style.display = 'none';
        is_roled = true;
    }else{
        //document.getElementById('role_down').style.marginTop = '62px';
        document.getElementById('role_down').style.display = 'revert';
        is_roled = false;
    }
}
let selected_date ;
window.onload= function() {
    //load_all_time_slots()
    document.getElementById('input_date').value=(new Date()).toISOString().substr(0,10);
    document.getElementById('input_date').min=(new Date()).toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);
    console.log(selected_date);
    document.getElementById('date_number').innerHTML = selected_date;

}
function date_add(kolko){
    if (kolko !== 1 && kolko !== -1 ){
        let new_date = kolko.value;
        if (new_date <  document.getElementById('input_date').min ){
            console.log('chybni');
            document.getElementById('date_number').innerHTML = "date is not valid";
            //new_date = (new Date()).toISOString().substr(0,10);
            //document.getElementById('input_date').value = new_date;
        }else{
            //document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
            document.getElementById('date_number').innerHTML = new_date;
            generate_prepared_html('prepared','prepared_tr','prepared');
            generate_prepared_html('requested','requested_tr','requested');
            generate_prepared_html('booked','booked_tr','booked');
            generate_prepared_html('finished','finished_tr','finished');
            //document.getElementById('back_date').disabled = false;
        }
    }else{
        let new_date = new Date((document.getElementById('input_date').value));
        new_date.setDate(new_date.getDate() + kolko);
        if (new_date.toISOString().substr(0,10) < document.getElementById('input_date').min ){
            document.getElementById('input_date').value=(new Date()).toISOString().substr(0,10);
            //document.getElementById('date_number').innerHTML = new_date.toISOString().substr(0,10);
        }else{
            //console.log(document.getElementById('input_date').min)
            document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
            document.getElementById('date_number').innerHTML = new_date.toISOString().substr(0,10);
            generate_prepared_html('prepared','prepared_tr','prepared');
            generate_prepared_html('requested','requested_tr','requested');
            generate_prepared_html('booked','booked_tr','booked');
            generate_prepared_html('finished','finished_tr','finished');
            //document.getElementById('back_date').disabled = false;
        }
    }
    //display_time_slot_for_this_date(document.getElementById('input_date'));
}
let array_of_options = ['prepared','requested','booked','finished'];
function select_only_text_with(elem){
    let text = elem.value;
    let founded = false;
    //console.log(text);
    let display_only = document.getElementById('select_only').value.split(" ");
    if (display_only[0] === 'all'){
        for (let i = 0 ;i < array_of_options.length;i++){
            let table_rows_with_class_name = document.getElementsByClassName(array_of_options[i]+"_tr");
            for (let row = 0 ; row < table_rows_with_class_name.length; row++){
                founded = false;
                for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
                    //console.log("text td  ",table_rows_with_class_name[row].childNodes[column].innerHTML);
                    if (table_rows_with_class_name[row].childNodes[column].innerHTML.includes(text)) {
                        founded = true;
                    }
                }
                if (founded === false){
                    table_rows_with_class_name[row].style.display = 'none';
                }else{
                    table_rows_with_class_name[row].style.display = 'revert';
                }
                //console.log();
            }
        }
    }else{
        let table_rows_with_class_name = document.getElementsByClassName(display_only[1]+"_tr");
        for (let row = 0 ; row < table_rows_with_class_name.length; row++){
            founded = false;
            for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
                //console.log("text td  ",table_rows_with_class_name[row].childNodes[column].innerHTML);
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
    select_only_text_with(document.getElementById('input_text'));

}
class Time_slot {
    constructor() {
        this.ids = [];
        this.start_times = [];
        this.end_times = [];
        this.states = [];
        this.kamionists_1 = [];
        this.kamionists_2 = [];
        this.evcs = [];
    }
    get_ids(){
        return this.ids;
    }
    get_start_times(){
        return this.start_times;
    }
    get_end_times(){
        return this.end_times;
    }
    get_states(){
        return this.states;
    }
    count_of_states(state){
        let count = 0;
        for (let i = 0;i < this.states.length;i++){
            if (state === this.states[i]){
                count ++;
            }
        }
        return count;
    }
    get_all_time_slots(){
        return [this.ids,this.start_times,this.end_times,this.states,this.evcs,this.kamionists_1,this.kamionists_2]
    }
    add_next_time_slot(id, s_time, e_time, state,evc,driver1,driver2){
        this.ids.push(id)
        this.start_times.push(s_time)
        this.end_times.push(e_time)
        this.states.push(state)
        this.evcs.push(evc)
        this.kamionists_1.push(driver1)
        this.kamionists_2.push(driver2)
    }
}

class Calendar {
    constructor() {
        this.real_times = [];//real_time; 2020-12-11 (sk)
        this.time_slots = [];//new Time_slot();

    }
    get_real_times(){
        return this.real_times;
    }
    get_time_slots(){
        return this.time_slots;
    }
    push_real_time_and_time_slot(time,time_slot){
        this.real_times.push(time);
        this.time_slots.push(time_slot);
    }
    get_index_by_real_time(time){
        return this.real_times.indexOf(time);
    }

}
class Gate {
    constructor() {
        this.ids = [];
        this.arry_of_calendars = [];
    }
    get_ids(){
        return this.ids;
    }
    get_calendar(){
        return this.arry_of_calendars;
    }
    push_calendar_and_id(id,calendar){
        this.arry_of_calendars.push(calendar);
        this.ids.push(id);
    }
    contains_calendar(calendar){
        return this.arry_of_calendars.includes(calendar);
    }
    contains_id(id){
        return this.ids.includes(id);
    }
    get_index_by_id(id){
        return this.ids.indexOf(id);
    }
}

let gates = new Gate();


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
        // [8] == id_truck_driver_2
        let index = gates.get_index_by_id(data[i][1])
        //  console.log('index ',index);
        if (index >= 0){
            let index_real_time = gates.arry_of_calendars[index].get_index_by_real_time(data[i][2]);
            if (index_real_time >= 0){
                gates.arry_of_calendars[index].time_slots[index_real_time].add_next_time_slot(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
                gates.arry_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }

        }else{
            //console.log('nexistuje',data[i][1]);
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }

    }
    //console.log('dsadsad',list_of_all_objects);
}
function  load_all_prepared(){
    $.post('external AJAX/load_all_time_slots.php',{
    },function(data){
        if (data){
            //console.log("PREPARED ",data);
            parse_data(data);



        }else{
            alert("chyba nacitana dat s db");
        }
    });
    setTimeout(executed,250);

}
load_all_prepared();
function executed(){
    //console.log("im execiuted ",gates);
    generate_prepared_html('prepared','prepared_tr','prepared');
    generate_prepared_html('requested','requested_tr','requested');
    generate_prepared_html('booked','booked_tr','booked');
    generate_prepared_html('finished','finished_tr','finished');
    //generate_gate_selector(document.getElementById('select_gate'));
}
function generate_prepared_html(id_of_table , row_class_name , state){
    //console.log(gates);
    let table_prepared = document.getElementById(id_of_table);
    // delete all prepared_rows
    let table_rows_with_class_name = document.getElementsByClassName(row_class_name);
    //console.log(table_rows_prepared.length);
    while (table_rows_with_class_name.length){
        table_rows_with_class_name[0].remove();
        //let row = table_prepared.insertRow();
        //row.className = 'prepared_tr';
        //console.log('remove')
    }
    for (let calendar = 0 ; calendar < gates.arry_of_calendars.length; calendar++){
        let index_for_this_date = gates.arry_of_calendars[calendar].get_index_by_real_time(document.getElementById('input_date').value); // da sa pouzit premena 'selected_date'
        //console.log('real times   ',gates_prepared.arry_of_calendars[calendar].real_times);
        //console.log(document.getElementById('input_date').value);
        //console.log("  REAL TIME INDEX  ",index_for_this_date);
        if (index_for_this_date !== -1){
            //console.log('naiel v calendari ',calendar);
            for (let certain_time_slot = 0; certain_time_slot < gates.arry_of_calendars[calendar].time_slots[index_for_this_date].states.length ; certain_time_slot++){
                if (gates.arry_of_calendars[calendar].time_slots[index_for_this_date].states[certain_time_slot] === state){
                    // pokial je row prepared negenegrovat s rovnakim casom ak sa uz cas nachada v
                    let row = table_prepared.insertRow();
                    row.className = row_class_name;
                    let cell1 = row.insertCell(0);
                    cell1.innerHTML = gates.arry_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot].split(" ")[1];
                    // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    if (state !== 'prepared'){
                        if (gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot] !== null){
                            console.log(gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot],gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot]);
                            cell2.innerHTML = gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot]
                                +"<br>"+gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot];
                        }else{
                            cell2.innerHTML = gates.arry_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot];
                        }


                        cell3.innerHTML = gates.arry_of_calendars[calendar].time_slots[index_for_this_date].evcs[certain_time_slot];
                    }

                    let cell4 = row.insertCell(3);

                    // treba pridat funkcionalitu buutonom
                    if (state === 'prepared'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-success only_one";
                        apply_button.innerHTML="apply";
                        cell4.className="td_flex_buttons";
                        cell4.appendChild(apply_button);
                    }else if(state === 'requested'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-primary only_one";
                        apply_button.innerHTML="edit";
                        cell4.className="td_flex_buttons";
                        cell4.appendChild(apply_button);
                    }

                }

            }
        }
        ///}
    }

}
/*
load_all_prepared();
function  load_all_requested_booked_finished(){
    $.post('external AJAX/load_all_requested_booked_finished.php',{
    },function(data){
        if (data){
            console.log("OTHER ",data);



        }else{
            alert("chyba nacitana dat s db");
        }
    });
    //setTimeout(executed,250);
}
load_all_requested_booked_finished();*/