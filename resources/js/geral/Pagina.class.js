class Pagina {

	constructor(){
		this._pagina = '#fw_pagina';
		this._conteudo = '#fw_pagina_conteudo';
	}

	abrir(link, data_post = {}){
		Loading.show();
		this._incluir_html();
		this._carregar_pagina(link, data_post);
		$('body').css('overflow-y', 'hidden');
		$('html').css('overflow-y', 'hidden');
	}
	fechar(){
		this._fechar_pagina();
	}

	_incluir_html(){
		if($(this._pagina).length == 0){
			$('body').append(`
				<div id="${this._pagina.replace('#', '')}" class="fw_pagina_abrir">
					<div id="${this._conteudo.replace('#', '')}" class="${this._conteudo.replace('#', '')}">
					</div>
				</div>
			`);
		}else {
			$(this._conteudo).addClass('fw_pagina_conteudo_fechar');
			$(this._conteudo).removeClass('fw_pagina_conteudo_abrir');
		}
	}

	_carregar_pagina(link, data_post){
		data_post['ajax'] = true;
		let self = this;
		$.get(link, data_post, function(resposta){
			$('#fw_pagina_conteudo').html(resposta);
			self._botao_fechar();
			self._tecla_fechar();

			self._abrir_conteudo();
		});
	}

	_abrir_conteudo(){
		Loading.hide();
		let conteudo = $(this._conteudo);
		if(conteudo.hasClass('fw_pagina_conteudo_fechar')){
			setTimeout(function(){
				conteudo.removeClass('fw_pagina_conteudo_fechar');
				conteudo.addClass('fw_pagina_conteudo_abrir');
			}, 300);
		}else {
			conteudo.addClass('fw_pagina_conteudo_abrir');
		}
	}

	_botao_fechar(){
		let self = this;

		$('body').on('click', '#fw_pagina, #fw_pagina_conteudo', function(e){
			var target = $(e.target).attr('id');
			if(target == self._pagina.replace('#', '') || target == self._conteudo.replace('#', '')){
				self._fechar_pagina();
			}
		});
		$('body').on('click', '#fw_pagina_conteudo .botao_fechar', function(){
			self._fechar_pagina();
		})
	}
	_tecla_fechar(){
		let self = this;
		$('body').on('keydown', function(e){
			if(e.keyCode == 27 && $(self._pagina).is(':visible')){
				self._fechar_pagina();
			}
		});
	}
	_fechar_pagina(){
		let pagina = $(this._pagina);
		let conteudo = $(this._conteudo);
		conteudo.removeClass('fw_pagina_conteudo_abrir');
		conteudo.addClass('fw_pagina_conteudo_fechar');
		pagina.removeClass('fw_pagina_abrir');
		pagina.addClass('fw_pagina_fechar');
		$('body').css('overflow', 'auto');
		setTimeout(function(){
			pagina.remove();
		}, 505);
	}
}
