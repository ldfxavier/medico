<div class="bloco-popup__botao ">

    <header class="header-popup">	
		<i class="voltar mobile botao_fechar" data-font="&#xe804;"></i>
		<h1 class="h1_voltar"><?= $dado->titulo ?></h1>
		<i class="fechar desktop botao_fechar" data-font="&#xe80e;"></i>
	</header>
    <article class="bloco-popup__conteudo">
		<?php if(!empty($dado->imagem)): ?>
		<div class="container_imagem">
			<img src="<?= $dado->imagem ?>" alt="">
		</div>
		<?php endif; ?>
		<?php if(!empty($dado->video)): ?>
		<div class="container_video">
			<?= $dado->video ?>
		</div>
		<?php endif; ?>

		<?= $dado->texto ?>
    </article>

</div>
