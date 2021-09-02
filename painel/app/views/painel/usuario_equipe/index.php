<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

	// Título
	$_titulo = 'EQUIPE';

	// Botões
	$add = true;
	$relatorio = true;
	$download = true;
	$deletar = true;
	$selecao = true;

	$Model = new EquipeModel;
	$lista = $Model->lista(1);
?>

<link rel="stylesheet" href="{{LINK}}/app/views/painel/{{$_app}}/scripts/layout.css"/>

<div id="bloco_app_{{$_app}}" class="app_geral_imagem">
    <header class="header_principal header_principal_animacao header_principal_absolute">
        <h1>{{$_titulo}}</h1>
    </header>
	<div class="header_principal_false"></div>

	<div class="bloco_controlador">
        <div class="botao visualizar"><i data-font="&#xf105;"></i></div>

		<?php if($add && ($desenvolvedor || in_array(Permissao::nome($_app).'_add', $permissao))): ?>
        <a class="botao add" href="{{PAINEL}}/add/{{$_app}}"><i data-font="&#xe809;"></i><span>ADD</span></a>
		<?php endif; ?>

		<?php if($download && ($desenvolvedor || in_array(Permissao::nome($_app).'_download', $permissao))): ?>
        <div class="botao download but_download_geral but_bloco_ajax" data-width="600" data-href="{{PAINEL}}/download/{{$_app}}"><i data-font="&#xf0ed;"></i><span>DOWNLOAD</span></div>
		<?php endif; ?>

		<?php if($deletar && ($desenvolvedor || in_array(Permissao::nome($_app).'_deletar', $permissao))): ?>
		<div class="botao deletar but_deletar_lista bloco_selecionado hide"><i data-font="&#xe808;"></i><span>DELETAR</span></div>
		<?php endif; ?>
    </div>

	<ul class="lista_dados" id="bloco_lista_geral" data-app="{{$_app}}">
		<?php
			if($lista):
				foreach($lista as $r):
		?>
		<li class="bloco li <?php echo ($selecao == true) ? 'but_visualizar_geral' : '' ?>" data-id="<?php echo $r->id ?>">
			<figure style="background-image: url(<?php echo $r->imagem ?>300)"></figure>
			<a href="{{PAINEL}}/visualizar/{{$_app}}/<?php echo $r->cod ?>"></a>
			<span><?php echo Converter::caixa($r->nome->valor, 'A') ?></span>
		</li>
		<?php
				endforeach;
			else:
		?>
		<div class="zero">
			<i data-font="&#xe801;"></i>
			<span>SEM DADOS NO MOMENTO</span>
		</div>
		<?php
			endif;
		?>
	</ul>
</div>
