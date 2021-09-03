<div class="bloco_ajax_form bloco_ajax_geral">
	<header class="padrao">
		<h1>DOWNLOAD</h1>
		<i class="fechar"></i>
	</header>
	<div class="conteudo">
		<form class="form_geral" action="{{PAINEL}}/post-download" method="post">
			<div class="corpo">
				<div class="texto mb10">Escolha um ou mais campos para gerar se arquivo</div>
				<input type="hidden" name="app" value="{{$_app}}">
				<fieldset class="bloco_checkbox_todos">
					{{Form::checkbox('', 2, 'Marcar/Desmarcar todos', false, array('data-name' => 'todos'))}}
					<?php
						if($_coluna):
							foreach($_coluna as $r):
								if(!empty($r->titulo)):
									echo Form::checkbox('coluna', $r->titulo, $r->titulo, false, array('data-nome' => $r->campo));
								endif;
							endforeach;
						endif;
					?>
				</fieldset>
			</div>
			<footer class="mt10">
				<button id="but_download_geral">DOWNLOAD<i data-font="&#xf0ed;"></i></button>
			</footer>
		</form>
	</div>
</div>
