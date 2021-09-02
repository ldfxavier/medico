<div class="container_topo">

    <header class="header_pagina">
        <h1>CONTRATAR</h1>
    </header>
</div>

<form action="<?=LINK . Route::link('post.index.salvar_cadastro');?>" method="post">
    <div class="centro">
        <div class="form">
            <article class="bloco ">
                <header class="bloco__titulo">
                    <h1>Dados de Acesso</h1>
                </header>

                <div class="bloco__label">      
                    <input name="login"  type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Login</label>
                </div>
                <div class="bloco__label">      
                    <input name="senha"  type="password" placeholder=" ">
                    <span class="linha"></span>
                    <label>Senha</label>
                </div>
                <div class="bloco__label">      
                    <input name="confirmar_senha"  type="password" placeholder=" ">
                    <span class="linha"></span>
                    <label>Confirmar Senha</label>
                </div>


                <header class="bloco__titulo endereco">
                    <h1>Dados do Pessoais</h1>
                </header>

                <div class="bloco__label">      
                    <input name="nome" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Nome</label>
                </div>
                <div class="bloco__label">      
                    <input name="cpf" data-mascara="000.000.000-00" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>CPF</label>
                </div>
                <div class="bloco__label">      
                    <input name="email" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Email</label>
                </div>
                <div class="bloco__label">      
                    <input name="confirmar_email" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Confirme o email</label>
                </div>

                <div class="bloco__label">      
                    <input name="telefone" data-mascara="telefone"  type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Telefone</label>
                </div>
                <div class="bloco__label">      
                    <input name="celular" data-mascara="telefone" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Celular</label>
                </div>


            </article>

            <article class="bloco ">

                <header class="bloco__titulo">
                    <h1>Endereço</h1>
                </header>

                <div class="bloco__label">      
                    <input name="cep" type="text" id="cep" data-mascara="00000-000" placeholder=" ">
                    <span class="linha"></span>
                    <label>CEP</label>
                </div>
                <div class="bloco__label">      
                    <input name="logradouro" id="logradouro" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Logradouro</label>
                </div>
                <div class="bloco__label">      
                    <input name="numero" id="numero" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Número</label>
                </div>
                <div class="bloco__label">      
                    <input name="complemento" id="complemento" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Complemento</label>
                </div>
                <div class="bloco__label">      
                    <input name="referencia" id="referencia" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Referência</label>
                </div>
                <div class="bloco__label">      
                    <input name="bairro" id="bairro" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Bairro</label>
                </div>
                <div class="bloco__label">      
                    <input name="cidade" id="cidade" type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Cidade</label>
                </div>
                <div class="bloco__label">      
                    <select  value="" name="estado" id="estado">
                        <option value=""></option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                    <span class="linha"></span>
                    <label>Estado</label>
                </div>
            </article>
            
        </div>
        
        <div class="footer">

            <button id="botao_enviar_cadastro">CONTINUE</button>
        </div>

    </div>    

</form>