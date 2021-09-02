<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="Markt Club" />
    <meta name="robots" content="<?=$header_robots;?>">
    <meta name="description" content="Site para parceiros Markt Club" />

    <meta name="twitter:card" value="summary">
    <meta name="twitter:site" content="<?=$header_url;?>">
    <meta name="twitter:title" content="<?=$header_titulo;?>">
    <meta name="twitter:description" content="Site para parceiros Markt Club">
    <meta name="twitter:creator" content="<?=$header_titulo;?>">
    <meta name="twitter:image" content="<?=$header_imagem;?>">

    <meta property="og:title" content="<?=$header_titulo;?>" />
    <meta property="og:url" content="<?=$header_url;?>" />
    <meta property="og:image" content="<?=$header_imagem;?>" />
    <meta property="og:description" content="Site para parceiros Markt Club" />

    <?php if (!empty($header_favicon)): ?>
    <link rel="icon" href="<?=$header_favicon;?>" type="image/png">
    <?php endif;?>
    <link rel="stylesheet" href="<?=LINK_PADRAO;?>/css/login.css?cache=<?=CACHE;?>"/>
    <?=$css_pagina;?>
    <title> Parlamentum </title>
</head>
<body>
    <div id="site">
        <header class="header">
            <div class="centro">
                <a href="<?= LINK_PADRAO ?>" class="logo"><img height="50" src="<?= LINK_PADRAO ?>/images/logo.png" alt=""></a>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li><a href="#fazemos">O que fazemos</a></li>
                    <li><a href="#quem_somos">Quem somos</a></li>
                    <li><a href="<?=LINK . Route::link('noticia.index');?>">Notícias</a></li>
                    <li><a href="#prevencao">Prevenção de riscos</a></li>
                    <li><a href="#opotunidade">Oportunidades</a></li>
                    <li><a href="#na_midia">Na mídia</a></li>
                    <li><a href="#dicas">Dicas</a></li>
                    <li class="contratar"><a href="<?=LINK . Route::link('index.cadastro');?>">Contratar</a></li>
                    <li class="restrita"><a href="#restrita">Área restrita</a></li>
                </ul>
            </div>
        </header>

        <main id="conteudo_principal">

            <div class="centraliza--conteudo_principal">

