Array.prototype.random = function () {
    return this[Math.floor((Math.random()*this.length))];
}

let array_of_options = ['prepared','requested','booked','finished'];

function update_handler(){
    console.log('loooop');
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
    let selector = document.getElementById('select_only');
    if (text === 'prepared'){
        selector.selectedIndex = "1";
    }else if (text === 'requested'){
        selector.selectedIndex = "2";
    }else if (text === 'booked'){
        selector.selectedIndex = "3";
    }else{
        selector.selectedIndex = "4";
    }
    select_only(selector)
}

let selected_date ; // dolezita premena pre dalsie selecti a posuni pmocou sipiek pri minicalendari a samotnom calendari
let actual_date_now ;
/**
 * funkica ktora nacita akutalni datum dnesneho dna a prradi ho do mini calendaru
 */
setTimeout(first_load,150);


function pad2(n) {  // always returns a string
    return (n < 10 ? '0' : '') + n;
}


function first_load(){
    let new_date = new Date();
    let date = new Date();
    let y = new_date.getFullYear();
    let mm = new_date.getMonth();
    let d = new_date.getDate();

    let h = new_date.getHours();
    let m = new_date.getMinutes();
    let s = new_date.getSeconds();
    h = pad2(h);
    m = pad2(m);
    s = pad2(s);
    mm = pad2(mm+ 1);
    d = pad2(d);

    actual_date_now = y+'-'+mm+'-'+d+' '+h+":"+m+":"+s;
    document.getElementById('input_date').value = new_date.toISOString().substr(0,10);//new_date.toDateString(); //new_date.toISOString().substr(0,10);
    new_date.setDate(new_date.getDate() -7 ); // maximum vyditelnich dni +7 EXD
    document.getElementById('input_date').min=new_date.toISOString().substr(0,10);

    new_date.setDate(new_date.getDate() + 21); // maximum vyditelnich dni +7 EXD
    document.getElementById('input_date').max=new_date.toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);

    document.getElementById('date_number').innerHTML = selected_date;
    update_handler();
    loop()
}
// window.onload= function() {
//
//
// }
/**
 * mini calendar arrows onclick event a zaroven mini calendar onchange event
 * @how_many_or_elem  :HTML/:integer
 */
function make_date(how_many_or_elem){
    let only_one_day = document.getElementById('select_only_day').value;
    if (only_one_day === 'One day'){
        document.getElementById('select_only_day').style.border = '1px solid #ced4da';
        if (how_many_or_elem !== 1 && how_many_or_elem !== -1 ){ // pkial sa klika na sipky pri minicalendari
            let new_date = how_many_or_elem.value;
            if (new_date <  document.getElementById('input_date').min || new_date >  document.getElementById('input_date').max ){
                console.log('chybni');
                document.getElementById('date_number').innerHTML = "date is not valid";

            }else{
                document.getElementById('date_number').innerHTML = new_date;
                //document.getElementById('input_date').value=new_date.toISOString().substr(0,10);
                //document.getElementById('date_number').innerHTML = new_date.toISOString().substr(0,10);
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
                document.getElementById('date_number').innerHTML = new_date.toISOString().substr(0,10);
                generate_HTML();
                find_by(document.getElementById('input_text'))
            }
        }
    }else{
        create_exception('Please select <strong> One day </strong> in last select box in top bar .' , 6 , 'warning');
        document.getElementById('select_only_day').style.border = '1px solid #ff0000';
    }

}
function generate_HTML(){
    make_table_for_external_dispatcher('prepared','prepared_tr','prepared' , false);
    make_table_for_external_dispatcher('requested','requested_tr','requested'  , false);
    make_table_for_external_dispatcher('booked','booked_tr','booked'  , false);
    make_table_for_external_dispatcher('finished','finished_tr','finished'  , false );
    select_only_new_old(document.getElementById('select_only_new_old').value);
    if (document.getElementById('input_text').value !== ''){
        find_by(document.getElementById('input_text'));
    }
}
function select_only_day(elem_val){
    if (elem_val === 'One day'){
        generate_HTML();
        document.getElementById('select_only_day').style.border = '1px solid #ced4da';
    }else{
        make_table_for_external_dispatcher_all();
        if (document.getElementById('input_text').value !== ''){
            find_by(document.getElementById('input_text'));
        }
    }
}



