function log_in(){
    let email = document.getElementById('inputEmail');
    let password = document.getElementById('inputPassword');
    if (email.value !== "" && password.value !== ""){
        if (is_correct_email(email.value) || is_correct_password(password.value)){
            return;
        }
        //console.log(email.value,password.value)
        $.post('login_AJAX/login.php',{
            email: email.value,
            password: password.value
        },function(data){
            if (data){
                if (typeof data === 'object'){
                    if (data['login_count']  === '0' ){
                        window.open("change_password.php","_self");
                    }else if (  data['role']  === 'AD' || data['role']  === 'IND' ){
                        window.open("internal_dispatcher.php","_self");
                    }else if ( data['role']  === 'EXD'){
                        window.open("external_dispatcher.php","_self");
                    }else if ( data['role']  === 'GM'){
                        window.open("gate_man.php","_self");
                    }
                }else if (data.includes('$')){
                    create_exception(data.split('$')[1],13,'warning');
                }else{
                    create_exception(data,23,'danger');
                }
            }else{
                create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
            }
        });
    }else{
        create_exception("Both <strong>email</strong> and <strong>password</strong> are required.",13,'warning');
    }

}

setTimeout(first_load, 200);

function first_load() {
    if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 )
    {
        create_exception("Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for better performance.", 10, "warning");
    }
    else if(navigator.userAgent.indexOf("Chrome") != -1 )
    {
        //alert('Chrome');
    }
    else if(navigator.userAgent.indexOf("Safari") != -1)
    {
        create_exception("This browser has not been tested for this application. Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for best performance.", 10, "warning");
    }
    else if(navigator.userAgent.indexOf("Firefox") != -1 )
    {
        create_exception("Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for better performance.", 10, "warning");
    }
	else if(navigator.userAgent.indexOf("SamsungBrowser") != -1 )
    {
        create_exception("Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for better performance.", 10, "warning");
    }
    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
    {
        create_exception("Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for better performance.", 10, "warning");
    }
    else if((navigator.userAgent.indexOf("Edge") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
    {
        //alert('Edge');
    }
    else
    {
        create_exception("Using <strong>Chrome</strong> or <strong>Edge</strong> is recommended for better performance.", 10, "warning");
    }
}

