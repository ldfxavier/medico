<?php
	$Historico = new HistoricoModel;
	$quantidade = 50;

	$historico = $Historico->lista($_app, $_cod, $_pagina, $quantidade);
	if(isset($historico->lista) && $historico->lista):
		if($_pagina == 1):
			echo '<span class="pagina" data-pagina="'.$historico->pagina.'"></span>';
		endif;
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
