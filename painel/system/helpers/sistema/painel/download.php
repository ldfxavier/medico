<form class="form_geral bloco_pagina_geral bloco_download" action="<?= PAINEL ?>/download-gerar" method="post" target="_blank">
	<header class="geral">
		<h1>DOWNLOAD</h1>
		<i class="fechar"></i>
	</header>
	<div class="corpo">
		<div class="texto">Escolha um ou mais campos para gerar se arquivo</div>
		<input type="hidden" name="app" value="<?= $painel_app ?>">
		<fieldset class="bloco_checkbox_todos">
			<div class="checkbox">
				<?= Form::checkbox('', 2, 'Marcar/Desmarcar todos', false, array('data-name' => 'todos')) ?>
			</div>
			<div class="checkbox">
				<?php
					if($painel_coluna):
						foreach($painel_coluna as $r):
							if(!empty($r->titulo)):
								echo Form::checkbox('coluna[]', $r->campo.'|'.$r->titulo, $r->titulo, false, array('data-nome' => $r->campo));
							endif;
						endforeach;
					endif;
				?>
			</div>
		</fieldset>
	</div>
	<footer class="geral_botao">
		<button class="botao" id="but_download_geral">DOWNLOAD</button>
	</footer>
</form>
