function log_out(){
    $.post('log out AJAX/log_out.php',{
    },function(data){
        if (data){
            window.open("index.php","_self");
        }else{
            alert("nepodarilo sa spojit so serverom");
        }
    });
}