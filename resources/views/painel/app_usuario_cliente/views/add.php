<article class="bloco_app_padrao">

	<div class="bloco bloco_botao">
		<a class="botao_quadrado add" data-ajuda="Adicionar" href="<?= LINK ?>/" target="_self"><i data-font="&#xe809;"></i></a>
		<button class="botao_quadrado relatorio" data-ajuda="Relatório" href="<?= LINK ?>/" target="_self"><i data-font="&#xe803;"></i></button>
		<button class="botao_quadrado download" data-ajuda="Download" href="<?= LINK ?>/" target="_self"><i data-font="&#xf0ed;"></i></button>
		<button class="botao_quadrado historico" data-ajuda="Histórico" href="<?= LINK ?>/" target="_self"><i data-font="&#xf1da;"></i></button>
		<button class="botao_quadrado deletar" data-ajuda="Deletar" href="<?= LINK ?>/" target="_self"><i data-font="&#xe801;"></i></button>

		<form action="<?= LINK_PAINEL ?>" method="get" id="form_app_index_busca">
			<input type="shared" name="pesquisa" placeholder="Buscar..." value="">
			<button><i data-font="&#xe805;"></i></button>
		</form>

		<i class="filtro" data-font="&#xe81a;" data-ajuda="Filtrar dados"></i>
	</div>

	<?php if(isset($_SESSION['BUSCAR_'.$app]) && $_SESSION['BUSCAR_'.$app]): ?>
	<div class="bloco filtro_lista">
		<div class="filtro">Teste<i data-font="&#xe807;"></i></div>
		<div class="limpar">Limpar filtros</div>
	</div>
	<?php endif; ?>

	<div class="bloco lista_conteudo lista_titulo">
		<div class="ordem"></div>

		<div class="selecao bloco_checkbox" id="bloco_marcar_todos" data-marcar-todos="#bloco_app_lista_dado">
			<input type="checkbox">
			<span></span>
		</div>

		<figure></figure>
		<div class="td flex_grow"><a href=""><span class="titulo">NOME</span><i data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div style="width: 150px" class="td"><a href=""><span class="titulo">CPF</span><i data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div style="width: 200px" class="td"><a href=""><span class="titulo">E-MAIL</span><i data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div style="width: 150px" class="td"><a href=""><span class="titulo">TELEFONE</span><i data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div style="width: 40px" class="td centralizar"><a href="#teste"><i data-ajuda="MENSAGEM" data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div class="numero"><span class="bola" data-ajuda="CONTADOR"></span></div>

		<div class="linha"></div>

		<div class="td status centralizar"><a href="#teste"><i data-ajuda="STATUS" data-font="&#xe810;"></i></a></div>

		<div class="linha"></div>

		<div class="previa"></div>

		<div class="linha sem_borda"></div>

		<div class="editar"></div>
	</div>

	<ul class="bloco lista_conteudo" id="bloco_app_lista_dado">
		<?php for($i=0; $i<20; $i++): ?>
		<li class="lista">
			<div class="hover"></div>
			<div class="ordem">
				<i class="dragdrop" data-font="&#xf0dc;"></i>
			</div>

			<div class="selecao bloco_checkbox" data-controlador="#bloco_marcar_todos">
				<input type="checkbox">
				<span></span>
			</div>

			<figure style="background-image: url(<?= EQUIPE_IMAGEM ?>40)"></figure>

			<div class="td flex_grow">André Rodrigues</div>

			<div class="linha"></div>

			<div style="width: 150px" class="td bloco_copiar">
				<span>014.951.801-31</span>
				<input type="text" class="input_copiar" value="014.951.801-31">
				<i data-font="&#xe818;" class="botao_copiar"></i>
			</div>

			<div class="linha"></div>

			<div style="width: 200px" class="td bloco_copiar">
				<span>andrerodrigues@andrerodrigues.com</span>
				<input type="text" class="input_copiar" value="andrerodrigues@andrerodrigues.com">
				<i data-font="&#xe818;" class="botao_copiar"></i>
			</div>

			<div class="linha"></div>

			<div style="width: 150px; text-align: center;" class="td">(61) 98177-7773</div>

			<div class="linha"></div>

			<div style="width: 40px; text-align: center;" class="td">1</div>

			<div class="linha"></div>

			<div class="numero"><span style="background-color: #FF6C60">3</span></div>

			<div class="linha"></div>

			<div class="status">
				<span data-ajuda="Ativo" style="background-color: #4AA9E9"></span>
			</div>

			<div class="linha"></div>

			<div class="previa">
				<i data-font="&#xe802;" data-ajuda="Prévia"></i>
			</div>

			<div class="linha"></div>

			<div class="editar">
				<a href="<?= LINK ?>/app/editar/<?= $_app ?>"><i data-font="&#xe815;"></i></a>
			</div>
		</li>
		<?php endfor; ?>
	</ul>

</article>
