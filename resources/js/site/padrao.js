$(function() {

    $.banner({
        id: '#banner_principal',
        imagem: 'figure',
        controle: '#controle',
        prev: '#banner_principal_next',
        next: '#banner_principal_prev',
        tempo: 8
    });
    $.banner({
        id: '#banner_principal_localiza',
        imagem: 'figure',
        controle: '#controle',
        prev: '#banner_principal_localiza_next',
        next: '#banner_principal_localiza_prev',
        tempo: 5
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
    $('.header .menu .bottom .menu-container.ativo ul li a[href^="#"]').on('click', function(e) {
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

    $(".header .menu .bottom .mobile-menu-icon").click(function(e){
		e.stopPropagation();

        $('.menu-container').toggleClass('ativo');

    });


	var dropButton = document.querySelectorAll('.header .menu .bottom ul li.sub');

	function fechaItemAberto() {
		abreMenu = document.querySelectorAll('.header .menu .bottom ul li.sub ul');
		abreMenu.forEach(function(menus) {
			menus.classList.remove('ativo');
		});  
	}

	dropButton.forEach(function(btn) {

		btn.addEventListener('click', function(e) {
		e.stopPropagation();
		var 
			dropConteudo = btn.querySelector('.header .menu .bottom ul li.sub ul'),
			abre = !dropConteudo.classList.contains('ativo');
		fechaItemAberto();
		if (abre) {
			dropConteudo.classList.add('ativo');      
		}
		});

	});


       // Ação quando a janela mudar de tamanho
    $(window).resize(function() {

        if ($(window).width() <= 760) {

            $('.header .menu .bottom .menu-container').removeClass('ativo');

        } 

    });


	$('#botao_enviar_contato').click(function(e){
		e.preventDefault();

		Loading.show();

		let form = $(this).closest('form');

		$.post(form.attr('action'), {
			ajax:true,
			nome:$('input[name=nome]', form).val(),
			telefone:$('input[name=telefone]', form).val(),
			email:$('input[name=email]', form).val(),
			mensagem:$('textarea[name=mensagem]', form).val()
		}, function(resposta){

			if(resposta.erro == false){
				$('input, textarea', form).val('');
				Alerta.mensagem('Dados enviado!', 'Mensagem enviada com sucesso, em breve retornaremos o contato.');
			}

		}, 'json').fail(function(resposta){

			resposta = JSON.parse(resposta.responseText);
			
			if(resposta.erro == true){
				Alerta.mensagem(resposta.titulo, resposta.texto);
			}

		}).always(function(){

			Loading.hide();

		});

	});
	


});