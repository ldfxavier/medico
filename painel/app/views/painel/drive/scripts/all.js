$(function(){
	$('#input_equipe_permissao').change(function(){
		var valor = $(this).val();
		if(valor != ''){
			//$.loading('show');
			$.post($('#PAINEL').val()+'/include/equipe/copiar_permissao', {
				equipe:valor
			}, function(resposta){
				$('#bloco_equipe_permissao input[type=checkbox]').removeAttr('checked');
				if(resposta.erro == false){
					var quantidade = 0;
					$(resposta.permissao).each(function(i, data){
						quantidade++;
						$('#bloco_equipe_permissao input[data-valor='+data+']').prop('checked', true);
					});
					if($('#bloco_equipe_permissao input[name=permissao]').size() == quantidade){
						$('#bloco_equipe_permissao input[data-name=todos]').prop('checked', true);
					}else {
						$('#bloco_equipe_permissao input[data-name=todos]').removeAttr('checked');
					}
				}
			}, 'json');
		}else {
			$('#bloco_equipe_permissao input[type=checkbox]').removeAttr('checked');
		}
	});

	$('.but_gerar_link').click(function(e){
			e.stopPropagation();
			var link = $(this).attr('data-link');
			var textBox = $('#gerar_link input');
			$('#gerar_link').show();
			$('body').css('overflow','hidden')
			$('#gerar_link input').val(link);
			$('#gerar_link input').focus();
			$('#gerar_link input').select();
		});

		$('.explicacao').click(function(e){
			e.stopPropagation();
			$('#gerar_link input').focus();
			$('#gerar_link input').select();
		});

		$('#gerar_link').click(function(){
			$('#gerar_link').hide();
			$('body').css('overflow','auto')
		});

});
