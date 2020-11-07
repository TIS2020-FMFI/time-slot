function loop(){
    console.log(window.innerWidth);
    if (window.innerWidth < 500){
        let all_elements_p = document.querySelectorAll('p');
        for (let i = 0 ;i < all_elements_p.length;i++){
            all_elements_p[i].style.fontSize = "10px";
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "0px";
        }
    }else{
        let all_elements_p = document.querySelectorAll('p');
        for (let i = 0 ;i < all_elements_p.length;i++){
            all_elements_p[i].style.fontSize = "20px";
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "10px";
        }
    }
    if (window.innerWidth > 500){
        document.getElementById('gate').innerText = "Gate";
    }else{
        document.getElementById('gate').innerText = "G";
    }
    if (window.innerWidth > 800){
        document.getElementById('evc').innerText = "Evidenčné číslo";
    }else{
        document.getElementById('evc').innerText = "EVČ";
    }
    setTimeout(loop,500);
}
loop();