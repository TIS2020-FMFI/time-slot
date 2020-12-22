let gates = undefined;
/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    gates = new Gate();
    let counter = 0 ;
    for(let i =0 ; i < data.length;i ++){
        // data format vystup SQL
        // [0] == id |
        // [1] == id_calendar  // gate_number|
        // [2] == real_time |
        // [3] == s_time |
        // [4] == e_time |
        // [5] == state |
        // [6] == evc_truck |
        // [7] == firm_name |
        // [8] == commodity |
        // [9] == order
        if (data[i][5] === "requested"){
            counter++;
        }

        let index = gates.get_index_by_id(data[i][1])
        if (index >= 0){
            let index_real_time = gates.array_of_calendars[index].get_index_by_real_time(data[i][2]);
            if (index_real_time >= 0){
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }
        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }
    }
    document.getElementById('only_requested_count').innerHTML = counter+"";
}
/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function load_all_time_slots() {
    $.post('internal_AJAX/load_all_time_slots.php',{
    },function(data){
        if (data){
            parse_data(data);



        }else{
            alert("chyba nacitana dat s db");
        }
    });
    //console.log("im execiuted");
    //generate_gate_selector(document.getElementById('select_gate'));
    setTimeout(generate_gate_selector,250,document.getElementById('select_gate')); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom

}

//let display_resolution = 7; // toto je premenna na faktor nasobenia pre ziskanie spravnich time slotov po kliknuti na show
let selected_date ;
/**
 * funkica ktora nacita akutalni datum dnesneho dna a prradi ho do mini calendaru
 */
window.onload= function() {
    load_all_time_slots()
    let currentTime = new Date()

    document.getElementById('input_date').value= currentTime.toISOString().substr(0,10);
    currentTime.setDate(currentTime.getDate()-7);
    document.getElementById('input_date').min= currentTime.toISOString().substr(0,10);
    currentTime.setDate(currentTime.getDate()+21);
    document.getElementById('input_date').max= currentTime.toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);
    loop();
    update_handler()
    //console.log(selected_date);
}

/**
 * mini calendar arrows onclick event
 * @how_many 1/-1 :integer
 */
function make_date_arrows_mini_calendar(how_many){
    let new_date = new Date((document.getElementById('input_date').value));
    new_date.setDate(new_date.getDate() + how_many);
    if (new_date.toISOString().substr(0,10) < document.getElementById('input_date').min  ||
        new_date.toISOString().substr(0,10) > document.getElementById('input_date').max){

        console.log('neposun');
    }else{
        if (new_date.toISOString().substr(0,10) === document.getElementById('input_date').min){
            document.getElementById('back_date').disabled = true;
        }else{
            document.getElementById('back_date').disabled = false;

        }
        if(new_date.toISOString().substr(0,10) === document.getElementById('input_date').max){
            document.getElementById('next_date').disabled = true;
        }else{
            document.getElementById('next_date').disabled = false;

        }
        document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
    }
    console.log(document.getElementById("ramp_title").innerHTML);
    display_time_slot_for_this_date(document.getElementById('input_date'));
}
/**
 * mini calendar onchange event
 * @elem  :HTML
 */
function display_time_slot_for_this_date(elem){
    if (document.getElementById('input_text').value !== "" ){
        find_by(document.getElementById('input_text'));
    }
    else if (document.getElementById('calendar_dates').style.display !== 'none' ){
        show_full_gate(document.getElementById("ramp_title").innerHTML.split(" ")[1]);
    }else{
        if ( elem.min > elem.value ) {
            console.log('invalid date')
        }
        else{
            selected_date = elem.value;
            generate_gate_selector(document.getElementById('select_gate'));
        }
    }
}


let row_columns_in_half_hours = document.getElementsByClassName('item_in_hours'); // vsetky stlpce a riadky vo dyspaly full_ramp
/**
 *  button show pod kazdou rampou
 * @param elem :HTML
 */
