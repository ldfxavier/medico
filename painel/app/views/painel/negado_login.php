<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LOGIN NESCESSÁRIO</title>
</head>
<body>
	<div id="bloco_negado">
		<i data-font="&#xe814;"></i>
		<h1 class="titulo">FAÇO SEU LOGIN!</h1>
		<p class="texto">SEU LOGIN TERMINOU, RECARREGUE A PÁGINA E REFAÇA O LOGIN.</p>

		<!-- <a href="{{PAINEL}}">VOLTAR AO PAINEL</a> -->
	</div>

<style>
@font-face {
    font-family: 'icone_negado';
    src: url('{{LINK}}/css/fonts/painel/icone.eot?24804979');
    src: url('{{LINK}}/css/fonts/painel/icone.eot?24804979#iefix') format('embedded-opentype'),
         url('{{LINK}}/css/fonts/painel/icone.woff?24804979') format('woff'),
         url('{{LINK}}/css/fonts/painel/icone.ttf?24804979') format('truetype'),
         url('{{LINK}}/css/fonts/painel/icone.svg?24804979#icone') format('svg');
    font-weight: normal;
    font-style: normal;
}
#bloco_negado {
	width: 100%;
	max-width: 480px;
	margin: 0 auto;
	padding: 30px 0;
	background-color: #FFF;
	font-family: Arial, sans-serif;
	border-radius: 4px;
	display: table;
}
#bloco_negado i:after {
	width: 80px;
	height: 80px;
	line-height: 80px;
	float: left;
	font-style: normal;
	font-family: icone_negado;
	content: attr(data-font);
	font-size: 18px;
	color: #AAA;
	margin-bottom: 20px;
	text-align: center;
	margin-left: calc((100% - 80px) / 2);
	border: 1px solid #CCC;
	border-radius: 100%;
}
#bloco_negado h1, #bloco_negado p {
	width: 100%;
	float: left;
	color: #999;
	padding: 0;
	margin: 0;
	font-size: 12px;
	text-align: center;
}
#bloco_negado h1 {
	margin-bottom: 5px;
	font-size: 24px;
}
#bloco_negado .margin {
	margin-bottom: 20px;
}
#bloco_negado a {
	margin: 0 auto;
	padding: 10px 20px;
	color: #999;
	text-decoration: none;
	border: 1px solid #CCC;
	border-radius: 3px;
	display: table;
	clear: both;
}
</style>
</body>
</html>
