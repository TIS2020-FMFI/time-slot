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
                create_exception("nepodarilo sa spojit so serverom",23,'danger');
            }
        });
    }else{
        create_exception("prosim vypln chybajuce kolonky",13,'warning');
    }

}