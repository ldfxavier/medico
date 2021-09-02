<form action="<?= LINK_PAINEL ?>/app/salvar/perfil" method="post" class="form_geral">

	<div class="coluna">
		<article class="fieldset">
			<h2 class="legenda">DADOS PESSOAIS:</h2>

			<label>Nome:</label>
			<input class="obrigatorio" type="text" name="nome_completo" placeholder="Digite seu nome" value="">

			<label>CPF:</label>
			<input class="obrigatorio" type="text" name="documento_cpf" data-mascara="000.000.000-00" inputmode="numeric" placeholder="000.000.000-00" value="">

			<label>Sexo:</label>
			<select class="obrigatorio" name="sexo">
				<option value="">Escolha uma opção</option>
				<option value="1">Masculino</option>
				<option value="2">Feminino</option>
			</select>

			<label>Data de nascimento:</label>
			<input class="obrigatorio" type="text" name="data_nascimento" data-mascara="00/00/0000" inputmode="numeric" placeholder="00/00/0000" value="">
		</article>
	</div>

	<div class="coluna">
		<article class="fieldset">
			<h2 class="legenda">Contato:</h2>

			<label>Celular:</label>
			<input class="um_ou_outro" type="tel" name="telefone_celular" data-mascara="telefone" inputmode="numeric" placeholder="(00) 90000-0000" value="">

			<label>Telefone Fixo:</label>
			<input class="um_ou_outro" type="tel" name="telefone_fixo" data-mascara="telefone" inputmode="numeric" placeholder="(00) 0000-0000" value="">

			<label>E-mail pessoal:</label>
			<input class="obrigatorio" type="email" name="email_pessoal" placeholder="email@dominio.com" value="">
			
			<label>E-mail de trabalho:</label>
			<input class="obrigatorio" type="email" name="email_trabalho" placeholder="email@dominio.com" value="">

		</article>
	</div>

	<div class="bloco">
		<article class="fieldset row wrap">
			<h2 class="legenda">ENDEREÇO</h2>

			<div class="bloco_input w120">
				<label>CEP:</label>
				<input type="text" name="name" data-mascara="00000-000" inputmode="numeric" placeholder="Ex.: 00000-000" value="">
			</div>
			<div class="bloco_input w300">
				<label>Logradouro:</label>
				<input type="text" name="logradouro" placeholder="Ex.: Rua dos Passaros" value="">
			</div>
			<div class="bloco_input w400">
				<label>Complemento:</label>
				<input type="text" name="complemento" placeholder="Ex.: Casa E" value="">
			</div>
			<div class="bloco_input w80">
				<label>Número:</label>
				<input type="text" name="numero" placeholder="4" data-mascara="numero" value="">
			</div>
			<div class="bloco_input w180">
				<label>Bairro:</label>
				<input type="text" name="bairro" placeholder="Ex.: Centro" value="">
			</div>
			<div class="bloco_input w180">
				<label>Cidade:</label>
				<input type="text" name="cidade" placeholder="Ex.: Brasília" value="">
			</div>
			<div class="bloco_input w220">
				<label>Estado:</label>
				<select name="estado">
					<option value="">Esclha uma opção</option>
				</select>
			</div>

		</article>
	</div>

	<div class="bloco">
		<article class="fieldset">
			<h2 class="legenda">CATEGORIAS:</h2>

			<label>Tag</label>
			<div class="input_tag">
				<div class="tag">Teste <i data-font="&#xe807" data-ajuda="Remover"></i></div>
				<input type="text" placeholder="Digite uma tag">
			</div>
		</article>
	</div>

	<button class="botao_salvar_flutuante" id="botao_salvar_geral"><i data-font="&#xe822;"></i><span>SALVAR</span></button>
</form>
