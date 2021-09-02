<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

	$zero = true;
	$busca = $_busca;

	if(empty($busca)):
?>
<div class="zero busca">
	<i data-font="&#xe805;"></i>
	<p>FAÇA SUA BUSCA</p>
</div>
<?php
		exit();
	endif;
?>

<?php
	if($desenvolvedor || in_array('per_usuario_equipe_visualizar', $permissao)):
		$Model = new PainelModel;
		$lista = $Model->p_read('usuario_equipe', "(`nome` LIKE '%{$busca}%' OR `login` LIKE '%{$busca}%' OR `documento` LIKE '%{$busca}%') AND `desenvolvedor` != '1'", "`nome` ASC", "0,24");

		if($lista):
			$zero = false;
?>
<p class="titulo">EQUIPE</p>
<ul>
	<?php foreach($lista as $r): ?>
	<li class="geral imagem">
		<a href="{{PAINEL}}/visualizar/usuario_equipe/<?php echo $r->cod ?>">
			<figure style="background-image: url(<?php echo $r->imagem ?>)"></figure>
			<span><?php echo $r->nome->valor ?></span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php
		endif;
	endif;
?>

<?php
	if($desenvolvedor || in_array('per_usuario_usuario_visualizar', $permissao)):
		$Model = new PainelModel;
		$lista = $Model->p_read('usuario_usuario', "`nome` LIKE '%{$busca}%'", "`nome` ASC", "0,24");

		if($lista):
			$zero = false;
?>
<p class="titulo">USUÁRIOS</p>
<ul>
	<?php foreach($lista as $r): ?>
	<li class="geral imagem">
		<a href="{{PAINEL}}/visualizar/usuario_usuario/<?php echo $r->cod ?>">
			<figure style="background-image: url(<?php echo $r->imagem ?>)"></figure>
			<span><?php echo $r->nome->valor ?></span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php
		endif;
	endif;
?>

<?php
	if($desenvolvedor || in_array('per_convenio_parceiro_visualizar', $permissao)):
		$Model = new PainelModel;
		$lista = $Model->p_read('convenio_parceiro', "`nome` LIKE '%{$busca}%' OR `titulo` LIKE '%{$busca}%' OR `razao_social` LIKE '%{$busca}%'", "`titulo` ASC", "0,24");

		if($lista):
			$zero = false;
?>
<p class="titulo">PARCEIROS</p>
<ul>
	<?php foreach($lista as $r): ?>
	<li class="geral imagem">
		<a href="{{PAINEL}}/visualizar/convenio_parceiro/<?php echo $r->cod ?>">
			<figure style="background-image: url(<?php echo $r->imagem->clube->link ?>)"></figure>
			<span>
			<?php
				if(!empty($r->titulo)) echo $r->titulo;
				elseif(!empty($r->nome)) echo $r->nome;
				elseif(!empty($r->razao_social)) echo $r->razao_social;
			?>
			</span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php
		endif;
	endif;
?>













<?php if($zero): ?>
<div class="zero nenhum">
	<i data-font="&#xe814;"></i>
	<p>NENHUM RESULTADO ENCONTRADO PELA SUA BUSCA</p>
</div>
<?php endif; ?>
