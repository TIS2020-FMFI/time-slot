let gates = undefined;
/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    gates = new Gate();
    linked_id = 0;
    let counter_requested = 0 ;
    let counter_prepared = 0 ;
    let counter_booked = 0 ;
    let counter_finished = 0 ;
    for(let i = 0 ; i < data.length;i ++){
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
        // [9] == order |
        // [10] == driver 1
        // [11] == driver 2
        if (data[i][5] === "requested"){
            counter_requested++;
        }else if (data[i][5] === "prepared"){
            counter_prepared++;
        }else if (data[i][5] === "booked"){
            counter_booked++;
        }else {
            counter_finished++;
        }

        let index = gates.get_index_by_id(data[i][1])
        if (index >= 0){
            let index_real_time = gates.array_of_calendars[index].get_index_by_real_time(data[i][2]);
            if (index_real_time >= 0){
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10],data[i][11]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10],data[i][11]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(data[i][2],time_slot);
            }
        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_internal_dispatcher(data[i][0],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10],data[i][11]);
            calendar.push_real_time_and_time_slot(data[i][2],time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }
    }
    document.getElementById('only_prepared_count').innerHTML = counter_prepared+"";
    document.getElementById('only_requested_count').innerHTML = counter_requested+"";
    document.getElementById('only_booked_count').innerHTML = counter_booked+"";
    document.getElementById('only_finished_count').innerHTML = counter_finished+"";
    make_table_for_external_dispatcher('prepared','prepared_tr','prepared');
    make_table_for_external_dispatcher('requested','requested_tr','requested');
    make_table_for_external_dispatcher('booked','booked_tr','booked');
    make_table_for_external_dispatcher('finished','finished_tr','finished');
    select_by('Newest');
}

/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function load_all_time_slots() {
    $.post('internal_AJAX/load_all_time_slots.php',{
    },function(data){
        if (typeof data === 'object'){
            parse_data(data);
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
    generate_gate_selector(document.getElementById('select_gate'));
}

let selected_date ;
/**
 * funkica ktora nacita akutalni datum dnesneho dna a prradi ho do mini calendaru
 */
setTimeout(first_load,250);

function first_load(){
    load_all_time_slots();
    let currentTime = new Date();
    document.getElementById('input_date').value = currentTime.toISOString().substr(0,10);
    currentTime.setDate(currentTime.getDate()-7);
    document.getElementById('input_date').min= currentTime.toISOString().substr(0,10);
    currentTime.setDate(currentTime.getDate()+21);
    document.getElementById('input_date').max= currentTime.toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);
    loop();
    setTimeout(update_handler , 60*5*1000);
}

function clear_find_by(){
    let elem = document.getElementById('input_text');
    if (elem.value !== ''){
        elem.value = '';
        find_by(elem);
    }
}

function select_by(elem_val){
    let multiplayer = 1;
    if (elem_val === 'Newest'){
        multiplayer *= -multiplayer
    }
    for (let i = 0 ;i < array_of_options.length;i++) {
        let all = document.getElementsByClassName(array_of_options[i] + "_tr");
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

        let table_rows_with_class_name_copy = document.getElementsByClassName(array_of_options[i] + "_tr");
        let parent = table_rows_with_class_name_copy[0].parentElement;
        while (table_rows_with_class_name_copy.length) {
            table_rows_with_class_name_copy[0].remove();
        }
        for (let elem = 0; elem < table_rows_with_class_name.length; elem++) {
            parent.append(table_rows_with_class_name[elem]);
        }
    }
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
    display_time_slot_for_this_date(document.getElementById('input_date'));
}

/**
 * mini calendar onchange event
 * @elem  :HTML
 */
function display_time_slot_for_this_date(elem){
    if (document.getElementById('input_text').value !== "" ){
        find_by(document.getElementById('input_text'));
    }else{
        if ( elem.min > elem.value || elem.value > elem.max) {
            create_exception("Selected date is not in a valid range. The valid range is from <strong>"+elem.min+"</strong> to <strong>"+elem.max+"</strong>.", 10, "warning")
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
            gate_index = int_index;
        }else{
            index = elem.className.split(" ");
            int_index = parseInt(index[index.length-1],10);
            gate_index = parseInt(values[0],10)+ ((int_index%8) -1);

        }
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

                    let ed_time = gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].end_times[count_time_slots].split(" ")[1];
                    let ed_time_strings = ed_time.split(":");
                    let ed_time_index = parseInt(ed_time_strings[0],10)*60 + parseInt(ed_time_strings[1],10);
                    let final_ed_index = Math.trunc(ed_time_index/30);

                    let html_row_count = 0;
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'occupied'){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_half_hours[make_html*7+day].style.backgroundColor = "#717983";
                            html_row_count ++
                            if (html_row_count === 3) {
                                row_columns_in_half_hours[make_html * 7 + day].innerHTML = "occupied";
                            }
                            if (html_row_count === 5){
                                row_columns_in_half_hours[make_html*7+day].style.borderBottom = '3px solid #f8f9fa';
                            }else{
                                row_columns_in_half_hours[make_html*7+day].style.borderBottom = '0px';
                                }
                        }
                    }
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'prepared' ){
                        for (let make_html = final_st_index ;make_html < final_ed_index;make_html++){
                            row_columns_in_half_hours[make_html*7+day].style.backgroundColor = "#2eff00";
                            html_row_count ++
                            if (html_row_count === 1) {
                                row_columns_in_half_hours[make_html * 7 + day].innerHTML = "Free";
                            }
                            if (html_row_count === 5){
                                let show_button = document.createElement("BUTTON")
                                show_button.className = "btn btn-default bg-primary only_one";
                                show_button.onclick = function (){
                                    Time_slot.open_time_slot(gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].ids[count_time_slots],'prepared' );
                                    //let index = gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].ids[count_time_slots];
                                    console.log('PREPARED  ',index);
                                }
                                show_button.innerHTML = "SHOW";

                                row_columns_in_half_hours[make_html*7+day].style.borderBottom = '3px solid #f8f9fa';
                                row_columns_in_half_hours[make_html*7+day].appendChild(show_button);
                            }else{
                                row_columns_in_half_hours[make_html*7+day].style.borderBottom = '0px';
                            }
                        }
                    }

                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'requested' ){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#ff9900',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots,'requested');
                            html_row_count ++
                            // treba pridat event click
                        }
                    }
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'booked'){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#ff0000',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots,'booked');
                            html_row_count ++
                            // treba pridat event click
                        }
                    }
                    if (gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time].states[count_time_slots] === 'finished'){
                        for (let make_html = final_st_index ;make_html <= final_ed_index;make_html++){
                            generate_html_column_for_show_full_ramp(html_row_count,make_html*7+day,'#9d00ff',gates.array_of_calendars[refactor_index_because_array].time_slots[index_real_time],count_time_slots,'finished');
                            html_row_count ++
                        }

                    }
                }
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
 * @param state :state of time slot
 */
