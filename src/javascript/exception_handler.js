let html_alert = undefined;
let html_close= undefined;
let html_text= undefined;
let alert_timer = 0;
let format_for_password = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
let format_for_email = /[ `!#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~]/;
let format_for_company_name = /[`!#$%^*_+=\[\]{};:\\<>\/?~]/;
let format_for_driver_part_one = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
let format_for_driver_part_two = /[0-9]/;
let format_for_date_config = new RegExp('[0-9]{2}-[0-9]{2}');

function test(){
    //let test_S = is_correct_name_for_driver('234567fgadfhsgf');
    //console.log(test_S);
    // console.log('test : ',format_for_date_config.test(test_S),test_S);
    //console.log('test',is_correct_company("S I M & ,+ - spol. s r.o. Bardejov"));

}


window.onload = function() {
    html_alert = document.getElementById('alert');
    html_close = document.getElementById('close');
    html_text = document.getElementById('text');
    test();
}
function is_good_length(text_length,min_count_of_characters,max_count_of_characters,what){
    if( text_length < min_count_of_characters || text_length > max_count_of_characters){
        create_exception( 'Your <strong>'+what+'</strong> has incorrect length.' +
            '<br> - the minimal length is <strong>'+min_count_of_characters+'</strong>,' +
            '<br> - the maximal length is <strong>'+max_count_of_characters+'</strong>.',13,'warning');
        return true;
    }else{
        return false;
    }
}
function is_correct_name_for_driver(text_string){
    if( format_for_driver_part_one.test(text_string)  || format_for_driver_part_two.test(text_string) ){
        create_exception( 'Your <strong>truck driver name</strong> has the wrong format. Do not use any of the following symbols: '+format_for_driver_part_one+'</strong> or <strong>'+format_for_driver_part_two+'</strong>',13,'warning');
        return true;
    }else{
        return is_good_length(text_string.length,0,30,'Truck driver');
    }
}
function is_correct_date(text_string){
    let split_day_string = text_string.split(',');
    for (let index_date_string = 0;index_date_string  < split_day_string.length ;index_date_string ++) {
        if (split_day_string[index_date_string] !== "") {

            if( format_for_date_config.test(split_day_string[index_date_string]) && split_day_string[index_date_string].length === 5 ){ // MM-DD
                //console.log(split_day_string[index_date_string]);
                let split_string_month_days = split_day_string[index_date_string].split('-');
                if (split_string_month_days[0] === '00' || split_string_month_days[0] > '12' || split_string_month_days[1] === '00' || split_string_month_days[1] > '31'){
                    create_exception('Use the correct format <strong>MM-DD</strong><br> This date is wrong : <strong>'+split_day_string[index_date_string] +'</strong>', 13, 'warning');
                    return true;
                }
            }else{
                create_exception('Wrong formatted <strong>date section</strong>, use only <strong>' + ("" + format_for_date_config).slice(1, -1) + ',' + '</strong><br> This date is wrong : <strong>'+split_day_string[index_date_string] +'</strong>', 13, 'warning');
                return true;
            }
        }
    }

}
function is_correct_company(text_string){
    if( format_for_company_name.test(text_string) ){
        create_exception( 'Your <strong>company name</strong> has the wrong format. Do not use any of the following symbols: '+format_for_password,13,'warning');
        return true;
    }else{
        return is_good_length(text_string.length,0,75,'Company name');
    }
}
function is_correct_name(text_string){
    if( format_for_password.test(text_string) || format_for_driver_part_two.test(text_string)){
        create_exception( 'Your <strong>first name</strong> or <strong>last name</strong> has the wrong format. Do not use any of the following symbols: '+format_for_password,13,'warning');
        return true;
    }else{
        return is_good_length(text_string.length,0,20,'First name / Last name');
    }
}
function is_correct_password(text_string){
    return is_good_length(text_string.length,7,30,'password');
}
function is_correct_email(email_string){
    if( format_for_email.test(email_string) ){
        create_exception( 'Your <strong>email</strong> has the wrong format. Do not use any of the following symbols: '+format_for_email,13,'warning');
        return true;
    }else{
        return is_good_length(email_string.length,7,50,'email');
    }
}
function create_exception(insert_text,time_of_display,type_of_style){
    html_alert.className = 'alert alert-'+type_of_style+' alert-dismissible fade show fixed-top ';
    html_text.innerHTML = insert_text;
    html_close.disabled = false;
    html_alert.style.opacity = 1+'';
    html_alert.style.display = 'revert';
    if (alert_timer !== 0){
        alert_timer = time_of_display
    }else{
        alert_timer = time_of_display
        fade(alert_timer)
    }
    // pocet sekund pokial zmizne allert + 3 pre aditional fade avai
}
function fade(){
    if (alert_timer === 0 ){
        html_alert.style.display = 'none';
    }else if (alert_timer <= 3){
        html_close.disabled = true;
        html_alert.style.opacity = alert_timer/10+'';
        alert_timer -= 0.5;
        setTimeout(fade,50,alert_timer);
    }else{
        alert_timer -= 1;
        setTimeout(fade,1000,alert_timer);
    }

}

function close_alert(){
    html_close.disabled = true;
    alert_timer = 3;
    //fade(3)// pocet sekund pokial zmizne allert
}
function in_danger_warning(){
    if (html_alert.className.includes('danger')||html_alert.className.includes('warning')){
        return true;
    }
    return  false;
}