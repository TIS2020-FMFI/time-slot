function log_in(){
    let email = document.getElementById('inputEmail');
    let password = document.getElementById('inputPassword');
    // kontrola validiti
    if (email.value && password.value){
        checked_if_user_exist(email.value , password.value);
    }
}
function checked_if_user_exist(email , password){
    $.post('login AJAX/login.php',{
        email: email,
        password: password
    },function(data){
        if (data){
            console.log(data);
            if (typeof data === 'object'){
                if (data['login_count']  === 0 ){
                    window.open("change_password.php","_self");
                }else if (  data['role']  === 'AD' || data['role']  === 'IND' ){
                    window.open("internal_dispatcher.php","_self");
                }else if ( data['role']  === 'EXD'){
                    window.open("external_dispatcher.php","_self");
                }else if ( data['role']  === 'GM'){
                    window.open("gate_man.php","_self");
                }
            }else{
                alert(data);
            }
        }else{
            alert("nepodarilo sa spojit so serverom");
        }
    });
}