/**
 * obstaranie pola find by
 * @param elem :HTML
 */
function find_by(elem){
    let text = elem.value.split(' ');
    let founded = false;
    let display_only = document.getElementById('select_only').value.split(" ");
    // funkcia spracovava data aj podala selectoru ktori sa nachadza vedla find by
    if (display_only[0] === 'all'){
        for (let i = 0 ;i < array_of_options.length;i++){
            founded = false;
            let table_rows_with_class_name = document.getElementsByClassName(array_of_options[i]+"_tr");
            for (let row = 0 ; row < table_rows_with_class_name.length; row++){
                founded = false;
                for (let index_text = 0 ;index_text < text.length;index_text++){
                    if (table_rows_with_class_name[row].innerHTML.toLowerCase().includes((text[index_text] === undefined) ? ':'  :text[index_text].toLowerCase() )){// && table_rows_with_class_name[row].style.display !== 'none'){//&& table_rows_with_class_name[row].style.display === 'revert'
                        founded = true;
                    }else{
                        founded = false;
                        break;
                    }
                }
                if (founded || text[0] === undefined ){
                    table_rows_with_class_name[row].style.display = 'revert';
                }else{
                    table_rows_with_class_name[row].style.display = 'none';
                }
            }
        }
    }else{
        let table_rows_with_class_name = document.getElementsByClassName(display_only[1]+"_tr");
        for (let row = 0 ; row < table_rows_with_class_name.length; row++){
            founded = false;
            for (let index_text = 0 ;index_text < text.length;index_text++){
                if (table_rows_with_class_name[row].innerHTML.toLowerCase().includes((text[index_text] === undefined) ? ':'  :text[index_text].toLowerCase() )){// && table_rows_with_class_name[row].style.display !== 'none'){//&& table_rows_with_class_name[row].style.display === 'revert'
                    founded = true;
                }else{
                    founded = false;
                    break;
                }
            }
            if (founded || text[0] === undefined ){
                table_rows_with_class_name[row].style.display = 'revert';
            }else{
                table_rows_with_class_name[row].style.display = 'none';
            }
        }
    }
}

function select_only_new_old(elem_val){
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
        try{
            let parent = table_rows_with_class_name_copy[0].parentElement;
            while (table_rows_with_class_name_copy.length) {
                table_rows_with_class_name_copy[0].remove();
            }
            if(array_of_options[i] === 'prepared'){
                for (let elem = 0; elem < table_rows_with_class_name.length; elem++) {
                    if (table_rows_with_class_name[elem].childNodes[5].innerHTML.includes('button')){
                        parent.append(table_rows_with_class_name[elem]);
                    }
                }
            }else{
                for (let elem = 0; elem < table_rows_with_class_name.length; elem++) {
                    parent.append(table_rows_with_class_name[elem]);
                }
            }
        }catch (e){
            // console.log('nexistuje rodic prazdne tabulky !!!');
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
                document.getElementById(array_of_options[i]+'_title').style.display ='none';
            }else{
                document.getElementById(array_of_options[i]).style.display ='revert';
                document.getElementById(array_of_options[i]+'_title').style.display ='revert';
            }
        }
    }else{
        for (let i = 0 ;i < array_of_options.length;i++){
            document.getElementById(array_of_options[i]).style.display ='revert';
            document.getElementById(array_of_options[i]+'_title').style.display ='revert';
        }
    }
    find_by(document.getElementById('input_text'));
}



