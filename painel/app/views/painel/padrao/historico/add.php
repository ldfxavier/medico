<article id="bloco_historico_add" class="bloco_ajax_geral">
	<form class="form_geral bloco_conteudo" action="{{PAINEL}}/post-historico">
		<header class="geral">
			<h1>SALVAR HISTÓRICO</h1>
			<i class="fechar"></i>
		</header>
		<div class="dados">
			<input type="hidden" name="app" value="">
			<input type="hidden" name="cod" value="">
			<input type="hidden" name="bloco" value="">
			<input type="hidden" name="volta" value="">

			<ul class="tipo">
				<li data-tipo="1" data-ajuda="Ligação realizada" class="hover grande realizar"><i data-font="&#xe818;"></i></li>
				<li data-tipo="2" data-ajuda="Ligação recebida" class="grande receber"><i data-font="&#xe818;"></i></li>
				<li data-tipo="3" data-ajuda="E-mail enviado" class="grande realizar"><i data-font="&#xf0e0;"></i></li>
				<li data-tipo="4" data-ajuda="E-mail recebido" class="grande receber"><i data-font="&#xf0e0;"></i></li>
				<li data-tipo="5" data-ajuda="Edição/Criação"><i data-font="&#xe807;"></i></li>
				<li data-tipo="6" data-ajuda="Outros"><i data-font="&#xe819;"></i></li>
			</ul>

			<select name="tipo">
				<option value="1">Ligação realizada</option>
				<option value="2">Ligação recebida</option>
				<option value="3">E-mail enviado</option>
				<option value="4">E-mail recebido</option>
				<option value="5">Edição/Criação</option>
				<option value="6">Outros</option>
			</select>

			<textarea name="texto" placeholder="Digite sua mensagem"></textarea>
		</div>

		<footer class="geral_botao">
			<div class="historico_booleano">
				<input id="form_booleano_historico" type="checkbox" name="booleano">
				<label for="form_booleano_historico" class="historico_booleano_texto"></label>
			</div>
			<button class="botao">SALVAR</button>
		</footer>
	</form>
</article>
