$(document).ready(function() {

    "use strict";



/////////////////////////////////////////////////////////////////
// SETTING
/////////////////////////////////////////////////////////////////

    var windowHeight = $(window).height();
    var windowWidth = $(window).width();


    var tabletWidth = 767;
    var mobileWidth = 640;



/////////////////////////////////////////////////////////////////
// Preloader
/////////////////////////////////////////////////////////////////


    var $preloader = $('#page-preloader'),
    $spinner   = $preloader.find('.spinner-loader');
    $spinner.fadeOut();
    $preloader.delay(50).fadeOut('slow');



/////////////////////////////////////
//  Sticky Header
/////////////////////////////////////


    if (windowWidth > tabletWidth) {

        var headerSticky = $(".layout-theme").data("header");
        var headerTop = $(".layout-theme").data("header-top");

        if (headerSticky.length) {
            $(window).on('scroll', function() {
                var winH = $(window).scrollTop();
                var $pageHeader = $('.header');
                if (winH > headerTop) {

                    $('.yamm').addClass("animated");
                    $('.yamm').addClass("animation-done");
                    $('.yamm').addClass("bounce");
                    $pageHeader.addClass('sticky');

                } else {

                    $('.yamm').removeClass("bounce");
                    $('.yamm').removeClass("animated");
                    $('.yamm').removeClass("animation-done");
                    $pageHeader.removeClass('sticky');
                }
            });
        }
    }



/////////////////////////////////////////////////////////////////
//   Dropdown Menu Fade
/////////////////////////////////////////////////////////////////


    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop(true, true).slideDown("fast");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).stop(true, true).slideUp("fast");
            $(this).toggleClass('open');
        }
    );


    $(".yamm .navbar-nav>li").hover(
        function() {
            $('.dropdown-menu', this).fadeIn("fast");
        },
        function() {
            $('.dropdown-menu', this).fadeOut("fast");
        });


    window.prettyPrint && prettyPrint();
    $(document).on('click', '.yamm .dropdown-menu', function(e) {
        e.stopPropagation();
    });



/////////////////////////////////////
//  Menu Android
/////////////////////////////////////

$( '.navbar-nav li:has(ul)' ).doubleTapToGo();


/////////////////////////////////////
//  Disable Mobile Animated
/////////////////////////////////////

    if (windowWidth < mobileWidth) {
        $("body").removeClass("animated-css");
    }

    $('.animated-css .animated:not(.animation-done)').waypoint(function() {
            var animation = $(this).data('animation');
            $(this).addClass('animation-done').addClass(animation);
    }, {
        triggerOnce: true,
        offset: '90%'
    });


////////////////////////////////////////////
// HOME SLIDER
///////////////////////////////////////////


    if ($('#my-slider').length > 0) {


            var sliderWidth = $("#my-slider").data("slider-width");
            var sliderHeigth = $("#my-slider").data("slider-height");

            $( '#my-slider' ).sliderPro({
            width:  sliderWidth,
            height: sliderHeigth,
            fade: true,
            loop: false,
            arrows: false,
            buttons: false,
            autoplay: true,
            autoScaleLayers: false,
            thumbnailHeight: 40,
            thumbnailWidth: 40,
            thumbnailPointer: false,
            thumbnailTouchSwipe: true,
            breakpoints: {
                500: {
                    thumbnailWidth: 30,
                    thumbnailHeight: 30
                }
            }
        });
    }



////////////////////////////////////////////
// Slider thumbnails
///////////////////////////////////////////

    if ($('#slider-product').length > 0) {

                // The slider being synced must be initialized first
                $('#carousel-product').flexslider({
                    animation: "slide",
                    controlNav: false,
                    directionNav: false,
                    animationLoop: false,
                    slideshow: true,
                    itemWidth: 84,
                    itemMargin: 8,
                    asNavFor: '#slider-product',
                    direction: "vertical",
                    smoothHeight: true
                });

                $('#slider-product').flexslider({
                    animation: "slide",
                    controlNav: false,
                    animationLoop: false,
                    slideshow: true,
                    sync: "#carousel-product",
                    smoothHeight: true
                });
    }
});