function show_full_gate(elem){
    //console.log('SJOWWWW');
    //if (document.getElementById("ramp_title").innerHTML === 'invalid date' &&  selected_date < document.getElementById('input_date').min) {
    //         console.log("zli datum  show_full_gate")
    //         return
    //     }
    if (elem === 'close'){
        document.getElementById('calendar_dates').style.display = 'none';
        document.getElementById('calendar').style.display = 'revert';
        let elem = document.getElementById('ramp_title').innerHTML
        document.getElementById('ramp_title').innerHTML = "Ramps "+elem.value;
        generate_gate_selector(document.getElementById("select_gate"));
    }else{
        let index ;
        let int_index;
        let gate_index;
        let values = document.getElementById('select_gate').value.split(" - ");
        if (typeof elem === 'string'){
            index = elem
            int_index = parseInt(elem,10)
            //console.log('CHYBA 2   ',index , "   alebo  int index ",int_index);
            gate_index = int_index;
        }else{
            //console.log(typeof elem , elem);
            index = elem.className.split(" ");
            int_index = parseInt(index[index.length-1],10);
            gate_index = parseInt(values[0],10)+ ((int_index%8) -1);
            //console.log('CHYBA 2   ',index , "   alebo  int index ",int_index);

        }
        //console.log("gate index   ",gate_index);
        document.getElementById('calendar_dates').style.display = 'revert';
        document.getElementById('calendar').style.display = 'none';
        document.getElementById('ramp_title').innerHTML = "Ramp "+gate_index;

        let base_date = new Date((document.getElementById('input_date').value)); // date form minicalendar moznost prerobenia na selected_date
        let days_in_calendar = document.getElementsByClassName("days_in_calendar_closer");



        for (let i = 0 ;i < row_columns_in_half_hours.length ;i++) {
            row_columns_in_half_hours[i].style.backgroundColor = "#f8f9fa";
            row_columns_in_half_hours[i].innerHTML = "";
        }
        for (let day = 0 ;day < 7;day++){     // 7 je maximalne mozne zobrazenie
            days_in_calendar[day].innerHTML =  base_date.toISOString().substr(0,10);
            base_date.setDate(base_date.getDate() + 1);

            let refactor_index_because_array = gate_index-1;
            if (refactor_index_because_array >= gates.array_of_calendars.length){
                return
            }
            let index_real_time = gates.array_of_calendars[refactor_index_because_array].get_index_by_real_time(days_in_calendar[day].innerHTML);

            if (index  !== -1 && index_real_time !== -1){
                for (let count_time_slots = 0 ; count_time_slots < gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].start_times.length; count_time_slots++){

                    let st_time = gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].start_times[count_time_slots].split(" ")[1];
                    let st_time_strings = st_time.split(":");
                    let st_time_index = parseInt(st_time_strings[0],10)*60 + parseInt(st_time_strings[1],10);
                    let final_st_index = Math.trunc(st_time_index/30);
                    //console.log("START : ",st_time,'    ',st_time_index,'     ',final_st_index);

                    let ed_time = gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].end_times[count_time_slots].split(" ")[1];
                    let ed_time_strings = ed_time.split(":");
                    let ed_time_index = parseInt(ed_time_strings[0],10)*60 + parseInt(ed_time_strings[1],10);
                    let final_ed_index = Math.trunc(ed_time_index/30);
                    //console.log("END : ",ed_time,'    ',ed_time_index,'     ',final_ed_index);
                    //console.log('\\n');


                    let html_row_count = 0;
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'prepared' ||
                        gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'occupied' ){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_half_hours[make_html*7+day].style.backgroundColor = "#2eff00";
                            html_row_count ++
                            if (html_row_count === 5){
                                let show_button = document.createElement("BUTTON")
                                show_button.className = "btn btn-default bg-primary only_one";
                                show_button.onclick = function (){
                                    Time_slot.open_time_slot(gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].ids[count_time_slots]);
                                    //let index = gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].ids[count_time_slots];
                                    console.log('PREPARED  ',index);
                                }
                                show_button.innerHTML = "SHOW";


                                row_columns_in_half_hours[make_html*7+day].appendChild(show_button);
                            }else{
                                row_columns_in_half_hours[make_html*7+day].innerHTML = "Free";
                            }
                            // treba pridat event click
                        }
                    }

                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'requested'){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#ff9900',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots);
                            html_row_count ++
                            // treba pridat event click
                        }
                    }
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'booked'){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#ff0000',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots);
                            html_row_count ++
                            // treba pridat event click
                        }
                    }
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'finished'){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#9d00ff',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots);
                            html_row_count ++
                            // treba pridat event click
                        }

                    }
                }
                console.log('NEXT DAY');
            }else{
                console.log("time slots for this gate ",gates.ids[day]," and this real time ",selected_date," is not existing");
            }
        }
        remove_unused_rows(row_columns_in_half_hours);
    }
}

