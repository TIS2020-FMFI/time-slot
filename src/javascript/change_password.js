function change_password(){
    let old_password = document.getElementById('inputOldPassword');
    let new_password = document.getElementById('inputNewPassword');
    if (old_password.value !== new_password.value){
        if (old_password.value !== '' && new_password.value !== ''){
            checked_if_user_exist(old_password.value , new_password.value);
        }else{
            create_exception("prosim vyplnnte prazdne kolonky ",13,'warning');
        }
    }else{
        create_exception("rovnake heslo nemoze byt pouzite",13,'warning');
    }
}
function checked_if_user_exist(old_password , new_password){
    if (is_correct_password(old_password,7,30,'password')||is_correct_password(new_password,7,30,'password')){
        return
    }
    $.post('change_password_AJAX/change_password.php',{
        old_password: old_password,
        new_password: new_password
    },function(data){
        if (data){
            if (data.includes("$")){
                let split = data.split("$")
                if (split[0] === '1'){
                    create_exception(split[1],13,'success');
                }else{
                    create_exception(split[1],13,'warning');
                }

            }else{
                create_exception(data,33,'danger');
            }
        }else{
            create_exception("nepodarilo sa spojit so serverom",23,'danger');
        }
    });
}