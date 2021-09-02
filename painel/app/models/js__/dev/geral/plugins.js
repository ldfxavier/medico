$(function(){
    MOBILE = $('#MOBILE').val() ? true : false;
    if(MOBILE){

    }

    $.password();
    $.textarea();
    $.ajuda();
    $.mascara();
    $("*[data-mascara=dinheiro]").maskMoney({
        symbol:'R$ ',
        showSymbol:false,
        thousands:'.',
        decimal:',',
        symbolStay: true
    });

    /**
     * JUNTA O PROTOCOLO E A URL
     */
    $('body').on('change', '.input_url_geral select, .input_url_geral input[type=url]', function(){
        var bloco = $(this).closest('.input_url_geral');
        $('input:eq(0)', bloco).val($('select', bloco).val()+$('input[type=url]', bloco).val());
    });
    /**
     * MUDA A MASCARA DO INPUT DO DOCUMENTO
     */
    $('.input_documento_geral select').change(function(){
        var bloco = $(this).closest('.input_documento_geral');
        $('input', bloco).attr({
            'data-mascara':$(this).find(':selected').attr('data-mascara'),
            'placeholder':$(this).find(':selected').attr('data-placeholder')
        });
        $('input', bloco).val('');
    });
    /**
     * MUDA O STATUS DO BOTAO BOOLEANO
     */
    $('body').on('click', '.input_booleano_geral', function(){
		if($(this).hasClass('but_admin')) return false;

        if($(this).hasClass('ativo')){
            $(this).addClass('inativo');
            $(this).removeClass('ativo');
            $('input', this).val(2);
        }else {
            $(this).addClass('ativo');
            $(this).removeClass('inativo');
            $('input', this).val(1);
        }
    });

    /**
     * TRAVAR TAMANHO DO INPUT
     */
    var input_tamanho = function(atual, tamanho, input){
        if($('#plugins_input_tamanho').size() == 1) $('#plugins_input_tamanho').remove();

        $('body').append('<div id="plugins_input_tamanho">'+atual+' de '+tamanho+' caracteres</div>');
        $('#plugins_input_tamanho').css({
            'top':input.offset().top+parseFloat(input.css('height'))+parseFloat(input.css('padding-top'))+parseFloat(input.css('padding-bottom'))+parseFloat(input.css('border-top-width'))+parseFloat(input.css('border-bottom-width')),
            'left':input.offset().left
        });
    }
    $(document).scroll(function(){
        //if($('#plugins_input_tamanho').size() == 1) $('#plugins_input_tamanho').remove();
    });
    $('body').on('focus', 'input[data-tamanho]', function(){
        var tamanho = $(this).attr('data-tamanho');
        var atual = $(this).val().length;
        $(this).attr('maxlength', tamanho);

        input_tamanho(atual, tamanho, $(this));
    });
    $('body').on('blur', 'input[data-tamanho]', function(){
        $('#plugins_input_tamanho').remove();
    });
    $('body').on('keyup', 'input[data-tamanho]', function(){
        var tamanho = $(this).attr('data-tamanho');
        var atual = $(this).val().length;

        input_tamanho(atual, tamanho, $(this));
    });

    /**
     * INPUT TIPO COR
     */
    $('body').on('click', '.input_cor_geral .botao_cor', function(){
        var id = 'div_'+Math.round(Math.random()*1000000);
        $(this).closest('.input_cor_geral').attr('data-cor-id', id);

        $('#bloco_cor_mascara').remove();
        $('body').append('<div id="bloco_cor_mascara" data-cor-id="'+id+'"><ul class="conteudo_cor"><li class="cor_titulo">ESCOLHA UMA COR<i class="but_cor_fechar" data-font="&#xe813;"></i></li><li class="but_cor_selecionar" data-cor="#E05D6F" style="background: #E05D6F"></li><li class="but_cor_selecionar" data-cor="#16A085" style="background: #16A085"></li><li class="but_cor_selecionar" data-cor="#FFA500" style="background: #FFA500"></li><li class="but_cor_selecionar" data-cor="#FF1493" style="background: #FF1493"></li><li class="but_cor_selecionar" data-cor="#00A7F6" style="background: #00A7F6"></li><li class="but_cor_selecionar" data-cor="#F0AD4E" style="background: #F0AD4E"></li><li class="but_cor_selecionar" data-cor="#8B4513" style="background: #8B4513"></li><li class="cor_linha"></li><li class="but_cor_selecionar" data-cor="#CCCCCC" style="background: #CCCCCC"></li><li class="but_cor_selecionar" data-cor="#666666" style="background: #666666"></li><li class="but_cor_selecionar" data-cor="#000000" style="background: #000000"></li><li class="but_cor_selecionar" data-cor="#FFCCCC" style="background: #FFCCCC"></li><li class="but_cor_selecionar" data-cor="#FF0000" style="background: #FF0000"></li><li class="but_cor_selecionar" data-cor="#660000" style="background: #660000"></li><li class="but_cor_selecionar" data-cor="#FFCC33" style="background: #FFCC33"></li><li class="but_cor_selecionar" data-cor="#FF6600" style="background: #FF6600"></li><li class="but_cor_selecionar" data-cor="#993300" style="background: #993300"></li><li class="but_cor_selecionar" data-cor="#FFFFCC" style="background: #FFFFCC"></li><li class="but_cor_selecionar" data-cor="#FFFF00" style="background: #FFFF00"></li><li class="but_cor_selecionar" data-cor="#999900" style="background: #999900"></li><li class="but_cor_selecionar" data-cor="#99FF99" style="background: #99FF99"></li><li class="but_cor_selecionar" data-cor="#33ff33" style="background: #33ff33"></li><li class="but_cor_selecionar" data-cor="#009900" style="background: #009900"></li><li class="but_cor_selecionar" data-cor="#003300" style="background: #003300"></li><li class="but_cor_selecionar" data-cor="#66FFFF" style="background: #66FFFF"></li><li class="but_cor_selecionar" data-cor="#33CCFF" style="background: #33CCFF"></li><li class="but_cor_selecionar" data-cor="#3366FF" style="background: #3366FF"></li><li class="but_cor_selecionar" data-cor="#000099" style="background: #000099"></li><li class="but_cor_selecionar" data-cor="#FFCCFF" style="background: #FFCCFF"></li><li class="but_cor_selecionar" data-cor="#FF99FF" style="background: #FF99FF"></li><li class="but_cor_selecionar" data-cor="#CC33CC" style="background: #CC33CC"></li><li class="but_cor_selecionar" data-cor="#663366" style="background: #663366"></li><li class="but_cor_selecionar" data-cor="#330033" style="background: #330033"></li><li class="but_cor_selecionar" data-cor="#5C4033" style="background: #5C4033"></li><li class="but_cor_selecionar" data-cor="#D19275" style="background: #D19275"></li><li class="but_cor_selecionar" data-cor="#7FFF00" style="background: #7FFF00"></li></ul></div>');

        return false;
    });
    $('body').on('click', '#bloco_cor_mascara  li i', function(){
        $('#bloco_cor_mascara').remove();
    });
    $('body').on('click', '#bloco_cor_mascara', function(e){
        if($(e.target).attr('id') == 'bloco_cor_mascara') $('#bloco_cor_mascara').remove();
    });
    $('body').on('click', '#bloco_cor_mascara li.but_cor_selecionar', function(){
        var cor = $(this).attr('data-cor');
        var id = $('#bloco_cor_mascara').attr('data-cor-id');
        $('.input_cor_geral[data-cor-id='+id+'] input').val(cor);
        $('.input_cor_geral[data-cor-id='+id+'] .botao_cor').css('background-color', cor);

        $('#bloco_cor_mascara').remove();
    });
    $('body').on('keyup', '.input_cor_geral input', function(){
        var div = $(this).closest('.input_cor_geral');
        var valor = $(this).val();

        var primeira_letra = valor[0];
        if(primeira_letra != '#') $(this).val('#'+valor);

        if(valor.length == 7) $('.botao_cor', div).css('background-color', valor);
        else  $('.botao_cor', div).css('background-color', '#CCCCCC');
    });
    $('body').on('blur', '.input_cor_geral input', function(){
        var valor = $(this).val();

        if(valor.length != 7) $(this).val('');
    });
});