function generate_html_column_for_show_full_ramp(html_row_count,index_of_column,color,time_slot,time_slot_index,state){
    row_columns_in_half_hours[index_of_column].style.backgroundColor = color;
    row_columns_in_half_hours[index_of_column].style.borderBottom = '0px';
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
        if (time_slot.commoditys[time_slot_index].length > 40){
            create_html_linked_text(time_slot.commoditys[time_slot_index],row_columns_in_half_hours[index_of_column])

        }else{
            row_columns_in_half_hours[index_of_column].innerHTML = time_slot.commoditys[time_slot_index];
        }
    }
    else if (html_row_count === 4){
        let show_button = document.createElement("BUTTON")
        show_button.className = "btn btn-default bg-primary only_one";
        show_button.onclick = function (){
            Time_slot.open_time_slot(time_slot.ids[time_slot_index],state);
        }
        show_button.innerHTML = "SHOW";

        row_columns_in_half_hours[index_of_column].style.borderBottom = '3px solid #f8f9fa';
        row_columns_in_half_hours[index_of_column].appendChild(show_button);
    }
}

function do_global_count_in_day(){
    let elem_prepared_row = document.getElementById('prepared_row_day');
    let elem_requested_row = document.getElementById('requested_row_day');
    let elem_booked_row = document.getElementById('booked_row_day');
    let elem_finished_row = document.getElementById('finished_row_day');
    let prepared = 0;
    let occupied = 0;
    let requested = 0;
    let booked = 0;
    let finished = 0;
    for(let i = 0 ; i < gates.array_of_calendars.length; i++) {
        if (gates.ids[i] >= 0 && gates.ids[i] <= 37) {
            let index = gates.array_of_calendars[i].get_index_by_real_time(selected_date);
            prepared += gates.array_of_calendars[i].time_slots[index].count_of_states("prepared");
            occupied += gates.array_of_calendars[i].time_slots[index].count_of_states("occupied");
            requested += gates.array_of_calendars[i].time_slots[index].count_of_states("requested");
            booked += gates.array_of_calendars[i].time_slots[index].count_of_states("booked");
            finished += gates.array_of_calendars[i].time_slots[index].count_of_states("finished");
        }
    }

    elem_prepared_row.innerHTML = 'Prepared ('+(prepared+occupied)+')';
    elem_requested_row.innerHTML = 'Requested ('+requested+')';
    elem_booked_row.innerHTML = 'Booked ('+booked+')';
    elem_finished_row.innerHTML = 'Finished ('+finished+')';
}
/**
 *  prvotni nahlad kalendaru, indexes su ziskane z a prsnuteho 'select_gate' format pre pc '1 - 7'  pre tablet '1 - 5' a mobil '1 - 3'
 * @param start_index :integer
 * @param end_index :integer
 */
