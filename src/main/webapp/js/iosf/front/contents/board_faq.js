
$(document).ready(function () {

    $('.board_faq .faq_list dl dt').click(function () {
        $(this).parent("dl").siblings("dl").children("dd").hide();
        $(this).next('.board_faq .faq_list dl dd').toggle();
        $(this).parent("dl").siblings("dl").children("dt").removeClass("on");
        $(this).toggleClass("on");
    });

    $('.board_faq .faq_list dl dd button').click(function () {
        $('.board_faq .faq_list dl dd').hide();
        $('.board_faq .faq_list dl dt').removeClass("on");
    });

});