/**
 * po vygenerovani celeho full_calendaru pre danu rampu pomaze prazdne riadky
 * @param rows_columns OBJECT: html element with class item_in_hours
 */
function remove_unused_rows(rows_columns){
    let time_columns = document.getElementsByClassName('time');
    let founded_empty_row = true;
    for (let r_c_index = 1 ;r_c_index < rows_columns.length+1; r_c_index++){
        if (rows_columns[r_c_index - 1].innerHTML !== ''){
            founded_empty_row = false;
        }
        if (r_c_index % 7 === 0 ){
            if (founded_empty_row){
                time_columns[(r_c_index / 7)-1].style.display = 'none';
            }else{
                time_columns[(r_c_index / 7)-1].style.display = 'revert';
            }
            founded_empty_row = true;
        }
    }

}
/**
 * Pomocna funkcia show_full_ramp pre odstranenie dupliciti
 * @param html_row_count :integer
 * @param index_of_column :integer
 * @param color #HEX :string
 * @param time_slot :index time slot
 * @param time_slot_index :index time slot
 */
function generate_html_column_for_show_full_ramp(html_row_count,index_of_column,color,time_slot,time_slot_index){
    //console.log([time_slot.external_dispatchers[html_row_count],
    // time_slot.evcs[html_row_count],
    // time_slot.destinations[html_row_count],
    // time_slot.commoditys[html_row_count] , ]);

    //console.log('\n');

    row_columns_in_half_hours[index_of_column].style.backgroundColor = color;
    if (html_row_count === 0){
        row_columns_in_half_hours[index_of_column].innerHTML = time_slot.external_dispatchers[time_slot_index];
    }
    else if (html_row_count === 1){
        row_columns_in_half_hours[index_of_column].innerHTML = time_slot.evcs[time_slot_index];
    }
    else if (html_row_count === 2){
        row_columns_in_half_hours[index_of_column].innerHTML = time_slot.destinations[time_slot_index];
    }
    else if (html_row_count === 3){
        row_columns_in_half_hours[index_of_column].innerHTML = time_slot.commoditys[time_slot_index];
    }
    else if (html_row_count === 4){
        let show_button = document.createElement("BUTTON")
        show_button.className = "btn btn-default bg-primary only_one";
        show_button.onclick = function (){
            Time_slot.open_time_slot(time_slot.ids[time_slot_index]);
            //let index = time_slot.ids[time_slot_index];
                 //console.log(index);
             }
        show_button.innerHTML = "SHOW";


        row_columns_in_half_hours[index_of_column].appendChild(show_button);
    }
}


/**
 *  prvotni nahlad kalendaru, indexes su ziskane z a prsnuteho 'select_gate' format pre pc '1 - 7'  pre tablet '1 - 5' a mobil '1 - 3'
 * @param start_index :integer
 * @param end_index :integer
 */
