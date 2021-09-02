<form action="<?= LINK_PAINEL ?>/app/salvar/perfil" method="post" class="form_geral">

	<div class="bloco">
		<article class="fieldset">
			
			<h2 class="legenda">TÍTULO PRINCIPAL:</h2>

			<label>Título:</label>
			<input class="obrigatorio" type="text" name="titulo_principal" placeholder="Digite o título" value="">
			
			<label>Sub Título:</label>
			<input class="obrigatorio" type="text" name="titulo_secundario" placeholder="Digite o subtítulo" value="">

		</article>
	</div>

	<div class="bloco">
		<article class="fieldset">
			
			<h2 class="legenda">TÍTULO/TEXTO PEQUENO:</h2>

			<label>Título:</label>
			<input class="obrigatorio" type="text" name="titulo_chamada" placeholder="Digite o título da chamada" value="">
			
			<label>Sub Título:</label>
			<input class="obrigatorio" type="text" name="texto_chamada" placeholder="Digite o texto da chamada" value="">

		</article>
	</div>
	
	<div class="bloco">
		<article class="fieldset">
			
			<h2 class="legenda">METATAG:</h2>

			<label>Título:</label>
			<input type="text" name="metatag_titulo" placeholder="Digite o título da metatag" value="">
			
			<label>Descrição:</label>
			<input type="text" name="metatag_descricao" placeholder="Digite a descrição da metatag" value="">

		</article>
	</div>
	
	<div class="bloco">
		<article class="fieldset">
			
			<h2 class="legenda">FONTE:</h2>

			<label>Fonte da matéria:</label>
			<input type="text" name="metatag_titulo" placeholder="Digite o nome da fonte" value="">
			
			<label>Link da matéria:</label>
			<input type="text" name="metatag_descricao" placeholder="Digite a descrição da metatag" value="">

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