function global_calendar(start_index, end_index){
    function global_calendar(start_index, end_index){
        try{
            let row_prepared_occupied =  document.getElementsByClassName('prepared_occupied');
            let row_requested = document.getElementsByClassName('requested');
            let row_booked = document.getElementsByClassName('booked');
            let row_finished = document.getElementsByClassName('finished');
            let row_gates_titles = document.getElementsByClassName('days_in_calendar');
            // global

            do_global_count_in_day();

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
                //console.log(enumerate+start_index , end_index )
                for (let i = enumerate;i < end_index-start_index+1;i++){
                    row_prepared_occupied[i].innerHTML = "None";
                    row_requested[i].innerHTML = "None";
                    row_booked[i].innerHTML = "None";
                    row_finished[i].innerHTML = "None";
                    row_gates_titles[i].innerHTML = "None";
                }
            }
        }catch (err){
            console.log('err')
            let row_prepared_occupied =  document.getElementsByClassName('prepared_occupied');
            let row_requested = document.getElementsByClassName('requested');
            let row_booked = document.getElementsByClassName('booked');
            let row_finished = document.getElementsByClassName('finished');
            let row_gates_titles = document.getElementsByClassName('days_in_calendar');

            let elem_prepared_row = document.getElementById('prepared_row_day');
            let elem_requested_row = document.getElementById('requested_row_day');
            let elem_booked_row = document.getElementById('booked_row_day');
            let elem_finished_row = document.getElementById('finished_row_day');
            let prepared = 0;
            let occupied = 0;
            let requested = 0;
            let booked = 0;
            let finished = 0;

            elem_prepared_row.innerHTML = 'Prepared ('+(prepared+occupied)+')';
            elem_requested_row.innerHTML = 'Requested ('+requested+')';
            elem_booked_row.innerHTML = 'Booked ('+booked+')';
            elem_finished_row.innerHTML = 'Finished ('+finished+')';


            for (let i = 0;i < row_gates_titles.length ;i++){

                row_prepared_occupied[i].innerHTML = "None";
                row_requested[i].innerHTML = "None";
                row_booked[i].innerHTML = "None";
                row_finished[i].innerHTML = "None";
                row_gates_titles[i].innerHTML = "None";
            }
            setTimeout(global_calendar,100,start_index, end_index);
        }
}

let base_selected_index = 0;

/**
 * onchange event funkcia pre gate_selector
 * @param elem
 */
function generate_gate_selector(elem){
    if (elem===1) {
        if (base_selected_index+1 > 5) {
            base_selected_index = 0;
        } else {
            base_selected_index += 1;
        }
    }

    if (elem===-1) {
        if (base_selected_index-1 < 0) {
            base_selected_index = 5;
        } else {
            base_selected_index -= 1;
        }
    }

    if (elem===-1 || elem===1) {
        document.getElementsByClassName("option_ramp")[base_selected_index].checked = true;
        document.getElementById("select_gate").selectedIndex = base_selected_index;
        elem=document.getElementsByClassName("option_ramp")[base_selected_index];
    }else{
        base_selected_index = document.getElementById("select_gate").selectedIndex;
    }

    if (document.getElementById('ramp_title').innerHTML.includes("Ramps")){
        let values = elem.value.split(" - ");
        global_calendar(parseInt(values[0],10),parseInt(values[1],10))
        document.getElementById('ramp_title').innerHTML = "Ramps "+elem.value;
    }else if(document.getElementById('ramp_title').innerHTML.includes("Ramp")){
        show_full_gate(document.getElementById('ramp_title').innerHTML.split(" ")[1])
    }else{
        find_by(document.getElementById('input_text'));
    }
}

/**
 * obstaranie pola find by
 * @param elem :HTML
 */
