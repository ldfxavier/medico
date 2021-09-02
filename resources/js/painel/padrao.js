$(window).load(function(){

	$('body').show();

	Loading.hide();

});

$(function(){

	$('body').on({
		mouseenter: function(){
			Ajuda.show($(this), $(this).attr('data-ajuda'), 'absolute');
		},
		mouseleave: function(){
			Ajuda.hide();
		}
	}, '*[data-ajuda]');
	$('body').on({
		mouseenter: function(){
			Ajuda.show($(this), $(this).attr('data-ajuda-fixed'), 'fixed');
		},
		mouseleave: function(){
			Ajuda.hide();
		}
	}, '*[data-ajuda-fixed]');

	$('body').on('click', '.botao_pagina', function(){
		
		let pagina = new Pagina;
		pagina.abrir($(this).attr('data-href'));

	});
	$('body').on('click', '.fechar_ajax', function(){
		let pagina = new Pagina;
		pagina.fechar();
	});


	/*
	|--------------------------------------------------------------------------
	| FUNÇÃO PARA COPIAR
	|--------------------------------------------------------------------------
	*/
	$('body').on('click', '.bloco_copiar .botao_copiar', function(){

		let bloco = $(this).closest('.bloco_copiar');

		$('input', bloco).select();

		let copiar = document.execCommand('copy');

		if(copiar){
			Alerta.notificacao('Texto copiado<br>com sucesso!');
		}else {
			Alerta.notificacao('Ocorreu um erro<br>ao copiar o texto.').alerta();
		}

	});

	/*
	|--------------------------------------------------------------------------
	| FUNÇÃO PARA ABRIR BLOCO DO CHECKBOX
	|--------------------------------------------------------------------------
	*/
	$('body').on('click', '.input_checkbox .botao_abrir', function(){

		$(this).closest('.checkbox').removeClass('curto');
		$(this).remove();

	});

	/*
	|--------------------------------------------------------------------------
	| FUNÇÃO PARA MANIPULAR O BOTÃO DE BOLEANO
	|--------------------------------------------------------------------------
	*/
	$('body').on('click', '.input_booleano p, .input_booleano .botao', function(){
		
		let bloco = $(this).closest('.input_booleano');
		let input = $('input', bloco).val();

		if(input == 1){
			bloco.removeClass('ativo');
			$('input', bloco).val(2);
		}else {
			bloco.addClass('ativo');
			$('input', bloco).val(1);
		}

	});

	/*
	|--------------------------------------------------------------------------
	| FUNÇÃO PARA MANIPULAR AS TAGS
	|--------------------------------------------------------------------------
	*/
	let inputTag = {
		adicionar: function(){

		},
		remover: function(){

		}
	};

	$('body').on('click', '.input_tag', function(){
		$('input', this).focus();
	});
	$('body').on('keydown', '.input_tag input', function(e){

		if(e.keyCode == 13){
			e.preventDefault();
			input_tag.adicionar($(this));
		}

	});
});































//
