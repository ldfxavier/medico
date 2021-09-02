$(function(){

	$('body').on('click', '.bloco_buscar_padrao .bloco_selecao .botao', function(){

		let id = $(this).attr('data-id');
		$('.bloco_buscar_padrao .dado').hide();
		$(id).css('display', 'flex');

		$('.bloco_buscar_padrao .bloco_selecao .botao').css('z-index', 1);
		$(this).css('z-index', 3);

	});

	$('body').on('click', '#bloco_formulario_avancado .input_booleano p, #bloco_formulario_avancado .input_booleano .botao', function(){

		let bloco = $(this).closest('.input_booleano');
		
		$('#bloco_formulario_avancado .input_booleano').removeClass('ativo');
		$('#bloco_formulario_avancado .input_booleano input').val(2);
		
		$('input', bloco).val(1);
		bloco.addClass('ativo');

	});

});