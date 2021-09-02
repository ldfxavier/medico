$(function(){
    // QUANDO JANELA FOR REDIRECIONADA
    $(window).resize(function(){
        if($(window).width() >= 1320){
            $('#menu_principal_sna').css({
                'display': 'flex',
                'opacity': 1
            });
        }
    });

    var menu_scroll = function(scroll){
        var menu = $('#menu_principal_sna');
        var perfil = $('#menu_perfil_sna');
        var header = $('#header_mobile_sna');

        if(scroll >= 100 && menu.hasClass('absolute')){
            menu.removeClass('absolute').addClass('fixed');
            perfil.removeClass('absolute').addClass('fixed');
        }else if(scroll < 100 && menu.hasClass('fixed')){
            menu.removeClass('fixed').addClass('absolute');
            perfil.removeClass('fixed').addClass('absolute');
        }
    };
    menu_scroll($(window).scrollTop());

    $(document).scroll(function(){
        var scroll = $(window).scrollTop();
        menu_scroll(scroll);
    });

    // ABRE E FECHA O MENU DE PERFIL
    var perfil_tamanho = function(){
        if($('#but_perfil_principal').is(':visible')){
            var tamanho = $(document).width() - $('#but_perfil_principal').offset().left+10;
            if(tamanho < 280) tamanho = 280;
            $('#menu_perfil_sna .scroll').css('max-width', tamanho);
        }
    };
    var menu_perfil_fechar = function(){
        $('#menu_perfil_sna').stop()
        .animate({opacity:0}, 300, function(){
            $(this).hide();
        });
    };
    $('.but_abrir_perfil').click(function(){
        if(!$('#menu_perfil_sna').is(':visible')){
            menu_principal_fechar();
            perfil_tamanho();
            $('#menu_perfil_sna').css('display', 'flex').stop()
            .animate({opacity:0}, 0)
            .animate({opacity:1}, 300);
            $('#menu_perfil_sna .scroll').stop()
            .animate({
                marginRight:'-100%',
                opacity: 0
            }, 0)
            .animate({
                marginRight: 0,
                opacity: 1
            }, 500);
        }else {
            menu_perfil_fechar();
        }
        return false;
    });
    $('#menu_perfil_sna').click(function(e){
        if($(e.target).attr('id') == 'menu_perfil_sna') menu_perfil_fechar();
    });

    // ABRE E FECHA O MENU PRINCIPAL
    var menu_principal_fechar = function(){
        if($('#logo_sna i').is(':visible')){
            $('#menu_principal_sna').stop()
            .animate({opacity:0}, 300, function(){
                $(this).hide();
            });
        }
    };
    $('.but_abrir_menu').click(function(){
        if(!$('#menu_principal_sna').is(':visible')){
            menu_perfil_fechar();
            $('#menu_principal_sna').css('display', 'flex').stop()
            .animate({opacity:0}, 0)
            .animate({opacity:1}, 300);
            $('#menu_principal_sna .scroll').stop()
            .animate({
                marginLeft:'-100%',
                opacity: 0
            }, 0)
            .animate({
                marginLeft: 0,
                opacity: 1
            }, 500);
        }else {
            menu_principal_fechar();
        }
        return false;
    });
    $('#menu_principal_sna').click(function(e){
        if($(e.target).attr('id') == 'menu_principal_sna') menu_principal_fechar();
    });
});
