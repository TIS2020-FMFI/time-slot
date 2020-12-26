let role_down = false;
function role_down_navigation(){
    if (role_down === false){
        document.getElementById('role_down').style.display = 'none';
        role_down = true;
    }else{
        document.getElementById('role_down').style.display = 'revert';
        role_down = false;
    }
}

let linked_id = 0;
function create_html_linked_text(text,cell){
    let link = document.createElement('a');
    let linked_text = document.createElement('span');
    link.href = '#';
    link.innerText  = " ..."
    link.onclick = function (){
        show_full_text(link,linked_text);
        return false;
    };
    linked_text.style.position = 'absolute';
    linked_text.style.top = '-9999px';
    linked_text.style.left = '-9999px';
    linked_text.innerText  = text.slice(40);

    cell.innerHTML = text.slice(0,40);
    cell.appendChild(link);
    cell.appendChild(linked_text);
    linked_id ++;
}
function show_full_text(link_id,linked_text_id){
    link_id.style.display = 'none';
    linked_text_id.style.position = 'inherit';

}

function close_time_slot(){
    $.post('order_AJAX/close_order.php',{
    },function(data){
        console.log(data);
        if (data ){
            //alert("dsadasdsa");
            if (data === '1' || data === '2'){
                create_exception('time slot bol uspesne uzavreti',5,'success');
                load_all_time_slots();
            }else{
                create_exception(data,5,'danger');
            }

        }else{
            create_exception("nepodarilo sa spojit so serverom",23,'danger');
        }
    });

}