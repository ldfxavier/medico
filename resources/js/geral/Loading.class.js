class Loading {

	constructor(){
		throw new Error('A class Loading não pode ser instanciada.');
	}

	static show(){
		if($('#fw_loading').length == 0){
			$('body').prepend(`
				<div id="fw_loading">
					<i></i>
					<p>AGUARDE</p>
				</div>
			`);
		}
	}
	static hide(){
		$('#fw_loading').remove();
	}

}
