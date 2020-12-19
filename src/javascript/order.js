function add_next_employee(){
    document.getElementById('add_employee').style.display = 'none';
    document.getElementById('kamionist2').style.display = 'block';
}
function update_time_slot(){
    //console.log("dasdasdsaasdas");
    document.getElementsByClassName('edit_button')[0].disabled = false;
    document.getElementsByClassName('update_button')[0].disabled = true;
    document.getElementById('EVC').disabled = true;
    document.getElementById('inputNameKamionist1').disabled = true;
    document.getElementById('inputNameKamionist2').disabled = true;
//    if ()

    // ajax poust
}
function edit_time_slot(){
    document.getElementsByClassName('update_button')[0].disabled = false;
    document.getElementsByClassName('edit_button')[0].disabled = true;
    document.getElementById('EVC').disabled = false;
    document.getElementById('inputNameKamionist1').disabled = false;
    document.getElementById('inputNameKamionist2').disabled = false;
}

function update_evc(elem){
    console.log(elem.value);
}

function update_kamionist(elem){
    console.log(elem.value);
}

function request_time_slot(){
    let evc =document.getElementById('EVC');
    let kam1 =document.getElementById('inputNameKamionist1');
    let kam2 =document.getElementById('inputNameKamionist2');
    if (evc.value === '' ){

        evc.style.borderColor = 'red';
    }
    if(kam1.value === ''){
        kam1.style.borderColor = 'red';
    }
    if (evc.value !== '' && kam1.value !== ''){
        $.post('objednavka AJAX/request_time_slot.php',{
            evc:evc.value,
            truck_driver1:kam1.value,
            truck_driver2:kam2.value,
        },function(data){
            if (data){
                if (data === '1111' || data === '111' ){
                    console.log('PRESIEL SUPER V POHODE');
                    window.open('internal_dispatcher.php',"_self");
                }else{
                    console.log('chyba servera');
                }

            }else{
                console.log("chyba v kode");
            }
        });
    }

}
let only_one_request = true;
function close_time_slot(){
    if (only_one_request === true){
        $.post('objednavka AJAX/close_objednavka.php',{
        },function(data){
            if (data){
                //alert("dsadasdsa");
                if (data === '1' ){
                    console.log(1)
                    window.open('internal_dispatcher.php',"_self");
                }else if (data === '2'){
                    console.log(2)
                }else if (data === '4'){
                    console.log(4)
                    window.open('internal_dispatcher.php',"_self");
                    //console.log('sesion nexistuje');
                }else {
                    console.log(3)
                }

            }else{
                console.log(5)
            }
        });
        only_one_request = false;
    }
}

window.addEventListener('beforeunload', (event) => {
    // tento event vie detekovat opustenie stranky nuz funguje len na sipku dopredu a spet nie inak ...
    close_time_slot();
});