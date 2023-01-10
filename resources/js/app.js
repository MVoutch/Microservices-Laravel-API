var $ = document.querySelector;
var active_item = $('.active');
var nav_item = $('.nav-item');
nav_item.addEventListener('click', function(event){
    nav_item.classList.add('active');
    active_item.classList.remove('active');
});