function global_calendar(start_index, end_index){

    let row_prepared_occupied =  document.getElementsByClassName('prepared_occupied');
    let row_requested = document.getElementsByClassName('requested');
    let row_booked = document.getElementsByClassName('booked');
    let row_finished = document.getElementsByClassName('finished');
    let row_gates_titles = document.getElementsByClassName('days_in_calendar');

    let enumerate = 0;
    for(let i = 0 ; i < gates.array_of_calendars.length; i++){
        if (gates.ids[i]  >= start_index &&  gates.ids[i] <= end_index  ){
            let index = gates.array_of_calendars[i].get_index_by_real_time(selected_date);
            if (index  !== -1){
                let all =  gates.array_of_calendars[i].time_slots[index].states.length ;
                let prepared = gates.array_of_calendars[i].time_slots[index].count_of_states("prepared");

                let occupied = gates.array_of_calendars[i].time_slots[index].count_of_states("occupied");

                let requested =gates.array_of_calendars[i].time_slots[index].count_of_states("requested");
                let booked = gates.array_of_calendars[i].time_slots[index].count_of_states("booked");

                let finished = gates.array_of_calendars[i].time_slots[index].count_of_states("finished");
                row_prepared_occupied[enumerate].innerHTML = ""+(prepared+occupied)+"/"+all;
                row_requested[enumerate].innerHTML = ""+requested+"/"+all;
                row_booked[enumerate].innerHTML = ""+booked+"/"+all;
                row_finished[enumerate].innerHTML = ""+finished+"/"+all;


            }else{
                row_prepared_occupied[enumerate].innerHTML = "None";
                row_requested[enumerate].innerHTML = "None";
                row_booked[enumerate].innerHTML = "None";
                row_finished[enumerate].innerHTML = "None";
            }
            row_gates_titles[enumerate].innerHTML = gates.ids[i]+" ramp";
            enumerate ++;
        }

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
}

/**
 * onchange event funkcia pre gate_selector
 * @param elem
 */
function generate_gate_selector(elem){
    //if (document.getElementById("ramp_title").innerHTML === 'invalid date' &&  selected_date < document.getElementById('input_date').min ) {
    //         console.log("zli datum generate_gate_selector", selected_date)
    //         return
    //     }
    console.log(document.getElementById('ramp_title').innerHTML)
    if (document.getElementById('ramp_title').innerHTML.includes("Ramps")){
        let values = elem.value.split(" - ");
        global_calendar(parseInt(values[0],10),parseInt(values[1],10))
        document.getElementById('ramp_title').innerHTML = "Ramps "+elem.value;
    }else if(document.getElementById('ramp_title').innerHTML.includes("Ramp")){
        show_full_gate(document.getElementById('ramp_title').innerHTML.split(" ")[1])
    }else{
        find_by(document.getElementById('input_text'));
        ///print("dsadasdsa22222222");
    }


}
/**
 * obstaranie pola find by
 * @param elem :HTML
 */
function find_by(elem){
    //if (document.getElementById("ramp_title").innerHTML === 'invalid date') {
    //         console.log("zli datum  filter_text")
    //         return
    //     }
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


        make_table_for_external_dispatcher('prepared','prepared_tr','prepared');
        make_table_for_external_dispatcher('requested','requested_tr','requested');
        make_table_for_external_dispatcher('booked','booked_tr','booked');
        make_table_for_external_dispatcher('finished','finished_tr','finished');
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


        document.getElementById('ramp_title').innerHTML = "Ramps "+document.getElementById('select_gate').value;
        generate_gate_selector(document.getElementById('select_gate'));

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
    while (table_rows_with_class_name.length){
        table_rows_with_class_name[0].remove();
    }
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
        for (let index_of_certain_time_slots_in_calendar = 0 ; index_of_certain_time_slots_in_calendar < gates.array_of_calendars[calendar].time_slots.length; index_of_certain_time_slots_in_calendar++){
            for (let certain_time_slot = 0; certain_time_slot < gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].states.length ; certain_time_slot++){
                if (gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].states[certain_time_slot] === state){
                    // pokial je row prepared negenegrovat s rovnakim casom ak sa uz cas nachada v
                    let row = table_witch_contains_id.insertRow();
                    row.className = row_class_name;
                    let cell1 = row.insertCell(0);
                    cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].start_times[certain_time_slot];
                    // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);

                    if (state !== 'prepared'){

                        cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].external_dispatchers[certain_time_slot]
                        cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].evcs[certain_time_slot];
                        cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].destinations[certain_time_slot];
                        cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].commoditys[certain_time_slot];
                    }

                    let cell6 = row.insertCell(5);

                    // treba pridat funkcionalitu buutonom
                    if (state === 'prepared'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-success only_one";
                        apply_button.innerHTML="SHOW";
                        apply_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot]);
                            //let index = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot];
                            console.log('PREPARED  ',index);
                        }
                        cell6.className="td_flex_buttons";
                        cell6.appendChild(apply_button);
                    }else if(state === 'requested'){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="SHOW";
                        show_button.onclick = function (){
                            //let index = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot];
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot]);
                            console.log('REQUEST  ',index);
                        }
                        cell6.className="td_flex_buttons";
                        cell6.appendChild(show_button);
                    }else if(state === 'booked' || state === 'finished'){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="SHOW";
                        show_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot]);
                            //let index = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot];
                            console.log('BOOKED  ',index);
                        }
                        cell6.className="td_flex_buttons";
                        cell6.appendChild(show_button);
                    }

                }

            }
        }
    }
}

