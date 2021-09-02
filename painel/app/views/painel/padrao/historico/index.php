<?php
	$div_bloco = isset($bloco_historico) ? $bloco_historico : 'div_'.md5(uniqid(time()));
	$historico_lista_app = isset($historico_lista_app) ? $historico_lista_app : $_app;
	$historico_lista_cod = isset($historico_lista_cod) ? $historico_lista_cod : $cod;

	$historico_add_app = isset($historico_add_app) ? $historico_add_app : $_app;
	$historico_add_cod = isset($historico_add_cod) ? $historico_add_cod : $cod;

	$historico_booleano = isset($historico_booleano) ? $historico_booleano : '';
?>
<article class="bloco_historico">
	<header>
		<h1>HISTÓRICO</h1>
		<i class="add but_add_historico" data-app="<?= $historico_add_app ?>" data-booleano="<?= $historico_booleano ?>" data-bloco="<?= $div_bloco ?>" data-cod="<?= $historico_add_cod ?>" data-font="&#xe809;" data-ajuda="Adicionar novo comentário"></i>
		<i class="abrir but_visualizar_historico" data-font="&#xf105;" data-app="<?= $historico_lista_app ?>" data-cod="<?= $historico_lista_cod ?>" data-ajuda="Abrir histórico completo"></i>
	</header>
	<ul id="<?= $div_bloco ?>">
		<?php
			$Historico = new HistoricoModel;
			$historico = $Historico->lista($historico_lista_app, $historico_lista_cod);
			if(isset($historico->lista) && $historico->lista):
				foreach($historico->lista as $historico_r):
		?>
		<li class="lista">
			<i class="<?php echo $historico_r->class ?>" data-font="&#xe801;"></i>
			<div class="dados_lista">
				<span class="nome"><?php echo $historico_r->nome ?></span>
				<span class="data"><?php echo $historico_r->data ?></span>
				<p><?php echo $historico_r->texto ?></p>
			</div>
		</li>
		<?php
				endforeach;
			else:
		?>
		<li class="zero">SEM HISTÓRICO</li>
		<?php
			endif;
		?>
	</ul>
</article>
