let x = document.getElementsByClassName("calendar_item");
console.log(x.length);
// toto zacne od 0 bude generovane funkieou create_html_employee()
let index_of_employees = 4;


// tu mudi bit kontrola podal zariadania sirky sa bude odvijat parameter pre zmenu begroundu parametr == displayed_length_of_calendar
let displayed_length_of_calendar = 7;
let time_slot_length = 5;
let max_lenght_of_calendar = 336;
for (let i = 0; i < x.length; i++) {
    x[i].onmouseover = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML !== "booked" && cal[(i + (x * 7))].innerHTML !== "prepared" && cal[(i + (x * 7))].innerHTML !== "requested"  ){
                    cal[(i + (x * 7))].style.backgroundColor = "grey";
                }
            }
        }
    }
    x[i].onmouseleave = function()
    {
        let cal = document.getElementsByClassName("calendar_item");
        for (let x = 0; x < time_slot_length; x++) {
            if (i+(x*displayed_length_of_calendar) < max_lenght_of_calendar) {
                if (cal[(i + (x * 7))].innerHTML !== "booked" && cal[(i + (x * 7))].innerHTML !== "prepared" && cal[(i + (x * 7))].innerHTML !== "requested"){
                        cal[(i + (x * 7))].style.backgroundColor = "#f8f9fa";
                }
            }
        }
    }
    x[i].onclick = function()
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

function some(val,elem){
    console.log("VALUE WITCH WAS CLCKED",this.previousSibling.previousSibling);
}

function add_new_customer(){
    document.getElementsByClassName('table-responsive')[0].style.display="none";
    document.getElementsByClassName('table_of_customers')[0].style.display="none";
    document.getElementsByClassName('add_customer')[0].style.display="block";
}
function close_new_customer(){
    document.getElementsByClassName('table-responsive')[0].style.display="block";
    document.getElementsByClassName('table_of_customers')[0].style.display="block";
    document.getElementsByClassName('add_customer')[0].style.display="none";
}
function witch(witch_elem){
    console.log("witch   ",witch_elem.value)
    // tuna je ide cod na zmenu type of roll
}
function add_employee(){
    console.log("F name" , document.getElementById('inputNewName').value);
    console.log("L name" , document.getElementById('inputNewLastName').value);
    console.log("Email" , document.getElementById('inputEmail').value);
    console.log("password" , document.getElementById('inputPassword').value);
    console.log("repeated password" , document.getElementById('inputConfirmPassword').value);
    console.log("roll" , document.getElementById('role_of_new_employee').value);
    create_html_employee(document.getElementById('inputNewName').value,
        document.getElementById('inputNewLastName').value,
        document.getElementById('inputEmail').value,
        document.getElementById('inputPassword').value,
        document.getElementById('inputConfirmPassword').value,
        document.getElementById('role_of_new_employee').value);

}

function create_html_employee(F_name,L_name,E_mail,password,Repeat_password ,type_of_role){
    //https://www.w3schools.com/jsref/met_table_insertrow.asp
    let table = document.querySelectorAll('table')[document.querySelectorAll('table').length-1];
    let row = table.insertRow(index_of_employees);
    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    let cell3 = row.insertCell(2);
    let cell4 = row.insertCell(3);
    let cell5 = row.insertCell(4);




    let label_name = document.createElement('label');
    label_name.htmlFor = "inputFirstName"+index_of_employees;
    let input_name = document.createElement('input');
    input_name.type = "text";
    input_name.id = "inputFirstName"+index_of_employees;
    input_name.className = "first_name_inputs";
    input_name.placeholder = "Name";
    input_name.value = F_name;

    cell1.appendChild(label_name);
    cell1.appendChild(input_name);

    let label_sure_name = document.createElement('label');
    label_sure_name.htmlFor = "inputSurName"+index_of_employees;
    let input_sure_name = document.createElement('input');
    input_sure_name.type = "text";
    input_sure_name.id = "inputSurName"+index_of_employees;
    input_sure_name.className = "last_name_inputs";
    input_sure_name.placeholder = "Surname";
    input_sure_name.value = L_name;

    cell2.appendChild(label_sure_name);
    cell2.appendChild(input_sure_name);



    let label_email = document.createElement('label');
    label_email.htmlFor = "inputEmail"+index_of_employees;
    let input_email = document.createElement('input');
    input_email.type = "email";
    input_email.id = "inputEmail"+index_of_employees;
    input_email.className = "email_inputs";
    input_email.placeholder = "Email";
    input_email.value = E_mail;

    cell3.appendChild(label_email);
    cell3.appendChild(input_email);



    cell4.className = "mobile_setup";
    let div_role = document.createElement('div');
    div_role.className = "form-group";
    let select = document.createElement('Select');
    select.className = "form-control bg-secondary text-light dropdown-toggle employee_type_of_roll";
    select.onchange = function (){
     witch(this);
    };
    let option1 = document.createElement("option");
    option1.text = "EXD";
    if (type_of_role === "EXD"){
        option1.selected = "selected";
    }
    let option2 = document.createElement("option");
    option2.text = "IND";
    if (type_of_role === "IND"){
        option2.selected = "selected";
    }
    let option3 = document.createElement("option");
    option3.text = "GM";
    if (type_of_role === "GM"){
        option3.selected = "selected";
    }
    let option4 = document.createElement("option");
    option4.text = "AD";
    if (type_of_role === "AD"){
        option4.selected = "selected";
    }
    select.appendChild(option1);
    select.appendChild(option2);
    select.appendChild(option3);
    select.appendChild(option4);
    div_role.appendChild(select);

    cell4.appendChild(div_role);

    let input_working = document.createElement('input');
    input_working.type = "checkbox";
    input_working.className = "is_working";
    input_working.checked = true;

    cell5.appendChild(input_working);
    index_of_employees += 1;
    // tuna je ide cod na pridanie zamestnanca do DB
}
//create_html_employee();
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
}