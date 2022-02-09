$(function(){

    //login page
    $('.login-comp .input-form input').on('focus', function(){
        $(this).parent('span').addClass('on');
    }).on('focusout', function(){
        $(this).parent('span').removeClass('on');
    });
});