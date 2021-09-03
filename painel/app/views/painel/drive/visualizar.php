<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;
	$pre_visualizacao = isset($_pre_visualizacao) ? true : false;

	$r = $_dado;
	$cod = $r->cod;
?>
<div id="bloco_visualizar_{{$_app}}" class="app_geral_visualizar">
    <header class="header_principal volta header_principal_animacao header_principal_absolute">
		<a class="voltar" href="{{PAINEL}}/app/{{$_app}}"></a>
        <h1>VISUALIZAR</h1>
		<?php if($desenvolvedor || in_array(Permissao::nome($_app).'_editar', $permissao)): ?>
		<a class="editar" href="{{PAINEL}}/editar/{{$_app}}/{{$r->cod}}" data-ajuda="Editar dados"></a>
		<?php endif; ?>
    </header>
	<div class="header_principal_false"></div>

	<div class="center">
		<div class="dados_esquerda">
			<figure class="perfil" style="background-image:url({{$r->imagem}}400)"></figure>
		</div>

		<div class="dados_direita">
			<article class="bloco">
				<header><h1>DADOS PESSOAIS</h1></header>
				<p><span class="bold">Nome:</span> <?php echo P::filtro($r->nome->valor, 'Sem nome') ?></p>
				<p><span class="bold">CPF:</span> <?php echo P::filtro($r->documento->br, 'Sem documento') ?></p>
				<p><span class="bold">Sexo:</span> <?php echo P::filtro($r->sexo->texto, 'Sem Dado') ?></p>
				<p><span class="bold">Nascimento:</span> <?php echo P::filtro($r->aniversario->br, 'Sem aniversário') ?></p>
				<p><span class="bold">Área:</span> <?php echo P::filtro($r->area->texto, 'Sem dado') ?></p>
			</article>

			<article class="bloco">
				<header><h1>ACESSO</h1></header>
				<p><span class="bold">Login:</span> <?php echo $r->login ?> <?php echo (!empty($r->login) && !empty($r->documento->br)) ? 'ou' : '' ?> <?php echo $r->documento->br ?></p>
				<p class="status_icone"><span class="bold">Senha:</span> <span class="status_<?php echo $r->senha ?>"></span></p>
				<p><span class="bold">Desde:</span> <?php echo P::filtro($r->data->criacao, 'Sem data') ?></p>
				<p><span class="bold">Data da atualização:</span> <?php echo P::filtro($r->data->atualizacao, 'Sem data') ?></p>
				<p><span class="bold">Último acesso:</span> <?php echo P::filtro($r->data->acesso, 'Sem data') ?></p>
			</article>

			<article class="bloco">
				<header><h1>CONTATO</h1></header>
				<?php
					if($r->contato):
						foreach($r->contato as $contato_r):
				?>
				<p><span class="bold"><?php echo $contato_r->nome->texto ?>:</span> <?php echo $contato_r->valor ?></p>
				<?php
						endforeach;
					else:
				?>
				<p>SEM DADOS DE CONTATO</p>
				<?php
					endif;
				?>
			</article>

			<article class="endereco">
				<header><h1>ENDEREÇO</h1></header>
				<?php
					if($r->endereco):
						foreach($r->endereco as $endereco_r):
				?>
				<p>
					<span class="bold"><?php echo $endereco_r->nome ?>:</span> <?php echo $endereco_r->completo ?>
					<a href="https://www.google.com.br/maps/dir//<?php echo $endereco_r->mapa->latitude ?>, <?php echo $endereco_r->mapa->longitude ?>" target="_blank" data-ajuda="Abrir no mapa"><i data-font="&#xe81a;"></i></a>
				</p>
				<?php
						endforeach;
					else:
				?>
				<p class="zero">SEM ENDEREÇO CADASTRADO</p>
				<?php
					endif;
				?>
			</article>

			<article class="bloco">
				<header><h1>STATUS</h1></header>
				<p class="status_icone"><span class="bold">Gerente:</span> <span class="status_<?php echo $r->gerente ?>"></span></p>
				<p class="status_icone"><span class="bold">Administrador:</span> <span class="status_<?php echo $r->admin ?>"></span></p>
				<p class="status_texto"><span class="bold">Status:</span> <span><?php echo $r->status->texto ?></span></p>
			</article>

		</div>

		<?php include('app/views/painel/padrao/historico/index.php') ?>
	</div>

</div>
