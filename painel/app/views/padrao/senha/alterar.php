<article id="bloco_senha">
	<div class="conteudo">
		<header>
			<h1>ALTERAR SENHA</h1>
			<i class="fechar"></i>
		</header>
		<form action="{{PAINEL}}/post-alterar-senha" method="post">
			<input type="text" class="input_zero" value="">
			<input type="password" class="input_zero" value="">

			<label>SENHA ATUAL:</label>
			<input class="atual" type="password" name="atual" autocomplete="off" placeholder="Digitar senha atual" value="">

			<label>DIGITE UMA NOVA SENHA:</label>
			{{Form::password_completo(array('password', 'password_2'), array('placeholder' => 'Digite sua nova senha'), array('placeholder' => 'Repetir nova senha'))}}

			<footer>
				<button>ALTERAR</button>
			</footer>
		</form>
	</div>
</article>
