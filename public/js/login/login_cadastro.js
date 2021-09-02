$(function() {

    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('logradouro').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
                $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        Alerta.mensagem('Erro', "Formato de CEP inválido.");
                    }
                });

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                Alerta.mensagem('Erro', "Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    var cep = document.getElementById("cep");
    cep.addEventListener("blur", function( event ) {
        pesquisacep(event.target.value);
    }, true);



    $('#botao_enviar_cadastro').click(function(e) {
        e.preventDefault();
        const form = $(this).closest("form");    
        
        
        let login = $("input[name=login]", form).val();
        let senha = $("input[name=senha]", form).val();
        let confirmar_senha = $("input[name=confirmar_senha]", form).val();
        let nome = $("input[name=nome]", form).val();
        let cpf = $("input[name=cpf]", form).val();
        let email = $("input[name=email]", form).val();
        let confirmar_email = $("input[name=confirmar_email]", form).val();
        let telefone = $("input[name=telefone]", form).val();
        let celular = $("input[name=celular]", form).val();
        let cep = $("input[name=cep]", form).val();
        let logradouro = $("input[name=logradouro]", form).val();
        let numero = $("input[name=numero]", form).val();
        let complemento = $("input[name=complemento]", form).val();
        let referencia = $("input[name=referencia]", form).val();
        let bairro = $("input[name=bairro]", form).val();
        let cidade = $("input[name=cidade]", form).val();
        let estado = $("select[name=estado]", form).val();
    

        Loading.show();

        let dado = new FormData();
        dado.append('login', login);
        dado.append('senha', senha);
        dado.append('confirmar_senha', confirmar_senha);
        dado.append('nome', nome);
        dado.append('cpf', cpf);
        dado.append('email', email);
        dado.append('cep', cep);
        dado.append('logradouro', logradouro);
        dado.append('numero', numero);
        dado.append('complemento', complemento);
        dado.append('referencia', referencia);
        dado.append('bairro', bairro);
        dado.append('cidade', cidade);
        dado.append('estado', estado);
        dado.append('confirmar_email', confirmar_email);
        dado.append('telefone', telefone);
        dado.append('celular', celular);

        $.ajax({
            url: form.attr('action'),
            data: dado,
            type: 'POST',
            dataType: 'json',
            success: function(resposta) {
                Loading.hide();
    
                if (false === resposta.erro) {
        
                    $("input[name=login]", form).val('');
                    $("input[name=senha]", form).val('');
                    $("input[name=confirmar_senha]", form).val('');
                    $("input[name=nome]", form).val('');
                    $("input[name=cpf]", form).val('');
                    $("input[name=email]", form).val('');
                    $("input[name=confirmar_email]", form).val('');
                    $("input[name=telefone]", form).val('');
                    $("input[name=celular]", form).val('');
                    $("input[name=cep]", form).val('');
                    $("input[name=logradouro]", form).val('');
                    $("input[name=numero]", form).val('');
                    $("input[name=complemento]", form).val('');
                    $("input[name=referencia]", form).val('');
                    $("input[name=bairro]", form).val('');
                    $("input[name=cidade]", form).val('');
                    $("select[name=estado]", form).val('');
                        
                    Alerta.mensagem("Sucesso!", "Seu cadastro foi efetuado com sucesso.");
    
                }else if(resposta.erro == true) {
                    Alerta.mensagem(resposta.titulo, resposta.texto);
                }
            },
            error: function(resposta) {
                Loading.hide();
                resposta = JSON.parse(resposta.responseText);
    
                if (resposta.erro == true) {
                    Alerta.mensagem(resposta.titulo, resposta.texto);
                } else {
                    Alerta.mensagem('Erro!', 'Ocorreu um erro ao enviar seu formulário, por favor, tente novamente.');
                }
            },
            processData: false,
            cache: false,
            contentType: false
        });

        return false;
    });
    


});