(function($){

    $.mapa = function(options){
        var settings = {
            id:'',
            latitude:'',
            longitude:'',
            zoom:14,
            scroll:false,
            icone:'',
            draggable:false,
            input_latitude:'',
            input_longitude:'',
            como_chegar:''
        }

        if(options){
            $.extend(settings, options);
        }

        var googlemaps = {};

        googlemaps.mapa = null;
        googlemaps.markers = [];

        googlemaps.iniciar = function(mapa_id, mapa_latitude, mapa_longitude, mapa_zoom, mapa_scroll, mapa_icone, mapa_draggable, input_latitude, input_longitude, como_chegar) {
            var latlng = new google.maps.LatLng(mapa_latitude, mapa_longitude);
            var options = {
                scrollwheel: mapa_scroll,
                zoom: mapa_zoom,
                center: latlng,
                disableDefaultUI: true,
                panControl: false,
                zoomControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            googlemaps.mapa = new google.maps.Map(document.getElementById(mapa_id), options);

            var lat_lng = new google.maps.LatLng(mapa_latitude, mapa_longitude);
            var icone = new google.maps.MarkerImage(mapa_icone, new google.maps.Size(32, 32));

            if(mapa_icone != ''){
                var marker = new google.maps.Marker({
                    'position': lat_lng,
                    'icon': icone,
                    'draggable' : mapa_draggable
                });
                marker.setMap(googlemaps.mapa);

                if(mapa_draggable == true){
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        var ponto_latitude = this.getPosition().lat();
                        var ponto_longitude = this.getPosition().lng();
                        if(input_latitude != '') $(input_latitude).val(ponto_latitude);
                        if(input_longitude != '') $(input_longitude).val(ponto_longitude);

                        if(como_chegar != '') $(como_chegar).attr('href', 'https://www.google.com.br/maps/dir//'+ponto_latitude+', '+ponto_longitude);
                    });
                }
            }
        };

        google.maps.event.addDomListener(window, 'load', googlemaps.iniciar(settings.id, settings.latitude, settings.longitude, settings.zoom, settings.scroll, settings.icone, settings.draggable, settings.input_latitude, settings.input_longitude, settings.como_chegar));
    }

    $.ajuda = function(options){

		if (options) {
			$.extend(settings, options);
		};

		$('body').on({
			mouseenter: function(){
				var html = $(this).attr('data-ajuda');
				if(html != ''){
					$('#plugins_ajuda').remove();
					$('body').append('<div id="plugins_ajuda"></div>');
					$('#plugins_ajuda').html(html);

					var scroll_top = $(document).scrollTop();
					var width = $(window).width();
					var height = $(window).height();

					var help_width = $('#plugins_ajuda').width()+parseFloat($('#plugins_ajuda').css('padding-left'))+parseFloat($('#plugins_ajuda').css('padding-right'))+parseFloat($('#plugins_ajuda').css('border-left-width'))+parseFloat($('#plugins_ajuda').css('border-right-width'));
					var div_width = $(this).width()+parseFloat($(this).css('padding-left'))+parseFloat($(this).css('padding-right'))+parseFloat($(this).css('border-left-width'))+parseFloat($(this).css('border-right-width'));
					var help_left = 0;
					var div_left = $(this).offset().left;

					if(div_width >= help_width) help_left = div_left+((div_width-help_width)/2);
					else if(div_width < help_width) help_left = div_left-((help_width-div_width)/2);

					if(help_left < 0) help_left = 0;

					$('#plugins_ajuda').css({
						left:help_left
					});

					var help_height = $('#plugins_ajuda').height()+parseFloat($('#plugins_ajuda').css('padding-top'))+parseFloat($('#plugins_ajuda').css('padding-bottom'))+parseFloat($('#plugins_ajuda').css('border-top-width'))+parseFloat($('#plugins_ajuda').css('border-bottom-width'));
					var div_height = $(this).height()+parseFloat($(this).css('padding-top'))+parseFloat($(this).css('padding-bottom'))+parseFloat($(this).css('border-top-width'))+parseFloat($(this).css('border-bottom-width'));
					var help_top = 0;
					var div_top = $(this).offset().top;

					var real_top = div_top-scroll_top;
					if(real_top > (height/2)){
						help_top = div_top-help_height-5;
					}else {
						help_top = div_top+div_height+5;
					}

					$('#plugins_ajuda').css({
						top:help_top,
					});
				}
			},
			mouseleave: function(){
				$('#plugins_ajuda').remove();
			}
		}, '*[data-ajuda]');

	}

    $.password = function(){
        $('body').on('click', '.but_password_visualizar', function(){
            var div = $(this).closest('.input_password_geral');
            if($('input', div).attr('type') == 'password'){
                $('input', div).attr('type', 'text');
                $(this).attr('data-password', 'inativo');
            }else {
                $('input', div).attr('type', 'password');
                $(this).attr('data-password', 'ativo');
            }
            $('input:first', div).focus();
        });

        $('body').on('keyup', '.input_password_geral input', function(){
            var div = $(this).closest('.input_password_geral');
            if($('input', div).size() == 2){
                var valor_1 = $('input:eq(0)', div).val()
                var valor_2 = $('input:eq(1)', div).val()
                if(valor_1 != '' && valor_1 == valor_2){
                    $('.bloco_verificar', div).addClass('correto');
                    $('.bloco_verificar', div).removeClass('incorreto');
                }else {
                    $('.bloco_verificar', div).removeClass('correto');
                    $('.bloco_verificar', div).addClass('incorreto');
                }
            }
        });
    }

    $.isData = function(valor){
        var retorno = true;
        if(valor == '' || valor == undefined) return false;

        var data = valor.replace(/[^0-9]/g,'');
        if((data) && $.isNumeric(data) && valor.length == 10 && (data != '')){
            var dia = data.substring(0,2);
            var mes = data.substring(2,4);
            var ano = data.substring(4,8);

            if(dia > 31){
                returno = false;
            }else if((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia > 30){
                retorno = false;
            }else if((ano % 4) != 0 && mes == 2 && dia > 28){
                retorno = false;
            }else if((ano%4) == 0 && mes == 2 && dia > 29){
                retorno = false;
            }
        }else{
            retorno = false;
        }
        return retorno;
    }

    $.isDataHora = function(valor){
        var retorno = true;
        if(valor == '' || valor == undefined) return false;

        var data = valor.replace(/[^0-9]/g,'');
        if((data) && $.isNumeric(data) && valor.length == 19 && (data != '')){
            var dia = data.substring(0,2);
            var mes = data.substring(2,4);
            var ano = data.substring(4,8);
            var hora = data.substring(8,10);
            var minuto = data.substring(10,12);
            var segundo = data.substring(12,14);

            if(dia > 31){
                returno = false;
            }else if((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia > 30){
                retorno = false;
            }else if((ano % 4) != 0 && mes == 2 && dia > 28){
                retorno = false;
            }else if((ano%4) == 0 && mes == 2 && dia > 29){
                retorno = false;
            }

            if(hora > 23 || minuto > 59 || segundo > 59) return false;
        }else{
            retorno = false;
        }
        return retorno;
    }
    $.isHora = function(valor){
        var retorno = true;
        if(valor == '' || valor == undefined) return false;

        var data = valor.replace(/[^0-9]/g,'');

        if((data) && $.isNumeric(data) && valor.length == 8 && (data != '')){
            var hora = data.substring(0,2);
            var minuto = data.substring(2,4);
            var segundo = data.substring(4,6);

            if(hora > 23 || minuto > 59 || segundo > 59) return false;
        }else{
            retorno = false;
        }
        return retorno;
    }

    $.textarea = function(options){
        var settings = {
            id:'.textarea_editor',
            height:350,
            barra: 'pequeno'
        }

        if(options){
            $.extend(settings, options);
        }

        if(settings.barra == 'completa'){
            var barra = 'undo redo | bold italic | removeformat | forecolor backcolor | blockquote | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink | image media table | codesample code fullscreen';
        }else if(settings.barra == 'normal'){
            var barra = 'undo redo | bold italic | removeformat | forecolor backcolor | blockquote | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink | image media'
        }else {
            var barra = 'bold italic | removeformat | link unlink'
        }

        // tinymce.init({
        //     selector: settings.id,
        //     height: settings.height,
        //     resize: false,
        //     menubar: false,
        //     statusbar: false,
        //     language:'pt_BR',
        //     plugins: [
        //         'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        //         'searchreplace wordcount visualblocks visualchars code fullscreen',
        //         'insertdatetime media nonbreaking save table contextmenu directionality',
        //         'template paste textcolor colorpicker textpattern imagetools codesample toc'
        //     ],
        //     paste_as_text: true,
        //     toolbar1: barra,
        // });
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

    /**
     * PLUGIN PARA LOADING
     */
    $.loading = function(posicao){
        if(posicao == 'show'){
            $('#plugins_loading').remove();
            $('body').append('<div id="plugins_loading"><span></span><span></span><span></span><span></span></div>');
        }else {
    		$('#plugins_loading').remove();
        }
	}

    /**
     * PLUGIN DE PÁGINA AJAX
     */
    $.pagina = function(options){
        var settings = {
            botao: null,
			attr: null,
            fechar:true,
            fechar_botao:false,
            fechar_mascara:true,
            fechar_tecla:true,
            scroll:false
		};

		if(options){
			$.extend(settings, options);
		};

        function pagina_abrir(botao, novo, dados){
            if(settings.fechar_mascara == true){
                $('#plugins_pagina').attr('data-fecharmascara', 'fechar');
            }else {
                $('#plugins_pagina').removeAttr('data-fecharmascara');
            }
            if(settings.fechar_tecla == true){
                $('#plugins_pagina').attr('data-fechartecla', 'fechar');
            }else {
                $('#plugins_pagina').removeAttr('data-fechartecla');
            }
            $.loading('show');
            if(settings.scroll == false) $('body').css('overflow-y', 'hidden');

            if(novo == true){
                if($('#plugins_pagina_fechar').size() == 1){
                    $('#plugins_pagina_fechar').stop().animate({opacity:0}, 500, function(){
                        $(this).hide();
                    });
                }

                $('#plugins_pagina_conteudo').stop()
                .animate({
                    top:-300,
                    opacity:0
                }, 300, function(){
                    $('#plugins_pagina_conteudo').html('');
                    $('#plugins_pagina_conteudo').load(botao.attr(settings.attr), {
						ajax:true,
                        dados:dados
					}, function(){
                        $.loading('hide');
                        if(settings.fechar == true) $('#plugins_pagina_fechar').show().stop().animate({opacity:1}, 500);
                        $('#plugins_pagina_conteudo').stop()
                        .animate({
                            'margin-top':0,
                            opacity:1
                        }, 500);
                    });
                });
            }else {
                $('#plugins_pagina').show().stop()
                .animate({opacity:1}, 500);
                $('#plugins_pagina_conteudo').load(botao.attr(settings.attr), {
					ajax:true,
                    dados:dados
				}, function(){
                    $.loading('hide');
                    if(settings.fechar == true) $('#plugins_pagina_fechar').show().stop().animate({opacity:1}, 500);
                    $('#plugins_pagina_conteudo').css('display', 'flex').stop()
                    .animate({
                        'margin-top':0,
                        opacity:1
                    }, 500);
                });
            }

            if(MOBILE){
                var url_atual = location.href;
                if(url_atual.indexOf('#paginamobile') == -1){
                    url_atual = url_atual+'#paginamobile';
                    window.history.pushState({url: url_atual}, 'paginamobile' , url_atual);
                }
            }
        }

        $('body').on('click', settings.botao, function(){
            var botao = $(this);
            var data_post = botao.attr('data-post') || '';
            if(data_post != '') data_post = data_post.split(',');
            var dados = new Object;
            if(data_post){
                data_post.forEach(function(nome){
                    dados[nome] = botao.attr('data-'+nome) || '';
                });
            }

            if($('#plugins_pagina').size() == 1){
                pagina_abrir($(this), true, dados);
            }else {
                $('body').append('<div id="plugins_pagina"></div>');
                $('#plugins_pagina').append('<div id="plugins_pagina_conteudo" class="plugins_pagina_conteudo"></div>');
                if(settings.fechar == true){
                    $('#plugins_pagina').append('<div id="plugins_pagina_fechar"></div>');
                }
                pagina_abrir($(this), false, dados);
            }
            return false;
        });

        function fechar(){
            $('#plugins_pagina').stop().animate({
                opacity:0
            }, 500, function(){
				$('body').css('overflow-y', 'auto');
                $(this).remove();
                if(MOBILE){
                    var url_atual = location.href;
                    if(url_atual.indexOf('#paginamobile') != -1){
                        history.go(-1);
                    }
                }
            });
            $('#plugins_pagina_conteudo').stop().animate({
                opacity:0,
                'margin-top':-300
            }, 500, function(){
                $(this).remove();
            });
            if($('#plugins_pagina_fechar').size() == 1){
                $('#plugins_pagina_fechar').stop().animate({
                    opacity:0
                }, 500, function(){
                    $(this).remove();
                });
            }
        }

        if(settings.fechar_botao != ''){
            $('body').on('click', settings.fechar_botao, function(){
                fechar();
                return false;
            });
        }
        $('body').on('click', '#plugins_pagina, #plugins_pagina_conteudo', function(e){
            if($('#plugins_pagina').attr('data-fecharmascara') == 'fechar'){
                if($(e.target).attr('id') == 'plugins_pagina' || $(e.target).attr('id') == 'plugins_pagina_conteudo') fechar();
            }
		});
        $('body').on('click', '#plugins_pagina_fechar', function(){
            fechar();
            return false;
        });
		$('body').on('keydown', function(e){
            if($('#plugins_pagina').attr('data-fechartecla') == 'fechar'){
    			var codigo = e.keyCode;
    			if(codigo == 27 && $('#plugins_pagina').is(':visible')){
                    fechar();
                }
            }
		});

        if(MOBILE){
            window.onhashchange = function() {
                var url_atual = window.location.href;
                if(url_atual.indexOf('#paginamobile') == -1 && $('#plugins_pagina').size() == 1){
                    fechar();
                }
            }
        }
    }

    /**
     * PLUGIN DE ALERTA
     */
     $.alerta = function(options){
 		var settings = {
 			titulo: '',
 			texto: '',
            notificacao: '',
            confirmar: false,
 			href: false,
 		};

 		if(options){
 			$.extend(settings, options);
 		};

 		if($('#plugins_alerta_conteudo').size() > 0 && settings.notificacao == ''){
            fechar_alerta();
 			return false;
 		}

        if(settings.notificacao != ''){
            abrir_notificacao();
        }else if(settings.confirmar != ''){
            $('body').append('<div id="plugins_alerta"></div>');
            $('#plugins_alerta').append('<div id="plugins_alerta_conteudo"><div class="plugins_alerta_titulo">'+settings.titulo+'</div><div class="plugins_alerta_texto">'+settings.texto+'</div><div class="plugins_alerta_footer"><div class="plugins_alerta_botao plugins_alerta_cancelar">CANCELAR</div><div id="'+settings.confirmar+'" class="plugins_alerta_botao">CONFIRMAR</div></div></div>');
            abrir_alerta();
        }else {
            $('body').append('<div id="plugins_alerta"></div>');
            $('#plugins_alerta').append('<div id="plugins_alerta_conteudo"><div class="plugins_alerta_titulo">'+settings.titulo+'</div><div class="plugins_alerta_texto">'+settings.texto+'</div><div class="plugins_alerta_footer"><div class="plugins_alerta_botao">OK</div></div></div>');
            abrir_alerta();
        }

        function abrir_notificacao(){
            var numero = Math.round(Math.random()*1000000);
            if($('#plugins_alerta_notificacao').size() == 1){
                $('#plugins_alerta_notificacao').stop().css('display', 'flex')
     			.animate({top: -100, opacity:0}, 300, function(){
     				$('#plugins_alerta_notificacao').remove();
                    $('body').append('<div id="plugins_alerta_notificacao" data-temporizador="'+numero+'"><div class="plugins_alerta_texto">'+settings.notificacao+'</div><div class="plugins_alerta_botao">OK</div></div>');
                    $('#plugins_alerta_notificacao').stop().css('display', 'flex')
         			.animate({top: -100, opacity:0}, 0)
                    .animate({top: 10, opacity: 1}, 300);
     			});
            }else {
                $('body').append('<div id="plugins_alerta_notificacao" data-temporizador="'+numero+'"><div class="plugins_alerta_texto">'+settings.notificacao+'</div><div class="plugins_alerta_botao">OK</div></div>');

                $('#plugins_alerta_notificacao').stop().css('display', 'flex')
     			.animate({top: -100, opacity:0}, 0)
                .animate({top: 10, opacity: 1}, 300);
            }
            setTimeout(function(){
                if($('#plugins_alerta_notificacao[data-temporizador='+numero+']').size() == 1){
                    $('#plugins_alerta_notificacao[data-temporizador='+numero+']').stop().css('display', 'flex')
         			.animate({top: -100, opacity:0}, 300, function(){
         				$(this).remove();
         			});
                }
            }, 10000);
        }

        $('body').on('mouseover', '#plugins_alerta_notificacao', function(){
            $('#plugins_alerta_notificacao').removeAttr('data-temporizador');
        });
        $('body').on('mouseout', '#plugins_alerta_notificacao', function(){
            var numero = Math.round(Math.random()*1000000);
            $('#plugins_alerta_notificacao').attr('data-temporizador', numero);
            setTimeout(function(){
                $('#plugins_alerta_notificacao[data-temporizador='+numero+']').stop().css('display', 'flex')
     			.animate({top: -100, opacity:0}, 300, function(){
     				$(this).remove();
     			});
            }, 10000);
        });

        function fechar_notificacao(){
            $('#plugins_alerta_notificacao').stop().css('display', 'flex')
 			.animate({top: -100, opacity:0}, 300, function(){
 				$(this).remove();
 			});
            if(settings.href == 'refresh'){
                $.loading('show');
                window.location.reload();
            }else if(settings.href != false){
                $.loading('show');
                window.location.replace(settings.href);
            }
        }

        function abrir_alerta(){
     		$('#plugins_alerta').css('display', 'flex').stop()
     		.animate({opacity:0}, 0)
            .animate({opacity:1}, 300);

     		$('#plugins_alerta_conteudo').css('display', 'flex').stop()
     		.animate({top: -100, opacity:0}, 0)
     		.animate({top: 20, opacity:1}, 300);

            if(MOBILE){
                var url_atual = location.href;
                if(url_atual.indexOf('#alertamobile') == -1){
                    url_atual = url_atual+'#alertamobile';
                    window.history.pushState({url: url_atual}, 'alertamobile' , url_atual);
                }
            }
        }
 		function fechar_alerta(){
 			$('#plugins_alerta').css('display', 'flex').stop()
 			.animate({opacity:0}, 300, function(){
                $(this).remove();
            });

 			$('#plugins_alerta_conteudo').css('display', 'flex').stop()
 			.animate({top: -100, opacity:0},300, function(){
 				$(this).remove();
                if(settings.href == 'refresh'){
                    $.loading('show');
                    window.location.reload();
                }else if(settings.href != false){
                    $.loading('show');
                    window.location.replace(settings.href);
                }
                if(MOBILE && settings.href == ''){
                    var url_atual = location.href;
                    if(url_atual.indexOf('#alertamobile') != -1){
                        history.go(-1);
                    }
                }
 			});
 		}

        if(MOBILE){
            window.onhashchange = function() {
                var url_atual = window.location.href;
                if(url_atual.indexOf('#alertamobile') == -1 && $('#plugins_alerta_conteudo').size() == 1){
                    fechar_alerta();
                }
            }
        }

        // Fecha o alerta com o esc ou enter
 		$('body').on('keydown', function(e){
 			if($('#plugins_alerta').size() > 0 && $('#plugins_alerta').is(':visible') && (e.which == 13 || e.which == 27)){
 				fechar_alerta();
 				return false;
 			}else if($('#plugins_alerta_notificacao').size() == 1 && $('#plugins_alerta_notificacao').is(':visible') && (e.which == 13 || e.which == 27)){
                fechar_notificacao();
                return false;
            }
 		});

        // Para a propagação para fechar
 		$('body').on('click', '#plugins_alerta_conteudo, #plugins_alerta_notificacao', function(e){
            e.stopPropagation();
        });
        // Fechar o alerta
 		$('body').on('click', '#plugins_alerta, .plugins_alerta_botao', function(){
 			if($('#plugins_alerta').size() == 1){
                fechar_alerta();
            }else if($('#plugins_alerta_notificacao').size() == 1){
                fechar_notificacao();
            }
 		});
 	}

    /**
     * PLUGIN DE MASCARA
     */
    $.mascara = function(){
        //
		// REMOVE O ERRO DO INPUT COM FOCUS
		$('body').on('focus', 'input', function(){
			$(this).removeClass('input_erro');
		});
		// VERIFICA SE O VALOR DE DATA ESTÁ CORRETO
		$('body').on('blur', 'input[data-mascara=data]', function(){
			er = /^([0-9]{2})\/([0-9]{2})\/[0-9]{4}/;
			er2 = /^([0-9]{4})\-([0-9]{2})\-[0-9]{2}/;
			if(((!er.exec($(this).val()) && !er2.exec($(this).val())) || ($(this).val() == '00/00/0000' || $(this).val() == '0000-00-00'))  && $(this).val() != '') $(this).addClass('input_erro');
		});
        // VERIFICA SE O VALOR DE DATA ESTÁ CORRETO
		$('body').on('blur', 'input[data-mascara=datahora]', function(){
			er = /^([0-9]{2})\/([0-9]{2})\/[0-9]{4}\ [0-9]{2}\:[0-9]{2}\:[0-9]{2}/;
			er2 = /^([0-9]{4})\-([0-9]{2})\-[0-9]{2}\ [0-9]{2}\:[0-9]{2}\:[0-9]{2}/;
			if(((!er.exec($(this).val()) && !er2.exec($(this).val())) || ($(this).val() == '00/00/0000 00:00:00' || $(this).val() == '0000-00-00 00:00:00'))  && $(this).val() != '') $(this).addClass('input_erro');
		});
		// VERIFICA SE O VALOR DE HORA ESTÁ CORRETO
		$('body').on('blur', 'input[data-mascara=hora]', function(){
			var valor = $(this).val();
			er = /^([0-9]{2}):([0-9]{2})/;
			if((!er.exec(valor) && valor != '') || (valor.split(':')[0] > 23 || valor.split(':')[1] > 59)) $(this).addClass('input_erro');
		});
		// VERIFICA SE O VALOR DE E-MAIL ESTÁ CORRETO
		$('body').on('blur', 'input[data-mascara=email]', function(){
			er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}/;
			if(!er.exec($(this).val()) && $(this).val() != '') $(this).addClass('input_erro');
		});
		// REMOVER O PROTOCOLO (HTTP OU HTTPS) DO INPUT
		$('body').on('blur', 'select[data-mascara=http]', function(){
			var valor = $(this).val().replace(/http:\/\//g, '').replace(/https:\/\//g, '');
			$(this).val(valor);
		});
		// VERIFICA SE O VALOR DE URL ESTÁ CORRETO
		$('body').on('blur', 'input[data-mascara=url]', function(){
			er = /^((http|https):\/\/)?([a-z0-9\-]+\.)*[a-z0-9\-]+\.[a-z0-9]{2,4}(\.[a-z0-9]{2,4})?(\/.*)?$/i;
			if(!er.exec($(this).val()) && $(this).val() != '') $(this).addClass('input_erro');
		});

        // MASCARA PARA O INPUT
		$('body').on('keyup', '*[data-mascara]', function(e){

        });
		$('body').on('keydown', '*[data-mascara]', function(e){
			var valor = $(this).val();
			var tipo = $(this).attr('data-mascara');
			var tamanho = tipo.length-1;
			var tamanho_valor = valor.length;

            if(tipo == 'cpf') tipo = '000.000.000-00';
            else if(tipo == 'cnpj') tipo = '00.000.000/0000-00';

			var key_geral = new Array(8,9,16,17,18,27,33,34,35,36,37,38,39,40,46,173,112,113,114,115,116,117,118,119,120,121,122,123);
			var key_ctrl = new Array(65,67,86,88);
			var key_letra = new Array();
			for(x=65;x<=90;x++){
				key_letra.push(x);
			}
			var key_numero = new Array();
			for(x=48;x<=57;x++){
				key_numero.push(x);
			}
			for(x=96;x<=105;x++){
				key_numero.push(x);
			}

			var key_codigo = e.which;
			if(tipo == 'numero'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					return true;
				}else {
					return false;
				}
			}else if(tipo == 'numero_espaco'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if(($.inArray(key_codigo,key_numero) != -1) || key_codigo == 32){
					return true;
				}else {
					return false;
				}
			}else if(tipo == 'letra'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_letra) != -1){
					return true;
				}else {
					return false;
				}
			}else if(tipo == 'data'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor[7] == '-') var data_tipo = 'en';
					else if(valor[2] == '/') var data_tipo = 'br';

					if(valor.length == 2) $(this).val(valor+'/');
					else if(valor.length == 5) $(this).val(valor+'/');
					else if((valor.length == 10 && data_tipo == 'br') || (valor.length == 10 && data_tipo == 'en' && valor[0] > 0)) return false;

					return true;
				}else {
					return false;
				}
            }else if(tipo == 'datahora'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor.length == 2) $(this).val(valor+'/');
					else if(valor.length == 5) $(this).val(valor+'/');
					else if(valor.length == 10) $(this).val(valor+' ');
					else if(valor.length == 13) $(this).val(valor+':');
					else if(valor.length == 16) $(this).val(valor+':');
					else if(valor.length == 19) return false;

					return true;
				}else {
					return false;
				}
			}else if(tipo == 'hora'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor.length == 2) $(this).val(valor+':');
					if(valor.length == 5) $(this).val(valor+':');
					else if(valor.length == 8) return false;

					return true;
				}else {
					return false;
				}
            }else if(tipo == 'celular'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor.length == 0) $(this).val('(');
					if(valor.length == 3) $(this).val(valor+') ');
					if(valor[5] != 9 && valor.length == 9) $(this).val(valor+'-');
					if(valor[5] == 9 && valor.length == 10) $(this).val(valor+'-');
					if(valor[5] != 9 && valor.length == 14) return false;
					if(valor[5] == 9 && valor.length == 15) return false;

					return true;
				}else {
					return false;
				}
            }else if(tipo == 'telefone'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor.length == 0) $(this).val('(');
					if(valor.length == 3) $(this).val(valor+') ');
					if(valor.length == 9) $(this).val(valor+'-');
					if(valor.length == 14) return false;

					return true;
				}else {
					return false;
				}
            }else if(tipo == 'cep'){
				if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else if($.inArray(key_codigo,key_numero) != -1){
					if(valor.length == 5) $(this).val(valor+'-');
					if(valor.length == 9) return false;

					return true;
				}else {
					return false;
				}
            }else if(tipo == 'dinheiro'){
                if((e.ctrlKey || e.metaKey) && key_codigo == 86){
					return false;
				}else if($.inArray(key_codigo,key_geral) != -1 || $.inArray(key_codigo,key_numero) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
					return true;
				}else {
					return false;
				}
			}else {
				var letra = tipo[tamanho_valor];
				var proximo = tipo[tamanho_valor];

				if(letra == '0'){
					if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
						return true;
					}else if($.inArray(key_codigo,key_numero) != -1){
						return true;
					}else {
						return false;
					}
				}else if(letra == 'a' || letra == 'A'){
					if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
						return true;
					}else if($.inArray(key_codigo,key_letra) != -1){
						return true;
					}else {
						return false;
					}
				}else {
					var letra_proxima = tipo[tamanho_valor+1];
					if(letra_proxima == '0'){
						if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
							return true;
						}else if($.inArray(key_codigo,key_numero) != -1){
							$(this).val($(this).val()+letra);
							return true;
						}else {
							return false;
						}
					}else if(letra_proxima == 'a' || letra_proxima == 'A'){
						if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
							return true;
						}else if($.inArray(key_codigo,key_letra) != -1){
							$(this).val($(this).val()+letra);
							return true;
						}else {
							return false;
						}
					}else {
						if($.inArray(key_codigo,key_geral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(key_codigo,key_ctrl) != -1)){
							return true;
						}else {
							return false;
						}
					}
				}
			}
		});
	}

})(jQuery);















