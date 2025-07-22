//recuperer le toggle de navigation
const toggle = document.querySelector('.toggle');
const hamburger = toggle.querySelector('.hamburger');

//les 3 barres du hamburger
const bar1 = hamburger.querySelector('#first');
const bar2 = hamburger.querySelector('#middle');
const bar3 = hamburger.querySelector('#last');

//compteur de clics
let clickCount = 0;

//Side Menu
const sideMenu = document.querySelector('.sideMenu');

function showMenu(){
    sideMenu.style.transform = 'translateX(0)';
    sideMenu.style.transition = 'transform 0.3s ease-in-out';
    sideMenu.style.boxShadow = '10px 0 37px  rgb(108, 107, 107)';
}

function hideMenu(){
    sideMenu.style.transform = 'translateX(-100%)';
    sideMenu.style.transition = 'transform 0.3s ease-in-out';
    sideMenu.style.boxShadow = 'none';
}

toggle.onclick = function(){
    clickCount++;
    //animation smoth sur les barres
    if(clickCount %2 != 0){
        bar2.style.display = 'none';
        bar1.style.transform = 'rotate(45deg) translateY(6px)';
        bar3.style.transform = 'rotate(-45deg) translateY(-6px)';
        showMenu();
    }else{
        bar2.style.display = 'block';
        bar1.style.transform = 'rotate(0deg) translateY(0px)';
        bar3.style.transform = 'rotate(0deg) translateY(0px)';
        hideMenu();
    }
}