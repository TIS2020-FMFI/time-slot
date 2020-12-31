let myCanvas ;
let myChart ;
let massPopChart;


let colors = {
    prepared:'rgba(46,255,0,1)',
    requested:'rgba(255,153,0,1)',
    booked:'rgba(255,0,0,1)',
    finished:'rgba(157,0,255,1)'
}
let intensity={
    0:['1','1','1','1'],
    1:['0.5','0.5','0.5','0.5'],
    2:['0.8','0.6','0.5','0.3'],
    3:['0.3','0.5','0.6','0.8']
}
let list_of_intensity = ['fill','half transparent','max prepared','max finished']
let gates = undefined;
let list_of_company_names;
let list_of_all_ramps ;
let list_of_options  = ['prepared','requested','booked','finished'];
let min_date ;
let max_date ;

/**
 * spracovanie ajax vystupu
 */
function parse_data(data){
    try{
        min_date = data[0][9].split(' ')[0];
        max_date = data[0][9].split(' ')[0];
    }catch (e) {
        document.getElementById('input_text').disabled = true;
        document.getElementById('input_date1').disabled = true;
        document.getElementById('input_date2').disabled = true;
        document.getElementById('exampleFormControlSelect2').disabled = true;
        document.getElementById('exampleFormControlSelect1').disabled = true;
        document.getElementById('intensityFormControlSelect').disabled = true;
        document.getElementById('direct_select').disabled = true;
        create_exception('There are currently no data available.',10,'danger');
        return ;
    }
    gates = new Gate();
    linked_id = 0;
    let counter = 0 ;
    let real_time = '';
    let set_of_of_company_names = new Set();
    let set_of_of_all_ramps = new Set();



    for(let i =0 ; i < data.length;i ++){
        // data format vystup SQL
        // [0] == id |
        // [1] == id_calendar  // gate_number|
        // [2] == company_name |
        // [3] == truck_driver1 |
        // [4] == truck_driver2 |
        // [5] == evc_truck |
        // [6] == destination |
        // [7] == cargo |
        // [8] == s_time |
        // [9] == e_time |
        // [10] == state
        set_of_of_company_names.add(data[i][2]);
        set_of_of_all_ramps.add('ramp '+data[i][1]);
        real_time = data[i][9].split(' ')[0];
        if (max_date < real_time){
            max_date = real_time;
        }
        if (min_date > real_time && min_date > max_date){
            min_date = real_time;
        }
        //console.log(min_date,max_date);
        let index = gates.get_index_by_id(data[i][1])
        if (index >= 0){
            let index_real_time = gates.array_of_calendars[index].get_index_by_real_time(real_time);
            if (index_real_time >= 0){
                gates.array_of_calendars[index].time_slots[index_real_time].add_next_time_slot_for_statistics(data[i][0],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
            }else{
                let time_slot = new Time_slot();
                time_slot.add_next_time_slot_for_statistics(data[i][0],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
                gates.array_of_calendars[index].push_real_time_and_time_slot(real_time,time_slot);
            }
        }else{
            let calendar = new Calendar();
            let time_slot = new Time_slot();
            time_slot.add_next_time_slot_for_statistics(data[i][0],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7],data[i][8],data[i][9],data[i][10]);
            calendar.push_real_time_and_time_slot(real_time,time_slot);
            gates.push_calendar_and_id(data[i][1],calendar);
        }
    }
    document.getElementById('input_date1').min = min_date;
    document.getElementById('input_date1').max = max_date;
    document.getElementById('input_date1').value = min_date;
    document.getElementById('input_date2').min = min_date;
    document.getElementById('input_date2').max = max_date;
    document.getElementById('input_date2').value = max_date;
    document.getElementById('input_text').value = "";
    set_of_of_company_names.delete('');
    list_of_company_names = Array.from(set_of_of_company_names);
    list_of_all_ramps = Array.from(set_of_of_all_ramps);


    prepare_direct_select();


    pre_make_chard();
}
function prepare_direct_select(){
    let elem_selector = document.getElementById('direct_select');
    let option = document.createElement("option");
    option.className = 'option';
    option.text = 'all';
    elem_selector.appendChild(option);

    for (let i = 0 ;i  < list_of_company_names.length; i++){
        let option = document.createElement("option");
        option.className = 'option';
        option.text = list_of_company_names[i];
        elem_selector.appendChild(option);
    }
    for (let i = 0 ;i  < list_of_all_ramps.length; i++){
        let option = document.createElement("option");
        option.className = 'option';
        option.text = list_of_all_ramps[i];
        elem_selector.appendChild(option);
    }
}
function take_picture(){
    let link = document.createElement('a');
    link.href = document.getElementById('myChart').toDataURL("image/png");
    link.download = document.getElementById('myChart').toDataURL("image/png")   ;
    link.click();
}

function first_load(){
    create_exception("Please wait for the data to be collected..",10,'primary')
    $.post('statistics_AJAX/load_all_time_slots_dump.php',{
    },function(data){
        if (typeof data === 'object'){
            JSONToCSVConvertor(data, "full_data", true);
            parse_data(data);
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
    myCanvas = document.getElementById('myChart')
    myChart = myCanvas.getContext("2d");
// Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#777';
    Chart.pluginService.register({
        beforeDraw: function (chart, easing) {
            if (chart.config.options.chartArea && chart.config.options.chartArea.backgroundColor) {
                // var helpers = Chart.helpers;
                let ctx = chart.chart.ctx;
                // var chartArea = chart.chartArea;

                ctx.save();
                ctx.fillStyle = chart.config.options.chartArea.backgroundColor;
                ctx.fillRect(0, 0, myCanvas.width, myCanvas.height);
                ctx.restore();
            }
        }
    });
    // Chart.defaults.backgroundColor = '#d21010';
    ///myChart = '#fefefe';backgroundColor
    // myChart.fillStyle = "#ec0000";
    // myChart.fillRect(0, 0, myCanvas.width, myCanvas.height);
    massPopChart = new Chart(myChart, {
        type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
            labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge','ondrej'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: 'rgb(115,255,99,0.5)',
                stack: 'Stack 0',
                data: [1, 2, 3, 4, 5, 6]
            }, {
                label: 'Dataset 2',
                backgroundColor: 'rgb(99,161,255,0.5)',
                stack: 'Stack 0',
                data: [1, 2, 3, 4, 5, 6]
            }, {
                label: 'Dataset 3',
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                stack: 'Stack 0',
                data: [1, 2, 3, 4, 5, 6
                ]
            }]

        },
        options:{
            chartArea: {
                backgroundColor: 'rgb(254,254,254)'
            },
            title:{
                display:true,
                text:'Empty chard',
                fontSize:25
            },
            legend:{
                display:true,// original true
                position:'right',
                labels:{
                    fontColor:'#000'
                }
            },
            layout:{
                padding:{
                    left:0,
                    right:0,
                    bottom:0,
                    top:0
                }
            },
            tooltips:{
                enabled:true
            }
        }
    });


}
setTimeout(first_load,500)
function get_all_real_times_between(from,to){
    try {
        let list_of_dates = [];
        let start_point = from;
        let currentTime = new Date(from)
        while (start_point !== to) {
            start_point = currentTime.toISOString().substr(0, 10);
            currentTime.setDate(currentTime.getDate() + 1);
            list_of_dates.push(start_point);
        }
        if (from === to) {
            list_of_dates.push(to);
        }
        //
        return list_of_dates;
    }catch (e) {
        create_exception('Date has the wrong format.',5,'warning');
        return [];
    }

}
let my_chard_data;
function pre_make_chard(elem) {
    console.log(min_date,max_date); // v tomto je chyba
    let lock_for = document.getElementById('input_text').value;

    if (elem !== undefined){
        document.getElementById('input_text').value = elem.value;
        lock_for = elem.value;
        //console.log()
    }else{
        let elem_selector = document.getElementsByClassName('option');
        for (let index = 0 ; index < elem_selector.length; index++){
            if (elem_selector[index].innerHTML.toLowerCase().includes(lock_for.toLowerCase())){
                elem_selector[index].style.display = 'revert';
            }else{
                elem_selector[index].style.display = 'none';
            }
        }
    }
    let start_date = document.getElementById('input_date1').value;
    let end_date = document.getElementById('input_date2').value;
    // if (start_date > end_date ){
    //     create_exception()
    //     return ;
    // }



    let type_of_chard = document.getElementById('exampleFormControlSelect2').value;
    let display_only_values = document.getElementById('exampleFormControlSelect1').value;
    let intensity_level = list_of_intensity.indexOf(document.getElementById('intensityFormControlSelect').value);


    let title_of_chard = '';
    let dates_between = [];

    console.log(start_date, end_date, lock_for, type_of_chard, display_only_values);
    if (start_date > end_date  ){//|| end_date  < start_date
        create_exception('Date has the wrong format.',5,'warning');
        return ;
    }

    if (list_of_all_ramps.includes(lock_for)) {
        create_exception('Creating charts..', 3, 'success');
    } else if (list_of_company_names.includes(lock_for)) {
        create_exception('Creating charts..', 3, 'success');
    } else if (lock_for === '') {
        create_exception('Creating charts..', 3, 'success');
    } else if (lock_for === 'all'){
        create_exception('Creating charts..', 3, 'success');

    }else{
        create_exception('Selected <strong>text</strong> in <strong>Find by</strong> has wrong format.', 5, 'warning');
        return;
    }
    my_chard_data = {};
    if (lock_for === 'all' && display_only_values === 'all'){
        title_of_chard = 'all time-slots between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = ['all time slots'];
        my_chard_data['datasets'] = [];


        for (let option = 0 ;option < list_of_options.length;option++){

            my_chard_data.datasets.push({
                label : list_of_options[option],
                backgroundColor: colors[list_of_options[option]].replace(/[^,]+(?=\))/, intensity[intensity_level][option]),
                stack: 'Stack '+option,
                data:[]
            })
        }

        //console.log(my_chard_data);

        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        for (let date_in = 0 ;date_in < dates_between.length; date_in++){
            for (let cal_index = 0 ;cal_index < gates.array_of_calendars.length; cal_index++){
                let index_of_real_time = gates.array_of_calendars[cal_index].get_index_by_real_time(dates_between[date_in]);
                // console.log(index_of_real_time);
                if (index_of_real_time >= 0 ){
                    prepared += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[0]);
                    requested += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[1]);
                    booked += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[2]);
                    finished += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[3]);
                }
            }
        }
        my_chard_data.datasets[0].data.push(prepared);
        my_chard_data.datasets[1].data.push(requested);
        my_chard_data.datasets[2].data.push(booked);
        my_chard_data.datasets[3].data.push(finished);

    }else if (lock_for === '' && display_only_values === 'all'){
        title_of_chard = 'all time-slots between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        for (let option = 0 ;option < list_of_options.length;option++){
            my_chard_data.datasets.push({
                label : list_of_options[option],
                backgroundColor: colors[list_of_options[option]].replace(/[^,]+(?=\))/, intensity[intensity_level][option]),
                stack: 'Stack 0',
                data:[]
            })
        }


        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        for (let date_in = 0 ;date_in < dates_between.length; date_in++){
            prepared = 0;
            requested = 0;
            booked = 0;
            finished = 0;
            for (let cal_index = 0 ;cal_index < gates.array_of_calendars.length; cal_index++){
                let index_of_real_time = gates.array_of_calendars[cal_index].get_index_by_real_time(dates_between[date_in]);
                if (index_of_real_time >= 0 ){
                    prepared += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[0]);
                    requested += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[1]);
                    booked += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[2]);
                    finished += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[3]);

                }

            }

            my_chard_data.datasets[0].data.push(prepared);
            my_chard_data.datasets[1].data.push(requested);
            my_chard_data.datasets[2].data.push(booked);
            my_chard_data.datasets[3].data.push(finished);

        }




        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat --> hotovo
        //datasets s 4 lablami a prislusnimi farbamy list_of_options
        //zatial na stack 0 vstky v buducnosti mozne rozdelenie
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else if (lock_for === '' && display_only_values !== 'all'){
        title_of_chard = 'all '+display_only_values+' time-slots between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        my_chard_data.datasets.push({
            label : [display_only_values],
            backgroundColor: colors[display_only_values].replace(/[^,]+(?=\))/, intensity[intensity_level][0]),
            stack: 'Stack 0',
            data:[]
        })


        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        for (let date_in = 0 ;date_in < dates_between.length; date_in++){
            prepared = 0;
            requested = 0;
            booked = 0;
            finished = 0;
            // console.log(dates_between[date_in]);
            for (let cal_index = 0 ;cal_index < gates.array_of_calendars.length; cal_index++){
                let index_of_real_time = gates.array_of_calendars[cal_index].get_index_by_real_time(dates_between[date_in]);
                // console.log(index_of_real_time);
                if (index_of_real_time >= 0 ){
                    prepared += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[0]);
                    requested += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[1]);
                    booked += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[2]);
                    finished += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states(list_of_options[3]);

                }

            }
            if (display_only_values === 'prepared'){
                my_chard_data.datasets[0].data.push(prepared);
            }else if (display_only_values === 'requested'){
                my_chard_data.datasets[0].data.push(requested);
            }else if (display_only_values === 'booked'){
                my_chard_data.datasets[0].data.push(booked);
            }else{
                my_chard_data.datasets[0].data.push(finished);
            }

        }
        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat
        //datasets s 1 lablami a prislusnou farbov z list_of_options
        //stack 0
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else if (lock_for.includes('ramp')  && display_only_values === 'all'){
        title_of_chard = 'all time-slots for '+lock_for+' between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        for (let option = 0 ;option < list_of_options.length;option++){
            my_chard_data.datasets.push({
                label : list_of_options[option],
                backgroundColor: colors[list_of_options[option]].replace(/[^,]+(?=\))/, intensity[intensity_level][option]),
                stack: 'Stack 0',
                data:[]
            })
        }


        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        let index_of_calendar = gates.get_index_by_id(lock_for.split(' ')[1]);
        for (let date_in = 0 ;date_in < dates_between.length; date_in++){
            prepared = 0;
            requested = 0;
            booked = 0;
            finished = 0;
            let index_of_real_time = gates.array_of_calendars[index_of_calendar].get_index_by_real_time(dates_between[date_in]);
            if (index_of_real_time >= 0 ){
                prepared = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[0]);
                requested = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[1]);
                booked = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[2]);
                finished = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[3]);

            }


            my_chard_data.datasets[0].data.push(prepared);
            my_chard_data.datasets[1].data.push(requested);
            my_chard_data.datasets[2].data.push(booked);
            my_chard_data.datasets[3].data.push(finished);

        }
        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat
        //datasets s 4 lablami a prislusnimi farbamy list_of_options
        //zatial na stack 0 vstky v buducnosti mozne rozdelenie
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else if (lock_for.includes('ramp') && display_only_values !== 'all') {
        title_of_chard = 'all time-slots for ' + lock_for + ' between ' + start_date + ' ' + end_date;
        dates_between = get_all_real_times_between(start_date, end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        my_chard_data.datasets.push({
            label: [display_only_values],
            backgroundColor: colors[display_only_values].replace(/[^,]+(?=\))/, intensity[intensity_level][0]),
            stack: 'Stack 0',
            data: []
        })


        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        let index_of_calendar = gates.get_index_by_id(lock_for.split(' ')[1]);
        for (let date_in = 0; date_in < dates_between.length; date_in++) {
            prepared = 0;
            requested = 0;
            booked = 0;
            finished = 0;
            let index_of_real_time = gates.array_of_calendars[index_of_calendar].get_index_by_real_time(dates_between[date_in]);
            if (index_of_real_time >= 0) {
                if (display_only_values === 'prepared') {
                    prepared = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[0]);
                } else if (display_only_values === 'requested') {
                    requested = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[1]);
                } else if (display_only_values === 'booked') {
                    booked = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[2]);
                } else {
                    finished = gates.array_of_calendars[index_of_calendar].time_slots[index_of_real_time].count_of_states(list_of_options[3]);
                }
            }


            if (display_only_values === 'prepared') {
                my_chard_data.datasets[0].data.push(prepared);
            } else if (display_only_values === 'requested') {
                my_chard_data.datasets[0].data.push(requested);
            } else if (display_only_values === 'booked') {
                my_chard_data.datasets[0].data.push(booked);
            } else {
                my_chard_data.datasets[0].data.push(finished);
            }

        }
        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat
        //datasets s 1 lablami a prislusnou farbov z list_of_options
        //stack 0
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else if (list_of_company_names.includes(lock_for)  && display_only_values === 'all'){
        title_of_chard = lock_for+' time-slots between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        for (let option = 1 ;option < list_of_options.length;option++){
            my_chard_data.datasets.push({
                label : list_of_options[option],
                backgroundColor: colors[list_of_options[option]].replace(/[^,]+(?=\))/, intensity[intensity_level][option]),
                stack: 'Stack 0',
                data:[]
            })
        }


        let requested = 0;
        let booked = 0;
        let finished = 0;
        for (let date_in = 0 ;date_in < dates_between.length; date_in++){
            requested = 0;
            booked = 0;
            finished = 0;
            for (let cal_index = 0 ;cal_index < gates.array_of_calendars.length; cal_index++){
                let index_of_real_time = gates.array_of_calendars[cal_index].get_index_by_real_time(dates_between[date_in]);
                if (index_of_real_time >= 0 ) {
                    requested += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[1]);
                    booked += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[2]);
                    finished += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[3]);

                }

            }

            my_chard_data.datasets[0].data.push(requested);
            my_chard_data.datasets[1].data.push(booked);
            my_chard_data.datasets[2].data.push(finished);



        }
        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat
        //datasets s 3 lablami a prislusnimi farbamy list_of_options pricom 'prepared' nebudeme chciet a odstranime ho zo zoznamu selectu
        //zatial na stack 0 vstky v buducnosti mozne rozdelenie
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else if (list_of_company_names.includes(lock_for)  && display_only_values !== 'all'){
        if (display_only_values === 'prepared'){
            create_exception('Invalid charts selection.',5,'danger');
        }

        title_of_chard = lock_for+' time-slots between '+start_date+' '+end_date;
        dates_between = get_all_real_times_between(start_date,end_date);
        my_chard_data['labels'] = dates_between;
        my_chard_data['datasets'] = [];


        my_chard_data.datasets.push({
            label : [display_only_values],
            backgroundColor: colors[display_only_values].replace(/[^,]+(?=\))/, intensity[intensity_level][0]),
            stack: 'Stack 0',
            data:[]
        })


        let prepared = 0;
        let requested = 0;
        let booked = 0;
        let finished = 0;
        for (let date_in = 0 ;date_in < dates_between.length; date_in++) {
            prepared = 0;
            requested = 0;
            booked = 0;
            finished = 0;
            for (let cal_index = 0; cal_index < gates.array_of_calendars.length; cal_index++) {
                let index_of_real_time = gates.array_of_calendars[cal_index].get_index_by_real_time(dates_between[date_in]);
                if (index_of_real_time >= 0) {
                    if (display_only_values === 'requested') {
                        requested += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[1]);
                    } else if (display_only_values === 'booked') {
                        booked += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[2]);
                    } else if (display_only_values === 'finished') {
                        finished += gates.array_of_calendars[cal_index].time_slots[index_of_real_time].count_of_states_with_employee(lock_for, list_of_options[3]);

                    }

                }

            }

            if (display_only_values === 'requested') {
                my_chard_data.datasets[0].data.push(requested);
            } else if (display_only_values === 'booked') {
                my_chard_data.datasets[0].data.push(booked);
            } else if (display_only_values === 'finished') {
                my_chard_data.datasets[0].data.push(finished);
            }
        }
        //labels bude obsahovat vsetky datumi *from *to a bude obsahovat
        //datasets s 1 lablami a prislusnou farbov z list_of_options
        //stack 0
        //data budu mat prislusne hodnoti pre kazdy den pocti time slotov prisluchajucimi danej farbe
    }else{
        create_exception('Invalid charts selection.',5,'danger');
        return ;
    }



    make_chard(my_chard_data,type_of_chard,title_of_chard,dates_between.length)
}

