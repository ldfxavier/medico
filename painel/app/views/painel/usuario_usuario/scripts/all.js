
$(function() {

	$('.adicionar_dependente').click(function(e){
		e.preventDefault();

		$(".bloco_dependente").append(`
            <div class="categoria dependente">
                <label for="input_nome_dependente">NOME COMPLETO:</label>
                <input type="text" id="input_nome_dependente" name="nome_dependente" data-campo="Nome dependente" placeholder="Digite o nome do dependente" >

                <label for="input_documento_dependente">CPF:</label>
                <input type="text" id="input_documento_dependente" name="documento_dependente" data-campo="Cônjuge"data-mascara="000.000.000-00"  placeholder="Digite o documento do dependente">

                <label for="input_rg_dependente">RG:</label>
                <input type="text" id="input_rg_dependente" name="rg_dependente" data-campo="Cônjuge" placeholder="Digite o rg do dependente" >

                <label for="input_emissor_dependente">EMISSOR:</label>
                <input type="text" id="input_emissor_dependente" name="emissor_dependente" data-campo="Emissor" placeholder="Digite o emissor do dependente" >

                <label for="input_data_nascimento_dependente">DATA DE NASCIMENTO:</label>
                <input type="text" id="input_data_nascimento_dependente" name="data_nascimento_dependente" data-campo="data_nascimento" placeholder="Digite o data_nascimento do dependente"  data-mascara="00/00/0000">

                <label for="input_parentesco_dependente">PARENTESCO:</label>
                <input type="text" id="input_parentesco_dependente" name="parentesco_dependente" data-campo="parentesco" placeholder="Digite o parentesco do dependente" >
            </div>`
		);

    });

    $("body").on("click", '.btn_dependente', function(e){
        e.preventDefault();

        let form = $('.form_geral_codigo');

        let cod = $('input[name=cod]', form).val();
        let acao = $('input[name=acao]', form).val();

		var dependentes = $(".bloco_dependente ");
		dependente = {};  

		dependentes.each(function(i){
			$('.categoria.dependente', this).each(function(i){

				dependente[i] = {
					nome: $('input[name=nome_dependente]', this).val() || '',
					documento: $('input[name=documento_dependente]', this).val() || '',
					rg: $('input[name=rg_dependente]', this).val() || '',
					emissor: $('input[name=emissor_dependente]', this).val() || '',
					nascimento: $('input[name=data_nascimento_dependente]', this).val() || '',
					parentesco: $('input[name=parentesco_dependente]', this).val() || ''
				};

			});
		});


        $.post($("#PAINEL").val() + '/incorporar/usuario_usuario/post_salvar_dependente', {
        acao,
        cod,
        dependente: dependente,
        }, function(resposta){
        if(resposta.erro == false){
            location.reload();
        }else if(resposta.erro == true){
            $.alerta({
                titulo:resposta.titulo,
                texto:resposta.texto
            });
            $.loading();
        }

        }, 'json');
    });

});