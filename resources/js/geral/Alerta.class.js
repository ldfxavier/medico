class Alerta {

	constructor(){

		throw new Error('A class Alerta não pode ser instanciada.');

		this.recarregarPagina = false;
		this.linkRedirecionar;
		this.tipo;
		this.notificacaoId;
		this.mensagemId;
		this.confirmarId;
		this.confirmarIdProximo;
		this.texto;
		this.titulo;

	}

	static gerarId(){

		let min = Math.ceil(1);
		let max = Math.floor(9999999);
		let numero = Math.floor(Math.random() * (max - min)) + min;

		return 'fw_alerta__bloco--'+numero;

	}

	static recarregar(){
		this.recarregarPagina = true;
	}

	static redirecionar(link){

		this.linkRedirecionar = link;
		return this;

	}

	/*
    |--------------------------------------------------------------------------
    | METODOS PARA GERAR AS NOTIFICACOES
    |--------------------------------------------------------------------------
	*/
	static notificacaoCarregarHtml(){

		let id = this.gerarId();

		$('body').append(`
			<div class="fw_notificacao" id="`+id+`">
				<p>`+this.texto+`</p>
				<div class="fechar"><i></i></div>
				<div class="tempo"><span></span></div>
			</div>
		`);

		this.notificacaoTempo(id);
		this.notificacaoAnimacao(id);

		this.notificacaoId = id;

	}

	static notificacaoAnimacao(id){

		$('#'+id).stop().animate({
			right: -180,
			opacity: 0
		}, 0).animate({
			right: 20,
			opacity: 1
		}, 500);

	}

	static notificacaoTempo(id){

		let tempo = setInterval(() => {

			let bloco = $('#'+id+' .tempo').css('width');
			let barra = $('#'+id+' span').css('width');

			if($('#'+id).length == 0 || bloco == barra){

				this.notificacaoFechar(id);
				clearInterval(tempo);

			}

		}, 100);

	}

	static notificacaoFechar(id){

		let redirecionar = this.linkRedirecionar;
		let recarregar = this.recarregarPagina;

		$('#'+id).stop().animate({
			right: 220,
			opacity: 0
		}, 300, function(){

			$(this).remove();

			if(redirecionar != '' && redirecionar != undefined){
				window.location.assign(redirecionar);
			}else if(true === recarregar){
				window.location.reload(true);
			}

		});

	}

	static notificacaoFecharAberta(){

		let id = this.notificacaoId;
		$(id).attr('id', '');

		this.notificacaoFechar(id)

		this.notificacaoCarregarHtml();

	}

	static notificacao(texto){

		this.linkRedirecionar = '';
		this.recarregarPagina = false;
		this.texto = texto;
		this.tipo = 'notificacao';

		if($('.fw_notificacao').length == 0){

			this.notificacaoCarregarHtml();

		}else {

			this.notificacaoFecharAberta();

		}

		return this;

	}
	
	/*
    |--------------------------------------------------------------------------
    | METODOS PARA GERAR AS MENSAGENS NORMAIS
    |--------------------------------------------------------------------------
	*/
	static mensagemAnimacao(id, idAberto){

		if(idAberto != ''){
			$('#'+idAberto).remove();
			$('#'+id).stop().animate({
				opacity: 1
			}, 0);
		}else {
			$('#'+id).stop().animate({
				opacity: 0
			}, 0).animate({
				opacity: 1
			}, 500);
		}
		
		$('#'+id+' .fw_mensagem_bloco').stop()
		.animate({
			opacity:0,
			marginTop: -200
		}, 0)
		.delay(100).animate({
			opacity:1,
			marginTop: 20
		}, 500);

	}
	static mensagemCarregarHtml(aberto){

		let idAberto = 0;
		if(aberto){
			idAberto = this.mensagemId;
		}

		let id = this.gerarId();

		let titulo = '<div class="fw_mensagem_header"></div>';
		if(this.titulo != undefined && this.titulo != ''){
			titulo = `<h1>`+this.titulo+`</h1>`;
		}
		$('body').append(`
			<div class="fw_mensagem fw_mensagem_aberto fw_bloco_aberto_liberado" id="`+id+`">
				<div class="fw_mensagem_bloco">
					`+titulo+`
					<p>`+this.texto+`</p>
					<div class="fw_mensagem_footer">
						<div class="fw_mensagem_fechar">Fechar</div>
					</div>
				</div>
			</div>
		`);

		this.mensagemAnimacao(id, idAberto);

		this.mensagemId = id;

	}

	static mensagemFechar(id, aberto){

		let self = this;

		$('#'+id+' .fw_mensagem_bloco').stop().animate({
			opacity: 0,
			marginTop: -200
		}, 500, function(){

			if(aberto == true){
				self.mensagemCarregarHtml(true);
			}

		});

		let redirecionar = this.linkRedirecionar;

		if(true === this.recarregarPagina){
			window.location.reload(true);
		}else if(aberto == false && redirecionar != '' && redirecionar != undefined){
			window.location.assign(redirecionar);
		}else if(aberto == false){
			$('#'+id).stop().delay(100).animate({
				opacity: 0
			}, 500, function(){
				$(this).remove();
				$('body').css('overflow-y', 'auto');
			});
		}

	}
	static mensagemFecharAberta(){

		let id = this.mensagemId;
		$(id).removeClass('fw_mensagem_aberto');

		this.mensagemFechar(id, true);

	}

	static mensagem(textoPrincipal, textoSecundario){

		this.linkRedirecionar = '';
		this.recarregarPagina = false;
		
		if(textoSecundario != undefined){
			this.titulo = textoPrincipal;
			this.texto = textoSecundario;
		}else {
			this.texto = textoPrincipal;
		}

		if($('.fw_mensagem_aberto').length == 0){

			this.mensagemCarregarHtml(false);

		}else {

			this.mensagemFecharAberta();

		}

		return this;

	}

	/*
    |--------------------------------------------------------------------------
    | METODOS PARA GERAR AS CONFIRMACOES
    |--------------------------------------------------------------------------
	*/
	static confirmarAnimacao(id, idAberto){

		if(idAberto != ''){
			$('#'+idAberto).remove();
			$('#'+id).stop().animate({
				opacity: 1
			}, 0);
		}else {
			$('#'+id).stop().animate({
				opacity: 0
			}, 0).animate({
				opacity: 1
			}, 500);
		}
		
		$('#'+id+' .fw_confirmar_bloco').stop()
		.animate({
			opacity:0,
			marginTop: -200
		}, 0)
		.delay(100).animate({
			opacity:1,
			marginTop: 20
		}, 500);

	}
	static confirmarCarregarHtml(aberto){

		let idAberto = 0;
		if(aberto){
			idAberto = this.confirmarId;
		}

		let id = this.gerarId();

		let titulo = '<div class="fw_confirmar_header"></div>';
		if(this.titulo != undefined && this.titulo != ''){
			titulo = `<h1>`+this.titulo+`</h1>`;
		}
		$('body').append(`
			<div class="fw_confirmar fw_confirmar_aberto fw_bloco_aberto_liberado" id="`+id+`">
				<div class="fw_confirmar_bloco">
					`+titulo+`
					<p>`+this.texto+`</p>
					<div class="fw_confirmar_footer">
						<div class="fw_confirmar_cancelar fw_confirmar_fechar">Cancelar</div>
						<div class="fw_confirmar_flex_grow"></div>
						<div class="fw_confirmar_confirmar fw_confirmar_fechar" id="`+this.confirmarIdProximo+`">Confirmar</div>
					</div>
				</div>
			</div>
		`);

		this.confirmarAnimacao(id, idAberto);

		this.confirmarId = id;

	}

	static confirmarFechar(id, aberto){

		let self = this;

		$('#'+id+' .fw_confirmar_bloco').stop().animate({
			opacity: 0,
			marginTop: -200
		}, 500, function(){

			if(aberto == true){
				self.confirmarCarregarHtml(true);
			}

		});

		if(aberto == false){
			$('#'+id).stop().delay(100).animate({
				opacity: 0
			}, 500, function(){
				$(this).remove();
				$('body').css('overflow-y', 'auto');
			});
		}

	}
	static confirmarFecharAberta(){

		let id = this.confirmarId;
		$(id).removeClass('fw_confirmar_aberto');

		this.confirmarFechar(id, true);

	}

	static confirmar(confirmar, textoPrincipal, textoSecundario){

		if(textoSecundario != undefined){
			this.titulo = textoPrincipal;
			this.texto = textoSecundario;
		}else {
			this.texto = textoPrincipal;
		}

		this.confirmarIdProximo = confirmar;

		if($('.fw_confirmar_aberto').length == 0){

			this.confirmarCarregarHtml(false);

		}else {

			this.confirmarFecharAberta();

		}

		return this;

	}

}

