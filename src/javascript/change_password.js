function change_password(){
    let old_password = document.getElementById('inputOldPassword');
    let new_password = document.getElementById('inputNewPassword');
    // kontrola validiti napr. dlzka  a sql
    if (old_password.value !== new_password.value){
        checked_if_user_exist(old_password.value , new_password.value);
    }else{
        alert("rovnake heslo nemoze byt pouzite");
        // insie allerts vhodne pre vypis chibi
    }
}
function checked_if_user_exist(old_password , new_password){
    $.post('change password AJAX/change_password.php',{
        old_password: old_password,
        new_password: new_password
    },function(data){
        if (data){
            console.log(data);
            if (data.includes("*")){
                alert(data);
            }else{
                alert(data);
                window.open("calendar.php","_self");
            }


        }else{
            alert("nepodarilo sa spojit so serverom");
        }
    });
}