class Ajuda {

	constructor(){

		throw new Error('A class Ajuda não pode ser instanciada.');

		this.texto;
		this.bloco;
		this.position;

	}

	static calculaWidth(bloco){
		return parseFloat(bloco.width())+parseFloat(bloco.css('margin-left'))+parseFloat(bloco.css('padding-left'))+parseFloat(bloco.css('padding-right'))+parseFloat(bloco.css('border-left-width'))+parseFloat(bloco.css('border-right-width'));
	}
	static calculaHeight(bloco){
		return parseFloat(bloco.height())+parseFloat(bloco.css('margin-top'))+parseFloat(bloco.css('padding-top'))+parseFloat(bloco.css('padding-bottom'))+parseFloat(bloco.css('border-top-width'))+parseFloat(bloco.css('border-bottom-width'));
	}
	static posicionarHtml(){
		let bloco = this.bloco;
		let blocoAjuda = $('#fw_ajuda');

		let blocoTop = bloco.offset().top;
		let blocoLeft = bloco.offset().left;

		let blocoWidth = this.calculaWidth(bloco);
		let blocoHeight = this.calculaHeight(bloco);

		let textoWidth = this.calculaWidth(blocoAjuda);

		blocoAjuda.css({
			top: blocoTop+blocoHeight+5,
			left: blocoLeft - (textoWidth / 2) + (blocoWidth / 2)
		});
	}

	static montarHtml(){

		if(this.texto != '' && this.texto != undefined){
			$('body').append('<div id="fw_ajuda" style="position: '+this.position+'">'+this.texto+'</div>');
		}
	}

	static verificarSeExiste(){
		if($('#fw_ajuda').length == 1){
			return true;
		}else {
			return false;
		}
	}
	static show(bloco, texto, position){

		if($(window).width() <= 1000){
			return false;
		}

		this.texto = texto;
		this.bloco = bloco;
		this.position = position;

		if(this.verificarSeExiste()){
			this.hide();
		}

		this.montarHtml();

		this.posicionarHtml();

	}

	static hide(){
		$('#fw_ajuda').remove();
	}

}
