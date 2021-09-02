$(function() {

    $.banner({
        id: ".banner-home",
        imagem: ".banner-principal",
        next: "#but-banner-login-prev",
        prev: "#but-banner-login-next",
        tempo: 5
    });

    
    //MENU ICON
    //ANIMA AO CLICAR NO lINK
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('href'),
                targetOffset = $(id).offset().top;

        $('html, body').animate({
            scrollTop: targetOffset - 100
        }, 500);

    });


    //ANIMA AO SCROLL

    function animaAoScroll(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
    $(window).scroll(function() {
        $('.animar').each(function() {
            if (animaAoScroll(this) === true) {
                $(this).addClass('fadeInDown');
            }
        });
    });


    //PARALLAX
    var windowWidth = window.innerWidth;
    var $window = $(window);
    var $bannerSel = $('.banner');
    
    function parallaxBg(selector, speed) {
        if (selector.length != 0 ) {
        var sectionOffset = selector.offset().top;
        var scrolled = $(window).scrollTop() - sectionOffset;
        var sectionPosition = '20% ' + (scrolled * speed);
        selector.css('background-position', sectionPosition + 'px');
        }
    }
    
    if (windowWidth > 767) {
        parallaxBg($bannerSel, 0.35);

        $window.on('scroll', function() {
        parallaxBg($bannerSel, 0.35);
        });
    }




    //PARALLAX FOOTER
    var windowWidthFooter = window.innerWidth;
    var $window = $(window);
    var $bannerSelFooter = $('.banner_footer');
    
    function parallaxBgFooter(selector, speed) {
        if (selector.length != 0 ) {
        var sectionOffset = selector.offset().top;
        var scrolled = $(window).scrollTop() - sectionOffset;
        var sectionPosition = '10% ' + (scrolled * speed);
        selector.css('background-position', sectionPosition + 'px');
        }
    }
    
    if (windowWidthFooter > 767) {
        parallaxBgFooter($bannerSelFooter, 0.35);

        $window.on('scroll', function() {
        parallaxBgFooter($bannerSelFooter, 0.35);
        });
    }

});