$('body').on('click', '.fw_notificacao i', function(){
	Alerta.notificacaoFechar($(this).closest('.fw_notificacao').attr('id'));
});

$('body').on('click', '.fw_mensagem .fw_mensagem_fechar', function(){
	Alerta.mensagemFechar($(this).closest('.fw_mensagem').attr('id'), false);
});
$('body').on('click', '.fw_mensagem', function(e){

	if($(e.target).attr('id') != undefined && $(e.target).hasClass('fw_bloco_aberto_liberado')){
		$(e.target).removeClass('fw_bloco_aberto_liberado');
		Alerta.mensagemFechar($(this).closest('.fw_mensagem').attr('id'), false);
	}

});

$('body').on('click', '.fw_confirmar .fw_confirmar_fechar', function(){
	Alerta.confirmarFechar($(this).closest('.fw_confirmar').attr('id'), false);
});
$('body').on('click', '.fw_confirmar', function(e){

	if($(e.target).attr('id') != undefined){
		Alerta.confirmarFechar($(this).closest('.fw_confirmar').attr('id'), false);
	}

});

$('body').keyup(function(e){
	
	if(e.keyCode == 27 && $('.fw_notificacao').length > 0){
		Alerta.notificacaoFechar($('.fw_notificacao').attr('id'));
	}else if(e.keyCode == 27 && $('.fw_mensagem').length > 0){
		Alerta.mensagemFechar($('.fw_mensagem').attr('id'), false);
	}else if(e.keyCode == 13 && $('.fw_mensagem').length > 0){
		Alerta.mensagemFechar($('.fw_mensagem').attr('id'), false);
		return false;
	}else if(e.keyCode == 27 && $('.fw_confirmar').length > 0){
		Alerta.confirmarFechar($('.fw_confirmar').attr('id'), false);
	}else if(e.keyCode == 13 && $('.fw_confirmar').length > 0){
		$('.fw_confirmar_confirmar').click();
		return false;
	}

});
