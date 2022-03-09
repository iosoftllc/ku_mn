$(function(){

    //login page
    $('.login-comp .input-form input').on('focus', function(){
        $(this).parent('span').addClass('on');
    }).on('focusout', function(){
        $(this).parent('span').removeClass('on');
    });

    //m2.1.1
    if($('#m2_slider1').length > 0){
        $('#m2_slider1').slick({
            slidesToShow:4,
            infinite:true,
            variableWidth:true,
            initialSlide:7,
            slidesToScroll:1,
            autoplay:true,
            arrows:false,
            pauseOnFocus:false,
            pauseOnHover:false,
            asNavFor:'#m2_slider1_title'
        });
        $('#m2_slider1_title').slick({
            autoplay:true,
            arrows:false,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '#m2_slider1',
            dots: false,
            infinite:true,
            initialSlide:7,
            fade:true,
            pauseOnFocus:false,
            pauseOnHover:false
        });

        $('#m2_slider2').slick({
            slidesToShow:4,
            infinite:true,
            variableWidth:true,
            initialSlide:11,
            slidesToScroll:1,
            autoplay:true,
            arrows:false,
            pauseOnFocus:false,
            pauseOnHover:false,
            asNavFor:'#m2_slider2_title'
        });
        $('#m2_slider2_title').slick({
            autoplay:true,
            arrows:false,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '#m2_slider2',
            dots: false,
            infinite:true,
            initialSlide:11,
            fade:true,
            pauseOnFocus:false,
            pauseOnHover:false
        });
    }
    if($('#m2_slider3').length > 0){
        $('#m2_slider3').slick({
            slidesToShow:1,
            infinite:true,
            slidesToScroll:1,
            autoplay:true,
            pauseOnFocus:false,
            pauseOnHover:false,
            dots:true,
            asNavFor:'#m2_slider3_title',
            responsive: [
            {
              breakpoint: 479,
              settings: {
                arrows:false
              }
            }]
        });
        $('#m2_slider3_title').slick({
            autoplay:true,
            arrows:false,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '#m2_slider3',
            dots: false,
            infinite:true,
            fade:true,
            pauseOnFocus:false,
            pauseOnHover:false
        });   
    }
    if($('#prec_slider').length > 0){
        $('#prec_slider').slick({
            slidesToShow: 1,
            infinite:true,
            slidesToScroll:1,
            autoplay:true,
            dots:false,
            pauseOnFocus:false,
            pauseOnHover:false
        });
    }
});