function make_chard(data,type,title, length_of_dates){
    console.log(length_of_dates);
    //removeData(massPopChart);
    massPopChart.destroy();
    //myChart.restore();
    massPopChart = new Chart(myChart, {
    type:type,
    data:data,
    options:{
        chartArea: {
            backgroundColor: 'rgb(254,254,254)'
        },
        title:{
            display:true,
            text:title,
            fontSize:25
        },
        legend:{
            display: true ,
            position:'right',
            labels:{
                fontColor:'#000'
            }
        },
        layout:{
            padding:{
                left:0,
                right:0,
                bottom:0,
                top:0
            }
        },
        tooltips:{
            enabled:true
        }
    }
    });
}

//(length_of_dates < 8),  //true,// original true



// let myChart = document.getElementById('myChart').getContext('2d');
//
// // Global Options
// Chart.defaults.global.defaultFontFamily = 'Lato';
// Chart.defaults.global.defaultFontSize = 18;
// Chart.defaults.global.defaultFontColor = '#777';
//
// let massPopChart = new Chart(myChart, {
//   type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
//   data:{
//     labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge'],
//     datasets: [{
//       label: 'Dataset 1',
//       backgroundColor: 'rgb(115,255,99)',
//       stack: 'Stack 0',
//       data: [
//         617594,
//         181045,
//         153060,
//         106519,
//         105162,
//         95072
//       ]
//     }, {
//       label: 'Dataset 2',
//       backgroundColor: 'rgb(99,161,255)',
//       stack: 'Stack 0',
//       data: [
//         617594,
//         181045,
//         153060,
//         106519,
//         105162,
//         95072
//       ]
//     }, {
//       label: 'Dataset 3',
//       backgroundColor: 'rgba(255, 99, 132, 0.6)',
//       stack: 'Stack 0',
//       data: [
//         617594,
//         181045,
//         153060,
//         106519,
//         105162,
//         95072
//       ]
//     }]
//
//   },
//   //   datasets:[{
//   //     label:'Population',
//   //     data:[
//   //       617594,
//   //       181045,
//   //       153060,
//   //       106519,
//   //       105162,
//   //       95072
//   //     ],
//   //     //backgroundColor:'green',
//   //     backgroundColor:[
//   //       'rgba(255, 99, 132, 0.6)',
//   //       'rgba(54, 162, 235, 0.6)',
//   //       'rgba(255, 206, 86, 0.6)',
//   //       'rgba(75, 192, 192, 0.6)',
//   //       'rgba(153, 102, 255, 0.6)',
//   //       'rgba(255, 159, 64, 0.6)',
//   //       'rgba(255, 99, 132, 0.6)'
//   //     ],
//   //     borderWidth:1,
//   //     borderColor:'#777',
//   //     hoverBorderWidth:3,
//   //     hoverBorderColor:'#000'
//   //   }]
//   // },
//   options:{
//     title:{
//       display:true,
//       text:'Largest Cities In Massachusetts',
//       fontSize:25
//     },
//     legend:{
//       display:true,
//       position:'right',
//       labels:{
//         fontColor:'#000'
//       }
//     },
//     layout:{
//       padding:{
//         left:50,
//         right:0,
//         bottom:0,
//         top:0
//       }
//     },
//     tooltips:{
//       enabled:true
//     }
//   }
// });
