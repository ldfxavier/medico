<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;
	// Botões
	$add = $painel_permissao['add'];
	$add_ajax = isset($painel_permissao['add_ajax']) ? $painel_permissao['add_ajax'] : false;
	$visualizar_ajax = isset($painel_permissao['visualizar_ajax']) ? $painel_permissao['visualizar_ajax'] : false;
	$relatorio = $painel_permissao['relatorio'];
	$download = $painel_permissao['download'];
	$historico = $painel_permissao['historico'];
	$deletar = $painel_permissao['deletar'];
	$selecao = $painel_permissao['selecao'];

	$Model = new PainelModel;

    // Manipulando as páginas
    $quantidade = $Model->p_contar($painel_app, $painel_where);
	$painel_pagina_total = ceil($quantidade/$painel_registro);

	$painel_pagina_anterior = $painel_pagina-1;
	$painel_pagina_proxima = $painel_pagina+1;

    // Busca os registros
	$limit = (($painel_pagina-1)*$painel_registro).', '.$painel_registro;
	$lista = $Model->p_read($painel_app, $painel_where, $painel_order, $limit);

	$inicial = (($painel_pagina-1)*$painel_registro)+1;
	$final = (($inicial-1)+$painel_registro > $quantidade) ? $quantidade : ($inicial-1)+$painel_registro;

	$_SESSION['WHERE_'.$painel_app] = $painel_where;
	$_SESSION['ORDER_'.$painel_app] = $painel_order;
?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/layout.css')): ?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/layout.css"/>
<?php endif; ?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/all.js')): ?>
<script src="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/all.js" type="text/javascript"></script>
<?php endif; ?>

