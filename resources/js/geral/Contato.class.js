class Contato {
	constructor(){
		this._html_telefone = `
			<div class="bloco">
				<select tabindex="-1">
					<option value="1">Celular</option>
					<option value="2">Whatsapp</option>
					<option value="3">Comercial</option>
					<option value="4">Residencial</option>
					<option value="5">Fax</option>
					<option value="6">0800</option>
					<option value="10">Principal</option>
					<option value="11">Outro</option>
				</select>
				<input type="tel" class="input" data-mascara="celular" placeholder="Telefone" value="">
				<i data-font="&#xe800;" class="icon_fechar"></i>
			</div>
		`;
		this._html_email = `
			<div class="bloco">
				<select tabindex="-1">
					<option value="7">Profissional</option>
					<option value="8">Pessoal</option>
					<option value="9">Funcional</option>
					<option value="10">Principal</option>
					<option value="11">Outro</option>
				</select>
				<input type="email" class="input" placeholder="E-mail" value="">
				<i data-font="&#xe800;" class="icon_fechar"></i>
			</div>
		`;
	}

	adicionar_bloco(bloco_geral, bloco, input, tecla){
		let html;
		if(bloco_geral.hasClass('bloco_telefone')){
			html = this._html_telefone;
		}else if(bloco_geral.hasClass('bloco_email')){
			html = this._html_email;
		}else {
			return false;
		}

		let input_vazio_status = false;
		let input_vazio_array = [];
		$('.bloco input.input', bloco_geral).each(function(i){
			if($(this).val() == '' && $(this).attr('data-contato-editando-atual') == undefined){
				input_vazio_status = true;
				input_vazio_array.push($(this).closest('.bloco'));
			}else if($(this).val() == ''){
				input_vazio_status = true;
			}
		});

		let input_vazio_quantidade = input_vazio_array.length;
		if(input_vazio_status == false){
			$('.lista', bloco_geral).append(html);
		}else if(input.val() == '' && tecla == 8 && input_vazio_quantidade > 0){
			for(let i=0; i < input_vazio_quantidade; ++i){
				input_vazio_array[i].remove();
			}
		}
	}

	static anima_nome(acao) {
		if(acao == 'ativo'){
			$('#bloco_fw-contato-novo .bloco_nome').addClass('ativo');
		}else if(acao == 'inativo'){
			$('#bloco_fw-contato-novo .bloco_nome').removeClass('ativo');
		}
	}

	static carregar_mais_informacoes(){
		$('#bloco_fw-contato-novo .botao_mais').hide();
		$('#bloco_fw-contato-novo .bloco_mais').css('display', 'flex');
		$('#bloco_fw-contato-novo input[name=empresa]').focus();
	}

	static gerar_link_mapa(){
		let empresa = $('#bloco_fw-contato-novo input[name=empresa]').val();
		let logradouro = $('#bloco_fw-contato-novo input[name=logradouro]').val();
		let cep = $('#bloco_fw-contato-novo input[name=cep]').val();
		let cidade = $('#bloco_fw-contato-novo input[name=cidade]').val();
		let estado = $('#bloco_fw-contato-novo select[name=estado]').val();

		let mostar_primario = 0;
		let montar_secundario = 0;

		let url = $('#bloco_fw-contato-novo .botao_geolocalizacao').attr('data-href');
		let array = [];
		if(empresa != ''){
			mostar_primario = true;
			array.push(empresa);
		}
		if(logradouro != ''){
			mostar_primario = true;
			array.push(logradouro);
		}
		if(cidade != ''){
			montar_secundario = true;
			array.push(cidade);
		}
		if(estado != ''){
			array.push(estado);
		}
		if(cep != ''){
			array.push(cep);
		}
		if(mostar_primario && montar_secundario){
			$('#bloco_fw-contato-novo .botao_geolocalizacao').css('display', 'flex');
			$('#bloco_fw-contato-novo .botao_geolocalizacao').attr('href', url+array.join(', '));
		}else {
			$('#bloco_fw-contato-novo .botao_geolocalizacao').hide();
		}
	}
}

$('body').on('focus', '#textarea_nota', function(){
	formulario = new Formulario();
	formulario.autoresize('#textarea_nota');
});

$('body').on('click', '#bloco_fw-contato-novo button', function(e){
	e.preventDefault();
});
$('body').on('focus', '#bloco_fw-contato-novo .bloco_nome input', function(){
	Contato.anima_nome('ativo');
});
$('body').on('blur', '#bloco_fw-contato-novo .bloco_nome input', function(){
	if($(this).val() == ''){
		Contato.anima_nome('inativo');
	}
});
$('body').on('click', '#bloco_fw-contato-novo .botao_mais', function(){
	Contato.carregar_mais_informacoes();
});
$('body').on('change', '#bloco_fw-contato-novo input[name=empresa], #bloco_fw-contato-novo input[name=logradouro], #bloco_fw-contato-novo input[name=cep], #bloco_fw-contato-novo input[name=cidade], #bloco_fw-contato-novo select[name=estado]', function(){
	Contato.gerar_link_mapa();
});
$('body').on('click', '#bloco_fw-contato-novo .botao_geolocalizacao', function(){
	let href = $(this).attr('href');
	if(href == '#mapa'){
		return false;
	}
});

$('body').on('keyup', '#bloco_fw-contato-novo .bloco_add_mais input.input', function(e){
	let bloco_geral = $(this).closest('.bloco_add_mais');
	let bloco = $(this).closest('.bloco');
	let input = $(this);
	let tecla = e.keyCode;

	if(input.attr('data-contato-editando-atual') == undefined){
		$('#bloco_fw-contato-novo .bloco_add_mais .bloco input.input').removeAttr('data-contato-editando-atual');
		input.attr('data-contato-editando-atual', true);
	}
	
	let contato = new Contato();
	contato.adicionar_bloco(bloco_geral, bloco, input, tecla);

	if(input.val() == ''){
		$('i', bloco).hide();
	}else {
		$('i', bloco).show();
	}
});
$('body').on('click', '#bloco_fw-contato-novo .bloco_add_mais .bloco i', function(){
	$(this).closest('.bloco').remove();
});