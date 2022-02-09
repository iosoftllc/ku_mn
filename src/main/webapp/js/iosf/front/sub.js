$(function(){

    $('.left-menu >li >a').on('click', function(){
        $(this).parent().siblings().removeClass('on');
        $(this).parent().toggleClass('on');

    });
});