let gates = new Gate();
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
    document.getElementById('only_prepared_count').innerHTML = counter_prepared+"";
    document.getElementById('only_requested_count').innerHTML = counter_requested+"";
    document.getElementById('only_booked_count').innerHTML = counter_booked+"";
    document.getElementById('only_finished_count').innerHTML = counter_finished+"";
}

/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function  load_all_time_slots(){
    $.post('external_AJAX/load_all_time_slots.php',{
    },function(data){
        if (typeof data === 'object'){
            parse_data(data);
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
    setTimeout(select_only_day,250,'All days'); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom
}


function remove_all_tables(){
   array_of_options.forEach(value => {
        let table_rows_with_class_name = document.getElementsByClassName(value+'_tr');
        while (table_rows_with_class_name.length){ // delete all row of certain table
            table_rows_with_class_name[0].remove();
        }
    })

}
function make_table_for_external_dispatcher_all(){
    if (gates.array_of_calendars.length === 0 ){
        setTimeout(make_table_for_external_dispatcher_all,100);
        return
    }
    remove_all_tables()

    let prepared_times = [] ;
    let all_prepared_times_ids = {};
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++) {
        for (let calendar_real_time = 0; calendar_real_time < gates.array_of_calendars[calendar].time_slots.length; calendar_real_time++) {
            for (let only_time_slot = 0; only_time_slot < gates.array_of_calendars[calendar].time_slots[calendar_real_time].states.length; only_time_slot++) {
                let state =  gates.array_of_calendars[calendar].time_slots[calendar_real_time].states[only_time_slot];
                if (state === 'prepared' && !prepared_times.includes(gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot])) {
                    prepared_times.push(gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]);
                    all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]] = [gates.array_of_calendars[calendar].time_slots[calendar_real_time].ids[only_time_slot]];
                } else if (state === 'prepared') {
                    all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]].push(gates.array_of_calendars[calendar].time_slots[calendar_real_time].ids[only_time_slot]);
                    continue;
                }
                let row = document.getElementById(state).insertRow();
                row.className = state+'_tr';
                let cell1 = row.insertCell(0);

                cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot];

                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                let cell4 = row.insertCell(3);
                let cell5 = row.insertCell(4);
                if (state !== 'prepared') {
                    if (gates.array_of_calendars[calendar].time_slots[calendar_real_time].kamionists_2[only_time_slot] !== null) {
                        cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].kamionists_1[only_time_slot]
                            + "<br>" + gates.array_of_calendars[calendar].time_slots[calendar_real_time].kamionists_2[only_time_slot];
                    } else {
                        cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].kamionists_1[only_time_slot];
                    }


                    cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].evcs[only_time_slot];
                    cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].destinations[only_time_slot];

                    if (gates.array_of_calendars[calendar].time_slots[calendar_real_time].commoditys[only_time_slot].length > 40) {
                        create_html_linked_text(gates.array_of_calendars[calendar].time_slots[only_time_slot].commoditys[only_time_slot], cell5)
                    } else {
                        cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[calendar_real_time].commoditys[only_time_slot];
                    }
                }

                let cell6 = row.insertCell(5);

                if (state === 'prepared') {

                    let apply_button = document.createElement("BUTTON")
                    apply_button.className = "btn btn-default bg-success only_one";
                    apply_button.innerHTML = "apply";
                    apply_button.onclick = function () {
                       Time_slot.open_time_slot(all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]].random(), 'prepared');
                    }
                    cell6.className = "td_flex_buttons";
                    if (actual_date_now > gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]) {
                    } else {
                        cell6.appendChild(apply_button);
                    }

                } else if (state === 'requested') {
                    let show_button = document.createElement("BUTTON")
                    show_button.className = "btn btn-default bg-primary only_one";
                    show_button.innerHTML = "show";
                    show_button.onclick = function () {
                        Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[calendar_real_time].ids[only_time_slot], 'requested');
                        console.log('REQUESTED');
                    }
                    cell6.className = "td_flex_buttons";
                    if (actual_date_now > gates.array_of_calendars[calendar].time_slots[calendar_real_time].start_times[only_time_slot]) {
                    } else {
                        cell6.appendChild(show_button);
                    }
                }
            }
        }
    }
    select_only_new_old(document.getElementById('select_only_new_old').value);
}




