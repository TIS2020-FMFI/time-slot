Array.prototype.random = function () {
    return this[Math.floor((Math.random()*this.length))];
}
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
//loop();


function update_handler(){
    //console.log('loooop');
    // chyba zobraziea koli tomu ze nepremazavame data tabuliek
    load_all_time_slots()
    setTimeout(update_handler,1000*60*5); ///*60*5 -->1000 je jedna sekunda  teda update bude prebiehat kazdich 5 minut
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
    console.log(new_date);
    console.log(new_date.toDateString())
    console.log(d);
    actual_date_now = y+'-'+mm+'-'+d+' '+h+":"+m+":"+s;
    // console.log(actual_date_now);
    // alert( date.getFullYear() + ("0" + (date.getMonth() + 1)).slice(-2) + ("0" + this.getDate()).slice(-2) + ("0" + this.getHours() + 1 ).slice(-2) + ("0" + this.getMinutes()).slice(-2) + ("0" + this.getSeconds()).slice(-2) );
    document.getElementById('input_date').value = new_date.toISOString().substr(0,10);//new_date.toDateString(); //new_date.toISOString().substr(0,10);
    // console.log(document.getElementById('input_date').value);
    new_date.setDate(new_date.getDate() -7 ); // maximum vyditelnich dni +7 EXD
    document.getElementById('input_date').min=new_date.toISOString().substr(0,10);

    new_date.setDate(new_date.getDate() + 21); // maximum vyditelnich dni +7 EXD
    document.getElementById('input_date').max=new_date.toISOString().substr(0,10);
    selected_date = (new Date()).toISOString().substr(0,10);

    // console.log('actual_date_now',actual_date_now);
    document.getElementById('date_number').innerHTML = selected_date;
    update_handler();
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
}
function generate_HTML(){
    make_table_for_external_dispatcher('prepared','prepared_tr','prepared');
    make_table_for_external_dispatcher('requested','requested_tr','requested');
    make_table_for_external_dispatcher('booked','booked_tr','booked');
    make_table_for_external_dispatcher('finished','finished_tr','finished');
    if (document.getElementById('input_text').value !== ''){
        find_by(document.getElementById('input_text'));
    }
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
                    if (table_rows_with_class_name[row].childNodes[column].innerText.includes(text)) {
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
                if (table_rows_with_class_name[row].childNodes[column].innerText.includes(text)) {
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
    gates = new Gate();
    linked_id = 0;
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
    $.post('external_AJAX/load_all_time_slots.php',{
    },function(data){
        if (typeof data === 'object'){
            parse_data(data);
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("nepodarilo sa spojit so serverom",23,'danger');
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
    let prepared_times = [] ;
    let all_prepared_times_ids = {};


    // generator html pre dani table
    for (let calendar = 0 ; calendar < gates.array_of_calendars.length; calendar++){
        let index_for_this_date = gates.array_of_calendars[calendar].get_index_by_real_time(document.getElementById('input_date').value); // da sa pouzit premena 'selected_date'
        if (index_for_this_date !== -1){
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
                    cell1.innerHTML = gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot].split(" ")[1];
                    // tuna bude podmienka na nieje prepared tak wiplni innner html cell2 a cell3 s menami jazdcov a EVC
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);
                    if (state !== 'prepared'){
                        if (gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot] !== null){
                            //console.log(gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_1[certain_time_slot],gates.array_of_calendars[calendar].time_slots[index_for_this_date].kamionists_2[certain_time_slot]);
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
                            // pokial niekto zmeni funkciju tak bude mat pristup info/time slotom ktore nmusia byt este volne to znamena ze spravi
                            // zapisa tpu 20.12.2020 08:00:00 ale je to malo pravdepodobne neviem ci to treba odchitavat....
                             //console.log(all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]])
                            //console.log(all_prepared_times_ids[gates.array_of_calendars[calendar].time_slots[index_for_this_date].start_times[certain_time_slot]].random())
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
                            console.log('REQUESTED');
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
}

