
// toto zacne od 0 bude generovane funkieou create_html_employee()
let index_of_employees = 1;
let all_employees_jason = [];

let type_of_change = "";
let parameter_for_update = "";
let input_element = "";
let id_of_clicked_element = "";
const time_constant_for_sending_updates = 5000; // milisekund sekund ma to byt konstanta ako 10000 (10 sek) pre test je 300milisek


function loop(){
    //console.log(window.innerWidth);
    // konstanta honrneho pola kde je find by datum nam dava tuto hodnotu
    const margin = 2;
    if (window.innerWidth < 500){
        //console.log("TU SOM 1");

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
        //log("TU SOM 2")
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
        //console.log("TU SOM 3")

        let all_elements_p = document.querySelectorAll('th');

        for (let i = 0 ;i < all_elements_p.length;i++){
            if (i === 0 ){
                all_elements_p[i].style.display = "revert ";
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
//loop();


function add_new_customer(){
    document.getElementById('inputNewName').value = "";
    document.getElementById('inputNewLastName').value = "";
    document.getElementById('inputEmail').value = "";
    document.getElementById('inputFirm').value = "";
    document.getElementById('inputPassword').value = "";
    document.getElementById('inputConfirmPassword').value = "";
    document.getElementsByClassName('table-responsive')[0].style.display="none";
    document.getElementsByClassName('table_of_customers')[0].style.display="none";
    document.getElementsByClassName('add_customer')[0].style.display="block";
}
function close_new_customer(){
    document.getElementsByClassName('table-responsive')[0].style.display="block";
    document.getElementsByClassName('table_of_customers')[0].style.display="block";
    document.getElementsByClassName('add_customer')[0].style.display="none";
}



function create_html_employee(id,F_name,L_name,Firm,E_mail,type_of_role,is_working){
    //https://www.w3schools.com/jsref/met_table_insertrow.asp
    let table = document.querySelectorAll('table')[document.querySelectorAll('table').length-1];
    let row = table.insertRow(index_of_employees);
    row.id = ''+id;
    if (is_working === '1'){
        row.style.display = 'revert';
    }else{
        row.style.display = 'none';
    }

    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    let cell3 = row.insertCell(2);
    let cell4 = row.insertCell(3);
    let cell5 = row.insertCell(4);
    let cell6 = row.insertCell(5);



    let label_name = document.createElement('label');
    label_name.htmlFor = "inputFirstName"+index_of_employees;
    let input_name = document.createElement('input');
    input_name.type = "text";
    input_name.id = "inputFirstName"+index_of_employees;
    input_name.className = "first_name_inputs";
    input_name.placeholder = "Name";
    input_name.disabled = true;
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
    input_sure_name.disabled = true;
    input_sure_name.value = L_name;

    cell2.appendChild(label_sure_name);
    cell2.appendChild(input_sure_name);




    let label_firm = document.createElement('label');
    label_firm.htmlFor = "inputEmail"+index_of_employees;
    let input_firm = document.createElement('input');
    input_firm.type = "email";
    input_firm.id = "inputFrim"+index_of_employees;
    input_firm.className = "firm_inputs";
    input_firm.placeholder = "Firm Name";
    input_firm.disabled = true;
    input_firm.value = Firm;

    cell3.appendChild(label_firm);
    cell3.appendChild(input_firm);




    let label_email = document.createElement('label');
    label_email.htmlFor = "inputEmail"+index_of_employees;
    let input_email = document.createElement('input');
    input_email.type = "email";
    input_email.id = "inputEmail"+index_of_employees;
    input_email.className = "email_inputs";
    input_email.placeholder = "Email";
    input_email.disabled = true;
    input_email.value = E_mail;
    cell4.appendChild(label_email);
    cell4.appendChild(input_email);



    cell4.className = "mobile_setup";
    let div_role = document.createElement('div');
    div_role.className = "form-group";
    let select = document.createElement('Select');
    select.className = "form-control bg-secondary text-light dropdown-toggle employee_type_of_roll";
    select.disabled = true;
    //select.onchange = function (){
    //         change_rolle(hidden_id_element.innerHTML,this , input_name , input_sure_name ,input_email,row);
    //     };
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

    cell5.appendChild(div_role);

    let input_working = document.createElement('input');

    input_working.type = "checkbox";
    input_working.className = "is_working";
    input_working.disabled = true;

    if (is_working === '1'){
        input_working.checked = true;
    }else{
        input_working.checked = false;
    }

    cell6.appendChild(input_working);
    index_of_employees += 1;



    // pri zmene bude treba menit aj tento jason
    all_employees_jason.push( {
        id:id,
        table_row:row,
        table_row_input_name:input_name,
        table_row_input_sure_name:input_sure_name,
        table_row_input_email:input_email,
        table_row_input_firm:input_firm,
        table_row_select:select,
        table_row_input_working:input_working,
    });
    //runt_test();
}
function load_db_data(){
    $.post('employee_AJAX/load_all_employee.php',{
        data:'get_data'
    },function(data){
        if (typeof data === 'object'){
            for(let i =0 ; i < data.length;i ++){
                create_html_employee(data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6]);
            }
        }else if(data){
            create_exception(data ,23,'danger');
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
    setTimeout(select_only,250);
}
//load_db_data();
setTimeout(load_db_data,100);
//window.onload = function() {
    //setTimeout(load_db_data,250);
    //load_db_data();

//}


function select_only(){
    let only_value_find_by = document.getElementById('find_by').value;
    let element_value = document.getElementById('change_select_role').value;
    let only_valid_by_second_selector = document.getElementById('change_select_type_working').value;
    // console.log(only_value_find_by);
    // console.log(element_value);
    // console.log(only_valid_by_second_selector);
    if (element_value === "Select Only"){
        for(let i = 0 ; i < all_employees_jason.length;i ++){
            if (only_valid_by_second_selector === "Only working"){
                if(all_employees_jason[i]['table_row_input_working'].checked === false){
                    all_employees_jason[i].table_row.style.display = "none";
                }else{
                    all_employees_jason[i].table_row.style.display = "revert";
                }
            }

            if (only_valid_by_second_selector === "Only not working"){
                if(all_employees_jason[i]['table_row_input_working'].checked === true){
                    all_employees_jason[i].table_row.style.display = "none";
                }else{
                    all_employees_jason[i].table_row.style.display = "revert";
                }
            }
            if (only_valid_by_second_selector === "All employee"){
                all_employees_jason[i].table_row.style.display = "revert";
            }
            if (only_value_find_by !== ''){
                if (all_employees_jason[i]['table_row_input_name'].value.includes(only_value_find_by) ||
                    all_employees_jason[i]['table_row_input_sure_name'].value.includes(only_value_find_by) ||
                    all_employees_jason[i]['table_row_input_email'].value.includes(only_value_find_by) ){
                }else{
                    all_employees_jason[i].table_row.style.display = "none";
                }
            }

        }
    }
    if (element_value === "Administrator"){
        select_only_satisfied_users(only_valid_by_second_selector,only_value_find_by,"AD");
    }
    if (element_value === "Internal dispatcher"){
        select_only_satisfied_users(only_valid_by_second_selector,only_value_find_by,"IND");
    }
    if (element_value === "External dispatcher"){
        select_only_satisfied_users(only_valid_by_second_selector,only_value_find_by,"EXD");
    }
    if (element_value === "Gate man"){
        select_only_satisfied_users(only_valid_by_second_selector,only_value_find_by,"GM");
    }
}
function select_only_satisfied_users(only_valid_by_second_selector,only_value_find_by,  employee_role){
    for(let i =0 ; i < all_employees_jason.length;i ++){
        if (all_employees_jason[i]['table_row_select'].value === employee_role){
            if (only_valid_by_second_selector === "Only working"){
                if(all_employees_jason[i]['table_row_input_working'].checked === false){
                    all_employees_jason[i].table_row.style.display = "none";
                }else{
                    all_employees_jason[i].table_row.style.display = "revert";
                }
            }

            if (only_valid_by_second_selector === "Only not working"){
                if(all_employees_jason[i]['table_row_input_working'].checked === true){
                    all_employees_jason[i].table_row.style.display = "none";
                }else{
                    all_employees_jason[i].table_row.style.display = "revert";
                }
            }
            if (only_valid_by_second_selector === "All employee"){
                all_employees_jason[i].table_row.style.display = "revert";
            }
            if (only_value_find_by !== ''){
                if (all_employees_jason[i]['table_row_input_name'].value.includes(only_value_find_by) ||
                    all_employees_jason[i]['table_row_input_sure_name'].value.includes(only_value_find_by) ||
                    all_employees_jason[i]['table_row_input_email'].value.includes(only_value_find_by) ){
                }else{
                    all_employees_jason[i].table_row.style.display = "none";
                }
            }
        }else{
            all_employees_jason[i].table_row.style.display = "none";
        }
    }
}

function edit_employees(){
    document.getElementById('edit').style.display = 'none';
    document.getElementById('new').disabled = true;
    document.getElementById('update').style.display = 'revert';
    for (let row  = 0 ; row < all_employees_jason.length; row ++){
        all_employees_jason[row]['table_row_input_name'].disabled = false;
        all_employees_jason[row]['table_row_input_sure_name'].disabled = false;
        all_employees_jason[row]['table_row_input_email'].disabled = false;
        all_employees_jason[row]['table_row_input_firm'].disabled = false;
        all_employees_jason[row]['table_row_select'].disabled = false;
        all_employees_jason[row]['table_row_input_working'].disabled = false;
    }
}

function update_employees(){
    document.getElementById('edit').style.display = 'revert';
    document.getElementById('new').disabled = false;
    document.getElementById('update').style.display = 'none';
    let update_array  = [];
    let founded = 'Some of the columns contain a wrong data: <br>';
    let founded_bool = false;
    for (let row  = 0 ; row < all_employees_jason.length; row ++) {
        all_employees_jason[row]['table_row_input_name'].disabled = true;
        all_employees_jason[row]['table_row_input_sure_name'].disabled = true;
        all_employees_jason[row]['table_row_input_email'].disabled = true;
        all_employees_jason[row]['table_row_input_firm'].disabled = true;
        all_employees_jason[row]['table_row_select'].disabled = true;
        all_employees_jason[row]['table_row_input_working'].disabled = true;
        if (is_correct_name(all_employees_jason[row]['table_row_input_name'].value)||
            is_correct_name(all_employees_jason[row]['table_row_input_sure_name'].value)||
            is_correct_email(all_employees_jason[row]['table_row_input_email'].value)||
            is_correct_company(all_employees_jason[row]['table_row_input_firm'].value)){
            founded_bool = true;
            founded += 'First <strong>'+all_employees_jason[row]['table_row_input_name'].value+'</strong><br>';
            founded += 'Last <strong>'+all_employees_jason[row]['table_row_input_sure_name'].value+'</strong><br>';
            founded += 'Email <strong>'+all_employees_jason[row]['table_row_input_email'].value+'</strong><br>';
            founded += 'Company <strong>'+all_employees_jason[row]['table_row_input_firm'].value+'</strong><br>';
            founded += '<br>';
            document.getElementById(all_employees_jason[row]['id']).className = 'bg-warning';
        }else{
            document.getElementById(all_employees_jason[row]['id']).className = '';
        }
        update_array.push([all_employees_jason[row]['id'],
                            all_employees_jason[row]['table_row_input_name'].value,
                            all_employees_jason[row]['table_row_input_sure_name'].value,
                            all_employees_jason[row]['table_row_input_email'].value,
                            all_employees_jason[row]['table_row_input_firm'].value,
                            all_employees_jason[row]['table_row_select'].value,
                            all_employees_jason[row]['table_row_input_working'].checked
                            ]);
    }
    if (founded_bool){
        founded += 'Please check the <strong>following formats</strong>: <br>- for company name '+format_for_company_name+'<br>- for company email '+format_for_email+'<br>- for company name '+format_for_password+'<br>';
        create_exception(founded,23,'warning');
        return
    }
        $.post('employee_AJAX/update_all_employees.php',{
        data: update_array,
    },function(data){
        if (data){
            if (data.includes("$")){
                let split = data.split("$")
                if (split[0] === '1'){
                    create_exception(split[1],23,'success');
                }else{
                    create_exception(split[1],23,'warning');
                }
            }else{
                create_exception(data,23,'danger');
            }
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });
}


function submit_form_new_employee(){
    // check for validiti of inputs , toto je len taka kontrola treba pridat kontrolu na rovnake heslo atd...
    let F_name = document.getElementById('inputNewName').value;
    let L_name = document.getElementById('inputNewLastName').value;
    let email = document.getElementById('inputEmail').value;
    let Firm = document.getElementById('inputFirm').value;
    let Password = document.getElementById('inputPassword').value;
    let Confirm_password = document.getElementById('inputConfirmPassword').value;
    let Role = document.getElementById('role_of_new_employee').value;
    // toto je prvi stupen kontoli neprazdnosti vstupov
    // #3 treba mrknut uz s vigenerovaneho pola zamestnancou ci maju rovnake meno a prezvisko ps bude nato niaki jason
    if ( Password === Confirm_password && Role && (Password !== "" && Confirm_password !== "" && email !== "" && Firm !== "") ){
        // #3
        add_employee(F_name,L_name,email,Firm,Password,Role);
    }else{
        create_exception("All fields marked with <strong>*</strong> are required.",13,'warning');
    }
}

function add_employee(F_name,L_name,email,Firm,Password,Role){
    if (is_correct_name(F_name)||is_correct_name(L_name)||is_correct_email(email)||is_correct_company(Firm)||is_correct_password(Password)){
        return
    }
    $.post('employee_AJAX/register_user.php',{
        F_name: F_name,
        L_name:L_name,
        firm: Firm,
        email: email,
        password : Password,
        role : Role
    },function(data){
        if (data){
            if (data.includes("$")){
                let split = data.split("$")
                if (split[0] === '1'){
                    create_exception(split[1],23,'success');
                    close_new_customer();
                }
            }else{
                create_exception(data,23,'warning');
            }
        }else{
            create_exception("Could not connect to the server. Please check your <strong>internet connection</strong>.",23,'danger');
        }
    });

}
