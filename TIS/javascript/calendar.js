let calendar_item = document.getElementsByClassName("calendar_item");
//console.log(calendar_item.length);




// tu mudi bit kontrola podal zariadania sirky sa bude odvijat parameter pre zmenu begroundu parametr == displayed_length_of_calendar
let displayed_length_of_calendar = 7;
let time_slot_length = 5;
let max_lenght_of_calendar = 336;
for (let i = 0; i < calendar_item.length; i++) {
    calendar_item[i].onmouseover = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML !== "booked"   ){//&& cal[(i + (x * 7))].innerHTML !== "prepared" && cal[(i + (x * 7))].innerHTML !== "requested"
                    cal[(i + (x * 7))].style.backgroundColor = "grey";
                }
            }
        }
    }
    calendar_item[i].onmouseleave = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML === "booked"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ff0000";
                }
                if ( cal[(i + (x * 7))].innerHTML === "prepared" ){
                    cal[(i + (x * 7))].style.backgroundColor = "#b5e97c";
                }
                if  (cal[(i + (x * 7))].innerHTML === "requested"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ffc107";
                }
                if  (cal[(i + (x * 7))].innerHTML === "free"){
                    cal[(i + (x * 7))].style.backgroundColor = "#ffffff";
                }



            }
        }
    }
    calendar_item[i].onclick = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {

                if (cal[(i + (x * 7))].innerHTML === "requested") {
                    cal[(i + (x * 7))].style.backgroundColor = "#ff0000";

                    cal[(i + (x * 7))].innerHTML = "booked";
                }
                if (cal[(i + (x * 7))].innerHTML === "prepared") {
                    cal[(i + (x * 7))].style.backgroundColor = "#ffc107";

                    cal[(i + (x * 7))].innerHTML = "requested";
                }
                if (cal[(i + (x * 7))].innerHTML === "free") {
                    cal[(i + (x * 7))].style.backgroundColor = "#b5e97c";

                    cal[(i + (x * 7))].innerHTML = "prepared";
                }
            }
        }
    }
}

function roll(){
    if (document.getElementById('roll_down').style.display !== 'block'){
        document.getElementById('roll_down').style.display = 'block';
    }
    else{
        document.getElementById('roll_down').style.display = 'none';
    }
}
function dysplay_nakladka(index){
    if (index === undefined){
        let all_elements_inputs = document.querySelectorAll('.form-check-input');
        for (let i = 0 ;i < all_elements_inputs.length-1;i++){
            all_elements_inputs[i].checked = false;
        }
        // displey intersection between all gates(nakladiek)
    }else{
        // displey nakladka number(index)
    }
}//create_html_employee();
function loop(){
    //console.log(window.innerWidth);
    // konstanta honrneho pola kde je find by datum nam dava tuto hodnotu
    const margin = 2;
    if (window.innerWidth < 500){
        console.log("TU SOM 1");

        let all_elements_p = document.querySelectorAll('th');

        for (let i = 8 ;i < all_elements_p.length;i+=8){

            for (let x = 0;x < 4;x++){
                all_elements_p[margin+i-x].style.display = "none";
            }

        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "2px";
            if (i === all_elements_button.length-1){
                all_elements_button[i].style.marginRight = "0px";
            }
        }
    }
    if (window.innerWidth > 500 && window.innerWidth < 900){
        console.log("TU SOM 2")
        let all_elements_p = document.querySelectorAll('th');

        for (let i = 8 ;i < all_elements_p.length;i+=8){

            for (let x = 0;x < 4;x++){
                if (x < 2){
                    all_elements_p[margin+i-x].style.display = "none";
                }else {
                    all_elements_p[margin+i-x].style.display = "revert";
                }
            }
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "5px";
            if (i === all_elements_button.length-2){
                all_elements_button[i].style.marginRight = "5px";
                all_elements_button[i].style.marginLeft = "5px";
            }
        }
    }
    if ( window.innerWidth > 900){
        console.log("TU SOM 3")

        let all_elements_p = document.querySelectorAll('th');

        for (let i = 0 ;i < all_elements_p.length;i++){
            if (i === 0 ){
                all_elements_p[i].style.display = "flex ";
            }else{
                all_elements_p[i].style.display = "revert";
            }

        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "10px";
            if (i === all_elements_button.length-2){
                all_elements_button[i].style.marginRight = "10px";
                all_elements_button[i].style.marginLeft = "10px";
            }
        }
    }
    setTimeout(loop,500);
}
loop();