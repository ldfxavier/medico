$(function(){
	var LINK = $('#LINK').val();
	var URL = $('#URL').val();
	var COR = $('#COR').val();
	var BROWSER = $('#BROWSER').val();
	var SISTEMA = $('#SISTEMA').val();

	$.banner({
		id: '#banner',
		imagem: 'figure',
		next: '#but_banner_prev',
		prev: '#but_banner_next',
		tempo: 8
	});

	$.banner({
		id: '#fotos_imoveis',
		imagem: 'figure',
		next: '#but_fotos_next',
		prev: '#but_fotos_prev',
		tempo: 0
	});

	$.banner({
		id: '#banner_home',
		imagem: 'figure',
		next: '#but_banner_login_next',
		prev: '#but_banner_login_prev',
		transicao:0.5,
		tempo: 6
	});
	$.pagina({
        botao:'.but_ajax',
        attr:'href',
		width:'500px'
    });

	$.pagina({
		botao:'.but_ajax_completo',
		width:'1000px',
		attr: 'href'
	});

	$.pagina({
        botao:'.but_ajax_novo',
        attr:'data-href'
    });

	/**
	 * CONTAGEM DE NÚMEROS
	**/
	var executado = false;
	function contador(){
		$('.contador').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 2000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
		executado = true;
		});
	}

	if($('#bloco_login').length == 1){
		$(window).on("scroll",function(){
			var trigger = Math.round($(window).scrollTop());
			var trigger_2 = Math.round($("#bloco_login .banner").offset().top);
			if(trigger >= trigger_2 && executado == false){
				contador();
			}else{

			}
		});
	}

	/**
	 * TORNAR PARCEIRO
	**/
	$('#bloco_login .parceiro .botao_mais').click(function(){
		$('body, html').scrollTop($('#bloco_login .bloco_contato').offset().top-50);
	});

	/**
	 * LOGIN
	**/
	$('#but_login').click(function(){
		$('#bloco_login .banner form').show();
		$('#bloco_login .banner form').animate({
			opacity:1
		}, 350, function(){
			$('#form_login input[name=login]').focus();
		});
	});
	$('#but_login_api').click(function(){
		if(!$('#bloco_login .banner form').is(":visible")){
			$('#bloco_escolha_login').show();
			$('#bloco_escolha_login').animate({
				opacity:1
			}, 350);
		}
	});
	$('#but_login_dependete').click(function(){
		$('#bloco_escolha_login').stop()
		.animate({
			opacity:0,
			right: 300
		}, 300, function(){
			$(this).hide();
		});

		$('#form_login').show().delay(150).stop()
		.animate({
			opacity:0,
			right:-300
		}, 0)
		.animate({
			opacity:1,
			right:0
		}, 300, function(){
			$('#form_login input[name=login]').focus();
		});
		return false;
	});


	/**
	 * VALIDA USUÁRIO ONLINE
	**/
	if($('#LOGADO').length == 1){
		var usuario_online = function(){
			$.post(LINK+'/perfil/post-online', {
				ajax:true
			}, function(resposta){
				if(resposta == 'deslogado'){
					clearInterval(usuario_online_intervalo);
				}
			});
		};
		var usuario_online_intervalo = setInterval(usuario_online, 20000);
	}

	if($('#bloco_promocoes').size() == 1){
		$.galeria({
			id: '#bloco_galeria',
			href: 'data-href',
			botao: 'article'
		});
	}else if($('#bloco_imoveis_detalhes').size() == 1){
		$.galeria({
			id: '#foto_grande',
			href: null,
			botao: 'figure'
		});
	}

	/**
	 * TROCA DE IMAGEM PARA VIDEO PAGINA IMOVEIS
	 */

	 $('.bt_videos').click(function(){
		 $('#foto_grande').hide();
		 $('.video_detalhe').show();
		 $('.bt_videos').css('border-bottom','3px solid var(--cor)');
		 $('.bt_fotos').css('border-bottom','none');

	 });

	 $('.bt_fotos').click(function(){
		 $('#foto_grande').show();
		 $('.video_detalhe').hide();
		 $('.bt_fotos').css('border-bottom','3px solid var(--cor)');
		 $('.bt_videos').css('border-bottom','none');

	 });

	/**
	 * SISTEMA DE BUSCA POR VOZ
	 */
	window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition || null;
	if(window.SpeechRecognition === null) {
		$('.but_busca_voz').hide();
	}else {
		var rec = new window.SpeechRecognition();
		rec.continuous = false;
		rec.interimResults = false;
		rec.lang = 'pt-BR';

		rec.onstart = function(event){
			$('#bloco_api_audio').addClass('gravando').removeClass('encontrado').removeClass('hide');
		};
		rec.onend = function(event){
			$('#bloco_api_audio').removeClass('gravando');
		};
		rec.onerror = function(event){
			if($('#bloco_api_audio').hasClass('hide')){
				$('#erro_permissao_audio').show();
			}else {
				$('#bloco_api_audio').removeClass('gravando').removeClass('encontrado');
				rec.stop();
			}
		};

		rec.onresult = function(event){
			var rec_texto = event.results[0][0].transcript;
			if(rec_texto != ''){
				$('#bloco_api_audio').addClass('encontrado');
				$('#bloco_api_audio .resultado').text(rec_texto);
				setTimeout(function(){
					if($('#bloco_api_audio').hasClass('encontrado')){
						window.location.assign(LINK+'/convenios/lista/pesquisa/'+rec_texto);
					}
				}, 3000);
			}
			rec.stop();
		};

		$('.but_busca_voz').click(function(){
			try {
				rec.start();
			} catch(ex) {
				rec.stop();
			}
		});

		$('#bloco_api_audio i.fechar').click(function(){
			$('#bloco_api_audio').addClass('hide');
			rec.stop();
		});
	}

	/**
	 * MENSAGEM DE ERRO DE PERMISSÃO
	**/
	$('body').click(function(){
	    $('.bloco_erro_permissao').hide();
	});
	$('body').on('click', '.bloco_erro_permissao', function(e){
	    e.stopPropagation();
	});
	$('body').on('click', '.bloco_erro_permissao .fechar', function(){
	    $('.bloco_erro_permissao').hide();
	});

	/**
	 * POPUPS
	 */
	$('body').on('click', '.but_forca_atualizacao', function(){
		var id = $(this).attr('id');
		$('#but_popu_atualizacao').attr('data-id', id);
		$('#but_popu_atualizacao').click();
		return false;
	});

	$('body').on('click', '#but_atualizacao_forcada', function(){
		var botao = $(this);
		var form = $(this).closest('form');
		var link = form.attr('action');
		var id = $('#but_popu_atualizacao').attr('data-id');

		var dados = form_dados(form);

		botao.text('AGUARDE');

		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$('.but_forca_atualizacao').removeClass('but_forca_atualizacao');
				if(!$('#'+id).hasClass('but_ajax')) $('#plugins_pagina').click();
				var forca_abrir = $('#'+id).attr('data-abrir') || 0;
				if(forca_abrir == 0){
					$('#'+id).click();
				}else if(forca_abrir == 1){
					window.open($('#'+id).attr('href'));
    				window.focus();
				}
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}
			botao.text('CONTINUAR');
		}, 'json');
		return false;
	});

	$('body').on('click', '#but_atualizacao_promocao', function(){
		var botao = $(this);
		var form = $(this).closest('form');
		var link = form.attr('action');

		var dados = form_dados(form);

		if(dados.promocao.length == 0){
			$.alerta({
				titulo:'Campo obrigatório!',
				texto:'Selecione pelo menos 1 promoção para participar.'
			});
			return false;
		}

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$('.but_forca_atualizacao').removeClass('but_forca_atualizacao');
				$('#plugins_pagina').click();
				$.alerta({
					titulo:'Dados atualizados!',
					texto: 'Obrigado por atualizar seus dados e participar desta promoção.'
				});
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}
			$.loading('hide');
			botao.text('CONTINUAR');
		}, 'json');
		return false;
	});


	if($('#but_popu_promocao').size() == 1){
		$('#but_popu_promocao').click();
	}
	if($('#but_popu_bemvindo').size() == 1){
		$('#but_popu_bemvindo').click();
	}
	if($('#but_popu_retorno').size() == 1){
		$('#but_popu_retorno').click();
	}
	if($('#but_popup_evento').size() == 1){
		$('#but_popup_evento').click();
	}
	if($('#but_popup_ajuda').size() == 1){
		$('#but_popup_ajuda').click();
	}
	if($('#but_popu_interacao').size() == 1){
		setTimeout(function(){
			$('#but_popu_interacao').click();
		}, 180000);
	}


	/**
	 * BOTÃO DE FECHAR A PÁGINA EM AJAX
	 */
	$('body').on('click', '.but_ajax_fechar', function(){
		$('#plugins_pagina').click();
	});

	/**
	 * AÇÕES QUANDO CLICAR NO BODY
	 */
	$('body').click(function(){
		if($('#bloco_menu_principal').is(':visible')){
			$('#bloco_menu_principal').hide();
			$('#but_menu_principal').removeClass('hover');
		}
		if($('.but_convenio_estado ul').is(':visible')){
			$('.but_convenio_estado ul').hide();
		}
	});

	/**
	 * SOLICITAR FINANCIAMENTO
	 */
	var calcular_credito = function(form){
		var tipo_financiamento = $('input[name=tipo_financiamento]', form).val();
		var valor_financiamento = $('input[name=valor_financiamento]', form).val();
		var parcela = $('select[name=parcela]', form).val();

		if(parcela != '' && valor_financiamento != ''){
			if(SISTEMA != 'qa'){
				$.loading('show');
			}
			$.post(LINK+'/credito/post_calculo', {
				ajax: true,
				tipo_financiamento:tipo_financiamento,
				valor_financiamento:valor_financiamento,
				parcela:parcela
			}, function(resposta){
				if(resposta.erro == false){
					$('.valor span', form).text(resposta.valor);
				}else if(resposta.erro == true){
					$.alerta({
						titulo:resposta.titulo,
						texto: resposta.texto
					});
				}
				$.loading('hide');
			}, 'json');
		}else {
			$('.valor span', form).text('Valor das parcelas');
		}
	};
	$('#bloco_credito select[name=parcela]').change(function(){
		var form = $(this).closest('form');
		calcular_credito(form);
		return false;
	});
	var valor_atual = '';
	$('#bloco_credito input[name=valor_financiamento]').blur(function(){
		var valor = $(this).val();

		if(valor != valor_atual){
			valor_atual = valor;
			var form = $(this).closest('form');
			calcular_credito(form);
		}
		return false;
	});

	$('#bloco_credito .botao_solicitar').click(function(){
		if(!$(this).hasClass('but_forca_atualizacao')){
			var form = $(this).closest('form');
			var botao = $(this);
			var tipo_financiamento = $('input[name=tipo_financiamento]', form).val();
			var valor_financiamento = $('input[name=valor_financiamento]', form).val();
			var valor_parcela = $('.valor span', form).text().replace('R$ ', '').replace('Valor das parcelas', '');
			var parcela = $('select[name=parcela]', form).val();
			var link = form.attr('action');

			if(SISTEMA != 'qa'){
				$.loading('show');
			}
			botao.text('AGUARDE');
			$.post(link, {
				ajax:true,
				tipo_financiamento:tipo_financiamento,
				valor_financiamento:valor_financiamento,
				parcela:parcela,
				valor_parcela:valor_parcela
			}, function(resposta){
				if(resposta.erro == false){
					$.alerta({
						titulo:'Solicitação enviada com sucesso!',
						texto:'O Sicoob Judiciário entrará em contato em breve.'
					});
				}else if(resposta.erro == true){
					$.alerta({
						titulo:resposta.titulo,
						texto:resposta.texto
					});
				}
				$.loading('hide');
				botao.text('SOLICITAR');
			}, 'json');
			return false;
		}
	});

	/**
	 * MENSAGEM GERAL
	 */
	var form_dados = function(form){
		var dados = {};
		$('*[name]', form).each(function(i){
			var nome = $(this).attr('name');

			if($(this).attr('type') == 'checkbox'){
				if(dados[nome] == undefined && !$(this).is(':checked')){
					dados[nome] = [];
				}else if(dados[nome] == undefined && $(this).is(':checked')){
					dados[nome] = Array($(this).val());
				}else if($.isArray(dados[nome]) && $(this).is(':checked')){
					dados[nome].push($(this).val());
				}
			}else {
				var valor = $(this).val();
				dados[nome] = valor;
			}
		});
		return dados;
	};
	var botao_geral;
	$('body').on('click', '.but_enviar_geral', function(){
		var form = $(this).closest('form');
		var limpar = $(this).attr('data-limpar') || 1;
		var link = form.attr('action');
		var botao = $('span', this);
		var mensagem = $(this).attr('data-mensagem') || 'Em breve retornaremos o contato.';

		botao_geral = botao.text();
		botao.text('AGUARDE');
		if(SISTEMA != 'qa'){
			$.loading('show');
		}

		var dados = form_dados(form);
		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				if(limpar == 1){
					$('input[type=email]', form).val('');
					$('input[type=text]', form).val('');
					$('input[type=number]', form).val('');
					$('input[type=tel]', form).val('');
					$('input[type=password]', form).val('');
					$('textarea', form).val('');
					$('select', form).val('');
				}
				$.alerta({
					titulo:'Enviado!',
					texto:mensagem
				});
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}else {
				$.alerta({
					titulo:'Ocorreu um erro!',
					texto:'Ocorreu um erro no envio, por favor, tente novamente ou entre em contato com o atendimento.'
				});
			}
			$.loading('hide');
			botao.text(botao_geral);
		}, 'json');
		return false;
	});

	/**
	 * RECUPERAR NOVA SENHA
	 */
	$('#but_nova_senha').click(function(){
		var form = $(this).closest('form');
		var link = form.attr('action');
		var botao = $('span', this);

		var dados = form_dados(form);
		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax: true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				window.location.replace(LINK);
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				$.loading('hide');
				botao.text('SALVAR NOVA SENHA');
			}
		}, 'json');

		return false;
	});

	$('body').on('click', '#but_login_buscar_usuario', function(){
		var form = $(this).closest('form');
		var link = form.attr('action');
		var botao = $('span', this);

		var dados = form_dados(form);
		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax: true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$('#but_login_abrir_ativar_dados').attr('href', $('#but_login_abrir_ativar_dados').attr('href')+'/'+dados.login);
				$('#but_login_abrir_ativar_dados').click();
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				botao.text('BUSCAR USUÁRIO');
			}
			$.loading('hide');
		}, 'json');

		return false;
	});
	$('body').on('click', '#but_ativar_cadastro', function(){
		var form = $(this).closest('form');
		var link = form.attr('action');
		var botao = $('span', this);

		var dados = form_dados(form);
		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax: true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$('#but_login_abrir_ativacao_concluida').attr('href', $('#but_login_abrir_ativacao_concluida').attr('href')+'/'+dados.email_pessoal);
				$('#but_login_abrir_ativacao_concluida').click();
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				botao.text('ATIVAR CADASTRO');
			}
			$.loading('hide');
		}, 'json');

		return false;
	});

	/**
	 * MENU DROPDOWN
	 */
	var dropdown = function(atual){
		var lista = ['#bloco_menu_principal','.but_convenio_estado ul'];
		lista.forEach(function(valor){
			if(valor != atual) $(valor).hide();
		});
	};
	$('#but_menu_principal').click(function(){
		dropdown('#bloco_menu_principal');
		$('#bloco_menu_principal').show();
		$('#but_menu_principal').addClass('hover');
		return false;
	});
	$('#bloco_menu_principal').click(function(e){
		e.stopPropagation();
	});

	$('#bloco_convenio_lista').on('click', '.but_convenio_estado', function(){
		$('.but_convenio_estado ul').hide();
		dropdown('.but_convenio_estado ul');
		$('ul', this).show();
		return false;
	});

	$('.but_menu_convenio').hover(function(){
		$('ul', this).show();
	}, function(){
		$('ul', this).hide();
	});

	/**
	 * MENU MOBILE
	 */
	var abrir_menu = function(){
		$('#menu_mobile ul li ul').hide();
		$('#menu_mobile .but_abrir_mais').removeClass('hover');

		$('#menu_mobile').show().stop()
		.animate({
			opacity:0
		}, 0)
		.animate({
			opacity:1
		}, 200, function(){
			$('#menu_mobile .bg').addClass('aberto');
		});

		$('#menu_mobile .conteudo').show().stop()
		.animate({
			left:'-100%'
		}, 0)
		.animate({
			left:0
		}, 400);
		$('body').css('overflow-y', 'hidden');
	};
	var fechar_menu = function(){
		$('#menu_mobile .bg').removeClass('aberto');
		$('#menu_mobile').stop()
		.animate({
			opacity:0
		}, 300, function(){
			$(this).hide();
		});
		$('#menu_mobile .conteudo').show().stop()
		.animate({
			left:'-100%'
		}, 400);
		$('body').css('overflow-y', 'auto');
	};
	$('#header_mobile .menu').click(function(){
		abrir_menu();
	});
	$('#botao_mobile').swiperight(function(){
		abrir_menu();
	});
	$('body').on('click', '#menu_mobile .bg.aberto, #menu_mobile .conteudo ul li a', function(){
		fechar_menu();
	});
	$('#menu_mobile .conteudo').swipeleft(function(){
		fechar_menu();
	});

	$('#menu_mobile .but_abrir_mais').click(function(){
		var li = $(this).closest('li');
		if($('ul', li).is(':visible')){
			$('#menu_mobile ul li ul').hide();
			$('#menu_mobile .but_abrir_mais').removeClass('hover');
		}else {
			$('#menu_mobile ul li ul').hide();
			$('#menu_mobile .but_abrir_mais').removeClass('hover');
			$('ul', li).show();
			$(this).addClass('hover');
		}
	});


	/**
	 * BUSCA PRINCIPAL
	 */
	var busca_change = function(){
		var estado = $('#input_busca_principal_estado').val();
		var pesquisa = $('#input_busca_principal_pesquisa').val();

		if(estado != '') estado = '/estado/'+estado;
		if(pesquisa != '') pesquisa = '/pesquisa/'+pesquisa;

		$('#bloco_categoria').each(function(i){
			var categoria = $(this).attr('data-categoria');
			$(this).attr('href', LINK+'/convenio/busca/categoria/'+categoria+estado+pesquisa);
		});
	};
	$('#input_busca_principal_estado').change(function(){
		$('#input_busca_principal_pesquisa').focus();
		busca_change();
	});
	$('#input_busca_principal_pesquisa').keyup(function(){
		busca_change();
	});

	/**
	 * BUSCA AVANÇADA
	 */
	var busca_avancada_tag = function(){
		var tag = '';
		$('#bloco_busca_avancada .lista li[data-tag]').each(function(){
			if($(this).hasClass('hover')) tag += ','+$(this).attr('data-tag');
		});
		$('#input_busca_avancada_tag').val(tag.replace(',', ''));
	};
	$('body').on('click', '#bloco_busca_avancada .but_todos', function(){
		var div = $(this).closest('.lista');

		var quantidade = $('li', div).size()-1;
		var marcado = 0;
		$('li[data-tag]', div).each(function(){
			if($(this).hasClass('hover')){
				marcado++;
			}
		});
		if(quantidade == marcado){
			$('li', div).removeClass('hover');
		}else {
			$('li', div).addClass('hover');
		}
		busca_avancada_tag();
	});
	$('body').on('click', '#bloco_busca_avancada .lista li', function(){
		var div = $(this).closest('.lista');
		var quantidade = $('li', div).size()-1;
		var marcado = 0;

		if($(this).hasClass('hover')){
			$(this).removeClass('hover');
		}else {
			$(this).addClass('hover');
		}

		$('li[data-tag]', div).each(function(){
			if($(this).hasClass('hover')){
				marcado++;
			}
		});

		if(quantidade == marcado){
			$('.but_todos', div).addClass('hover');
		}else {
			$('.but_todos', div).removeClass('hover');
		}
		busca_avancada_tag();
	});


	/**
	 * SCROLL PARA CONVÊNIOS
	 */
	if($('#bloco_convenio').size() == 1 && $('#menu_principal').is(':visible')){
		var pesquisa_categoria = $('#form_pesquisa_scroll input[name=categoria]').val();
		var pesquisa_estado = $('#form_pesquisa_scroll input[name=estado]').val();
		var pesquisa_pesquisa = $('#form_pesquisa_scroll input[name=pesquisa]').val();
		var pesquisa_preferenciasa = $('#form_pesquisa_scroll input[name=preferencias]').val();

		if(pesquisa_categoria != '' || pesquisa_estado != ''  || pesquisa_pesquisa != ''  || pesquisa_preferenciasa != '' ){
			$('body, html').scrollTop($('#bloco_convenio .bloco_convenio').offset().top-50);
		}
	}

	if($('#menu_convenio_categoria').size() == 1 && $('#menu_principal').is(':visible')){
		$('#form_busca_principal select, #form_busca_principal input').change(function(){
			var estado = $('#form_busca_principal select').val() || '';
			var pesquisa = $('#form_busca_principal input').val() || '';

			if(estado != '') estado = '/estado/'+estado;
			if(pesquisa != '') pesquisa = '/pesquisa/'+pesquisa;

			$('#menu_convenio_categoria *[data-href]').each(function(){
				var link = $(this).attr('data-href')+estado+pesquisa;
				$(this).attr('href', link);
			});
		});
	}

	/**
	 * CARREGAR CONVÊNIOS
	 */
	var pagina_atual = $('#but_carregar_convenio').attr('data-atual');
	$('#but_carregar_convenio').click(function(){
		var pagina_quantidade = parseInt($(this).attr('data-pagina'));
		if(pagina_atual < pagina_quantidade){
			if(SISTEMA != 'qa'){
				$.loading('show');
			}
			pagina_atual++;
			$.post(LINK+'/convenios/post_mais', {
				pagina:pagina_atual
			}, function(resposta){
				if(resposta == ''){
					$('#but_carregar_convenio').hide();
				}else {
					$('#bloco_convenio_lista').append(resposta);
				}
				if(pagina_atual == pagina_quantidade){
					$('#but_carregar_convenio').hide();
				}
				$.loading('hide');
			});
		}else {
			$('#but_carregar_convenio').hide();
		}
		return false;
	});

	/**
	 * BOTÃO PARA ESCOLHER ENDEREÇO NOS CONVÊNIOS
	 */
	$('#but_escolher_endereco').click(function(){
		if($(this).hasClass('mais')){
			$('#bloco_endereco_lista').stop().show()
			.animate({opacity:0}, 0)
			.animate({opacity:1}, 300);
			$('body').css('overflow-y', 'hidden');
		}
	});
	$('#bloco_endereco_lista').click(function(){
		$('#bloco_endereco_lista').stop()
		.animate({opacity:0}, 300, function(){
			$(this).hide();
			$('body').css('overflow-y', 'auto');
		});
	});
	$('#bloco_endereco_lista .conteudo').click(function(e){
		e.stopPropagation();
	});

	/**
	 * PÁGINA DE LOGIN
	**/
	$('#but_fazer_login').click(function(){
		var form = $(this).closest('form');
		var link = form.attr('action');
		var botao = $('span', this);

		var login = $('input[name=login]', form).val();
		var password = $('input[name=password]', form).val();
		var hash = $('input[name=hash]').val();

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');
		$.post(link, {
			ajax:true,
			hash:hash,
			login:login,
			password:password
		}, function(resposta){
			if(resposta.erro == false){
				window.location.replace($('#LOCATIONLOGIN').val());
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				$.loading('hide');
				botao.text('LOGIN');
			}else {
				$.alerta({
					titulo:'Erro no login!',
					texto:'Ocorreu um erro ao fazer o login, por favor, tente novamente.'
				});
				$.loading('hide');
				botao.text('LOGIN');
			}
		}, 'json');
		return false;
	});

	/**
	 * PERFIL / PREFERENCIAS
	 */
	$('#bloco_perfil_preferencia article').click(function(){
		if($(this).hasClass('hover')){
			$(this).removeClass('hover');
		}else {
			$(this).addClass('hover');
		}
	});
	$('#but_salvar_preferencias').click(function(){
		var botao = $(this);
		var link = LINK+'/perfil/post_preferencias';

		var dados = [];
		$('#bloco_perfil_preferencia .lista article.hover').each(function(){
			dados.push($(this).attr('data-id'));
		});

		$.post(link,{
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$.alerta({
					titulo:'Preferências salvas!',
					texto:'Suas preferências foram salvas com sucesso.',
					href:LINK+'/convenios/preferencias'
				});
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}
		}, 'json');
		return false;
	});

	/**
	 * PERFIL / DEPENDENTE
	 */
	$('.but_dependente_salvar').click(function(){
		var form = $(this).closest('form');
		var dados = form_dados(form);
		var link = form.attr('action');
		var botao = $(this);

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$.alerta({
					titulo:'Dependente cadastrado!',
					texto:'Seu dependente foi cadastrado com sucesso.',
					href:LINK+'/perfil/dependente'
				});
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				botao.text('SALVAR DEPENDENTE');
			}
			$.loading('hide');
		}, 'json');
		return false;
	});
	$('.but_dependente_deletar').click(function(){
		var id = $(this).attr('data-id');
		if(SISTEMA != 'qa'){
			$.loading('show');
		}

		$.post(LINK+'/perfil/post-dependente-deletar', {
			ajax:true,
			id:id
		}, function(resposta){
			if(resposta.erro == false){
				window.location.replace(LINK+'/perfil/dependente');
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
				$.loading('hide');
			}
		}, 'json');
	});

	/**
	 * PERFIL / CASHBACK
	 */
	var cashback = function(mensagem, form){
		if(mensagem.erro == false){
			$.post(LINK+'/solicitacao/post_cashback', {
				arquivo:mensagem.arquivo
			}, function(resposta){
				if(resposta.erro == true){
					$.loading('hide');
					$('i', form).removeClass('hide');
					$('i.loading', form).addClass('hide');
					$.alerta({
						titulo:resposta.titulo,
						texto:resposta.texto
					});
				}else if(resposta.erro == false){
					window.location.assign(LINK+'/perfil/cashback/historico');
				}
			}, 'json');
		}else if(mensagem.erro == true){
			$.loading('hide');
			$('i', form).removeClass('hide');
			$('i.loading', form).addClass('hide');

			$.alerta({
				titulo:mensagem.titulo,
				texto:mensagem.texto
			});
		}
	};
	$('#input_cashback_upload').change(function(){
		if(!$(this).hasClass('but_forca_atualizacao')){
			var form = $(this).closest('form');
			var link  = form.attr('action');

			var dados = new FormData();
			dados.append('arquivo', $('input[type=file]', form).prop('files')[0]);
			dados.append('diretorio', 'cashback');


			$('i', form).removeClass('hide');
			$('i.icone', form).addClass('hide');
			if(SISTEMA != 'qa'){
				$.loading('show');
			}

			$.ajax({
				url: link,
				data: dados,
				type: 'post',
				dataType : "json",
				success: function(resposta){
					cashback(resposta, form);
					$.loading('hide');
				},
				error: function(resposta){
					cashback(resposta, form);
					$.loading('hide');
				},
				processData: false,
				cache: false,
				contentType: false
			});
			$.loading('hide');
		}
	});


	/**
	 * PERFIL / COMPROVANTE
	 */
	var comprovante = function(mensagem, form){
		if(mensagem.erro == false){
			$.post(LINK+'/solicitacao/post_imovel', {
				arquivo:mensagem.arquivo
			}, function(resposta){
				if(resposta.erro == true){
					$.loading('hide');
					$('i', form).removeClass('hide');
					$('i.loading', form).addClass('hide');
					$.alerta({
						titulo:resposta.titulo,
						texto:resposta.texto
					});
				}else if(resposta.erro == false){
					$.alerta({
						titulo:'Comprovante enviado!',
						texto:'Obrigado por enviar seu comprovante. Em breve entraremos em contato.',
						href: LINK+'/perfil/comprovante-imovel'
					});
				}
			}, 'json');
		}else if(mensagem.erro == true){
			$.loading('hide');
			$('i', form).removeClass('hide');
			$('i.loading', form).addClass('hide');

			$.alerta({
				titulo:mensagem.titulo,
				texto:mensagem.texto
			});
		}
	};
	$('#input_comprovante_upload').change(function(){
		if(!$(this).hasClass('but_forca_atualizacao')){
			var form = $(this).closest('form');
			var link  = form.attr('action');

			var dados = new FormData();
			dados.append('arquivo', $('input[type=file]', form).prop('files')[0]);
			dados.append('diretorio', 'comprovante');

			$('i', form).removeClass('hide');
			$('i.icone', form).addClass('hide');
			if(SISTEMA != 'qa'){
				$.loading('show');
			}

			$.ajax({
				url: link,
				data: dados,
				type: 'post',
				dataType : "json",
				success: function(resposta){
					comprovante(resposta, form);
					$.loading('hide');
				},
				error: function(resposta){
					comprovante(resposta, form);
					$.loading('hide');
				},
				processData: false,
				cache: false,
				contentType: false
			});
			$.loading('hide');
		}
	});

	/**
	 * SOLICITAÇÃO DE TURISMO
	 */
	$('#but_solicitacao_turismo_abrir').click(function(){
		if(!$('#bloco_turismo_detalhe .termo input').is(':checked')){
			$.alerta({
				titulo:'Campo obrigatório!',
				texto:'Para continuar, aceite os termos de uso.'
			});
			return false;
		}
	});
	$('body').on('click', '#but_solicitar_cotacao', function(){
		var form = $(this).closest('form');
		var botao = $(this);
		var link = form.attr('action');

		var dados = form_dados(form);

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		botao.text('AGUARDE');

		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto,
				});
			}else if(resposta.erro == false){
				$.alerta({
					titulo:'Solicitação enviada!',
					texto:'Sua solicitação foi enviada com sucesso, aguarde contato com sua cotação por e-mail ou telefone.',
				});
				$('#plugins_pagina_fechar').click();
			}
			$.loading('hide');
			botao.text('ENVIAR SOLICITAÇÃO');
		}, 'json');

		return false;
	});
	var categoria_turismo = function(categoria){
		var form = $('.turismo_categoria').closest('form');
		$('.turismo_categoria_valor').val(categoria);
		$('input[name=origem]', form).focus();
		if(categoria == 2){
			$('input[name=origem]', form).hide();
			$('input[name=destino]', form).focus();
		}else{
			$('input[name=origem]', form).show();
			$('input[name=origem]', form).focus();
		}
	};

	$('.turismo_categoria').click(function(){
		$('.turismo_categoria').removeClass('hover').removeClass('color_cor');
		$(this).addClass('hover').addClass('color_cor');
		var categoria = $(this).attr('data-categoria');
		categoria_turismo(categoria);
	});

	$('.hoteis').click(function(){
		$(".veiculos").removeClass('hover');
		$(".veiculos i").removeClass('color_cor');
		$(".veiculos p").removeClass('color_cor');
	});
	$('.veiculos').click(function(){
		$(".hoteis").removeClass('hover');
		$(".hoteis i").removeClass('color_cor');
		$(".hoteis p").removeClass('color_cor');
	});

	$('.bt_passagens').click(function(){
		$('body, html').scrollTop($('.buscador').offset().top-80);
		$('.bloco_explicacao').show();
		$('body').css('overflow','hidden');
		$('.destaque').addClass('destaque_ativo');
	});

	$('.bloco_explicacao').click(function(){
		$('.bloco_explicacao').hide();
		$('body').css('overflow','auto');
		$('.destaque').removeClass('destaque_ativo');
	});

	$('.bt_hoteis').click(function(){
		$('body, html').scrollTop($('.bloco_contato').offset().top-50);
		categoria_turismo(2);
		$('.turismo_categoria').removeClass('hover');
		$(".hoteis").addClass('hover');
		$(".hoteis i").addClass('color_cor');
		$(".hoteis p").addClass('color_cor');
		$(".veiculos").removeClass('hover');
		$(".veiculos").removeClass('color_cor');

	});

	$('.bt_pacotes').click(function(){
		$('body, html').scrollTop($('.bloco_compra').offset().top-50);
	});

	$('.bt_veiculos').click(function(){
		$('body, html').scrollTop($('.bloco_contato').offset().top-50);
		categoria_turismo(2);
		$('.turismo_categoria').removeClass('hover');
		$('.turismo_categoria i').removeClass('color_cor');
		$('.turismo_categoria p').removeClass('color_cor');
		$(".veiculos").addClass('hover');
		$(".veiculos i").addClass('color_cor');
		$(".veiculos p").addClass('color_cor');
	});

	/**
	 * AUTOMOVEIS
	**/
	// Tipo de veiculos
	$('.bloco_automovel_tipo li').click(function(){
		$('.bloco_automovel_tipo li').removeClass('hover').removeClass('bg_cor');
		$(this).addClass('hover').addClass('bg_cor');
		var tipo = $(this).attr('data-tipo');
		$('#bloco_lista_concessionaria article').addClass('hide');
		if(tipo == 1 || tipo == 3){
			$('#bloco_lista_concessionaria article[data-tipo='+tipo+']').removeClass('hide');
			$('#bloco_lista_concessionaria article[data-tipo=4]').removeClass('hide');
		}else {
			$('#bloco_lista_concessionaria article').removeClass('hide');
		}
		return false;
	});

	// Endereços
	$('#but_automoveis_endereco').click(function(){
		$('#bloco_automovel_endereco').css('display', 'flex')
		.animate({opacity:0}, 0)
		.animate({opacity:1}, 300);
		$('body').css('overflow-y', 'hidden');
	});
	var automovel_endereco_fechar = function(){
		$('#bloco_automovel_endereco').css('display', 'flex')
		.animate({opacity:0}, 300, function(){
			$('body').css('overflow-y', 'auto');
			$(this).hide();
		});
	};
	$('#bloco_automovel_endereco').click(function(e){
		if($(e.target).attr('id') == 'bloco_automovel_endereco') automovel_endereco_fechar();
	});
	$('#bloco_automovel_endereco i.fechar').click(function(){
		automovel_endereco_fechar();
	});

	// Modelo
	$('.but_automovel_modelo').click(function(){
		$('#bloco_automovel_mascara').css('display', 'flex')
		.animate({opacity:0}, 0)
		.animate({opacity:1}, 300);
		$('body').css('overflow-y', 'hidden');

		var li = $(this).closest('li');
		var modelo = $('p.titulo_sub', li).text();
		var valor = $('p.valor span:eq(1)', li).text();

		var modelo_link = modelo.replace(/\//g, '-').replace(/\ /g, '+');

		$('#form_declaracao input[name=modelo]').val(modelo);
		$('#but_voucher').attr('href', $('#but_voucher').attr('data-href') + modelo_link);

		$('#bloco_automovel_mascara header p').text(modelo);
		$('#bloco_automovel_mascara .valor').text(valor);

		return false;
	});
	var automovel_mascara_fechar = function(){
		$('#bloco_automovel_mascara')
		.animate({opacity:0}, 300, function(){
			$('body').css('overflow-y', 'auto');
			$(this).hide();
		});
	};
	$('#bloco_automovel_mascara').click(function(e){
		if($(e.target).attr('id') == 'bloco_automovel_mascara') automovel_mascara_fechar();
	});
	$('#bloco_automovel_mascara .fechar').click(function(){
		automovel_mascara_fechar();
	});

	/**
	 * CARROS
	 */
	$('.but_carro').click(function(){
		if($(this).hasClass('hover')){
			$('.but_carro').show();
			$(this).removeClass('hover');
			$('#form_declaracao input[name=modelo]').val('');
		}else {
			$('#form_declaracao input[name=modelo]').val($(this).attr('data-modelo'));
			$('.but_carro').hide();
			$(this).show();
			$(this).addClass('hover');
		}
		return false;
	});
	$('#but_carro_voucher').click(function(){
		var modelo = $('#form_declaracao input[name=modelo]').val();
		if(modelo == ''){
			$.alerta({
				titulo:'Escolha um modelo',
				texto:'Para gerar seu documento clique em um dos modelos.'
			});
			return false;
		}else {
			$(this).attr('href', $(this).attr('data-href')+'/'+modelo.replace(/ /g, '-'));
		}
	});
	$('#but_declaracao').click(function(){
		if(!$(this).hasClass('but_forca_atualizacao')){
			var form = $('#form_declaracao');
			var botao = $('span', this);
			var link = form.attr('action');

			var dados = form_dados(form);

			botao.text('AGUARDE');
			if(SISTEMA != 'qa'){
				$.loading('show');
			}

			$.post(link, {
				ajax:true,
				dados:dados
			}, function(resposta){
				if(resposta.erro == true){
					$.alerta({
						titulo:resposta.titulo,
						texto:resposta.texto,
					});
				}else if(resposta.erro == false){
					$.alerta({
						titulo:'Solicitação enviada com sucesso!',
						texto:'A declaração será encaminhada para seu e-mail após assinatura do documento.',
					});
					if($('#bloco_automovel_mascara').length > 0){
						$('#bloco_automovel_mascara').click();
					}
				}else {
					$.alerta({
						titulo:'Erro no envio!',
						texto:'Ocorreu um erro ao enviar sua declaração, por favor, tente novamente.',
					});
				}
				botao.text('SOLICITAR DECLARAÇÃO');
				$.loading('hide');

			}, 'json');
			return false;
		}
	});



	/**
	 * BANCORBRAS
	 */
	$('#but_cadastro_bancorbras').click(function(){
		var form = $(this).closest('form');
		var nome = $('input[name=nome]', form).val();
		var cpf = $('input[name=cpf]', form).val();
		var nascimento = $('input[name=nascimento]', form).val();
		var foneres = $('input[name=foneres]', form).val();
		var fonecel = $('input[name=fonecel]', form).val();
		var cep = $('input[name=cep]', form).val();
		var endereco = $('input[name=endereco]', form).val();
		var botao = $('span', this);
		var link = form.attr('action');

		var dados = form_dados(form);

		botao.text('AGUARDE');
		if(SISTEMA != 'qa'){
			$.loading('show');
		}

		$.post(link, {
            nome:nome,
            cpf:cpf,
            nascimento:nascimento,
            foneres:foneres,
            fonecel:fonecel,
            cep:cep,
            endereco:endereco
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto,
				});
			}else if(resposta.erro == false){
				window.location.assign(resposta.link);
			}else {
				$.alerta({
					titulo:'Erro no cadastro!',
					texto:'Ocorreu um erro, por favor, tente novamente.',
				});
			}
			botao.text('CADASTRAR');
			$.loading('hide');

		}, 'json');
		return false;
	});


	// MENSAGEM IMOVEL
	$('.but_mensagem_imovel').click(function(){
		var imovel = $(this).attr('data-imovel');
		var link = $(this).attr('data-link');
		var botao = $(this);

		botao.text('Aguarde');
		if(SISTEMA != 'qa'){
			$.loading('show');
		}

		var dados = {
			tipo:2,
			imovel:imovel
		};

		$.post(link, {
			ajax:true,
			dados:dados
		}, function(resposta){
			if(resposta.erro == false){
				$.alerta({
					titulo:'Enviado!',
					texto:'Em breve retornaremos o contato..'
				});
			}else {
				$.alerta({
					titulo:'Erro na solicitação!',
					texto:'Ocorreu um erro, por favor, tente novamente.',
				});
			}
			botao.text('Solicitar Contato');
			$.loading('hide');
		}, 'json');
		return false;
	});

	/**
	 * ENQUETE
	 */
	 $('body').on('click', '.pergunta input[name=navegar]', function(){
 		if($('input[name=navegar]:checked').val() == "1"){
			$('#explicacao').hide();
		}else{
			$('#explicacao').show();
		}

 	});
	/**
	 * ENQUETE PESQUISA DE SATISFAÇÃO
	 */
	$('body').on("click", "#but_enquete", function(){
		var form = $(this).closest('form');
		var navegar = $('input[name=navegar]', form).val();
		var problema = $('textarea[name=problema]', form).val() || "";
		var procura = $('input[name=procura]', form).val();
		var suporte = $('input[name=suporte]', form).val();
		var comentario = $('textarea[name=comentario]', form).val();
		var atendimento = $('input[name=atendimento]', form).val();
		var sistemas = [];
		$("input[name='sistemas']:checked").each(function(i) {
		    sistemas.push($(this).val());
		});
		var botao = $('span', this);
		var link = form.attr('action');

		var dados = form_dados(form);

		botao.text('AGUARDE');
		if(SISTEMA != 'qa'){
			$.loading('show');
		}

		$.post(link, {
			navegar:navegar,
			problema:problema,
			procura:procura,
			suporte:suporte,
			comentario:comentario,
			atendimento:atendimento,
			sistemas:sistemas
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto,
				});
			}else if(resposta.erro == false){
				$.alerta({
					titulo:'Feedback realizado!',
					texto:'Obrigado pelo seu feedback. Sua resposta será analizada para melhorias do seu clube.',
				});
				$("#plugins_pagina_fechar").click();
			}else {
				$.alerta({
					titulo:'Erro no cadastro!',
					texto:'Ocorreu um erro, por favor, tente novamente.',
				});
			}
			botao.text('CADASTRAR');
			$.loading('hide');

		}, 'json');
		return false;
	});

	$(".voucher_combustivel").click(function(){
		var voucher = $(this).attr('data-voucher');
		if(voucher == 1){
			$.alerta({
				'titulo':'Atenção!',
				'texto':'Você não poderá gerar outro voucher!',
				'confirmar':'voucher_combustivel_confirmar'
			});
		}
	});

	$('body').on('click', '#voucher_combustivel_confirmar', function(){
		$('.voucher_combustivel').attr('data-voucher', 2);
		window.open(LINK+"/combustivel/voucher", "_blank");

	});

	/**
	 * VOUCHER MANUAL
	**/
	$('#bloco_voucher_manual .bloco_botao .botao').click(function(){
		var id = $(this).attr('data-id');
		$('#bloco_voucher_manual .bloco_botao .botao').removeClass('hover');
		$(this).addClass('hover');
		$('#bloco_voucher_manual form').hide();
		$(id).css('display', 'flex');
	});

	$('#bloco_voucher_manual form button').click(function(){
			var form = $(this).closest('form');

			var tipo = $('input[name=tipo]', form).val();
			var nome = $('input[name=nome]', form).val();
			var email = $('input[name=email]', form).val() || '';
			var celular = $('input[name=celular]', form).val() || '';
			var parentesco = $('select[name=parentesco]', form).val() || '';
			var documento = $('input[name=documento]', form).val() || '';

			var erro = false;
			var erro_titulo = '';
			var erro_texto = '';
			if(tipo == 2 && parentesco == ''){
				erro = true;
				erro_titulo = 'Campo obrigatório!';
				erro_texto = 'Escolha o grau de parentesco do seu dependente.';
			}else if((tipo == 1 || tipo == 2) && nome == ''){
				erro = true;
				erro_titulo = 'Campo obrigatório!';
				erro_texto = 'O campo nome é obrigatório.';
			}else if(tipo == 1 && email == ''){
				erro = true;
				erro_titulo = 'Campo obrigatório!';
				erro_texto = 'O campo e-mail é obrigatório.';
			}else if(tipo == 1 && celular == ''){
				erro = true;
				erro_titulo = 'Campo obrigatório!';
				erro_texto = 'O campo celular é obrigatório.';
			}

			if(erro == true){
				$.alerta({
					titulo:erro_titulo,
					texto:erro_texto
				});
				return false;
			}
	});

	$(".simulacao_seguro").click(function(){
		var form = $(this).closest("form");
		var link = $(form).attr("data-post");
		var tipo = $('select[name=tipo]', form).val();
		var plano = $('select[name=plano]', form).val();
		var nascimento = $('input[name=nascimento]', form).val();

		$.post(link, {
			tipo:tipo,
			plano:plano,
			nascimento:nascimento
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo: resposta.titulo,
					texto: resposta.texto
				});
				return false;
			}else{
				$('.valor_final').show();
				$('input[name=valor]', form).val(resposta.valor);
				$('.valor_final').html(resposta.real);
			}
		}, 'json');
		return false;
	});

	$("ul.beneficiario div.add").click(function(){
		$(".campo_beneficiario").append('<ul class="beneficiario lista"><li class="texto border_cor"><input class="border_cor" type="text" name="beneficiario" placeholder="Nome do(a) Beneficiário"></li><li class="texto border_cor"><input class="border_cor" type="number" name="porcentagem" placeholder="0"></li><li class="texto border_cor"><input class="border_cor" type="text" name="parentesco" placeholder="grau"></li><li class="texto border_cor"></li></ul>');
	});

	/**
	 * SISTEMA DE PEGAR DADOS DE FORMULARIO
	**/
    var form_dados_geral = function(form, falso){
        var dados = {};
		$('*[name]', form).each(function(i){
			var nome = $(this).attr('name');

			if($(this).attr('type') == 'checkbox'){
				if(dados[nome] == undefined && !$(this).is(':checked')){
					dados[nome] = [];
				}else if(dados[nome] == undefined && $(this).is(':checked')){
					dados[nome] = Array($(this).val());
				}else if($.isArray(dados[nome]) && $(this).is(':checked')){
					dados[nome].push($(this).val());
				}
            }else if($(this).attr('type') == 'radio'){
				if(dados[nome] == undefined && !$(this).is(':checked')){
					dados[nome] = "";
				}else if($(this).is(':checked')){
					dados[nome] = $(this).val();
				}
			}else if($(this).attr('data-array') == '1'){
                if(dados[nome] == undefined){
					dados[nome] = Array($(this).val());
				}else if($.isArray(dados[nome])){
					dados[nome].push($(this).val());
				}
			}else {
                var valor;
                if(falso == true){
    				if($(this).attr('data-editor') == 1) valor = tinyMCE.get(nome).getContent();
                    else valor = $(this).val();
    				dados[nome] = valor;
                }else if(false == false && $(this).attr('data-falso') == undefined){
                    if($(this).attr('data-editor') == 1) valor = tinyMCE.get(nome).getContent();
                    else valor = $(this).val();
    				dados[nome] = valor;
                }
			}
		});
        return dados;
    };

    /**
	 * SISTEMA DE SEGUROS
	**/
	$('body').on('click', '#but_add_seguros', function(){
		var form = $('#but_add_seguros').closest("form");
		var link = form.attr('action');

        var dados = form_dados_geral(form);

		var beneficiario = {};

		var nome_objeto, numero_linha, valor_1, valor_2, valor_3, campo;
		$('ul.beneficiario.lista', form).each(function(i){
			valor_1 = $('input[name=beneficiario]', this).val();
			valor_2 = $('input[name=porcentagem]', this).val();
			valor_3 = $('input[name=parentesco]', this).val();
			numero_linha = i+1;

			if(valor_1 != '' || valor_2 != '' || valor_3 != ''){

				if(valor_1 == ''){
					campo = "beneficiário";
				}else if(valor_2 == ''){
					campo = "participação";
				}else if(valor_3 == ''){
					campo = "grau de parentesco";
				}
				nome_objeto = 'beneficionario_'+i;
				beneficiario[nome_objeto] = {};
				beneficiario[nome_objeto].nome = valor_1;
				beneficiario[nome_objeto].participacao = valor_2;
				beneficiario[nome_objeto].parentesco = valor_3;
			}
		});
		if(campo != undefined){
			$.alerta({
				titulo: 'Campo beneficiário obrigatório',
				texto: 'Preencha o campo '+campo+' da linha '+numero_linha+'.'
			});
			return false;
		}

        $.loading('show');

		$.post(link, {
			dados:dados,
			beneficiario:beneficiario
		}, function(resposta){
			if(resposta.erro == false){
				window.location.replace(LINK + "/seguros/formulario_print/" + resposta.id);
			}else if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}else {
			}
			$.loading('hide');
		}, 'json');
		return false;
	});


	var seguros = function(mensagem, form){
	   if(mensagem.erro == false){
		   $.post(LINK+'/seguros/post_proposta', {
			   arquivo:mensagem.arquivo
		   }, function(resposta){
			   if(resposta.erro == true){
				   $.loading('hide');
				   $('i', form).removeClass('hide');
				   $('i.loading', form).addClass('hide');
				   $.alerta({
					   titulo:resposta.titulo,
					   texto:resposta.texto
				   });
			   }else if(resposta.erro == false){
				   $(".input_seguros_upload span").html("PROPOSTA ENVIADA");
				   $.alerta({
					   titulo:"Proposta enviada!",
					   texto:"Sua proposta foi enviada com sucesso! Agora é só aguardar o nosso retorno."
				   });
			   }
		   }, 'json');
	   }else if(mensagem.erro == true){
		   $.loading('hide');
		   $('i', form).removeClass('hide');
		   $('i.loading', form).addClass('hide');

		   $.alerta({
			   titulo:mensagem.titulo,
			   texto:mensagem.texto
		   });
	   }
	};


	$('.input_seguros_upload input[name=arquivo]').change(function(){
		$.loading('show');
		if(!$(this).hasClass('but_forca_atualizacao')){
			var form = $(this).closest('form');
			var link  = form.attr('action');

			var dados = new FormData();
			dados.append('arquivo', $('input[type=file]', form).prop('files')[0]);
			dados.append('diretorio', 'seguros');

			$('i', form).removeClass('hide');
			$('i.icone', form).addClass('hide');
			if(SISTEMA != 'qa'){
				$.loading('show');
			}

			$.ajax({
				url: link,
				data: dados,
				type: 'post',
				dataType : "json",
				success: function(resposta){
					seguros(resposta, form);
					$.loading('hide');
				},
				error: function(resposta){
					seguros(resposta, form);
					$.loading('hide');
				},
				processData: false,
				cache: false,
				contentType: false
			});
			$.loading('hide');
		}
	});


	/**
	 * FUNN FESTIVAL
	**/
	// Clique para saber se ganhou ingresso
	$('#but_ingresso_gratuito_funnfestival').click(function(){
		var cod = $(this).attr('data-cod');

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		$.post(LINK+'/convenios/post-funnfestival-gratis', {
			cod:cod,
			ajax: true
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}else if(resposta.erro == false){
				$('body').append('<div id="bloco_funnfestival_gratis"></div>');
				$('#bloco_funnfestival_gratis').load(LINK+'/convenios/funnfestival_100', {codigo:resposta.codigo});
			}
			$.loading('hide');
		}, 'json');
		return false;
	});

	$("p.bt_impressao").click(function(){
		window.print();
	});
	// Coloca a class hover no botão clicado
	$('body').on('click', '#bloco_funnfestival_gratis .botao button', function(){
		$('#bloco_funnfestival_gratis .botao button').removeClass('bg_cor').removeClass('hover');
		$(this).addClass('bg_cor').addClass('hover');
	});

	// Abre formulário para enviar para um dependente
	$('body').on('click', '#but_funnfestival_form', function(){
		$('#form_funnfestival_dependente').css('display', 'flex');
	});

	// Fecha o formulário se estiver aberto
	$('body').on('click', '#but_funnfestival_uso_pessoal', function(){
		$('#form_funnfestival_dependente').hide();
		$('#bloco_funnfestival_gratis').load(LINK+'/convenios/funnfestival-atencao');
	});

	// Envia os dados se o cupom for para um dependente
	$('body').on('click', '#form_funnfestival_dependente button', function(){
		var form = $(this).closest('form');
		var link = form.attr('action');

		var cod = $('input[name=cod]', form).val();
		var nome = $('input[name=nome]', form).val();
		var documento = $('input[name=documento]', form).val();
		var email = $('input[name=email]', form).val();
		var telefone = $('input[name=telefone]', form).val();

		if(SISTEMA != 'qa'){
			$.loading('show');
		}
		$.post(link, {
			ajax:true,
			cod:cod,
			nome:nome,
			documento:documento,
			email:email,
			telefone:telefone
		}, function(resposta){
			if(resposta.erro == true){
				$.alerta({
					titulo:resposta.titulo,
					texto:resposta.texto
				});
			}else if(resposta.erro == false){
				$('#bloco_funnfestival_gratis').load(LINK+'/convenios/funnfestival-atencao');
			}
			$.loading('hide');
		}, 'json');
		return false;
	});
	// Fechar o bloco da funn festival
	$('body').on('click', '#but_funnfestival_fechar', function(){
		$('#bloco_funnfestival_gratis').remove();
		return false;
	});

});
