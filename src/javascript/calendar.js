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
function load_all_time_slots() {
    $.post('calendar AJAX/load_all_time_slots.php',{
    },function(data){
        if (data){
            parse_data(data);



        }else{
            alert("chyba nacitana dat s db");
        }
    });
    setTimeout(executed,250);

}
function executed(){
    console.log("im execiuted")
    generate_gate_selector(document.getElementById('select_gate'));
}

//let display_resolution = 7; // toto je premenna na faktor nasobenia pre ziskanie spravnich time slotov po kliknuti na show
let selected_date ;
window.onload= function() {
    load_all_time_slots()
    document.getElementById('input_date').value=(new Date()).toISOString().substr(0,10);
    document.getElementById('input_date').min=(new Date()).toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);
    console.log(selected_date);
    //document.getElementById('back_date').disabled = true;

}

function date_add(kolko){
    let new_date = new Date((document.getElementById('input_date').value));
    new_date.setDate(new_date.getDate() + kolko);
    if (new_date.toISOString().substr(0,10) < document.getElementById('input_date').min ){
        console.log('neposun');
    }else{
        //console.log(document.getElementById('input_date').min)
        document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
        //document.getElementById('back_date').disabled = false;
    }
    console.log(document.getElementById("ramp_title").innerHTML);
    display_time_slot_for_this_date(document.getElementById('input_date'));
}
function display_time_slot_for_this_date(elem){

    if (document.getElementById('input_text').value !== " "){
        filter_text(document.getElementById('input_text'));
    }
    else if (document.getElementById('calendar_dates').style.display !== 'none'){
        console.log('chyba   ',document.getElementById("ramp_title").innerHTML.split(" ")[1]);
        show_full_gate(document.getElementById("ramp_title").innerHTML.split(" ")[1]);
    }else{
        selected_date = elem.value;
        generate_gate_selector(document.getElementById('select_gate'));
    }
    //console.log(selected_date);
}
// pokial je nieco occupied je to zapocitane v prepared
function show_full_gate(elem){
    if (elem === 'close'){
        document.getElementById('calendar_dates').style.display = 'none';
        document.getElementById('calendar').style.display = 'revert';
        generate_gate_selector(document.getElementById("select_gate"));
    }else{
        let index ;
        let int_index;
        let gate_index;
        let values = document.getElementById('select_gate').value.split(" - ");
        if (typeof elem === 'string'){
            index = elem
            int_index = parseInt(elem,10)
            console.log('CHYBA 2   ',index , "   alebo  int index ",int_index);
            gate_index = int_index;
        }else{
            console.log(typeof elem , elem);
            index = elem.className.split(" ");
            int_index = parseInt(index[index.length-1],10);
            gate_index = parseInt(values[0],10)+ ((int_index%8) -1);
            console.log('CHYBA 2   ',index , "   alebo  int index ",int_index);

        }

        //console.log(int_index);
        document.getElementById('calendar_dates').style.display = 'revert';
        document.getElementById('calendar').style.display = 'none';


        // make_html_for_IND(parseInt(values[0],10),parseInt(values[1],10))
        //console.log('toto je chybaaaa    ',parseInt(values[0],10)+int_index-1, "toto je chybaaaa ?? ",values[0]  );
        //console.log('toto je chybaaaa    ',parseInt(values[0],10)+int_index-1, "toto je chybaaaa ?? ",values[0]  , "alebo su to values  ??   ",values   );
        //console.log("index po deleni % 8   ",int_index%8);

        //let gate_index = parseInt(values[0],10)+ ((int_index%8) -1);
        //document.getElementById('ramp_title').innerHTML = "Ramps "+gate_index;
        //let gate_index = int_index;
        console.log("gate index   ",gate_index);
        document.getElementById('ramp_title').innerHTML = "Ramps "+gate_index;



        let base_date = new Date((document.getElementById('input_date').value));
        let days_in_calenadr = document.getElementsByClassName("days_in_calendar_closer");


        let row_columns_in_hours = document.getElementsByClassName('item_in_hours');
        for (let i = 0 ;i < row_columns_in_hours.length ;i++) {
            row_columns_in_hours[i].style.backgroundColor = "#f8f9fa";
        }
        for (let i = 0 ;i < 7;i++){     // 7 je maximalne mozne zobrazenie
            days_in_calenadr[i].innerHTML =  base_date.toISOString().substr(0,10);
            base_date.setDate(base_date.getDate() + 1);
            //let times_in_html = document.getElementsByClassName('right_border_time');
            //console.log("GATE INDEX ",gate_index);
            let upraveni_index_koli_arry = gate_index-1;
            if (upraveni_index_koli_arry >= gates.arry_of_calendars.length){
                return
            }
            let index_real_time = gates.arry_of_calendars[upraveni_index_koli_arry].get_index_by_real_time(days_in_calenadr[i].innerHTML);
            //console.log('real time  ' ,  days_in_calenadr[i].innerHTML, "    index   ",index_real_time," hladani na indexre   ",gate_index-1 ,"    ",gates.arry_of_calendars.length)
            //console.log(gates.arry_of_calendars[gate_index-1]);
            if (index  !== -1 && index_real_time !== -1){
                for (let count_time_slots = 0 ;count_time_slots < gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].start_times.length;count_time_slots++){

                    let st_time = gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].start_times[count_time_slots].split(" ")[1];
                    let st_time_strings = st_time.split(":");
                    let st_time_index = parseInt(st_time_strings[0],10)*60 + parseInt(st_time_strings[1],10);
                    let final_st_index = Math.trunc(st_time_index/30);

                    let ed_time = gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].end_times[count_time_slots].split(" ")[1];
                    let ed_time_strings = ed_time.split(":");
                    let ed_time_index = parseInt(ed_time_strings[0],10)*60 + parseInt(st_time_strings[1],10);
                    let final_ed_index = Math.trunc(ed_time_index/30);

                    //console.log("time slot   ",st_time , "  ",ed_time);
                    //console.log(final_st_index,"    ",final_ed_index,"   i value = ",i);

                    let make_it_in_columns = 0;
                    if (gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].states[count_time_slots] === 'prepared' ||
                        gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].states[count_time_slots] === 'occupied' ){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_hours[make_html*7+i].style.backgroundColor = "#2eff00";
                            make_it_in_columns ++
                            // treba pridat event click
                        }
                    }

                    if (gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].states[count_time_slots] === 'requested'){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_hours[make_html*7+i].style.backgroundColor = "#ff9900";
                            make_it_in_columns ++
                            // treba pridat event click
                        }
                    }
                    if (gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].states[count_time_slots] === 'booked'){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_hours[make_html*7+i].style.backgroundColor = "#ff0000";
                            make_it_in_columns ++
                            // treba pridat event click
                        }
                    }
                    if (gates.arry_of_calendars[upraveni_index_koli_arry].time_slots[index_real_time].states[count_time_slots] === 'finished'){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_hours[make_html*7+i].style.backgroundColor = "#9d00ff";
                            make_it_in_columns ++
                            // treba pridat event click
                        }

                    }


                    //gates.arry_of_calendars[gate_index].time_slots[index_real_time].end_times[count_time_slots];
                }

            }else{
                console.log("time slots for this gate ",gates.ids[i]," and this real time ",selected_date," is not existing");

            }
        }
        //console.log(gates.arry_of_calendars[(parseInt(values[0],10)+int_index-1)])


    }


}

