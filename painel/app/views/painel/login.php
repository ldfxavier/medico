
<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta charset="UTF-8">

	<title>LOGIN - PAINEL ADMINISTRATIVO</title>

	<link rel="stylesheet" href="<?= LINK ?>/css/painel.css"/>

	<script src="<?= LINK ?>/js/fw/editor/tinymce.min.js" type="text/javascript"></script>
	<script src="https://apis.google.com/js/api:client.js"></script>
	<script src="<?= LINK ?>/js/painel.js" type="text/javascript"></script>
</head>
<body>
<div class="conteudo">
	<form action="<?= PAINEL ?>/post-login">
		<fieldset>
			<input type="text" class="input_zero" value="">
			<input type="password" class="input_zero" value="">

			<div class="legend border_cor">
				<span class="titulo_sub">ÁREA RESTRITA</span>
				<span class="titulo cor">FAÇA SEU LOGIN</span>
				<span class="texto">Acesse a área restrita digitando seu e-mail e senha nos campos abaixo</span>
			</div>
			<div class="input">
				<label class="login">
					<input type="text" name="login" placeholder="Digite seu login" value="">
					<span class="linha bg_cor"></span>
				</label>
				<label class="password">
					<input type="password" autocomplete="off" name="password" placeholder="Digite sua senha" value="">
					<span class="linha bg_cor"></span>
					<span class="ver inativo"></span>
				</label>
			</div>
			<button class="bg_cor">LOGIN</button>
		</fieldset>
	</form>
</div>

<form action="/" method="post">
	<input type="hidden" name="MOBILE" id="MOBILE" value="<?= Sistema::is_mobile() ?>">
</form>

<script>
$(window).load(function(){
	$('.conteudo').css('display', 'flex');

	$('form label.password .ver').click(function(){
		var label = $(this).closest('label');
		if($(this).hasClass('ativo')){
			$(this).removeClass('ativo');
			$(this).addClass('inativo');
			$('input', label).attr('type', 'password');
		}else {
			$(this).addClass('ativo');
			$(this).removeClass('inativo');
			$('input', label).attr('type', 'text');
		}
	});
	if($(window).width() > 1000){
		$('form').stop()
		.animate({
			marginTop:-40
		}, 0)
		.animate({
			opacity:1,
			marginTop:40
		}, 300, function(){
			$('form label:first input').focus();
		});
	}else {
		$('form').css('opacity', 1);
	}

	$('button').click(function(){
		var botao = $(this);
		var form = $(this).closest('form');
		var link = form.attr('action');

		var login = $('input[name=login]', form).val();
		var password = $('input[name=password]', form).val();

		$.loading('show');
		botao.text('AGUARDE');

		$.post(link, {
            ajax:true,
			login:login,
			password:password
		}, function(resposta){
			if(resposta.erro == false){
				window.location.assign("<?= (isset($_SESSION['PAINEL_REDIRECIONAR']) && $_SESSION['PAINEL_REDIRECIONAR']) ?  $_SESSION['PAINEL_REDIRECIONAR'] : PAINEL ?>");
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				botao.text('LOGIN');
				$.loading('hide');
			}
		}, 'json');

		return false;
	});
});
</script>

