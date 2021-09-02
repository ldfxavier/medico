<?php $equipe = $_SESSION['EQUIPE'] ?>
<article id="bloco_bloquear" style="display: <?php echo isset($_SESSION['BLOQUEADO']) ? 'block' : 'hidden' ?>">
	<div class="conteudo">
		<header>
			<h1>SESSÃO BLOQUEADA</h1>
		</header>
		<form action="{{PAINEL}}/post-desbloquear" method="post">
			<input type="password" class="input_zero" value="">

			<figure class="imagem_trocar" style="background-image: url({{$equipe->imagem}}100)" data-width="100"></figure>

			{{Form::password_completo(array('password'), array('placeholder' => 'Digite sua senha'))}}

			<footer>
				<button>DESBLOQUEAR</button>
				<p class="texto">ou</p>
				<a href="{{PAINEL}}/sair">SAIR DO SISTEMA</a>
			</footer>
		</form>
	</div>
</article>