//let pc_show_case = [0, 6];
function make_html_for_IND(start_index,end_index){
    console.log("indexis   ",start_index ,end_index);
    let row_prepared_occupied =  document.getElementsByClassName('prepared_occupied');
    let row_requested = document.getElementsByClassName('requested');
    let row_booked = document.getElementsByClassName('booked');
    let row_finished = document.getElementsByClassName('finished');
    let row_gates_titles = document.getElementsByClassName('days_in_calendar');
    /*
    console.log(row_prepared_occupied);
    console.log(row_requested);
    console.log(row_booked);
    console.log(row_finished);
    */

    let enumerate = 0;
    for(let i = 0 ;i < gates.arry_of_calendars.length;i++){
        if (gates.ids[i]  >= start_index &&  gates.ids[i] <= end_index  ){
            let index = gates.arry_of_calendars[i].get_index_by_real_time(selected_date);
            if (index  !== -1){
                console.log(gates.arry_of_calendars[i].time_slots[index]);
                let all =  gates.arry_of_calendars[i].time_slots[index].states.length ;
                let prepared = gates.arry_of_calendars[i].time_slots[index].count_of_states("prepared");

                let occupied = gates.arry_of_calendars[i].time_slots[index].count_of_states("occupied");

                let requested =gates.arry_of_calendars[i].time_slots[index].count_of_states("requested");
                let booked = gates.arry_of_calendars[i].time_slots[index].count_of_states("booked");

                let finished = gates.arry_of_calendars[i].time_slots[index].count_of_states("finished");
                console.log( "FREE SPACE \n");
                row_prepared_occupied[enumerate].innerHTML = ""+(prepared+occupied)+"/"+all;
                row_requested[enumerate].innerHTML = ""+requested+"/"+all;
                row_booked[enumerate].innerHTML = ""+booked+"/"+all;
                row_finished[enumerate].innerHTML = ""+finished+"/"+all;
                //row_gates_titles[enumerate].innerHTML = gates.ids[i]+" gate";


            }else{
                console.log("time slots for this gate ",gates.ids[i]," and this real time ",selected_date," is not existing");
                row_prepared_occupied[enumerate].innerHTML = "None";
                row_requested[enumerate].innerHTML = "None";
                row_booked[enumerate].innerHTML = "None";
                row_finished[enumerate].innerHTML = "None";
                //row_gates_titles[enumerate].innerHTML = gates.ids[i]+" gate";
            }
            row_gates_titles[enumerate].innerHTML = gates.ids[i]+" ramp";
            //console.log("dsada")
            enumerate ++;
        }
        //console.log(i);

    }
    if (enumerate+start_index < end_index ){
        console.log(enumerate+start_index , end_index )
        for (let i = enumerate;i < end_index-start_index+1;i++){
            row_prepared_occupied[i].innerHTML = "None";
            row_requested[i].innerHTML = "None";
            row_booked[i].innerHTML = "None";
            row_finished[i].innerHTML = "None";
            row_gates_titles[i].innerHTML = "None";
        }
    }
    //console.log("som tu")
    /*
    for (let i = 0 ;i < time_slots_jason.length;i++)
         let option1 = document.createElement("option");
    option1.text = "EXD";
    if (type_of_role === "EXD"){
        option1.selected = "selected";
    }
    select.appendChild(option1);*/

}

