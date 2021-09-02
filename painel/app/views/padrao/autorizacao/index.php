<div id="bloco_autorizacao">
	<form action="{{PAINEL}}/post-autorizacao" method="post" class="bloco_pagina_geral">
		<header class="geral">
			<h1>AUTENTICAÇÃO SOLICITADA</h1>
			<i class="fechar"></i>
		</header>
		<div class="corpo">
			<input type="text" class="input_zero" value="">
			<input type="password" class="input_zero" value="">

			<input type="text" name="login" autocomplete="off" placeholder="Login do administrador" value="<?= ($_SESSION['EQUIPE']->gerente == 1) ? $_SESSION['EQUIPE']->login : '' ?>">
			{{Form::password_completo(['password'], ['placeholder' => 'Digite sua senha'])}}

			<input type="hidden" name="tipo" value="1">
		</div>
		<footer class="geral_botao">
			<button class="botao">AUTENTICAR</button>
		</footer>
	</form>
</div>
