angular.module('gamingPassion', []);

angular.module('gamingPassion').controller('PostController', function() {

});

$(function(){
    $('.green-message').delay(5000).fadeOut(400);
});

$(document).scroll(function() {
    var scrollTop = $(window).scrollTop();
    var elementOffset = $('#menu').offset().top;
    distance = (elementOffset - scrollTop);
    bar_pos = distance;
    if (bar_pos <= 0) {
        document.getElementById("menu").style.top="0";
        document.getElementById("menu").style.position="fixed";
        document.getElementById("container").style.marginTop="65px";
    }
    if(scrollTop <= 150){
        document.getElementById("menu").style.top="0";
        document.getElementById("menu").style.position="static";
        document.getElementById("container").style.marginTop="15px";
    }
});