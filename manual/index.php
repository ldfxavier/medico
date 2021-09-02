<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofolow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>DOCUMENTAÇÃO</title>

	<link rel="stylesheet" href="../css/site.css">
	<script src="../js/site.js" type="text/javascript"></script>
</head>
<body>
<div class="bloco">

<h1>INTRODUÇÃO</h1>
<div class="margin_20"></div>
<p>O objetivo deste documento é informar e indicar a normalização a escrita de scripts, marcações entre outros mostrando exemplos de nomenclaturas, regras de utilização e normas de montagem de classes, métodos, funções, banco de dados e demais dados com o intuito de acabar estruturas de igual teor com normas diferentes.</p>

<hr>

<h1>NORMAS GERAIS</h1>
<div class="margin_20"></div>
<p>Por padrão, adotar as normas a seguir em todo o sistema:</p>
<ul>
	<li>Não é permitido abreviar;</li>
	<li>Não utilizar palavras no plural;</li>
	<li>Usar apenas nome no masculino;</li>
	<li>Não usar número;</li>
	<li>Não usar nome próprio;</li>
	<li>O nome não pode ter várias interpretações;</li>
	<li>Crie nome sucinto e objetivo;</li>
	<li>Não comentar o código;</li>
</ul>

</div>

<div class="bloco">
	<?php include('html.php') ?>
</div>
<div class="bloco">
	<?php include('css.php') ?>
</div>
<div class="bloco">
	<?php include('javascript.php') ?>
</div>
<div class="bloco">
	<?php include('php.php') ?>
</div>
<div class="bloco">
	<?php include('mysql.php') ?>
</div>

<link rel="stylesheet" href="../css/dev/geral/resetar.css">

<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 62.5%;
	background-color: #F9F9F9;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}
nav {
	width: 100%;
	padding-top: 40px;
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
}
nav a {
	height: 40px;
	line-height: 40px;
	padding: 0 20px;
	border: 1px solid blue;
	background-color: #FFF;
	margin: 0 2px;
	font-size: 1.4em;
	border-radius: 3px;
}
hr {
	width: 100%;
	margin: 40px 0;
	opacity: .5;	
}
h1 {
	width: 100%;
	font-size: 2.8em;
	text-align: center;
	font-weight: bold;
}
h2 {
	width: 100%;
	font-size: 1.8em;
	font-weight: bold;
}
h3 {
	width: 100%;
	font-size: 1.6em;
	font-weight: bold;
	padding-top: 15px;
}
h3 {
	margin-top: 0;
}
b,
strong {
	font-weight: bold;
}
p {
	width: 100%;
	line-height: 1.6em;
	margin: 5px 0;
	font-size: 1.5em;
}
ul {
	width: 100%;
	background-color: #FFF;
	list-style: decimal;
	list-style-position: inside;
	padding: 0;
	border: 1px solid #CCC;
	border-top: none;
}
ul li {
	width: 100%;
	line-height: 1.5em;
	padding: 0 10px;
	border-top: 1px solid #CCC;
}
ul li strong {
	color: #F00;
}
ul > li {
	font-size: 1.6em;
}
ul li ul {
	width: calc(100% + 20px);
	margin: 0 0 0 -10px;
	border: none;
}
ul li ul li {
	font-size: 1.0em;
	padding-left: 30px;
}
pre {
	width: 100%;
	border: 1px solid #CCC;
	padding: 10px;
	font-size: 1.6em;
	background: #FFF;
}
.bloco {
	width: 100%;
	max-width: 1000px;
	padding: 20px;
	display: flex;
	flex-direction: column;
}
.bloco_geral {
	display: flex;
}
.exemplo {
	width: 100%;
	font-weight: bold;
	padding: 10px;
	margin-top: 5px;
	border: 2px dotted #CCC;
	background-color: #FFF;
	font-size: 1.6em;
	display: flex;
	flex-direction: column
}
.margin_5 {
	width: 100%;
	margin-top: 5px;
}
.margin_10 {
	width: 100%;
	margin-top: 10px;
}
.margin_20 {
	width: 100%;
	margin-top: 20px;
}
.margin_30 {
	width: 100%;
	margin-top: 30px;
}
.margin_40 {
	width: 100%;
	margin-top: 40px;
}
</style>

</body>
</html>