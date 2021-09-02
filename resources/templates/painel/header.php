<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="<?= CHARSET ?>" />

	<meta name="robots" content="noindex,nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="icon" href="<?= LINK_PADRAO ?>/images/painel/favico.png" type="image/png">

	<title>PAINEL ADMINISTRATIVO</title>
</head>
<body style="display:none">

<div id="site">

	<header id="header_principal">

		<?php if(isset($config['header']['voltar']) && !empty($config['header']['voltar'])): ?>
		<i class="voltar" data-font="&#xe808;"><a href="<?= $config['header']['voltar'] ?>" target="_self"></a></i>
		<?php else: ?>
		<div class="voltar_hidden"></div>
		<?php endif; ?>

		<?php if(isset($config['header']['titulo']) && !empty($config['header']['titulo'])): ?>
		<h1>
			<?php
				if(isset($config['header']['subtitulo'])):
					foreach($config['header']['subtitulo'] as $link => $titulo):
			?>
			<span class="subtitulo"><a href="<?= $link ?>" target="_self"><?= $titulo?></a> / </span>
			<?php
					endforeach;
				endif;
			?>
			<span class="titulo"><?= $config['header']['titulo'] ?></span>
		</h1>
		<?php endif; ?>

		<div class="flex_grow"></div>

		<i data-font="&#xf188;" class="botao_bug" data-ajuda-fixed="Reportar bug/alteração<br>ao desenvolvimento"></i>

		<i data-font="&#xe804;" class="botao_notificacao alerta" data-href="<?= LINK_PADRAO ?>/app/popup/notificacao/popup">
			<div class="notificacao">
				<span class="bola"></span>
				<span class="animacao"></span>
			</div>
		</i>

		<figure class="botao_menu_secundario" style="background-image: url(<?= EQUIPE_IMAGEM ?>40)"></figure>
	</header>

	<div id="botao_menu_principal">
		<i data-font="&#xe800;"></i>
		<figure><img src="<?= LINK_PADRAO ?>/images/painel/logo.png" alt="[Logo]" height="15"></figure>
	</div>

	<nav id="menu_principal">
		<ul>

			<?=

				(new \System\Painel([
					'acao' => 'menu',
					'app' => $app
				]))
				->menu([
					'link' => '',
					'app' => 'dashboard',
					'icone' => '&#xf0e4;',
					'titulo' => 'Dashboard',
					'class' => 'dashboard'
				])
				->titulo('Usuários')
				->dropdown([
					[
						'icone' => '&#xe81b;',
						'titulo' => 'Usuários',
					],
					[
						'app' => 'usuario-cliente',
						'permissao' => 'usuario-cliente',
						'titulo' => 'Clientes'
					],
					[
						'app' => 'usuario-prospeccao',
						'permissao' => 'usuario-prospeccao',
						'titulo' => 'Prospecção'
					]
				])
				->titulo('Gestão')
				->menu([
					'app' => 'usuario-equipe',
					'icone' => '&#xf2c1;',
					'titulo' => 'Funcionários'
				])
				->menu([
					'app' => 'geral-agenda',
					'titulo' => 'Agenda',
					'icone' => '&#xe813;'
				])
				->titulo('Clube')
				->dropdown([
					[
						'titulo' => 'Convênio',
						'icone' => '&#xe80a;'
					],
					[
						'app' => 'convenio-captacao',
						'permissao' => 'convenio-captacao',
						'titulo' => 'Captação'
					],
					[
						'app' => 'convenio-analise',
						'permissao' => 'convenio-analise',
						'titulo' => 'Em analise'
					],
					[
						'app' => 'convenio-concluido',
						'permissao' => 'convenio-concluido',
						'titulo' => 'Publicados'
					],
					[
						'app' => 'convenio-cancelado',
						'permissao' => 'convenio-cancelado',
						'titulo' => 'Cancelados'
					]
				])
				->menu([
					'app' => 'clube-construtor',
					'permissao' => 'clube-construtor',
					'titulo' => 'Clube',
					'icone' => '&#xe813;'
				])
				->titulo('Institucional')
				->dropdown([
					[
						'titulo' => 'Páginas',
						'icone' => '&#xe80a;'
					],
					[
						'app' => 'institucional-pagina',
						'permissao' => 'intitucional-pagina-historico',
						'link' => '/editar/institucional-pagina/historico',
						'titulo' => 'Histórico'
					],
					[
						'app' => 'institucional-pagina',
						'permissao' => 'intitucional-pagina-missao-visao-valores',
						'link' => '/editar/institucional-pagina/missao-visao-valores',
						'titulo' => 'Missão, Visão e Valores'
					]
				])
				->menu([
					'app' => 'institucional-diretoria',
					'titulo' => 'Diretoria',
					'icone' => '&#xe81b;'
				])
				->titulo('Publicações')
				->menu([
					'app' => 'publicacao-noticia',
					'titulo' => 'Notícias',
					'icone' => '&#xe81d;'
				])
				->titulo('Atendimento')
				->menu([
					'app' => 'contato-fale-conosco',
					'titulo' => 'Fale conosco',
					'icone' => '&#xe80f;'
				])
				->get();

			?>

		</ul>

	</nav>

	<nav id="menu_secundario">

		<div class="conteudo">

			<div class="header header_linha_botton">
				<i class="mobile" data-font="&#xe808;"></i>
				<h1>CONFIGURAÇÃO</h1>
				<i class="desktop" data-font="&#xe807;"></i>
			</div>

			<figure style="background-image: url(<?= EQUIPE_IMAGEM ?>100)"></figure>
			<p><?= EQUIPE_NOME ?></p>

			<a href="<?= LINK ?>/perfil" target="_self"><i data-font="&#xe80e;"></i> Perfil</a>

			<div class="linha"></div>

			<a href="<?= LINK ?>/perfil/dados" target="_self"><i data-font="&#xe80a;"></i> Meus dados</a>
			<a href="<?= LINK ?>/perfil/senha" target="_self"><i data-font="&#xe80b;"></i> Mudar senha</a>
			<a href="<?= LINK ?>/perfil/configuracoes" target="_self"><i data-font="&#xe811;"></i> Configurações</a>

			<div class="linha"></div>

			<a href="<?= LINK ?>/perfil/facebook" target="_self"><i data-font="&#xf300;"></i> Vincular Facebook</a>
			<a href="<?= LINK ?>/perfil/google" target="_self"><i data-font="&#xf1a0;"></i> Vincular Google</a>

			<div class="linha"></div>

			<a href="#bloquear-tela" target="_self"><i data-font="&#xe80c;"></i> Bloquear tela</a>
			<a href="<?= LINK ?>/login/sair" target="_self"><i data-font="&#xe80d;"></i> Sair do sistema</a>

		</div>

	</nav>

	<main id="conteudo_principal">