/**
 * PLUGIN DA MASCARA DE DINHEIRO
 */
!function(a){a.browser||(a.browser={},a.browser.mozilla=/mozilla/.test(navigator.userAgent.toLowerCase())&&!/webkit/.test(navigator.userAgent.toLowerCase()),a.browser.webkit=/webkit/.test(navigator.userAgent.toLowerCase()),a.browser.opera=/opera/.test(navigator.userAgent.toLowerCase()),a.browser.msie=/msie/.test(navigator.userAgent.toLowerCase()));var b={destroy:function(){var b=a(this);return b.unbind(".maskMoney"),a.browser.msie?this.onpaste=null:a.browser.mozilla&&this.removeEventListener("input",blurEvent,!1),this},mask:function(){return this.trigger("mask")},init:function(b){return b=a.extend({symbol:"US$",showSymbol:!1,symbolStay:!1,thousands:",",decimal:".",precision:2,defaultZero:!0,allowZero:!1,allowNegative:!1},b),this.each(function(){function e(){d=!0}function f(){d=!1}function g(b){b=b||window.event;var g=b.which||b.charCode||b.keyCode;if(void 0==g)return!1;if(g<48||g>57)return 45==g?(e(),c.val(q(c)),!1):43==g?(e(),c.val(c.val().replace("-","")),!1):13==g||9==g?(d&&(f(),a(this).change()),!0):!(!a.browser.mozilla||37!=g&&39!=g||0!=b.charCode)||(k(b),!0);if(c.val().length>=c.attr("maxlength"))return!1;k(b);var h=String.fromCharCode(g),i=c.get(0),j=s(i),m=j.start,n=j.end;return i.value=i.value.substring(0,m)+h+i.value.substring(n,i.value.length),l(i,m+1),e(),!1}function h(b){b=b||window.event;var g=b.which||b.charCode||b.keyCode;if(void 0==g)return!1;var h=c.get(0),i=s(h),j=i.start,m=i.end;return 8==g?(k(b),j==m?(h.value=h.value.substring(0,j-1)+h.value.substring(m,h.value.length),j-=1):h.value=h.value.substring(0,j)+h.value.substring(m,h.value.length),l(h,j),e(),!1):9==g?(d&&(a(this).change(),f()),!0):46!=g&&63272!=g||(k(b),h.selectionStart==h.selectionEnd?h.value=h.value.substring(0,j)+h.value.substring(m+1,h.value.length):h.value=h.value.substring(0,j)+h.value.substring(m,h.value.length),l(h,j),e(),!1)}function i(a){var d=o();if(c.val()==d?c.val(""):""==c.val()&&b.defaultZero?c.val(p(d)):c.val(p(c.val())),this.createTextRange){var e=this.createTextRange();e.collapse(!1),e.select()}}function j(d){a.browser.msie&&g(d),""==c.val()||c.val()==p(o())||c.val()==b.symbol?b.allowZero?b.symbolStay?c.val(p(o())):c.val(o()):c.val(""):b.symbolStay?b.symbolStay&&c.val()==b.symbol&&c.val(p(o())):c.val(c.val().replace(b.symbol,""))}function k(a){a.preventDefault?a.preventDefault():a.returnValue=!1}function l(a,b){var d=c.val().length;c.val(n(a.value));var e=c.val().length;b-=d-e,r(c,b)}function m(){var a=c.val();c.val(n(a))}function n(a){a=a.replace(b.symbol,"");var c="0123456789",d=a.length,e="",f="",g="";if(0!=d&&"-"==a.charAt(0)&&(a=a.replace("-",""),b.allowNegative&&(g="-")),0==d){if(!b.defaultZero)return f;f="0.00"}for(var h=0;h<d&&("0"==a.charAt(h)||a.charAt(h)==b.decimal);h++);for(;h<d;h++)c.indexOf(a.charAt(h))!=-1&&(e+=a.charAt(h));var i=parseFloat(e);i=isNaN(i)?0:i/Math.pow(10,b.precision),f=i.toFixed(b.precision),h=0==b.precision?0:1;var j,k=(f=f.split("."))[h].substr(0,b.precision);for(j=(f=f[0]).length;(j-=3)>=1;)f=f.substr(0,j)+b.thousands+f.substr(j);return p(b.precision>0?g+f+b.decimal+k+Array(b.precision+1-k.length).join(0):g+f)}function o(){var a=parseFloat("0")/Math.pow(10,b.precision);return a.toFixed(b.precision).replace(new RegExp("\\.","g"),b.decimal)}function p(a){if(b.showSymbol){var c="";0!=a.length&&"-"==a.charAt(0)&&(a=a.replace("-",""),c="-"),a.substr(0,b.symbol.length)!=b.symbol&&(a=c+b.symbol+a)}return a}function q(a){if(b.allowNegative){a.val();return""!=a.val()&&"-"==a.val().charAt(0)?a.val().replace("-",""):"-"+a.val()}return a.val()}function r(b,c){return a(b).each(function(a,b){if(b.setSelectionRange)b.focus(),b.setSelectionRange(c,c);else if(b.createTextRange){var d=b.createTextRange();d.collapse(!0),d.moveEnd("character",c),d.moveStart("character",c),d.select()}}),this}function s(a){var d,e,f,g,h,b=0,c=0;return"number"==typeof a.selectionStart&&"number"==typeof a.selectionEnd?(b=a.selectionStart,c=a.selectionEnd):(e=document.selection.createRange(),e&&e.parentElement()==a&&(g=a.value.length,d=a.value.replace(/\r\n/g,"\n"),f=a.createTextRange(),f.moveToBookmark(e.getBookmark()),h=a.createTextRange(),h.collapse(!1),f.compareEndPoints("StartToEnd",h)>-1?b=c=g:(b=-f.moveStart("character",-g),b+=d.slice(0,b).split("\n").length-1,f.compareEndPoints("EndToEnd",h)>-1?c=g:(c=-f.moveEnd("character",-g),c+=d.slice(0,c).split("\n").length-1)))),{start:b,end:c}}var c=a(this),d=!1;c.attr("readonly")||(c.unbind(".maskMoney"),c.bind("keypress.maskMoney",g),c.bind("keydown.maskMoney",h),c.bind("blur.maskMoney",j),c.bind("focus.maskMoney",i),c.bind("mask.maskMoney",m))})}};a.fn.maskMoney=function(c){return b[c]?b[c].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof c&&c?void a.error("Method "+c+" does not exist on jQuery.tooltip"):b.init.apply(this,arguments)}}(jQuery);
