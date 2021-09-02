
<?php
	$logo = isset($_SESSION['CLUBE']) && isset($_SESSION['CLUBE']->imagem->logo) ? $_SESSION['CLUBE']->imagem->logo : '';
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?= $titulo ?></title>

</head>
<body>

<div id="pagina_status">
	<?php if(!empty($logo)): ?>
	<figure><a href="<?= LINK ?>"><img src="<?= $logo ?>" alt="[]"></a></figure>
	<?php endif; ?>

	<i>!</i>
	<header>
		<h1 class="titulo"><?= $codigo ?></h1>
		<p class="texto"><?= !empty($texto) ? $texto.'<br>' : '' ?> Para continuar a navegar, clique no botão abaixo:</p>
	</header>

	<a href="<?= LINK ?>">RETORNAR</a>
</div>

<link href="https://fonts.googleapis.com/css?family=Sarala:400,700" rel="stylesheet">
<style media="screen">
*{box-sizing:border-box}a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,button,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,input,ins,kbd,label,legend,li,main,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,select,small,span,strike,strong,sub,summary,sup,table,tbody,td,textarea,tfoot,th,thead,time,tr,tt,u,ul,var,video{margin:0;padding:0;border:0;font-weight:400;font-size:1em;vertical-align:baseline;box-sizing:border-box;word-wrap:break-word;text-shadow:none}button,input,select,textarea{cursor:pointer;font-size:100%;font-family:inherit;resize:none;border-radius:0;background:0 0;-webkit-appearance:none;-moz-appearance:none;appearance:none}button:focus,input:focus,select:focus,textarea:focus{outline:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section{display:block}body{line-height:1;font-size:62.5%;overflow-x:hidden;-webkit-font-smoothing:antialiased;-moz-font-smoothing:antialiased;font-smoothing:antialiased}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:'';content:none}a,a:active,a:hover,a:link,a:visited{outline:0;text-decoration:none}table{border-collapse:collapse;border-spacing:0}i{font-style:normal}input[type=number]{-moz-appearance:textfield}input::-webkit-inner-spin-button,input::-webkit-outer-spin-button{-webkit-appearance:none}


body {
	font-family: 'Sarala', sans-serif;
	font-size: 62.5%;
}

#pagina_status {
	width: 100%;
	padding: 0 20px;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

figure {
	margin: 40px 0;
}
figure img {
	max-width: 100%;
	max-height: 80px;
}
i {
	width: 80px;
	height: 80px;
	line-height: 80px;
	border: 1px solid #CCC;
	text-align: center;
	font-size: 5.0em;
	font-weight: bold;
	color: #AAA;
	border-radius: 50%;
}
header {
	width: 100%;
	max-width: 400px;
	text-align: center;
	margin: 40px 0 20px 0;
}
h1 {
	font-size: 3.5em;
	font-weight: bold;
	color: #FF6C60;
}
p {
	font-size: 1.6em;
	line-height: 1.5em;
	color: #666;
	margin-top: 10px;
}
#pagina_status > a {
	height: 40px;
	line-height: 40px;
	color: #FFF;
	background-color: #18718B;
	padding: 0 20px;
	border-radius: 3px;
	font-size: 1.2em;
}
</style>

</body>
</html>
