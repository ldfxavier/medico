$(function(){

	$('#form_app_index_busca input').focus(function(){
		$('#form_app_index_busca').addClass('ativo');
	});

	$('#form_app_index_busca input').blur(function(){
		if($(this).val() == ''){
			$('#form_app_index_busca').removeClass('ativo');
		}
	});

	let liberar_botao_download = function(){
		if($('#bloco_app_lista_dado .selecao.checked').length > 0){
			$('.bloco_app_padrao .bloco_botao .deletar').addClass('ativo');

		}else {
			$('.bloco_app_padrao .bloco_botao .deletar').removeClass('ativo');
		}
	}
	let marcar_li_selecionada = function(){

		let li;
		$('#bloco_app_lista_dado li.lista .selecao').each(function(){

			li = $(this).closest('li.lista');

			if($(this).hasClass('checked')){
				li.addClass('ativo');
			}else {
				li.removeClass('ativo');
			}

		});

	}
	$('.bloco_app_padrao .lista_conteudo .selecao').click(function(){

		Checkbox.click($(this))

		liberar_botao_download();
		marcar_li_selecionada();

	});

	$('#bloco_app_lista_dado').sortable({
		update: function(){
			console.log(1)
		},
		opacity: 0.8,
		handle: '.dragdrop'
	});
	
	$('#bloco_app_lista_dado li.lista').dblclick(function(){
	
		if($('.editar .botao', this).length == 1){
			console.log(1);
			$('.editar .botao', this)[0].click();
		}else if($('.previa .botao', this).length == 1){
			$('.previa .botao', this)[0].click();
		}
	
	});

});
