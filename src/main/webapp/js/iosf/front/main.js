$(function(){

    $('.visual-slide .slider').slick({
        autoplay: true,
        dots: true,
        fade: true,
        appendDots: $('.slider-nav .paging-nav'),
        prevArrow: $('.slide-prev'),
        nextArrow: $('.slide-next'),
        speed:700
    });

    $('.slider-nav .navi .play').on('click', function(e){
        e.preventDefault();

        if($(this).hasClass('pause')){

            $('.visual-slide .slider').slick('slickPlay');
            $(this).removeClass('pause');
        } else {
            $('.visual-slide .slider').slick('slickPause'); 
            $(this).addClass('pause');
        }

    });

    $('#notice-list').slick({
        autoplay: true,
        prevArrow: $('.notice-navi .notice-prev'),
        nextArrow: $('.notice-navi .notice-next'),
        mobileFirst: true,
        slidesToShow:1,
        slidesToShow:1,
        responsive:[
            {
                breakpoint: 767,
                settings:{
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 1023,
                settings:{
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            }
        ]
    })
    
});