$(function(){

	let menu = {
		principal: {

		},
		secundario: {
			abrir: function(){
				Scroll.hide();
				$('#menu_secundario').stop().css('display', 'flex')
				.animate({opacity:0}, 0)
				.animate({opacity:1}, 300);

				$('#menu_secundario .conteudo').stop().css('display', 'flex')
				.animate({
					opacity:0,
					right: '-300px'
				}, 0)
				.delay(50).animate({
					opacity:1,
					right: 0
				}, 400);
			},
			fechar: function(){
				$('#menu_secundario .conteudo').stop()
				.animate({
					opacity:0,
					right: '-300px'
				}, 400, function(){
					$(this).hide();
				});
				$('#menu_secundario').stop().delay(100)
				.animate({opacity:0}, 300, function(){
					$(this).hide();
					Scroll.show();
				});
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| MENU SECUNDÁRIO
	|--------------------------------------------------------------------------
	|
	| Funções para a utilização do menu da direita
	|
	*/
	$('#header_principal .botao_menu_secundario').click(function(){

		menu.secundario.abrir();

	});

	$('#menu_secundario').click(function(e){

		if($(e.target).attr('id') == 'menu_secundario'){
			menu.secundario.fechar();
		}

	});
	$('#menu_secundario .header i').click(function(){

		menu.secundario.fechar();

	});


	/*
	|--------------------------------------------------------------------------
	| ABRIR DROPDOW DO MENUS
	|--------------------------------------------------------------------------
	*/
	$('#menu_principal .dropdown .botao').click(function(){

		let li = $(this).closest('.dropdown');

		if(li.hasClass('ativo')){
			li.removeClass('ativo');
		}else {
			li.addClass('ativo');
		}

	});

	/*
	|--------------------------------------------------------------------------
	| HEADER
	|--------------------------------------------------------------------------
	|
	| Funções para a utilização do header principal do site
	|
	*/
	$(document).scroll(function(){

		if($('body, html').scrollTop() > 60 && !$('#header_principal').hasClass('ativo')){

			$('#header_principal').addClass('ativo');

		}else if($('body, html').scrollTop() <= 60 && $('#header_principal').hasClass('ativo')){

			$('#header_principal').removeClass('ativo');

		}

	});

	$('.botao_notificacao').click(function(){

		$(this).removeClass('alerta');
		
		let pagina = new Pagina();
		pagina.abrir($(this).attr('data-href'));

	});

	$('body').on('click', '#bloco_notificacao header i.fechar', function(){

		let pagina = new Pagina();
		pagina.fechar();

	});

});
