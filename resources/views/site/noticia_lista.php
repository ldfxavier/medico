
<div id="bloco_noticia_lista" class="bloco_lista_artigo">
    <header class="header_pagina">
        <h1>NOTÍCIA</h1>
    </header>

	<div class="centro">
		<div class="lista">
            <?php 
                $i = 1;
                while ($i <= 6) {
            ?>
			<article>
				<figure>
					<div class="bg" style="background-image: url(<?= LINK_PADRAO ?>/images/imagem.jpg)">
					</div>
					<a href="<?=LINK . Route::link('noticia.detalhe').'teste';?>"></a>
					<span></span>
				</figure>
				<header>
					<h1><a href="<?=LINK . Route::link('noticia.detalhe').'teste';?>">Lorem Ipsum</a>
					</h1>
					<p class="tres_linhas">
						<a href="<?=LINK . Route::link('noticia.detalhe').'teste';?>">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae placeat assumenda non quos eum perferendis dolorum et. Ad eveniet illum sed debitis vel corporis harum ipsum similique! Illo, quam dolore!</a>
					</p>
				</header>
			</article>
            <?php 
                    $i++;
                }
            ?>
		</div>


	</div>
</div>