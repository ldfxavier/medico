<?php
if (isset($banner) && !empty($banner)):
	?>
<section class="bloco_banner--padrao " id="banner_principal">

	<?php
	if (isset($banner) && !empty($banner)):
		foreach ($banner as $b):
	?>
	<figure style="background-image: url(<?=$b->imagem;?>)">
		<?php if(!empty($b->titulo) || !empty($b->texto)): ?>
		<header>
			<h1><?=$b->titulo;?></h1>
			<p><?=$b->texto;?></p>
		</header>
		<?php endif; ?>
		<a href="<?=$b->url->link;?>" target="<?=$b->url->target;?>"></a>
	</figure>
	<?php
	endforeach;
	endif;
	?>

	<i class="controlador prev" id="banner_principal_prev"></i>
	<i class="controlador next" id="banner_principal_next"></i>

	<?php
	if (isset($banner) && !empty($banner)):
	?>
	<div class="controler">
		<ul class="controle" id="controle">
		<?php
			foreach ($banner as $i => $v):
		?>  
			<li data-id="<?= $i ?>" class="<?= $i == 0 ? 'hover' : ''; ?>"></li>
		<?php
			endforeach;
		?>
		</ul>
	</div>
	<?php
	endif;
	?>

</section>
<?php
endif;
?>
<div>

<section id="sobre">
	<div class="quadrado"></div>
	<div class="conteudo">
		<article class="esquerdo">
			<h1>DR. ANDRÉ NERI</h1>
			<div class="texto">
				<?php
					if (isset($dado->imagem) && !empty($dado->imagem)):
				?>
					<img src="<?= $dado->imagem ?>" alt="">
				<?php
					endif;
				?>
				<?php
					if (isset($dado->sobre_chamada) && !empty($dado->sobre_chamada)):
				?>
				<div class="bloco_texto">
					<?= $dado->sobre_chamada ?>
				</div>
				<?php
					endif;
				?>

			</div>
			<div class="link">
				<a href="#"  data-href="<?= LINK_PADRAO . '/popup/sobre'; ?>"  class="abre_popup_sobre" >Saiba mais</a>
			</div>
		</article>
	</div>
</section>

<section id="especialidade">
	<div class="bg"></div>
	<div class="titulo_padrao">
		<h1>Especialidades</h1>
		<div class="linha"></div>
	</div>
	<div class="conteudo">
		<?php
		if (isset($especialidade) && !empty($especialidade)):
			foreach ($especialidade as $e):
		?>
		<article>
			<figure style="background-image: url(<?= $e->imagem ?>)">
				<!-- <img src="<?= $e->imagem ?>" alt=""> -->
			</figure>
			<h1><?= $e->titulo ?></h1>
			<div class="texto">
				<p><?= $e->texto ?></p>
			</div>
			<a href="#" data-href="<?= LINK_PADRAO . '/popup/especialidade' . '/' . $e->url; ?>"  class="abre_popup_especialidade"></a>
		</article>	
		<?php
		endforeach;
		endif;
		?>

		<article class="ultimo">
			<div class="quadrado"></div>
		</article>
	</div>
</section>

<section id="agenda">
	<div class="centro">
		<article class="esquerdo">
			<div class="titulo_padrao_esquerdo">
				<h1>Agende sua consulta</h1>
				<div class="linha"></div>
			</div>

			<?php
				if (isset($dado->agendamento) && !empty($dado->agendamento)):
			?>
				<?= $dado->agendamento ?>
			<?php
				endif;
			?>
		</article>
		<article class="direito">
			<div class="link">
				<a href="<?= $dado->link_agendamento ?>"  target="_blank">AGENDAR</a>
			</div>
		</article>
	</div>
</section>

<section id="localizacao">
	<div class="titulo_padrao">
		<h1>Localização</h1>
		<div class="linha"></div>
	</div>
	<div class="centro">
		<article class="esquerdo">
			<div class="quadrado"></div>

			<?php
				if (isset($dado->endereco) && !empty($dado->endereco)):
			?>
				<ul>
					<li><?= $dado->endereco ?></li>
				</ul>
			<?php
				endif;
			?>
			
		</article>
		<article class="direito">
			<div class="mapa">
				<section class="bloco_banner--padrao localiza " id="banner_principal_localiza">

					<?php
					if (isset($banner_localiza) && !empty($banner_localiza)):
						foreach ($banner_localiza as $b_l):
					?>
					<figure style="background-image: url(<?=$b_l->imagem;?>)">
						<?php if(!empty($b_l->titulo) || !empty($b_l->texto)): ?>
						<header>
							<h1><?=$b_l->titulo;?></h1>
							<p><?=$b_l->texto;?></p>
						</header>
						<?php endif; ?>
						<a href="<?=$b_l->url->link;?>" target="<?=$b_l->url->target;?>"></a>
					</figure>
					<?php
					endforeach;
					endif;
					?>

					<i class="controlador prev" id="banner_principal_localiza_prev"></i>
					<i class="controlador next" id="banner_principal_localiza_next"></i>

				</section>

			</div>
		</article>
		<div class="quadrado_footer"></div>
	</div>
</section>


<section id="contato">
	<div class="centro">
		<article class="esquerdo">
			<div class="titulo_padrao_esquerdo">
				<h1>Contato</h1>
				<div class="linha"></div>
			</div>

			<ul>
				<?php
					if (isset($dado->email) && !empty($dado->email)):
				?>
				<li>
					<p>
						<span class="bold">E-mail:</span>
					</p>
					<p>
						<span><?= $dado->email?></span>
					</p>
				</li>
				<?php
					endif;
				?>
				<?php
					if (isset($dado->telefone) && !empty($dado->telefone)):
				?>
					<li>
						<p>
							<span class="bold">Telefone:</span>
							
						</p>
						<p>
						<span><?= $dado->telefone ?></span>
						</p>
						<a class="link" href="<?= $dado->telefone ?>"  target="_blank"></a>
					</li>
				<?php
					endif;
				?>
			</ul>
		</article>
		<article class="direito">
			<form action="<?= LINK.\Route::link('post.index.salvar') ?>" method="post">
				<h1>Dúvidas / Sugestões / Reclamações:</h1>
				<label for="nome">Nome</label>
				<input type="text" placeholder="Nome" name="nome" id="nome">

				<label for="email">E-mail</label>
				<input type="text"  placeholder="E-mail"  name="email" id="email">

				<label for="telefone">Telefone para contato</label>
				<input type="text" data-mascara="telefone"   placeholder="telefone"  name="telefone" id="telefone">
				
				<label for="telefone">Mensagem</label>
				<textarea placeholder="Sua mensagem" name="mensagem" id="" cols="30" rows="10"></textarea>
				<button id="botao_enviar_contato">Enviar</button>
			</form>
		</article>
	</div>
</section>


<section id="parceiro">
	<div class="lista">

		<?php
		if (isset($galeria) && !empty($galeria)):
			foreach ($galeria->lista as $g):
		?>
		<article>
            <figure style="background-image: url(<?= $g->imagem ?>)">
            </figure>
        </article>
		<?php
		endforeach;
		endif;
		?>
	</div>				
</section>