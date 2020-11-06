
// toto zacne od 0 bude generovane funkieou create_html_employee()
let index_of_employees = 1;
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

    create_html_employee(document.getElementById('inputNewName').value,
        document.getElementById('inputNewLastName').value,
        document.getElementById('inputEmail').value,
        document.getElementById('role_of_new_employee').value,
        "1");


    let F_name = document.getElementById('inputNewName').value;
    let L_name = document.getElementById('inputNewLastName').value;
    let email = document.getElementById('inputEmail').value;
    let password = document.getElementById('inputPassword').value;
    let role = document.getElementById('role_of_new_employee').value;
    $.post('register_user.php',{
        F_name: F_name,
        L_name:L_name,
        email: email,
        password : password,
        role : role
    },function(data){
        if (data){
            alert(data);
        }else{
            alert(data);
        }
    });

}

function create_html_employee(F_name,L_name,E_mail,type_of_role,is_working){
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

    console.log("WORKING TYPE   " ,is_working);
    if (is_working === '1'){
        input_working.checked = true;
    }else{
        input_working.checked = false;
    }
    input_working.onchange = function (e){
        console.log("zmena");
    }


    cell5.appendChild(input_working);

    index_of_employees += 1;
    // tuna je ide cod na pridanie zamestnanca do DB
}

function submit_my_form(){
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


function load_db_data(){
    $.post('load_all_employee.php',{
        data:'get_data'
    },function(data){
        if (data){
            for(let i =0 ; i < data.length;i ++){
                create_html_employee(data[i][1],data[i][2],data[i][3],data[i][5],data[i][6]);
            }

        }else{
            alert("chyba nacitana dat s db");
        }
    });
}
load_db_data();

// CONVERT JASON DATA TO EXCEL
// JSONToCSVConvertor(data,"TITLE",true);
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + '\r\n';
    }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {
        alert("Invalid data");
        return;
    }

    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");

    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension

    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");
    link.href = uri;

    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";

    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