function generate_gate_selector(elem){
    let values = elem.value.split(" - ");
    //console.log(parseInt(values[0],10),parseInt(values[1],10))
    make_html_for_IND(parseInt(values[0],10),parseInt(values[1],10))
    document.getElementById('ramp_title').innerHTML = "Ramps "+elem.value;
    //console.log("1  ",gates.arry_of_calendars[0].time_slots);
}
function filter_text(elem){
    if (elem.value !== ""){
        document.getElementById('calendar_dates').style.display = 'none';
        document.getElementById('calendar').style.display = 'none';

        document.getElementById('prepared_h3').style.display = 'revert';
        document.getElementById('requested_h3').style.display = 'revert';
        document.getElementById('booked_h3').style.display = 'revert';
        document.getElementById('finished_h3').style.display = 'revert';

        document.getElementById('prepared').style.display = 'revert';
        document.getElementById('requested').style.display = 'revert';
        document.getElementById('booked').style.display = 'revert';
        document.getElementById('finished').style.display = 'revert';


        generate_prepared_html('prepared','prepared_tr','prepared');
        generate_prepared_html('requested','requested_tr','requested');
        generate_prepared_html('booked','booked_tr','booked');
        generate_prepared_html('finished','finished_tr','finished');
        select_only_text_with(elem);
        document.getElementById('ramp_title').innerHTML = "Find by : "+elem.value;
    }else{
        document.getElementById('prepared_h3').style.display = 'none';
        document.getElementById('requested_h3').style.display = 'none';
        document.getElementById('booked_h3').style.display = 'none';
        document.getElementById('finished_h3').style.display = 'none';

        document.getElementById('prepared').style.display = 'none';
        document.getElementById('requested').style.display = 'none';
        document.getElementById('booked').style.display = 'none';
        document.getElementById('finished').style.display = 'none';


        document.getElementById('calendar_dates').style.display = 'none';
        document.getElementById('calendar').style.display = 'revert';


        document.getElementById('ramp_title').innerHTML = "Find by : "+document.getElementById('select_gate').value;
    }

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
                    }else if(state === 'booked'){
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
let array_of_options = ['prepared','requested','booked','finished'];
function select_only_text_with(elem){
    let text = elem.value;
    let founded = false;

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

}


/*
// tu mudi bit kontrola podal zariadania sirky sa bude odvijat parameter pre zmenu begroundu parametr == displayed_length_of_calendar
let displayed_length_of_calendar = 7;
let time_slot_length = 5;
let max_lenght_of_calendar = 336;
for (let i = 0; i < calendar_item.length; i++) {
    calendar_item[i].onmouseover = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML !== "booked"   ){//&& cal[(i + (x * 7))].innerHTML !== "prepared" && cal[(i + (x * 7))].innerHTML !== "requested"
                    cal[(i + (x * 7))].style.backgroundColor = "grey";
                }
            }
        }
    }
    calendar_item[i].onmouseleave = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML === "booked"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ff0000";
                }
                if ( cal[(i + (x * 7))].innerHTML === "prepared" ){
                    cal[(i + (x * 7))].style.backgroundColor = "#b5e97c";
                }
                if  (cal[(i + (x * 7))].innerHTML === "requested"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ffc107";
                }
                if  (cal[(i + (x * 7))].innerHTML === "free"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ffffff";
                }



            }
        }
    }
    calendar_item[i].onclick = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {

                if (cal[(i + (x * 7))].innerHTML === "requested") {
                    cal[(i + (x * 7))].style.backgroundColor = "#ff0000";

                    cal[(i + (x * 7))].innerHTML = "booked";
                }
                if (cal[(i + (x * 7))].innerHTML === "prepared") {
                    cal[(i + (x * 7))].style.backgroundColor = "#ffc107";
                    cal[(i + (x * 7))].innerHTML = "requested";
                    load_time_slot();
                }
                if (cal[(i + (x * 7))].innerHTML === "free") {
                    cal[(i + (x * 7))].style.backgroundColor = "#b5e97c";

                    cal[(i + (x * 7))].innerHTML = "prepared";
                }
            }
        }
    }
}
function load_time_slot(){

    let id_time_slot = 1;
    window.open('objednavka.php?id_of_time_slot='+id_time_slot,"_self");
    // pomocou parametru && sa da pridat rozne parametre kontroli pre zobrazenie alebo overenie validiti
}
function roll(){
    if (document.getElementById('roll_down').style.display !== 'block'){
        document.getElementById('roll_down').style.display = 'block';
    }
    else{
        document.getElementById('roll_down').style.display = 'none';
    }
}
function dysplay_nakladka(index){
    if (index === undefined){
        let all_elements_inputs = document.querySelectorAll('.form-check-input');
        for (let i = 0 ;i < all_elements_inputs.length-1;i++){
            all_elements_inputs[i].checked = false;
        }
        // displey intersection between all gates(nakladiek)
    }else{
        // displey nakladka number(index)
    }
}//create_html_employee();
function loop(){
    //console.log(window.innerWidth);
    // konstanta honrneho pola kde je find by datum nam dava tuto hodnotu
    const margin = 2;
    if (window.innerWidth < 500){
        console.log("TU SOM 1");

        let all_elements_p = document.querySelectorAll('th');

        for (let i = 8 ;i < all_elements_p.length;i+=8){

            for (let x = 0;x < 4;x++){
                all_elements_p[margin+i-x].style.display = "none";
            }

        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "2px";
            if (i === all_elements_button.length-1){
                all_elements_button[i].style.marginRight = "0px";
            }
        }
    }
    if (window.innerWidth > 500 && window.innerWidth < 900){
        console.log("TU SOM 2")
        let all_elements_p = document.querySelectorAll('th');

        for (let i = 8 ;i < all_elements_p.length;i+=8){

            for (let x = 0;x < 4;x++){
                if (x < 2){
                    all_elements_p[margin+i-x].style.display = "none";
                }else {
                    all_elements_p[margin+i-x].style.display = "revert";
                }
            }
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "5px";
            if (i === all_elements_button.length-2){
                all_elements_button[i].style.marginRight = "5px";
                all_elements_button[i].style.marginLeft = "5px";
            }
        }
    }
    if ( window.innerWidth > 900){
        console.log("TU SOM 3")

        let all_elements_p = document.querySelectorAll('th');

        for (let i = 0 ;i < all_elements_p.length;i++){
            if (i === 0 ){
                all_elements_p[i].style.display = "flex ";
            }else{
                all_elements_p[i].style.display = "revert";
            }

        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "10px";
            if (i === all_elements_button.length-2){
                all_elements_button[i].style.marginRight = "10px";
                all_elements_button[i].style.marginLeft = "10px";
            }
        }
    }
    setTimeout(loop,500);
}
loop();
*/