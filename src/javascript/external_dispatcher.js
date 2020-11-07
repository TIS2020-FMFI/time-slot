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
            all_elements_p[i].style.fontSize = "18px";
        }
        let all_elements_button = document.querySelectorAll('.btn');
        for (let i = 0 ;i < all_elements_button.length;i++){
            all_elements_button[i].style.padding = "10px";
        }
    }
    setTimeout(loop,500);
}
loop();