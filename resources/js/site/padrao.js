$(function() {

    $.banner({
        id: '#banner_principal',
        imagem: 'figure',
        controle: '#controle',
        prev: '#banner_principal_next',
        next: '#banner_principal_prev',
        tempo: 8
    });

    Pagina = new Pagina();

    $(".abre_popup_especialidade").click(function(e) {
        e.preventDefault();
        let url = $(this).attr("data-href");
        Pagina.abrir(url);
    });


    $(".abre_popup_sobre").click(function(e) {
        e.preventDefault();
        let url = $(this).attr("data-href");
        Pagina.abrir(url);
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
    $(window).scroll(function() {
        var windowBottom = $(this).scrollTop() + $(this).innerHeight();
        $(".animar").each(function() {
        var objectBottom = $(this).offset().top + $(this).outerHeight();
        
        if (objectBottom < windowBottom) { 
            if ( $(this).css("opacity") == 0) {
                $(this).addClass('fadeInDown');
                $(this).fadeTo(500,1);
            }
        } else if($(this).hasClass('fadeInDown')) { 
            $(this).css("opacity", "1")
            $(this).fadeTo(500,1);
        } else { 
            if ( $(this).css("opacity") == 1) {
                $(this).fadeTo(500,0);
            }
        }
        });
    }).scroll();

    $(".header .menu .bottom .mobile-menu-icon").click(function(e) {
        e.preventDefault();

        $('.menu-container').toggleClass('ativo');

    });

       // Ação quando a janela mudar de tamanho
    $(window).resize(function() {

        if ($(window).width() <= 760 && !$('.header .menu .bottom .menu-container').hasClass('ativo')) {

            $('.header .menu .bottom .menu-container').removeClass('ativo');

        } 

    });


});