<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

	// Título
	$_titulo = 'DADOS DO SITE';

	// Botões
	$add = true;
	$relatorio = false;
	$download = false;
	$deletar = false;
	$selecao = false;

	// READ
	$registro = 50;

	$order = $_order;
	$where = $_where;

	$Model = new PainelModel;

	$quantidade = $Model->p_contar($_app, $where);

	$pagina_total = ceil($quantidade/$registro);
	$pagina = $_pagina;

	$pagina_anterior = $pagina-1;
	$pagina_proxima = $pagina+1;

	$limit = (($pagina-1)*$registro).', '.$registro;

	$lista = $Model->p_read($_app, $where, $order, $limit);

	$inicial = (($pagina-1)*$registro)+1;
	$final = (($inicial-1)+$registro > $quantidade) ? $quantidade : ($inicial-1)+$registro;

	$_SESSION['ORDER_'.$_app] = $order;
?>

<link rel="stylesheet" href="{{LINK}}/app/views/painel/{{$_app}}/scripts/layout.css"/>

<div id="bloco_{{$_app}}" class="app_geral_lista">
    <header class="header_principal header_principal_animacao header_principal_absolute">
        <h1>{{$_titulo}}</h1>

		<?php if($pagina_total > 1): ?>
		<div class="controlador">
			<p><span>{{$inicial}}-{{$final}}</span> de <span>{{$quantidade}}</span></p>
			<?php if($pagina == 1): ?>
			<div class="botao" data-font="&#xf104;"></div>
			<?php else: ?>
			<a class="botao" href="{{PAINEL}}/app/{{$_app}}/par/pagina/{{$pagina_anterior}}" data-font="&#xf104;" data-ajuda="Anteriores"></a>
			<?php endif; ?>

			<?php if($final == $quantidade): ?>
			<div class="botao" data-font="&#xf105;"></div>
			<?php else: ?>
			<a class="botao" href="{{PAINEL}}/app/{{$_app}}/par/pagina/{{$pagina_proxima}}" data-font="&#xf105;" data-ajuda="Próximos"></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
    </header>
	<div class="header_principal_false"></div>

	<div class="menu_add_mobile but_menu_add_mobile"><i></i></div>
	<div class="bloco_controlador">
        <div class="botao visualizar"><i data-font="&#xf105;"></i></div>

		<?php if($add && ($desenvolvedor || in_array(Permissao::nome($_app).'_add', $permissao))): ?>
		<a class="botao add" href="{{PAINEL}}/add/{{$_app}}"><i data-font="&#xe809;"></i><span>ADD</span></a>
		<?php endif; ?>

		<?php if($relatorio && $quantidade > 0 && ($desenvolvedor || in_array(Permissao::nome($_app).'_relatorio', $permissao))): ?>
        <a class="botao relatorio" href="{{PAINEL}}/relatorio/{{$_app}}"><i data-font="&#xe80a;"></i><span>RELATÓRIO</span></a>
		<?php endif; ?>

		<?php if($download && $quantidade > 0 && ($desenvolvedor || in_array(Permissao::nome($_app).'_download', $permissao))): ?>
        <div class="botao download but_download_geral but_bloco_ajax" data-width="600" data-href="{{PAINEL}}/download/{{$_app}}"><i data-font="&#xf0ed;"></i><span>DOWNLOAD</span></div>
		<?php endif; ?>
		<?php if($deletar && ($desenvolvedor || in_array(Permissao::nome($_app).'_deletar', $permissao))): ?>
		<div class="botao deletar but_deletar_lista bloco_selecionado hide"><i data-font="&#xe808;"></i><span>DELETAR</span></div>
		<?php endif; ?>
    </div>

	<div class="lista_dados">
		<ul class="ul_lista topo">
			<li>
				<?php
					echo Menu::td(array(
						'id' => '#ID',
						'titulo' => 'TITULO',
						'data_atualizacao' => 'ATUALIZAÇÃO'
					), $_app, $order);
				?>
			</li>
		</ul>

		<ul class="ul_lista lista" id="bloco_lista_geral" data-app="<?php echo $_app ?>">
			<?php
				if($lista):
					foreach($lista as $r):
			?>
			<li class="li <?php echo ($selecao) ? 'but_visualizar_geral' : '' ?>" data-id="<?php echo $r->id ?>">
				<a href="{{PAINEL}}/editar/{{$_app}}/<?php echo $r->cod ?>">
					<div class="td"><?php echo $r->id ?></div>
					<div class="td"><?php echo P::filtro($r->titulo->titulo, 'Sem título') ?></div>
					<div class="td"><?php echo P::filtro($r->data->atualizacao, 'Sem data') ?></div>
				</a>
			</li>
			<?php
					endforeach;
				else:
			?>
			<div class="zero"><i data-font="&#xe801;"></i><span>SEM DADOS NO MOMENTO</span></div>
			<?php
				endif;
			?>
		</ul>
	</div>

	<i id="voltar_topo" class="hide" data-font="&#xf106;"></i>
</div>
