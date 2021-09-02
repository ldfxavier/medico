<?php
    /**
     * PADRÕES DO HEADER
     */
    $header_titulo = (isset($_h_titulo) && !empty($_h_titulo)) ? $_h_titulo.' - '.TITULO : TITULO;
    $header_url = (isset($_h_url) && !empty($_h_url)) ? $_h_url : URL;
    $header_descricao = (isset($_h_descricao) && !empty($_h_descricao)) ? $_h_descricao : DESCRICAO;
    $header_imagem = (isset($_h_imagem) && !empty($_h_imagem)) ? $_h_imagem : IMAGEMSOCIAL;
    $header_robots = (isset($_h_robots) && !empty($_h_robots)) ? $_h_robots : ROBOTS;
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="{{CHARSET}}" />

    <?php if(!empty($header_robots)): ?><meta name="robots" content="{{$header_robots}}"><?php endif; ?>

    <?php if(VIEWPORT == true): ?><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"><?php endif; ?>

    <?php if(!empty($header_descricao)): ?><meta name="description" content="{{$header_descricao}}" /><?php endif; ?>

    <?php if(!empty(KEYWORDS)): ?><meta name="keywords" content="{{KEYWORDS}}"><?php endif; ?>

	<meta name="twitter:card" value="summary">
	<meta name="twitter:site" content="{{$header_url}}">
	<meta name="twitter:title" content="{{$header_titulo}}">
	<meta name="twitter:description" content="{{$header_descricao}}">
	<meta name="twitter:creator" content="{{$header_titulo}}">
	<meta name="twitter:image" content="{{$header_imagem}}">

	<meta property="og:title" content="{{$header_titulo}}" />
	<meta property="og:url" content="{{$header_url}}" />
	<meta property="og:image" content="{{$header_imagem}}" />
	<meta property="og:description" content="{{$header_descricao}}" />

    <?php if(!empty(FAVICON)): ?><link rel="icon" href="{{FAVICON}}" type="image/png"><?php endif; ?>

	<title>{{$header_titulo}}</title>

    <?php if(!empty(GOOGLEANALYTICS)): ?><script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '<?= GOOGLEANALYTICS ?>', 'auto');
        ga('send', 'pageview');
    </script><?php endif; ?>

</head>
<body>

[[VIEW]]

<form action="/" method="post">
	<input type="hidden" name="LINK" id="LINK" value="{{LINK}}">
	<input type="hidden" name="PAINEL" id="PAINEL" value="{{PAINEL}}">
	<input type="hidden" name="ARQUIVO" id="ARQUIVO" value="{{ARQUIVO}}">
    <input type="hidden" name="MOBILE" id="MOBILE" value="{{Sistema::is_mobile()}}">
</form>

<link rel="stylesheet" href="{{LINK}}/css/site.css{{CACHE}}"/>

<script src="https://apis.google.com/js/api:client.js"></script>
<script src="{{LINK}}/js/editor/tinymce.min.js{{CACHE}}" type="text/javascript"></script>
<script src="{{LINK}}/js/site.js{{CACHE}}" type="text/javascript"></script>

</body>
</html>
