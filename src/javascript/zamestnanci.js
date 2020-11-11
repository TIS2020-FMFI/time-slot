
// toto zacne od 0 bude generovane funkieou create_html_employee()
let index_of_employees = 1;

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
loop();


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



function create_html_employee(id,F_name,L_name,E_mail,type_of_role,is_working){
    //https://www.w3schools.com/jsref/met_table_insertrow.asp
    let table = document.querySelectorAll('table')[document.querySelectorAll('table').length-1];
    let row = table.insertRow(index_of_employees);
    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    let cell3 = row.insertCell(2);
    let cell4 = row.insertCell(3);
    let cell5 = row.insertCell(4);

    let hidden_id_element = document.createElement('p');
    hidden_id_element.innerHTML = id;
    hidden_id_element.style.display = 'none';
    row.appendChild(hidden_id_element);


    let label_name = document.createElement('label');
    label_name.htmlFor = "inputFirstName"+index_of_employees;
    let input_name = document.createElement('input');
    input_name.type = "text";
    input_name.id = "inputFirstName"+index_of_employees;
    input_name.className = "first_name_inputs";
    input_name.placeholder = "Name";
    input_name.value = F_name;
    input_name.onclick = function (){
        // spustime casovasc ktori sa bude opakovat dokola kazdich 30 sekund spravit poust ak honota v danej kolonke bola zmenena
        parameter_for_update = this.value;
        type_of_change = 'first_name';
        input_element = input_name;
        id_of_clicked_element = hidden_id_element.innerHTML;
        //loop_for_updates_First_name_Last_name_Email();
    };
    input_name.onchange = function (){
        if (parameter_for_update !== input_name.value){
            change_First_name_Last_name_Email(hidden_id_element.innerHTML,input_name.value,"first_name");
        }
        //id_of_clicked_element = "";

        // db update
    };

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
    input_sure_name.onclick = function (){
        // spustime casovasc ktori sa bude opakovat dokola kazdich 30 sekund spravit poust ak honota v danej kolonke bola zmenena
        parameter_for_update = this.value;
        type_of_change = 'last_name';
        input_element = input_sure_name;
        id_of_clicked_element = hidden_id_element.innerHTML;
    };
    input_sure_name.onchange = function (){
        if (parameter_for_update !== input_sure_name.value) {
            change_First_name_Last_name_Email(hidden_id_element.innerHTML, input_sure_name.value, "last_name");
        }
        //id_of_clicked_element = "";

    };

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
    input_email.onclick = function (){
        // spustime casovasc ktori sa bude opakovat dokola kazdich 30 sekund spravit poust ak honota v danej kolonke bola zmenena
        parameter_for_update = this.value;
        type_of_change = 'email';
        input_element = input_email;
        id_of_clicked_element = hidden_id_element.innerHTML;
    };
    input_email.onchange = function (){
        if (parameter_for_update !== input_email.value) {
            change_First_name_Last_name_Email(input_email.innerHTML,input_sure_name.value,"email");
        }
        //id_of_clicked_element = "";
        // db update
    };

    cell3.appendChild(label_email);
    cell3.appendChild(input_email);



    cell4.className = "mobile_setup";
    let div_role = document.createElement('div');
    div_role.className = "form-group";
    let select = document.createElement('Select');
    select.className = "form-control bg-secondary text-light dropdown-toggle employee_type_of_roll";
    select.onchange = function (){
        change_state_working(hidden_id_element.innerHTML,this , input_name , input_sure_name ,input_email);
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

    console.log("WORKING TYPE   " ,is_working);
    if (is_working === '1'){
        input_working.checked = true;
    }else{
        input_working.checked = false;
    }
    input_working.onchange = function (e){
        change_rolle(hidden_id_element.innerHTML,input_working.checked, input_name , input_sure_name ,input_email);
    }
    cell5.appendChild(input_working);
    index_of_employees += 1;
    // tuna je ide cod na pridanie zamestnanca do DB
}

function loop_for_updates_First_name_Last_name_Email(){
    if (id_of_clicked_element){
        if (parameter_for_update !== input_element.value){
            console.log("PRED ZMENOU ",parameter_for_update ,"        ", input_element.value)
            change_First_name_Last_name_Email(id_of_clicked_element,input_element.value,type_of_change);
            parameter_for_update = input_element.value;
            //console.log(parameter_for_update ,"        ", premena.value)
        }

    }
    setTimeout(loop_for_updates_First_name_Last_name_Email,time_constant_for_sending_updates);

}
loop_for_updates_First_name_Last_name_Email();


function submit_form_new_employee(){
    // check for validiti of inputs , toto je len taka kontrola treba pridat kontrolu na rovnake heslo atd...
    let F_name = document.getElementById('inputNewName').value;
    let L_name = document.getElementById('inputNewLastName').value;
    let email = document.getElementById('inputEmail').value;
    let password = document.getElementById('inputPassword').value;
    let Cnfirmpassword = document.getElementById('inputConfirmPassword').value;
    let role = document.getElementById('role_of_new_employee').value;
    // toto je prvi stupen kontoli neprazdnosti vstupov
    // #3 treba mrknut uz s vigenerovaneho pola zamestnancou ci maju rovnake meno a prezvisko ps bude nato niaki jason
    if (F_name && L_name && email && password === Cnfirmpassword && role ){
        // #3
        add_employee();
        close_new_customer();
    }else{
        console.log("Nod valid ");
    }
}

function change_First_name_Last_name_Email(id,data,typ_zmeni){
    $.post('zamestnanci AJAX/update_employee_data.php',{
        id: id,
        data: data,
        typ_zmeni:typ_zmeni,
    },function(data){
        if (data){
            console.log(data);
        }else{
            console.log("chyba v kode");
        }
    });
}
function change_state_working(id , witch_elem , name , lname , email_get){
    let change_role = witch_elem.value;
    let F_name = name.value;
    let L_name = lname.value;
    let email = email_get.value;
    $.post('zamestnanci AJAX/change_role.php',{
        id: id,
        F_name: F_name,
        L_name:L_name,
        email: email,
        change_role : change_role,
    },function(data){
        if (data){
            alert(data);
        }else{
            alert(data);
        }
    });
    // tuna je ide cod na zmenu type of roll
}
function load_db_data(){
    $.post('zamestnanci AJAX/load_all_employee.php',{
        data:'get_data'
    },function(data){
        if (data){
            for(let i =0 ; i < data.length;i ++){
                create_html_employee(data[i][0],data[i][1],data[i][2],data[i][3],data[i][5],data[i][6]);
            }

        }else{
            alert("chyba nacitana dat s db");
        }
    });
}
load_db_data();

function change_rolle(id,witch_elem , name , lname , email_get){
    let is_working = witch_elem;
    let F_name = name.value;
    let L_name = lname.value;
    let email = email_get.value;
    //console.log(witch_elem);
    $.post('zamestnanci AJAX/change_state_working.php',{
        id: id,
        F_name: F_name,
        L_name:L_name,
        email: email,
        is_working: is_working
    },function(data){
        if (data){
            alert(data);
        }else{
            alert(data);
        }
    });

    // tuna je ide cod na zmenu type of roll
}
function add_employee(){




    let F_name = document.getElementById('inputNewName').value;
    let L_name = document.getElementById('inputNewLastName').value;
    let email = document.getElementById('inputEmail').value;
    let password = document.getElementById('inputPassword').value;
    let role = document.getElementById('role_of_new_employee').value;
    $.post('zamestnanci AJAX/register_user.php',{
        F_name: F_name,
        L_name:L_name,
        email: email,
        password : password,
        role : role
    },function(data){
        if (data){
            let paset_data = data.split("$");
            if (paset_data.length > 1){
                alert(paset_data[0]);
                create_html_employee(paset_data[1],document.getElementById('inputNewName').value,
                    document.getElementById('inputNewLastName').value,
                    document.getElementById('inputEmail').value,
                    document.getElementById('role_of_new_employee').value,
                    "1");
            }else{
                alert(data);
            }


        }else{
            alert(data);
        }
    });

}


