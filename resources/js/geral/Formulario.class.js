class Formulario {
	constructor(){

	}
	autoresize(elemento){
		let textarea = document.querySelector(elemento);
		if(textarea != null){
			textarea.addEventListener('keydown', function(){
				let self = this;
				setTimeout(function(){
					// self.style.cssText = 'height:auto; padding:0';
					self.style.cssText = '-moz-box-sizing:content-box';
					self.style.cssText = 'height:' + textarea.scrollHeight + 'px';
				}, 0);
			});
		}
	}

}

$('body').on('click', '.input_booleano, .input_booleano_pequeno', function(e){
	e.preventDefault();
	let bloco = $(this);
	let botao = $('button', bloco);
	let valor;
	if(botao.hasClass('ativo')){
		botao.addClass('inativo').removeClass('ativo');
		valor = 0;
	}else {
		botao.addClass('ativo').removeClass('inativo');
		valor = 1;
	}
	$('input', bloco).val(valor);
});