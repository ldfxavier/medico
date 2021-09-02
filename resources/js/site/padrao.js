$(function() {

	$.banner({
		id: '#banner_principal',
		imagem: 'figure',
        controle: '#controle',
		prev: '#banner_principal_next',
		next: '#banner_principal_prev',
		tempo: 8
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



});