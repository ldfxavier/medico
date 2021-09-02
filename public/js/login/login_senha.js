$(function(){


    $('form #botao_enviar_cadastro').click(function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        var link = $(form).attr('action');
        var email = $('input[name=email]', form).val();
        if(email == '' || email == undefined){
			Alerta.mensagem('Campo vazio!', 'O campo E-mail é obrigatório.');
            return false;
        }

        Loading.show();

        $.post(link,{
            ajax: true,
            email
        }, function(resposta){
            if(resposta.erro == false){
			    Alerta.mensagem('E-mail enviado!', `Acesse o email: ${resposta.email} para recuperar a sua senha.`);
                $('input').val('');
            }else{
			    Alerta.mensagem(resposta.titulo, resposta.texto);
            }

            Loading.show();
            
        }, 'json');
        return false;
    });


});