function find_by(elem){
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
                    let cell6 = row.insertCell(5);
                    let cell7 = row.insertCell(6);
                    if (state === 'prepared'){
                        cell2.innerHTML = 'ramp-'+gates.ids[calendar];
                    }

                    if (state !== 'prepared'){

                        cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].destinations[certain_time_slot];
                        cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].external_dispatchers[certain_time_slot];
                        cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].evcs[certain_time_slot];
                        if (gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].kamionists_2[certain_time_slot] !== null) {
                            cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].kamionists_1[certain_time_slot]
                                + "<br>" + gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].kamionists_2[certain_time_slot];
                        } else {
                            cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].kamionists_1[certain_time_slot];
                        }
                        if (gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].commoditys[certain_time_slot].length > 40){
                            create_html_linked_text(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].commoditys[certain_time_slot],cell6)
                        }else{
                            cell6.innerHTML = gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].commoditys[certain_time_slot];
                        }
                    }



                    // treba pridat funkcionalitu buutonom
                    if (state === 'prepared'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-success only_one";
                        apply_button.innerHTML="SHOW";
                        apply_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot],'prepared');
                        }
                        cell7.className="td_flex_buttons";
                        cell7.appendChild(apply_button);
                    }else if(state === 'requested'){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="SHOW";
                        show_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot],'requested');
                        }
                        cell7.className="td_flex_buttons";
                        cell7.appendChild(show_button);
                    }else if(state === 'booked' ){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="SHOW";
                        show_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot],'booked');
                        }
                        cell7.className="td_flex_buttons";

                        cell7.appendChild(show_button);
                    }else if(state === 'finished'){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="SHOW";
                        show_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_of_certain_time_slots_in_calendar].ids[certain_time_slot],'finished');
                            console.log('BOOKED  ',index);
                        }
                        cell7.className="td_flex_buttons";

                        cell7.appendChild(show_button);
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
    let text_split = elem.value.split(' ')[0];

    if (text_split === 'prepared'|| text_split ==='requested'||text_split ==='booked'||text_split ==='finished'){
        document.getElementById('prepared_h3').style.display = 'none';
        document.getElementById('requested_h3').style.display = 'none';
        document.getElementById('booked_h3').style.display = 'none';
        document.getElementById('finished_h3').style.display = 'none';

        document.getElementById('prepared').style.display = 'none';
        document.getElementById('requested').style.display = 'none';
        document.getElementById('booked').style.display = 'none';
        document.getElementById('finished').style.display = 'none';
        // jedine tieto zobraz ak je text urciteho typu
        document.getElementById(text_split).style.display = 'revert';
        document.getElementById(text_split+'_h3').style.display = 'revert';
        select(text,':');
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
            select(text,array_of_options[i]);
        }
    }


}
function select(lock_for,option){
    let text = lock_for.split(' ');
    if (array_of_options.includes(text[0])){
        let table_rows_with_class_name = document.getElementsByClassName(text[0]+"_tr");
        console.log(table_rows_with_class_name.length);
        for (let row = 0 ; row < table_rows_with_class_name.length; row++) {
            for (let column = 0; column < table_rows_with_class_name[row].childNodes.length - 1; column++) {
                let found_match = false;
                for (let index_text = 1 ;index_text < text.length;index_text++){
                    if (table_rows_with_class_name[row].innerHTML.toLowerCase().includes((text[index_text] === undefined) ? ':'  :text[index_text].toLowerCase() )){// && table_rows_with_class_name[row].style.display !== 'none'){//&& table_rows_with_class_name[row].style.display === 'revert'
                        found_match = true;
                    }else{
                        found_match = false;
                        break;
                    }
                }
                if (found_match || text[1] === undefined ){
                    table_rows_with_class_name[row].style.display = 'revert';
                }else{
                    table_rows_with_class_name[row].style.display = 'none';
                }
            }
        }
    }else{
        let founded = false;
        let table_rows_with_class_name = document.getElementsByClassName(option+"_tr");
        for (let row = 0 ; row < table_rows_with_class_name.length; row++){
            founded = false;
            for (let column = 0;column < table_rows_with_class_name[row].childNodes.length-1; column++){
                if (table_rows_with_class_name[row].childNodes[column].innerHTML.toLowerCase().includes(lock_for.toLowerCase())) {
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

function update_handler(){
    load_all_time_slots()
    setTimeout(update_handler,1000*60*5); ///*60*5 -->1000 je jedna sekunda  teda update bude prebiehat kazdich 5 minut
}
function loop(){
    document.getElementById('only_prepared').style.left = (document.documentElement.clientWidth/2)-200+'px';
    document.getElementById('only_requested').style.left = (document.documentElement.clientWidth/2)-100+'px';
    document.getElementById('only_booked').style.left = (document.documentElement.clientWidth/2)+'px';
    document.getElementById('only_finished').style.left = (document.documentElement.clientWidth/2)+100+'px';

    setTimeout(loop,100);
}
function select_only_by_state_top(text){
    document.getElementById('input_text').value = text;
    find_by(document.getElementById('input_text'));
}

function show_info(){
    document.getElementById('info').style.display = 'revert';
}
function hide_info(){
    document.getElementById('info').style.display = 'none';
}