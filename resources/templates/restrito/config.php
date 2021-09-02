<?php



$header_titulo = (isset($header['titulo']) && !empty($header['titulo'])) ? $header['titulo'].' - '.TITULO : TITULO;
$header_descricao = (isset($header['descricao']) && !empty($header['descricao'])) ? $$header['descricao'] : DESCRICAO;
$header_url = (isset($header['url']) && !empty($header['url'])) ? $header['url'] : LINK.URL;
$header_imagem = (isset($header['imagem']) && !empty($header['imagem'])) ? $header['imagem'] : '';  

$header_robots = 'index,follow';

$css_pagina = Route::css(__ROUTE_CONTROLLER, __ROUTE_ACTION);
$js_pagina = Route::js(__ROUTE_CONTROLLER, __ROUTE_ACTION);

