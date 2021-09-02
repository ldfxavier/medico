<article id="bloco_social">
	<div class="conteudo">
		<header>
			<h1>SOCIAL</h1>
			<i class="fechar" data-font=""></i>
		</header>
		<p>Vincule sua conta a uma rede social.</p>
		<div class="bloco_botao">
			<button class="icone facebook" id="but_vincular_facebook">FACEBOOK</button>
			<button class="icone google" id="but_vincular_google">GOOGLE</button>
		</div>
	</div>
</article>

<script>
function gravar(tipo, id, imagem){
	$.loading('show');
	$.post('{{PAINEL}}/post-social', {
		tipo:tipo,
		id:id,
		imagem:imagem
	}, function(resposta){
		if(resposta.erro == false){
			$.alerta({notificacao:'Conta vinculada com sucesso.'});
			$('#bloco_social').click();
			$('.imagem_trocar').each(function(i){
				var width = $(this).attr('data-width');
				$(this).css({
					'background-image':'url('+imagem+width+')'
				});
			});
		}else {
			$.alerta({
				titulo:resposta.titulo,
				texto:resposta.texto
			});
		}
		$.loading('hide');
	}, 'json');
}

/**
 * LOGIN COM O FACEBOOK
 */
$('#but_vincular_facebook').click(function(){
	FB.login(function(response){
		if (response.authResponse) {
			FB.api('/me', function(response) {
				var id = response.id;
				var imagem = 'https://graph.facebook.com/'+id+'/picture?width='
				gravar('facebook', id, imagem);
			});
		} else {
			$.alerta({
				titulo:'Erro!',
				texto:'Ocorreu um erro não identificado, por favor, tente novamente.'
			});
		}
	});
});

window.fbAsyncInit = function() {
	FB.init({
		appId: '{{FACEBOOKKEY}}',
		cookie: true,
		xfbml: true,
		version: 'v2.8'
	});
};

(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


/**
 * LOGIN COM O GOOGLE
 */
var googleUser = {};
var startApp = function() {
	gapi.load('auth2', function(){
		auth2 = gapi.auth2.init({
			client_id: '{{GOOGLECLIENTID}}',
			cookiepolicy: 'single_host_origin'
		});
		attachSignin(document.getElementById('but_vincular_google'));
	});
};

function attachSignin(element) {
	auth2.attachClickHandler(element, {},
	function(googleUser) {
		var id = googleUser.getBasicProfile().getId();
		var imagem = googleUser.getBasicProfile().getImageUrl()+'?sz=';

		gravar('google', id, imagem);
	}, function(error) {
		$.alerta({
			titulo:'Erro!',
			texto:'Ocorreu um erro não identificado, por favor, tente novamente.'
		});
	});
}
startApp();
</script>
