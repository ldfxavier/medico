$(function(){
    MOBILE = $('#MOBILE').val() ? true : false;
    if(MOBILE){

	}

    /**
     * PLUGIN DE GALERIA DE IMAGEM
     */
	$.galeria = function(options){
		var settings = {
			id: null,
			botao:null,
			href:false
		};

		if (options) {
			$.extend(settings, options);
		};

	   // Remove a propagação da imagem
		$(settings.id).on('click', 'img', function(e){
			e.stopPropagation();
			return false;
		});

	   // Ação ao clicar no botao
		$(settings.id+' '+settings.botao).click(function(){
			var botao = $(this);
			var original = $('img', this);
			var acao = botao.hasClass('animacao');
			var quantidade = $(settings.id+' '+settings.botao).size();

			if(!acao && original.size() == 1){
			   var width_botao = botao.width();
				var height_botao = botao.height();
				var width_inicial = original.width();
				var height_inicial = original.height();

			   var height_diferenca = 0;
			   var width_diferenca = 0;

			   var imagem = $('img', this).clone();
			   if(settings.href) imagem.addClass('but_plugins_galeria_a');

			   if(height_inicial > height_botao){
				   height_diferenca = (height_inicial-height_botao)/2;
				   original.css('margin-top', -height_diferenca);
			   }else {
				   original.removeAttr('width');
				   original.attr('height', '100%');
				   width_inicial = original.width();
				   original.removeAttr('height');
				   original.attr('width', width_inicial);
				   width_diferenca = (width_inicial-width_botao)/2;
				   original.css('margin-left', -width_diferenca);
			   }

			   var top = (original.offset().top-$(document).scrollTop());
				var left = original.offset().left;
			   botao.attr('data-galeria', 1);

				$('body').append('<div id="plugins_galeria_mascara"></div>');
				$('body').append(imagem);
				imagem.attr('id', 'plugins_galeria_imagem');
			   imagem.css({
				   'margin-top':'',
				   'margin-left':''
			   });

				imagem.removeAttr('height');
				imagem.removeAttr('width');
				var width_final = imagem.width();
				var height_final = imagem.height();
				if(height_final > ($(window).height()-80)){
					height_final = ($(window).height()-80);
					imagem.attr('height', height_final);
					width_final = imagem.width();
					imagem.removeAttr('height');
				}
				if(MOBILE && width_final > $(window).width()){
					width_final = $(window).width();
					imagem.attr('width', width_final);
					height_final = imagem.height();
					imagem.removeAttr('width');
				}else if(!MOBILE && width_final > ($(window).width()-140)){
					width_final = $(window).width()-140;
					imagem.attr('width', width_final);
					height_final = imagem.height();
					imagem.removeAttr('width');
				}
				imagem.css({
					width:original.width(),
					top:top,
					left:left,
				   opacity:0
				});

				botao.addClass('animacao');
				if(MOBILE) $('body').prepend('<div class="plugins_icon" id="plugins_galeria_fechar_mobile"></div>');
				else $('body').prepend('<div class="plugins_icon" id="plugins_galeria_fechar"></div>');
				if(!MOBILE && quantidade > 1){
					$('body').prepend('<div class="plugins_icon" id="plugins_galeria_prev"></div>');
					$('body').prepend('<div class="plugins_icon" id="plugins_galeria_next"></div>');
				}
				$('#plugins_galeria_mascara').stop().animate({opacity:1});
				imagem.animate({
					top:(($(window).height()-height_final)/2),
					left:(($(window).width()-width_final)/2),
					width:width_final,
				   opacity:1
				}, function(){
					imagem.css({
						width:'100%',
						maxWidth:width_final,
						top:0,
						bottom:0,
						left:0,
						right:0,
						margin:'auto'
					});
				});

				if(MOBILE){
					var url_atual = location.href;
					if(url_atual.indexOf('#galeriamobile') == -1){
						url_atual = url_atual+'#galeriamobile';
						window.history.pushState({url: url_atual}, 'galeriamobile' , url_atual);
					}
				}
			}
		});

		function fechar(){
			var imagem = $('#plugins_galeria_imagem');
			if(imagem.size() == 1){
				var botao = $(settings.id+' '+settings.botao+'[data-galeria=1]');
				var width = $('img', botao).width();
				var top = $('img', botao).offset().top-$(document).scrollTop();
				var left = $('img', botao).offset().left;

				$('#plugins_galeria_mascara').stop().animate({opacity:0}, function(){
					$(this).remove();
				});
				$('#plugins_galeria_fechar, #plugins_galeria_prev, #plugins_galeria_next, #plugins_galeria_fechar_mobile').remove();
				botao.removeAttr('data-galeria');
				botao.removeClass('animacao');

				imagem.css({
					width:imagem.width(),
					maxWidth:'',
					top:imagem.offset().top-$(document).scrollTop(),
					left:imagem.offset().left,
					right:'',
					bottom:'',
					margin:'',
				   opacity:1
				});

				imagem.animate({
					width:width,
					top:top,
					left:left,
				   opacity:0
				}, function(){
					$(this).remove();
				   if(MOBILE){
						var url_atual = location.href;
						if(url_atual.indexOf('#galeriamobile') != -1){
						   history.go(-1);
					   }
					}
				});
			}
		}
		$('body').on('click', '#plugins_galeria_mascara, #plugins_galeria_fechar, #plugins_galeria_fechar_mobile', function(){
			fechar();
		});

		if(MOBILE){
			window.onhashchange = function() {
				var url_atual = window.location.href;
				if(url_atual.indexOf('#galeriamobile') == -1 && $('#plugins_galeria_imagem').size() == 1){
					fechar();
				}
			}

			function resize(){
				if($('#plugins_galeria_imagem').size() == 1){
					var imagem = $('#plugins_galeria_imagem');
					imagem.css({
						'width':'',
						'max-width':''
					});
					imagem.removeAttr('width');
					imagem.removeAttr('height');

					var width_final = imagem.width();
					var height_final = imagem.height();

					if(height_final > ($(window).height()-80)){
						height_final = ($(window).height()-80);
						imagem.attr('height', height_final);
						width_final = imagem.width();
						imagem.removeAttr('height');
					}
					if(MOBILE && width_final > $(window).width()){
						width_final = $(window).width();
						imagem.attr('width', width_final);
						height_final = imagem.height();
						imagem.removeAttr('width');
					}
					imagem.css({
						'width':'100%',
						'max-width':width_final
					});
				}
			}
			window.onresize = resize;
		}

		function rotacao(acao){
			var atual = $('#plugins_galeria_imagem');
			var botao = $(settings.id+' '+settings.botao+'[data-galeria=1]');
			var original = $('img', botao);

			if(acao == 'next' && botao.is(':last-child')){
				var proximo = $(settings.id+' '+settings.botao+':first-child');
			}else if(acao == 'next'){
				var proximo = botao.next();
			}else if(acao == 'prev' && botao.is(':first-child')){
				var proximo = $(settings.id+' '+settings.botao+':last-child');
			}else {
				var proximo = botao.prev();
			}

			var imagem = $('img', proximo).clone();
		   if(settings.href) imagem.addClass('but_plugins_galeria_a');

			$('body').append(imagem);
			imagem.attr('id', 'plugins_galeria_imagem_temp');
			imagem.removeAttr('height');
			imagem.removeAttr('width');
			var width_final = imagem.width();
			var height_final = imagem.height();
			if(height_final > ($(window).height()-80)){
				height_final = ($(window).height()-80);
				imagem.attr('height', height_final);
				width_final = imagem.width();
				imagem.removeAttr('height');
			}
			if(MOBILE && width_final > $(window).width()){
				width_final = $(window).width();
				imagem.attr('width', width_final);
				height_final = imagem.height();
				imagem.removeAttr('width');
			}else if(!MOBILE && width_final > ($(window).width()-140)){
				width_final = $(window).width()-140;
				imagem.attr('width', width_final);
				height_final = imagem.height();
				imagem.removeAttr('width');
			}

			if(acao == 'next'){
				atual_left = atual.offset().left-atual.width();
				proximo_left = atual.offset().left+atual.width();
			}else {
				atual_left = atual.offset().left+atual.width();
				proximo_left = atual.offset().left-atual.width();
			}
			atual.css({
				left:atual.offset().left,
				right:''
			});
			atual.animate({
				opacity:0,
				left:atual_left,
			}, function(){
				$(this).remove();
			});

			imagem.css({
				width:width_final,
				top:0,
				bottom:0,
				margin:'auto',
				left:proximo_left,
				opacity:.3
			});
			imagem.animate({
				left:(($(window).width()-width_final)/2),
				opacity:1
			}, function(){
				imagem.css({
					width:'100%',
					maxWidth:width_final,
					top:0,
					bottom:0,
					left:0,
					right:0,
					margin:'auto'
				});
				$('#plugins_galeria_imagem').remove();
				imagem.removeAttr('id');
				imagem.attr('id','plugins_galeria_imagem');
				proximo.attr('data-galeria','1');
				proximo.addClass('animacao');
				botao.removeAttr('data-galeria');
				botao.removeClass('animacao');
				$('#plugins_galeria_imagem_false').remove();
			});

		}

	   if(settings.href){
		   $('body').on('click', '.but_plugins_galeria_a', function(){
			   $.loading('show');
			   var link = $(this).attr(settings.href);
			   window.location.assign(link);
		   });
	   }

		if(MOBILE){
			$('body').on('swipeleft', '#plugins_galeria_imagem', function(){
				rotacao('next');
			});

			$('body').on('swiperight', '#plugins_galeria_imagem', function(){
				rotacao('prev');
			});
		}else {
			$('body').keyup(function(e){
				var tecla = e.keyCode;
				if(tecla == 27) fechar();
				else if($('#plugins_galeria_imagem').is(':visible') && tecla == 37) rotacao('prev');
				else if($('#plugins_galeria_imagem').is(':visible') && tecla == 39) rotacao('next');
			});
			$('body').on('click', '#plugins_galeria_prev', function(){
				rotacao('prev');
			});
			$('body').on('click', '#plugins_galeria_next', function(){
				rotacao('next');
			});
		}
	}

	/**
     * PLUGIN DE BANNERS
     */
    $.banner = function(options){
		var settings = {
			id: null,
			imagem: null,
			controle: null,
			prev: null,
			next: null,
			barra: null,
			transicao: 0.5,
			rotacao: true,
			tempo: 8
		};

		if (options) {
			$.extend(settings, options);
		};

		var ativo_barra = false;
		if(settings.rotacao == true && settings.barra != undefined && $(settings.barra).size() == 1) ativo_barra = true;
		var ativo_controle = false;
		if(settings.controle != undefined && $(settings.controle).size() == 1) ativo_controle = true;
		var ativo_prev = false;
		if(MOBILE == false && settings.prev != undefined && $(settings.prev).size() == 1) ativo_prev = true;
		var ativo_next = false;
		if(MOBILE == false && settings.next != undefined && $(settings.next).size() == 1) ativo_next = true;


		var tempo = settings.tempo;
		var contador = 1;
		var atual = 0;
		var quantidade = $(settings.id+' '+settings.imagem).length-1;
		var transicao = parseFloat(settings.transicao)*1000;
		function banner(acao){
            if(quantidade < 1) return false;
			if((acao != atual && acao != undefined) || contador == settings.tempo){
				var proximo;
				if(acao == 'prev'){
					proximo = parseInt(atual)-1;
					if(proximo < 0) proximo = quantidade;
				}else if(acao == 'next' || acao == undefined){
					proximo = parseInt(atual)+1;
					if(proximo > quantidade) proximo = 0;
				}else {
					proximo = acao;
				}
				if(MOBILE == false){
					$(settings.id+' '+settings.imagem).stop()
					.animate({opacity:0}, transicao, function(){
						$(this).hide();
					});
					$(settings.id+' '+settings.imagem+':eq('+proximo+')').show().stop()
					.animate({opacity:0}, 0)
					.animate({opacity:1}, transicao);
				}else if(MOBILE == true){
					if(acao == 'prev') left = '-100%';
					else left = '100%';

					$(settings.id+' '+settings.imagem).css('z-index', 1);
					$(settings.id+' '+settings.imagem+':eq('+atual+')').css('z-index', 2);
					$(settings.id+' '+settings.imagem+':eq('+proximo+')').show().stop()
					.css({
						// 'opacity':0,
						'left':left,
						'z-index':3
					})
					.animate({
						// opacity:1,
						left:0
					}, transicao);
				}

				contador = 1
				atual = proximo;
				if(ativo_barra){
					$(settings.barra).css('width', 0);
					barra();
				}
				if(ativo_controle){
					$(settings.controle+' li').removeClass('hover');
					$(settings.controle+' li[data-id='+proximo+']').addClass('hover');
				}
			}else {
				contador++;
			}
		}

		function barra(){
			$(settings.barra).stop().animate({width:'100%'}, parseInt((parseInt(tempo)+1)-contador)*1000);
		}
		if(ativo_barra) barra();

		if(settings.rotacao == true){
			var loading = setInterval(banner, 1000);
			$('body').on('mouseover', settings.id, function(){
				clearInterval(loading);
				if(ativo_barra) $(settings.barra).stop();
			});
			$('body').on('mouseout', settings.id, function(){
				loading = setInterval(banner, 1000);
				if(ativo_barra) barra();
			});
		}

		if(ativo_controle){
			$('body').on('click', settings.controle+' li', function(){
				contador = 1;
				banner($(this).attr('data-id'));
			});
		}

		if(ativo_prev){
			$('body').on('click', settings.prev, function(){
				contador = 1;
				banner('prev');
			});
		}
		if(ativo_next){
			$('body').on('click', settings.next, function(){
				contador = 1;
				banner('next');
			});
		}
		if(MOBILE){
			$(settings.prev+', '+settings.next).hide();
			$(settings.id).on('swipeleft', function(){
				contador = 1;
				banner('next');
			});

			$(settings.id).on('swiperight', function(){
				contador = 1;
				banner('prev');
			});
		}
	}


	var TabBlock = {
		s: {
			animLen: 200
		},

		init: function() {
			TabBlock.bindUIActions();
			TabBlock.hideInactive();
		},

		bindUIActions: function() {
			$('.tabelaCaixa-tabs').on('click', '.tabelaCaixa-titulo p', function(){
				TabBlock.switchTab($(this).closest('.tabelaCaixa-titulo'));
			});
		},

		hideInactive: function() {
			var $tabBlocks = $('.tabelaCaixa');

			$tabBlocks.each(function(i) {
			var
				$tabBlock = $($tabBlocks[i]),
				$panes = $tabBlock.find('.tabelaCaixa-painel'),
				$activeTab = $tabBlock.find('.tabelaCaixa-titulo.is-active');

			$panes.hide();
			$($panes[$activeTab.index()]).show();
			});
		},

		switchTab: function($tab) {
			var $context = $tab.closest('.tabelaCaixa');

			if (!$tab.hasClass('is-active')) {
			$tab.siblings().removeClass('is-active');
			$tab.addClass('is-active');

			TabBlock.showPane($tab.index(), $context);
			}
			},

		showPane: function(i, $context) {
			var $panes = $context.find('.tabelaCaixa-painel');

			$panes.slideUp(TabBlock.s.animLen);
			$($panes[i]).slideDown(TabBlock.s.animLen);
		}
	};

	$(function() {
		TabBlock.init();
	});


});
