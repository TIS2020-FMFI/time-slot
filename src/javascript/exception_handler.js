let html_alert ;
let html_close;
let html_text;
let format_for_text = /^[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/;
let format_for_email = /^[!#$%^&*()_+\-=\[\]{};':"\\|,<>\/?]*$/;


window.onload = function() {
    html_alert = document.getElementById('alert');
    html_close = document.getElementById('close');
    html_text = document.getElementById('text');
}
function is_good_length(text_length,min_count_of_characters,max_count_of_characters,what){
    if( text_length < min_count_of_characters || text_length > max_count_of_characters){
        create_exception( '<strong>wrong length of '+what+'</strong>' +
            '<br> minimal length is :  <strong>'+min_count_of_characters+'</strong>' +
            '<br> maximal length is :  <strong>'+max_count_of_characters+'</strong>',13,'warning');
        return true;
    }else{
        return false;
    }
}
function is_correct_password(text_string){
    if( text_string.match(format_for_text) ){
        create_exception( '<strong>wrong formated password</strong> do not use <strong>'+format_for_text+'</strong>',13,'warning');
        return true;
    }else{
        return is_good_length(text_string.length,7,30,'password');
    }
}
function is_correct_email(email_string){
    if( email_string.match(format_for_email) ){
        create_exception( '<strong>wrong formated email</strong> do not use <strong>'+format_for_email+'</strong>',13,'warning');
        return true;
    }else{
        return is_good_length(email_string.length,7,30,'email');
    }
}
function create_exception(insert_text,time_of_display,type_of_style){
    html_alert.className = 'alert alert-'+type_of_style+' alert-dismissible fade show fixed-top';
    html_text.innerHTML = insert_text;
    html_close.disabled = false;
    html_alert.style.opacity = 1+'';
    html_alert.style.display = 'revert';
    fade(time_of_display)// pocet sekund pokial zmizne allert + 3 pre aditional fade avai
}
function fade(sek){
    if (sek === 0 ){
        html_alert.style.display = 'none';
        return;
    }else if (sek <= 3){
        html_close.disabled = true;
        html_alert.style.opacity = sek/10+'';
        setTimeout(fade,50,sek-0.5);
    }else{
        setTimeout(fade,1000,sek-1);
    }

}

function close_alert(){
    html_close.disabled = true;
    fade(3)// pocet sekund pokial zmizne allert
}