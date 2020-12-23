let array_of_days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']
let prefix_day = 'input_day_';
let prefix_start_time = 'input_start_';
let prefix_end_time = 'input_end_';
let prefix_special_time = 'input_special_';
let affected_days_in_week = '';
let array_of_holiday = [];
/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function  load_holidays(){
    $.post('config_AJAX/load_holidays.php',{
    },function(data){
        if (data){
            set_html_holidays(data)
        }else{
            alert("chyba nacitana dat s db");
        }
    });
}
load_holidays()
function set_html_holidays(data){
    document.getElementById('exampleFormControlTextarea1').innerText = data[0];
    array_of_holiday = data[0][0].split(',');
}
/**
 * ajax request na ziskanie dat pre externeho dispecera
 */
function  load_config_table(){
    $.post('config_AJAX/get_next_week.php',{
    },function(data){
        if (data){
            affected_days_in_week = data.split('|');

        }else{
            alert("chyba servera");
        }
    });
    $.post('config_AJAX/load_config_table.php',{
    },function(data){
        if (data){
            set_html_times(data)
            //parse_data(data);

        }else{
            alert("chyba nacitana dat s db");
        }
    });
    $.post('config_AJAX/load_disabled.php',{
    },function(data){
        if (data){
            set_html_disabled_ramps(data)
            //parse_data(data);

        }else{
            alert("chyba nacitana dat s db");
        }
    });

}
load_config_table()

function set_html_times(data){
    console.log(affected_days_in_week);
    for (let day = 0 ;day < array_of_days.length;day++){
        if (array_of_holiday.includes(affected_days_in_week[day].substring(5, 10))){
            document.getElementById(prefix_day+array_of_days[day]).innerHTML += "<br><span class='text-danger'>"+affected_days_in_week[day]+"<span>";
        }else{
            document.getElementById(prefix_day+array_of_days[day]).innerHTML += "<br><span class='text-success'>"+affected_days_in_week[day]+"<span>";
        }
        document.getElementById(prefix_start_time+array_of_days[day]).value = data[day][1];
        document.getElementById(prefix_end_time+array_of_days[day]).value =  data[day][2];
        if (data[day][3] === '1'){
            document.getElementById(prefix_special_time+array_of_days[day]).checked = true;
        }
    }
    set_html_for_ramps()
}
function set_html_for_ramps(){
    let elem = document.getElementsByClassName("days_in_calendar_closer");
    for (let day = 0 ;day < affected_days_in_week.length;day++){
        elem[day].innerHTML = affected_days_in_week[day];
    }
}

function set_new_times(){
    let send_array_start = []
    let send_array_end = []
    let send_array_special = []
    for (let day = 0 ;day < array_of_days.length;day++){
        send_array_start.push(document.getElementById(prefix_start_time+array_of_days[day]).value);
        send_array_end.push(document.getElementById(prefix_end_time+array_of_days[day]).value);
        send_array_special.push(document.getElementById(prefix_special_time+array_of_days[day]).checked);
        //console.log(document.getElementById(prefix_start_time+array_of_days[day]).value);
        //console.log(document.getElementById(prefix_end_time+array_of_days[day]).value);
        //console.log(document.getElementById(prefix_special_time+array_of_days[day]).checked);
    }
    $.post('config_AJAX/set_new_times.php',{
        send_array_start:send_array_start,
        send_array_end:send_array_end,
        send_array_special:send_array_special,
    },function(data){
        if (data){
            console.log(data);
        }else{
            alert("chyba nacitana dat s db");
        }
    });
}

function regenerate_new_time_slots(){
    set_new_times();
    set_new_holidays();
    setTimeout(uz_je_na_case_server_isto_skoncil_pracu,250);
    function uz_je_na_case_server_isto_skoncil_pracu(){
        console.log('UZ JE NA CASE')
        //let holidays = document.getElementById('exampleFormControlTextarea1').value;
        $.post('generate_scripts/generate_script_default.php',{
            regenerate:"1"
        },function(data){
            if (data){
                console.log(data); // tuna treba parsnut data napisat IND alebo AD ktroe time sloti boli zasiahnute a ktorim userom treba napisat email
            }else{
                alert("chyba nacitana dat s db");
            }
        });
    }

}
function set_new_holidays(){
    let holidays = document.getElementById('exampleFormControlTextarea1').value;
    $.post('config_AJAX/set_new_holidays.php',{
        holidays:holidays
    },function(data){
        if (data){
            console.log(data);
        }else{
            alert("chyba nacitana dat s db");
        }
    });
}
function disabled_all_in_ramp(ramp){
    let elem = document.getElementsByClassName('ramp_in_day');
    let index = (ramp-1)*7
    elem[index].checked = true;
    elem[index+1].checked = true;
    elem[index+2].checked = true;
    elem[index+3].checked = true;
    elem[index+4].checked = true;
    elem[index+5].checked = true;
    elem[index+6].checked = true;
}
function clear_all_in_ramp(ramp){
    let elem = document.getElementsByClassName('ramp_in_day');
    let index = (ramp-1)*7
    elem[index].checked = false;
    elem[index+1].checked = false;
    elem[index+2].checked = false;
    elem[index+3].checked = false;
    elem[index+4].checked = false;
    elem[index+5].checked = false;
    elem[index+6].checked = false;
}
function set_ramps(){
    let elem = document.getElementsByClassName('ramp_in_day');
    //console.log(elem,elem.length)
    let ramps = 'Ramp1-';
    for (let index_elem = 1 ;index_elem < elem.length+1;index_elem++){
        ramps+=""+Number(elem[index_elem-1].checked);

        if (index_elem % 7 === 0 && index_elem !== elem.length) {
            ramps += ' Ramp'+((index_elem/7)+1)+'-';
        }

    }
    console.log(ramps);

    $.post('config_AJAX/set_ramps.php',{
             ramps:ramps
         },function(data){
             if (data){
                 console.log(data);
             }else{
                 alert("chyba nacitana dat s db");
             }
         });
}
function set_html_disabled_ramps(data){
    let elem = document.getElementsByClassName('ramp_in_day');
    //let index = (ramp-1)*7
    let pared = data[0][0].split(" ");
    for (let index_ramp = 0;index_ramp < pared.length;index_ramp++){
        let parsed2 = pared[index_ramp].split("-")[1];
        for (let string_index = 0 ;string_index < parsed2.length;string_index++){
            if (parsed2[string_index]==="1"){
                elem[index_ramp*7+string_index].checked = true;
            }
        }
    }
}