<style>
@font-face {
	font-family: 'icone';
	src: url('<?= LINK ?>/css/fonts/painel/icone.eot<?= CACHE ?>');
	src: url('<?= LINK ?>/css/fonts/painel/icone.eot<?= CACHE ?>#iefix') format('embedded-opentype'),
		 url('<?= LINK ?>/css/fonts/painel/icone.woff<?= CACHE ?>') format('woff'),
		 url('<?= LINK ?>/css/fonts/painel/icone.ttf<?= CACHE ?>') format('truetype'),
		 url('<?= LINK ?>/css/fonts/painel/icone.svg<?= CACHE ?>#icone') format('svg');
	font-weight: normal;
	font-style: normal;
}
body {
	background: #333 url(<?= LINK ?>/images/painel/login_bg.jpg) no-repeat center top fixed;
	background-size: cover;
	font-family: Arial;
}
.conteudo {
	width: 100%;
	min-height: 100vh;
	background-color: rgba(0,0,0,.7);
	flex-direction: column;
	align-items: center;
	display: none;
}
form {
	width: calc(100% - 40px);
	max-width: 380px;
	background-color: #FFF;
	margin: 40px 0;
	border-radius: 3px;
	opacity: 0;
	overflow: hidden;
}
form fieldset {
	width: 100%;
	padding: 20px 20px 0 2px;
	flex-direction: column;
	flex-wrap: nowrap;
	display: flex;;
}
form .legend {
	width: 100%;
	color: #333;
	padding: 15px 0 15px 40px;
	border-left: 5px solid;
	display: flex;
	flex-direction: column;
}
form .legend span {
	width: 100%;
}
form .legend span.titulo {
	font-size: 2.4em;
	font-weight: bold;
}
form .legend span.titulo_sub {
	font-size: 1.3em;
	color: #000;
	margin: 2px 0 5px 0;
}
form .legend span.texto {
	line-height: 1.5em;
	font-size: 1.2em;
	color: #333;
}
form input.input_zero {
	width: 1px;
	height: 1px;
	position: absolute;
	top: -99999px;
	left: -99999px;
	opacity: 0;
}
form .input {
	width: 100%;
	display: flex;
	align-items: flex-end;
	flex-direction: column;
	flex-wrap: nowrap;
}
form label {
	width: calc(100% - 45px);
	position: relative;
	margin-top: 20px;
	padding-bottom: 1px;
}
form label:after {
	height: 30px;
	line-height: 30px;
	position: absolute;
	top: 0;
	left: -25px;
	font-size: 1.4em;
	color: #666;
	font-family: icone;
}
form label.login:after {
	content: "\e801";
}
form label.password:after {
	content: "\e80e";
}
form label.password .ver {
	width: 30px;
	height: 30px;
	line-height: 30px;
	position: absolute;
	top: 0;
	right: 0;
	font-family: icone;
	text-align: center;
	overflow: hidden;
	cursor: pointer;
	z-index: 10;
}
form label.password .ver.ativo:after {
	content:"\e806";
}
form label.password .ver.inativo:after {
	content:"\e802";
}
form label input {
	width: 100%;
	height: 30px;
	line-height: 30px;
	font-size: 1.4em;
	border-bottom: 1px solid #CCC;
}
form label.password input {
	padding-right: 30px;
}
form label .but_password_visualizar:before {
	width: 30px;
	height: 30px;
	line-height: 30px;
	position: absolute;
	top: 0;
	right: 0;
	font-size: 1.3em;
	font-family: icone;
	text-align: center;
	cursor: pointer;
}
form label .but_password_visualizar[data-password=ativo]:before {
	content: "\e802";
}
form label .but_password_visualizar[data-password=inativo]:before {
	content: "\e806";
}
form label .linha {
	width: 0;
	height: 2px;
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	margin: auto;
	transition: width .3s ease-out;
	z-index: 2;
}
form label input:focus + .linha {
	width: 100%;
}
form button {
	width: 160px;
	height: 45px;
	position: relative;
	font-size: 1.2em;
	margin-top: 30px;
	margin-left: calc((100% - 140px) / 2);
	color: #FFF;
	cursor: pointer;
	border-radius: 2px;
	margin-bottom: 20px;
}

form .footer {
	width: 100%;
	float: left;
	background-color: #F6F6F6;
	padding: 20px;
	margin-top: 30px;
}
form .footer .social {
	width: calc(50% - 10px);
	height: 40px;
	line-height: 40px;
	position: relative;
	float: left;
	padding-left: 50px;
	color: #FFF;
	cursor: pointer;
	border-radius: 3px;
}
form .footer .social i {
	width: 40px;
	height: 40px;
	line-height: 40px;
	position: absolute;
	top: 0;
	left: 0;
	text-align: center;
	font-family: icone;
	font-size: 1.4em;
	background-color: rgba(0,0,0,.1);
}
form .footer .social i:after {
	content: attr(data-font);
}
form .footer .social:first-child{
	background-color: #3C5A9A;
}
form .footer .social:last-child{
	background-color: #CE3730;
	float: right;
}
@media screen and (max-width: 1000px) {
	.conteudo {
		background-color: rgba(0,0,0,.5);
	}
	form {
		margin: 20px auto;
	}
	form .footer .social {
		height: 45px;
		line-height: 45px;
	}
	form .footer .social i {
		height: 45px;
		line-height: 45px;
	}
}
@media screen and (max-width: 350px) {
	form .footer .social {
		padding: 0;
		text-align: center;
	}
	form .footer .social i {
		display: none;
	}
}
</style>

</body>
</html>
