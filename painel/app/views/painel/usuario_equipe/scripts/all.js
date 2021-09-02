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

	$('input[name=gerente]').change(function(){
		var valor = $(this).val();
		if(valor == 1){
			$('.bloco_gerente_equipe').removeClass('hide');
		}else {
			$('.bloco_gerente_equipe').addClass('hide');
		}
	});
});
