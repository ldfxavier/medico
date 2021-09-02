class Checkbox {

	constructor(){
		throw new Error('A class Checkbox não pode ser instanciada.');
	}

	static verificarPosibilidade(bloco, acao){

		let marcarTodos = bloco.attr('data-marcar-todos') || false;
		let verificarTodosMarcados = bloco.attr('data-controlador') || false;

		if(marcarTodos != false){
			if(acao == 'marcar'){
				this.marcarTodos(marcarTodos);
			}else if(acao == 'desmarcar') {
				this.desmarcarTodos(marcarTodos);
			}
		}else if(verificarTodosMarcados){
			if(acao == 'desmarcar'){
				$(verificarTodosMarcados).removeClass('checked');
				$(verificarTodosMarcados+' input').prop('checked', false);
			}else {
				this.verificarTodosMarcados(verificarTodosMarcados);
			}
		}

	}

	static marcarTodos(id){

		$(id+' .bloco_checkbox').addClass('checked');
		$(id+' .bloco_checkbox input').prop('checked', true);

	}
	static desmarcarTodos(id){

		$(id+' .bloco_checkbox').removeClass('checked');
		$(id+' .bloco_checkbox input').prop('checked', false);

	}
	static verificarTodosMarcados(id){
		let bloco = $(id);
		let bloco_lista = $(bloco.attr('data-marcar-todos'));

		if($('.bloco_checkbox', bloco_lista).length == $('.bloco_checkbox.checked', bloco_lista).length){
			bloco.addClass('checked');
			$('input', bloco).prop('checked', true);
		}
	}

	static marcar(bloco){

		bloco.addClass('checked');
		$('input', bloco).prop('checked', true);

		this.verificarPosibilidade(bloco, 'marcar');

	}
	static desmarcar(bloco){

		bloco.removeClass('checked');
		$('input', bloco).prop('checked', false);

		this.verificarPosibilidade(bloco, 'desmarcar');

	}

	static click(bloco){

		if(!bloco.hasClass('checked')){
			this.marcar(bloco);
		}else {
			this.desmarcar(bloco);
		}

	}

}
