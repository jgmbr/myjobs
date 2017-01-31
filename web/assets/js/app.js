/**
 * Created by Justine GAMBIER on 31/01/2017.
 */

$(document).ready(function(){

    $('.gotop').on('click', function (e){
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $('html').offset().top
        }, 500, 'easeInOutExpo');
        return false;
    });

    var nb = $('.form-group.has-error').length;
    if (nb > 0) {
        $('html, body').animate({
            scrollTop: $('#contact').offset().top
        }, 500, 'easeInOutExpo');
    }

});

$(window).scroll(function(){

    posScroll = $(document).scrollTop();
    if(posScroll >=200)
        $('.gotop').fadeIn(600);
    else
        $('.gotop').fadeOut(600);

});
