"use strict";
$(document).ready(function(){
    $(window).scroll(function(){
        if ($(window).scrollTop() >= 150) {
            $('.sdr-header').addClass('fixed');
        }
        else {
            $('.sdr-header').removeClass('fixed');
        }
    });





});