/**
 * funkcia na vitvorenie tables 'prepared'/'requested'/'booked'/'finished'
 * @param id_of_table HTML.id table ktori sa ide spracovat :string
 * @param row_class_name HTML.class_name rows ktore sa idu spracovat :string
 * @param state parameter kontoli pri vibere time slotov :string
 * @param all parameter selectoru One day / All days :bool
 */

function make_table_for_external_dispatcher(id_of_table , row_class_name , state , all){
    let table_witch_contains_id = document.getElementById(id_of_table);
    let table_rows_with_class_name = document.getElementsByClassName(row_class_name);
    while (table_rows_with_class_name.length){ // delete all row of certain table
        table_rows_with_class_name[0].remove();
    }
    let prepared_times = [] ;
    let all_prepared_times_ids = {};

    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
    let index_for_this_date = gates.array_of_calendars[calendar].get_index_by_real_time(document.getElementById('input_date').value); // da sa pouzit premena 'selected_date'
        if (index_for_this_date !== -1 ){
            for (let certain_time_slot = 0; certain_time_slot < gates.array_of_calendars[calendar].time_slots[index_for_this_date].states.length ; certain_time_slot++){
                if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].states[certain_time_slot] === state){
                    // pokial je row prepared negenegrovat s rovnakim casom ak sa uz cas nachada v
                    if (state === 'prepared' && ! prepared_times.includes(gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot])){
                        prepared_times.push(gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]);
                        all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]]  = [gates.array_of_calendars[calendar].time_slots[index_for_this_date].ids[certain_time_slot]];
                    }else if(state === 'prepared'){
                        all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]].push(gates.array_of_calendars[calendar].time_slots[index_for_this_date].ids[certain_time_slot]);
                        continue;
                    }
                    let row = table_witch_contains_id.insertRow();
                    row.className = row_class_name;
                    let cell1 = row.insertCell(0);
                    if (all){
                        cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot];
                    }else{
                        cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot].split(" ")[1];
                    }
                    // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);
                    if (state !== 'prepared'){
                        if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot] !== null){
                            cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot]
                                +"<br>"+gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot];
                        }else{
                            cell2.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot];
                        }


                        cell3.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].evcs[certain_time_slot];
                        cell4.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].destinations[certain_time_slot];

                        if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].commoditys[certain_time_slot].length > 40){
                            create_html_linked_text(gates.array_of_calendars[calendar].time_slots[index_for_this_date].commoditys[certain_time_slot],cell5)

                        }else{
                            cell5.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].commoditys[certain_time_slot];
                        }


                    }

                    let cell6 = row.insertCell(5);

                    // treba pridat funkcionalitu buutonom
                    if (state === 'prepared'){
                        let apply_button = document.createElement("BUTTON")
                        apply_button.className="btn btn-default bg-success only_one";
                        apply_button.innerHTML="apply";
                        apply_button.onclick = function (){
                            Time_slot.open_time_slot(all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]].random(),'prepared');
                        }
                        cell6.className="td_flex_buttons";
                        if (actual_date_now >gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]){
                        }else{
                            cell6.appendChild(apply_button);
                        }

                    }else if(state === 'requested'){
                        let show_button = document.createElement("BUTTON")
                        show_button.className="btn btn-default bg-primary only_one";
                        show_button.innerHTML="show";
                        show_button.onclick = function (){
                            Time_slot.open_time_slot(gates.array_of_calendars[calendar].time_slots[index_for_this_date].ids[certain_time_slot],'requested');
                        }
                        cell6.className="td_flex_buttons";
                        if (actual_date_now >gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]){
                        }else{
                            cell6.appendChild(show_button);
                        }

                    }
                }
            }
        }
    }
    // }
}