<div id="bloco_<?= $painel_app ?>" class="app_geral_lista">
    <header class="header_principal header_principal_animacao header_principal_absolute">
        <h1><?= $painel_titulo ?></h1>

		<?php if($painel_pagina_total > 1): ?>
		<div class="controlador">
			<p><span><?= $inicial ?>-<?= $final ?></span> de <span><?= $quantidade ?></span></p>
			<?php if($painel_pagina == 1): ?>
			<div class="botao" data-font="&#xf104;"></div>
			<?php else: ?>
			<a class="botao" href="<?= PAINEL ?>/app/<?= $painel_app ?>/par/pagina/<?= $painel_pagina_anterior ?>" data-font="&#xf104;" data-ajuda="Anteriores"></a>
			<?php endif; ?>

			<?php if($final == $quantidade): ?>
			<div class="botao" data-font="&#xf105;"></div>
			<?php else: ?>
			<a class="botao" href="<?= PAINEL ?>/app/<?= $painel_app ?>/par/pagina/<?= $painel_pagina_proxima ?>" data-font="&#xf105;" data-ajuda="Próximos"></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

        <?php if($painel_permissao['imprimir']): ?>
		<i data-font="&#xe816;" class="icones print but_print" data-ajuda="IMPRIMIR DADOS"></i>
        <?php endif; ?>
        <?php if($painel_permissao['busca']): ?>
		<i data-font="&#xe805;" class="icones but_bloco_ajax" data-width="600" data-href="<?= PAINEL ?>/busca/<?= $painel_app ?>" data-ajuda="FILTRAR DADOS"></i>
        <?php endif; ?>
		<?php if(!empty($painel_busca)): ?>
        <i data-font="&#xe813;" class="icones but_remove_filtro" data-ajuda="REMOVER FILTRO"><a href="<?= PAINEL ?>/post-busca-remover/<?= $painel_app ?>"></a></i>
		<?php endif; ?>
    </header>
	<div class="header_principal_false"></div>

	<div class="bloco_controlador">
        <div class="botao visualizar"><i data-font="&#xf105;"></i></div>

		<?php
			if($add && ($desenvolvedor || in_array(Permissao::nome($painel_app).'_add', $permissao))):
				if($add_ajax):
		?>
        <div class="botao add but_bloco_ajax" data-href="<?= PAINEL ?>/add/<?= $painel_app ?>"><i data-font="&#xe809;"></i><span>ADD</span></div>
		<?php
				else:
		?>
		<a class="botao add" href="<?= PAINEL ?>/add/<?= $painel_app ?>"><i data-font="&#xe809;"></i><span>ADD</span></a>
		<?php
				endif;
			endif;
		?>

		<?php if($relatorio && $quantidade > 0 && ($desenvolvedor || in_array(Permissao::nome($painel_app).'_relatorio', $permissao))): ?>
        <a class="botao relatorio" href="<?= PAINEL ?>/relatorio/<?= $painel_app ?>"><i data-font="&#xe80a;"></i><span>RELATÓRIO</span></a>
		<?php endif; ?>

		<?php if($download && $quantidade > 0 && ($desenvolvedor || in_array(Permissao::nome($painel_app).'_download', $permissao))): ?>
        <div class="botao download but_download_geral but_bloco_ajax" data-href="<?= PAINEL ?>/download/<?= $painel_app ?>"><i data-font="&#xf0ed;"></i><span>DOWNLOAD</span></div>
		<?php endif; ?>

		<?php if($historico && ($desenvolvedor || in_array(Permissao::nome($painel_app).'_historico', $permissao))): ?>
        <div class="botao download but_download_geral but_bloco_ajax" data-href="<?= PAINEL ?>/download_historico/<?= $painel_app ?>"><i data-font="&#xf0ed;"></i><span>HISTÓRICO</span></div>
		<?php endif; ?>

		<?php if($deletar && ($desenvolvedor || in_array(Permissao::nome($painel_app).'_deletar', $permissao))): ?>
		<div class="botao deletar but_deletar_lista bloco_selecionado hide"><i data-font="&#xe808;"></i><span>DELETAR</span></div>
		<?php endif; ?>
    </div>
	<div class="lista_dados">
		<ul class="ul_lista lista_geral topo">
            <li>
                <?php
    				if($painel_lista):
						$conteudo = $lista ? true : false;
    					foreach($painel_lista as $r):
                            $class = isset($r['class']) ? $r['class'] : '';
							if(isset($r['tipo']) && in_array($r['tipo'], ['status', 'cor'])):
								$class .= ' status';
							endif;
                            $ordem_td = (isset($r['ordem']) && $painel_order == '`'.$r['ordem'].'` ASC') ? 'DESC' : 'ASC';
                            $icone = ($ordem_td == 'ASC') ? '&#xe810;' : '&#xf106;';
                ?>
                <?php if(isset($r['ordem']) && $conteudo): ?>
                <div class="td <?= $class ?>"><a href="<?= PAINEL ?>/app/<?= $painel_app ?>/par/ordem/`<?= $r['ordem'] ?>`+<?= $ordem_td ?>"><p><?= $r['titulo'] ?></p><span data-font="<?= $icone ?>"></span></a></div>
				<?php else: ?>
				<div class="td <?= $class ?>"><p><?= $r['titulo'] ?></p></div>
				<?php endif; ?>
                <?php
                        endforeach;
                    endif;
                ?>
            </li>
		</ul>

		<ul class="ul_lista lista_geral lista" id="bloco_lista_geral" data-app="<?php echo $painel_app ?>">
			<?php
				$app_link = 'editar';
				if(file_exists('app/views/painel/'.$painel_app.'/visualizar.php')) $app_link = 'visualizar';
				if($lista):
					foreach($lista as $r):
            ?>
            <li class="li <?= ($painel_permissao['selecao']) ? 'but_visualizar_geral' : '' ?>" data-id="<?= $r->id ?>">
				<?php if($visualizar_ajax): ?>
				<div class="link but_bloco_ajax" data-href="<?= PAINEL ?>/<?= $app_link ?>/<?= $painel_app ?>/<?= $r->cod ?>">
				<?php else: ?>
				<a href="<?= PAINEL ?>/<?= $app_link ?>/<?= $painel_app ?>/<?= $r->cod ?>">
				<?php endif; ?>
            <?php
                        foreach($painel_lista as $menu):
                            $valor_final = '';
        	                foreach($menu['campo'] as $r_lista):
                                $campo = explode('->', $r_lista);
                                $valor = '';
                                foreach($campo as $r_campo):
                                    $valor = empty($valor) ? $r->$r_campo : $valor->$r_campo;
                                endforeach;
                                if(!empty($valor)):
                                    $valor_final = $valor;
                                    break;
                                endif;
                            endforeach;
            ?>

                    <?php if(!isset($menu['tipo'])): ?>
                    <div class="td"><?= !empty($valor_final) ? Converter::caixa($valor_final, 'A') : 'SEM REGISTRO' ?></div>
                    <?php elseif($menu['tipo'] == 'status'): ?>
                    <div class="td status"><span style="background-color: <?= isset($valor_final->cor) ? $valor_final->cor : '#CCC' ?>" data-ajuda="<?= isset($valor_final->texto) ? Converter::caixa($valor_final->texto, 'A') : 'SEM REGISTRO' ?>"></span></div>
					<?php elseif($menu['tipo'] == 'cor'): ?>
					<div class="td status"><span style="background-color: <?= $valor_final ?>"></span></div>
					<?php endif; ?>

            <?php
                        endforeach;
            ?>
				<?php if($visualizar_ajax): ?>
				</div>
				<?php else: ?>
				</a>
				<?php endif; ?>
            </li>
            <?php
					endforeach;
				else:
			?>
			<li class="zero"><i data-font="&#xe801;"></i><span>SEM DADOS NO MOMENTO</span></li>
			<?php
				endif;
			?>
		</ul>

	</div>
</div>
