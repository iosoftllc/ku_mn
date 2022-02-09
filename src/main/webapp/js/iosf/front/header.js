$(function(){


    var fn_menu_navigate = function(){
        $('.header-mask').css('height', $(document).height());
       // mobile
       if($('#mobile-menu-btn').is(':visible')){
            var h = $(window).height() - $('#header').height();
            $('.menu-login').css('height', h + 'px');
            $('.header-mask').removeClass('show');
            $('#main-menu >li >a').stop().on('click', function(){
                $(this).parent().toggleClass('mobile-menu-show');
                $(this).parent('li').siblings('li').removeClass('mobile-menu-show');
            });
        // desktop
        } else {
            $('.header-mask').removeClass('mshow');
            $('.menu-login').attr('style','');
            $('#header').removeClass('mon');
            $('#main-menu >li').hover(function(){
                $('.header-mask').addClass('show');
                $('#header').addClass('on');
            }, function(){
                $('.header-mask').removeClass('show').attr('style');
                $('#header').removeClass('on');
            });
            $('.menu-holder').attr('style', '');
        } 
    }
    fn_menu_navigate();
    $(window).on('resize', fn_menu_navigate)
             .on('scroll', function(){
                var h = $('#header').height();
                $('#header').toggleClass( 'sticky-header', $(window).scrollTop() > 10);
            });
    
    $('#mobile-menu-btn').on('click', function(){
        $('.menu-holder').show().animate({right:0},500);
        $('.menu-holder').css('height', $(document).height());
        $('.header-mask').addClass('mshow');
    });
    $('.mobile-menu-close').on('click', function(){
        var w = $('.menu-holder').width();
        $('.menu-holder').animate({right:-w + 'px'},500,
            function(){
                $('.menu-holder').css({'height':'', 'display':''});
            }
        );
        $('.header-mask').removeClass('mshow');
    })

    $('.info-box .name').on('click', function(e){
        e.preventDefault();
        $('.info-pop').toggleClass('show');
    });

    $('.info-box .btnclose').on('click', function(){
        $('.info-pop').removeClass('show');
    });


    var fn_hide_back_to_top = function(){
        if($(window).scrollTop() < 10){
            $('.topbtn').stop().addClass('off');
        } else {
            $('.topbtn').stop().removeClass('off');
        }
    }
    fn_hide_back_to_top();
    $(window).on('scroll', fn_hide_back_to_top)

});