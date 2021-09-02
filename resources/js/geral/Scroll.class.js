class Scroll {

	constructor(){
		throw new Error('A class Scroll não pode ser instanciada.');
	}

	static hide(){

		$('body').css('overflow-y', 'hidden');

	}

	static show(){

		$('body').css('overflow-y', 'auto');

	}

}
