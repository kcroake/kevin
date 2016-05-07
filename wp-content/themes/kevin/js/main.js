jQuery(function($){
    $(window).scroll(function(){
        if($(this).scrollTop() > 40){
            $('header').addClass('fixed');
        } else {
            $('header').removeClass('fixed');
        }
        if($(this).scrollTop() > 45){
            $('header').addClass('flipin');
        } else {
            $('header').removeClass('flipin');
        }
    });
});
