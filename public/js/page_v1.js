
; /* Start:"a:4:{s:4:"full";s:102:"/local/templates/arkhitex/components/bitrix/catalog.element/indproject-sale-v2/script.js?1618943009764";s:6:"source";s:88:"/local/templates/arkhitex/components/bitrix/catalog.element/indproject-sale-v2/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(document).ready(function(){
    $('.planirovki-detail-slider').slick({
        //lazyLoad: 'ondemand',
        variableWidth: true,
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        //prevArrow: '.arkhitex-detail-slider-area .arrow-left',
        //nextArrow: '.arkhitex-detail-slider-area .arrow-right',
        autoplay: true,
        autoplaySpeed: 3000,
    });

    $('.js2BuyPlan').click(function(){
        topB = $('#buyplan').offset().top - 100;
        $('html, body').stop().animate({
            scrollTop: topB
        }, 300, function(){
            $('#buyplan input').focus().fadeOut(400).fadeIn(400);
        });

        return false;
    })
})
/* End */
;; /* /local/templates/arkhitex/components/bitrix/catalog.element/indproject-sale-v2/script.js?1618943009764*/