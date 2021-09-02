<div id="bloco__perfil--index">
	<article>
		<header>
			<figure style="background-image: url(<?= EQUIPE_IMAGEM ?>180)"></figure>
			<h1>André Rodrigues</h1>
			<p>Desenvolvimento</p>
			<a href="<?= LINK_PAINEL ?>/perfil/dados"><i data-font="&#xe815;"></i> <span>Editar</span></a>
		</header>

		<h2>CONTATOS:</h2>
		<ul class="contato">
			<li>
				<i class="icone" data-font="&#xe820;"></i><p>(61) 98888-7777</p>
				<span>Celular</span>
			</li>
			<li>
				<i class="icone" data-font="&#xe81f;"></i><p>(61) 3202-3003</p>
				<span>Fixo</span>
			</li>
			<li class="copiar">
				<i class="icone" data-font="&#xe821;"></i><p>andre@gmail.com</p><div class="bloco_copiar"><input type="text" value="andrerodrigues@andrerodrigues.com"><i data-ajuda="Copiar" class="botao_copiar" data-font="&#xe818;"></i></div>
				<span>E-mail pessoal</span>
			</li>
			<li class="copiar">
				<i class="icone" data-font="&#xe821;"></i><p>andre@marktclub.com.br</p><div class="bloco_copiar"><input type="text" value="andre@marktclub.com.br"><i class="botao_copiar" data-ajuda="Copiar" data-font="&#xe818;"></i></div>
				<span>E-mail do trabalho</span>
			</li>
			<li>
				<i class="icone" data-font="&#xf031;"></i><p>SIG Quadra 04, LOTE 125/175, Bloco A, Sala 10. CEP 70610-440, Capital Financial Center, Brasília - DF</p>
				<span>Endereço</span>
			</li>
		</ul>

		<h2>CONTATOS DE EMERGÊNCIA:</h2>
		<ul class="contato emergencia">
			<li>
				<i class="icone" data-font="&#xe814;"></i><p>(61) 94444-3333</p>
				<span>Milena Alana</span>
			</li>
			<li>
				<i class="icone" data-font="&#xe814;"></i><p>(61) 3202-3003</p>
				<span>Casa</span>
			</li>
		</ul>
	</article>

	<section class="historico">
		<h1>Atividades:</h1>
		<ul>
			<?php for($i=0; $i<3; $i++): ?>
			<li>
				<div class="bola"></div>
				<p>Adicionado Novo Usuário.</p>
				<time>10/10/2018 10:10</time>
			</li>
			<li>
				<div class="bola"></div>
				<p>Adicionado nova publicação de notícia.</p>
				<time>10/10/2018 20:10</time>
			</li>
			<li>
				<div class="bola"></div>
				<p>Edição em um usuário.</p>
				<time>10/10/2018 20:10</time>
			</li>
			<li>
				<div class="bola"></div>
				<p>Edição em uma publicação de notícia.</p>
				<time>10/10/2018 20:10</time>
			</li>
			<li>
				<div class="bola"></div>
				<p>Deletou um usuário.</p>
				<time>10/10/2018 20:10</time>
			</li>
			<?php endfor; ?>
		</ul>
		<a href="">VER TODAS</a>
	</section>
</div>
