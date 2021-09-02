<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="Dr André Neri" />
    <meta name="robots" content="<?=$header_robots;?>">
    <meta name="description" content="Site Dr André Neri" />

    <meta name="twitter:card" value="summary">
    <meta name="twitter:site" content="<?=$header_url;?>">
    <meta name="twitter:title" content="<?=$header_titulo;?>">
    <meta name="twitter:description" content="Site Dr André Neri">
    <meta name="twitter:creator" content="<?=$header_titulo;?>">
    <meta name="twitter:image" content="<?=$header_imagem;?>">

    <meta property="og:title" content="<?=$header_titulo;?>" />
    <meta property="og:url" content="<?=$header_url;?>" />
    <meta property="og:image" content="<?=$header_imagem;?>" />
    <meta property="og:description" content="Site Dr André Neri" />

    <?php if (!empty($header_favicon)): ?>
    <link rel="icon" href="<?=$header_favicon;?>" type="image/png">
    <?php endif;?>
    <link rel="stylesheet" href="<?=LINK_PADRAO;?>/css/site.css?cache=<?=CACHE;?>"/>
    <?=$css_pagina;?>
    <title> Dr André Neri </title>
</head>
<body>
    <div id="site">
        <header class="header">
            <div class="centro">
                <a href="<?= LINK_PADRAO ?>" class="logo"><img src="<?= LINK_PADRAO ?>/images/logo.png" alt=""></a>
				<nav class="menu">
					<div class="topo">
						<ul>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/email.png"" alt="">
								<p>
									<span class="color_cor azul">E-mail</span>
									<span class="opaco">cirurgiasoto@gmail.com</span>
								</p>
							</li>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/whatsapp.png"" alt="">
								<p>
									<span class="color_cor azul">Whatsapp</span>
									<span class="opaco">+55 61 99840 4040</span>
								</p>
							</li>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/youtube.png"" alt="">
							</li>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/facebook.png"" alt="">
							</li>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/instagram.png"" alt="">
							</li>
							<li>
								<img src="<?= LINK_PADRAO ?>/images/twitter.png"" alt="">
							</li>
						</ul>
					</div>
					<div class="bottom">
						<ul>
							<li class="active">Home</li>
							<li> <a href="#sobre">Dr André Neri</a> </li>
							<li> <a href="#especialidade">Especialidades</a> </li>
							<li> <a href="#agenda">Agendamentos</a> </li>
							<li> <a href="#localizacao">Localização</a> </li>
						</ul>
					</div>

				</nav>
            </div>
        </header>

        <main id="conteudo_principal">

            <div class="centraliza--conteudo_principal">