let array_of_options = ['prepared','requested','booked','finished'];
/**
 * pomocna funkcia na precistenie stolikou ktore su vygenerovane funkciou make_table_for_external_dispatcher
 * @param elem :HTML
 */
function select_only_text_with(elem){
    let text = elem.value;

    if (text === 'prepared'|| text ==='requested'||text ==='booked'||text ==='finished'){
        document.getElementById('prepared_h3').style.display = 'none';
        document.getElementById('requested_h3').style.display = 'none';
        document.getElementById('booked_h3').style.display = 'none';
        document.getElementById('finished_h3').style.display = 'none';

        document.getElementById('prepared').style.display = 'none';
        document.getElementById('requested').style.display = 'none';
        document.getElementById('booked').style.display = 'none';
        document.getElementById('finished').style.display = 'none';
        // jedine tieto zobraz ak je text urciteho typu
        document.getElementById(text).style.display = 'revert';
        document.getElementById(text+'_h3').style.display = 'revert';
        select(text,':')
    }else{
        document.getElementById('prepared_h3').style.display = 'revert';
        document.getElementById('requested_h3').style.display = 'revert';
        document.getElementById('booked_h3').style.display = 'revert';
        document.getElementById('finished_h3').style.display = 'revert';

        document.getElementById('prepared').style.display = 'revert';
        document.getElementById('requested').style.display = 'revert';
        document.getElementById('booked').style.display = 'revert';
        document.getElementById('finished').style.display = 'revert';
        for (let i = 0 ;i < array_of_options.length;i++){
            select(text,array_of_options[i])
        }
    }


}
function select(lock_for,option){
    let founded = false;
    let table_rows_with_class_name = document.getElementsByClassName(option+"_tr");
    for (let row = 0 ; row < table_rows_with_class_name.length; row++){
        founded = false;
        for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
            if (table_rows_with_class_name[row].childNodes[column].innerHTML.includes(lock_for)) {
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

function update_handler(){
    load_all_time_slots()
    setTimeout(update_handler,1000); ///*60*5 1000 je jedna sekunda  teda update bude prebiehat kazdich 5 minut
}
function loop(){

    //console.log(document.documentElement.clientWidth);
    document.getElementById('only_requested').style.left = (document.documentElement.clientWidth/2)-50+'px';
    //document.getElementById('only_requested_count').innerHTML = "";
    setTimeout(loop,200);


}
function show_requested(){
    document.getElementById('input_text').value = 'requested';
    find_by(document.getElementById('input_text'));
    console.log('dsadsadsad');
}
function show_info(){
    console.log('INFOOOOO');
}