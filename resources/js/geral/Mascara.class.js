$(function(){
	$("*[data-mascara=dinheiro]").maskMoney({
        symbol:'R$ ',
        showSymbol:false,
        thousands:'.',
        decimal:',',
        symbolStay: true
    });

	function pegarTamanhoMascara(mascara){
		
		let tipo = mascara.attr('data-mascara');
		
		let tamanhoMinimo = tipo.length;
		let tamanhoMaximo = tipo.length;

		if(mascara.attr('data-mascara-tamanho') != undefined){
			let tamanhoSplit = mascara.attr('data-mascara-tamanho').split(',');
			tamanhoMinimo = tamanhoSplit[0] || tamanhoMinimo;
			tamanhoMaximo = tamanhoSplit[1] || tamanhoSplit[0] || tamanhoMaximo;
		}else if(tipo == 'cep'){
			tamanhoMinimo = 9;
			tamanhoMaximo = 9;
		}else if(tipo == 'telefone'){
			tamanhoMinimo = 14;
			tamanhoMaximo = 15;
		}else if(tipo == 'numero' || tipo == 'numero_espaco' || tipo == 'letra'){
			tamanhoMinimo = '*';
			tamanhoMaximo = '*';
		}

		return [tamanhoMinimo, tamanhoMaximo];

	}

	$('body').on('focus', '*[data-mascara]', function(e){

		$(this).removeClass('mascara_input_erro');

	});
	$('body').on('blur', '*[data-mascara]', function(e){
		let mascara = $(this).attr('data-mascara');
		if(
			mascara == 'dinheiro' ||
			mascara == 'numero' ||
			mascara == 'numero_espaco' ||
			mascara == 'letra' ||
			mascara == 'telefone' ||
			mascara == 'cep'
		){
			return true;
		}

		let valorDigitado = $(this).val();
		let tamanhoValor = valorDigitado.length;

		let tamanhoMascara = pegarTamanhoMascara($(this));

		if((tamanhoMascara[0] != '*' && tamanhoValor < tamanhoMascara[0]) || (tamanhoMascara[1] != '*' && tamanhoValor > tamanhoMascara[1])){
			$(this).val('');
			$(this).addClass('mascara_input_erro');
		}


	});

	$('body').on('keydown', '*[data-mascara]', function(e){
		
		let valorDigitado = $(this).val();
		let tipoMascara = $(this).attr('data-mascara');
		let tamanhoValor = valorDigitado.length;

		if(tipoMascara == 'dinheiro'){
			return true;
		}
		
		let tamanhoMascara = pegarTamanhoMascara($(this))[1];

		let objetoSelecionado = document.getSelection();
		let textoSelecionado = objetoSelecionado.toString() || '';

		let teclaApertada = e.which;

		let teclaGeral = new Array(8,9,16,17,18,27,33,34,35,36,37,38,39,40,46,173,112,113,114,115,116,117,118,119,120,121,122,123);
		let teclaCtrl = new Array(65,67,86,88,90);
		
		let teclaLetra = new Array();
		let teclaNumero = new Array();

		for(x=65;x<=90;x++){
			teclaLetra.push(x);
		}
		for(x=48;x<=57;x++){
			teclaNumero.push(x);
		}
		for(x=96;x<=105;x++){
			teclaNumero.push(x);
		}

		if(
			($.inArray(teclaApertada, teclaGeral) != -1) ||
			(e.ctrlKey || e.metaKey)
		){
			return true;
		}else if(tamanhoMascara != '*' && tamanhoValor >= tamanhoMascara && textoSelecionado == ''){
			return false;
		}
		
		if(tipoMascara == 'numero'){
			if(
				($.inArray(teclaApertada, teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada, teclaCtrl) != -1)) ||
				($.inArray(teclaApertada, teclaNumero) != -1)
			){
				return true;
			}else {
				return false;
			}
		}else if(tipoMascara == 'numero_espaco'){
			if(
				($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)) ||
				($.inArray(teclaApertada,teclaNumero) != -1 || teclaApertada == 32)
			){
				return true;
			}else {
				return false;
			}
		}else if(tipoMascara == 'letra'){
			if(
				($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)) ||
				($.inArray(teclaApertada,key_letra) != -1)
			){
				return true;
			}else {
				return false;
			}
		}else if(tipoMascara == 'telefone'){
			if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
				return true;
			}else if($.inArray(teclaApertada,teclaNumero) != -1){
				if(valorDigitado.length == 0) $(this).val('(');
				if(valorDigitado.length == 3) $(this).val(valorDigitado+') ');
				if(valorDigitado[5] != 9 && valorDigitado.length == 9) $(this).val(valorDigitado+'-');
				if(valorDigitado[5] == 9 && valorDigitado.length == 10) $(this).val(valorDigitado+'-');
				if(valorDigitado[5] != 9 && valorDigitado.length == 14) return false;
				if(valorDigitado[5] == 9 && valorDigitado.length == 15) return false;

				return true;
			}else {
				return false;
			}
		}else if(tipoMascara == 'cep'){
			if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
				return true;
			}else if($.inArray(teclaApertada,teclaNumero) != -1){
				if(valorDigitado.length == 5) $(this).val(valorDigitado+'-');
				if(valorDigitado.length == 9) return false;

				return true;
			}else {
				return false;
			}
		}else {
			let letra = tipoMascara[tamanhoValor];

			if(letra == '0'){
				if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
					return true;
				}else if($.inArray(teclaApertada,teclaNumero) != -1){
					return true;
				}else {
					return false;
				}
			}else if(letra == 'a' || letra == 'A'){
				if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
					return true;
				}else if($.inArray(teclaApertada,key_letra) != -1){
					return true;
				}else {
					return false;
				}
			}else {
				let letra_proxima = tipoMascara[tamanhoValor+1];
				if(letra_proxima == '0'){
					if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
						return true;
					}else if($.inArray(teclaApertada,teclaNumero) != -1){
						$(this).val($(this).val()+letra);
						return true;
					}else {
						return false;
					}
				}else if(letra_proxima == 'a' || letra_proxima == 'A'){
					if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
						return true;
					}else if($.inArray(teclaApertada,key_letra) != -1){
						$(this).val($(this).val()+letra);
						return true;
					}else {
						return false;
					}
				}else {
					if($.inArray(teclaApertada,teclaGeral) != -1 || ((e.ctrlKey || e.metaKey) && $.inArray(teclaApertada,teclaCtrl) != -1)){
						return true;
					}else {
						return false;
					}
				}
			}
		}
	});
});

/**
 * PLUGIN DA MASCARA DE DINHEIRO
 */
!function(a){a.browser||(a.browser={},a.browser.mozilla=/mozilla/.test(navigator.userAgent.toLowerCase())&&!/webkit/.test(navigator.userAgent.toLowerCase()),a.browser.webkit=/webkit/.test(navigator.userAgent.toLowerCase()),a.browser.opera=/opera/.test(navigator.userAgent.toLowerCase()),a.browser.msie=/msie/.test(navigator.userAgent.toLowerCase()));var b={destroy:function(){var b=a(this);return b.unbind(".maskMoney"),a.browser.msie?this.onpaste=null:a.browser.mozilla&&this.removeEventListener("input",blurEvent,!1),this},mask:function(){return this.trigger("mask")},init:function(b){return b=a.extend({symbol:"US$",showSymbol:!1,symbolStay:!1,thousands:",",decimal:".",precision:2,defaultZero:!0,allowZero:!1,allowNegative:!1},b),this.each(function(){function e(){d=!0}function f(){d=!1}function g(b){b=b||window.event;var g=b.which||b.charCode||b.keyCode;if(void 0==g)return!1;if(g<48||g>57)return 45==g?(e(),c.val(q(c)),!1):43==g?(e(),c.val(c.val().replace("-","")),!1):13==g||9==g?(d&&(f(),a(this).change()),!0):!(!a.browser.mozilla||37!=g&&39!=g||0!=b.charCode)||(k(b),!0);if(c.val().length>=c.attr("maxlength"))return!1;k(b);var h=String.fromCharCode(g),i=c.get(0),j=s(i),m=j.start,n=j.end;return i.value=i.value.substring(0,m)+h+i.value.substring(n,i.value.length),l(i,m+1),e(),!1}function h(b){b=b||window.event;var g=b.which||b.charCode||b.keyCode;if(void 0==g)return!1;var h=c.get(0),i=s(h),j=i.start,m=i.end;return 8==g?(k(b),j==m?(h.value=h.value.substring(0,j-1)+h.value.substring(m,h.value.length),j-=1):h.value=h.value.substring(0,j)+h.value.substring(m,h.value.length),l(h,j),e(),!1):9==g?(d&&(a(this).change(),f()),!0):46!=g&&63272!=g||(k(b),h.selectionStart==h.selectionEnd?h.value=h.value.substring(0,j)+h.value.substring(m+1,h.value.length):h.value=h.value.substring(0,j)+h.value.substring(m,h.value.length),l(h,j),e(),!1)}function i(a){var d=o();if(c.val()==d?c.val(""):""==c.val()&&b.defaultZero?c.val(p(d)):c.val(p(c.val())),this.createTextRange){var e=this.createTextRange();e.collapse(!1),e.select()}}function j(d){a.browser.msie&&g(d),""==c.val()||c.val()==p(o())||c.val()==b.symbol?b.allowZero?b.symbolStay?c.val(p(o())):c.val(o()):c.val(""):b.symbolStay?b.symbolStay&&c.val()==b.symbol&&c.val(p(o())):c.val(c.val().replace(b.symbol,""))}function k(a){a.preventDefault?a.preventDefault():a.returnValue=!1}function l(a,b){var d=c.val().length;c.val(n(a.value));var e=c.val().length;b-=d-e,r(c,b)}function m(){var a=c.val();c.val(n(a))}function n(a){a=a.replace(b.symbol,"");var c="0123456789",d=a.length,e="",f="",g="";if(0!=d&&"-"==a.charAt(0)&&(a=a.replace("-",""),b.allowNegative&&(g="-")),0==d){if(!b.defaultZero)return f;f="0.00"}for(var h=0;h<d&&("0"==a.charAt(h)||a.charAt(h)==b.decimal);h++);for(;h<d;h++)c.indexOf(a.charAt(h))!=-1&&(e+=a.charAt(h));var i=parseFloat(e);i=isNaN(i)?0:i/Math.pow(10,b.precision),f=i.toFixed(b.precision),h=0==b.precision?0:1;var j,k=(f=f.split("."))[h].substr(0,b.precision);for(j=(f=f[0]).length;(j-=3)>=1;)f=f.substr(0,j)+b.thousands+f.substr(j);return p(b.precision>0?g+f+b.decimal+k+Array(b.precision+1-k.length).join(0):g+f)}function o(){var a=parseFloat("0")/Math.pow(10,b.precision);return a.toFixed(b.precision).replace(new RegExp("\\.","g"),b.decimal)}function p(a){if(b.showSymbol){var c="";0!=a.length&&"-"==a.charAt(0)&&(a=a.replace("-",""),c="-"),a.substr(0,b.symbol.length)!=b.symbol&&(a=c+b.symbol+a)}return a}function q(a){if(b.allowNegative){a.val();return""!=a.val()&&"-"==a.val().charAt(0)?a.val().replace("-",""):"-"+a.val()}return a.val()}function r(b,c){return a(b).each(function(a,b){if(b.setSelectionRange)b.focus(),b.setSelectionRange(c,c);else if(b.createTextRange){var d=b.createTextRange();d.collapse(!0),d.moveEnd("character",c),d.moveStart("character",c),d.select()}}),this}function s(a){var d,e,f,g,h,b=0,c=0;return"number"==typeof a.selectionStart&&"number"==typeof a.selectionEnd?(b=a.selectionStart,c=a.selectionEnd):(e=document.selection.createRange(),e&&e.parentElement()==a&&(g=a.value.length,d=a.value.replace(/\r\n/g,"\n"),f=a.createTextRange(),f.moveToBookmark(e.getBookmark()),h=a.createTextRange(),h.collapse(!1),f.compareEndPoints("StartToEnd",h)>-1?b=c=g:(b=-f.moveStart("character",-g),b+=d.slice(0,b).split("\n").length-1,f.compareEndPoints("EndToEnd",h)>-1?c=g:(c=-f.moveEnd("character",-g),c+=d.slice(0,c).split("\n").length-1)))),{start:b,end:c}}var c=a(this),d=!1;c.attr("readonly")||(c.unbind(".maskMoney"),c.bind("keypress.maskMoney",g),c.bind("keydown.maskMoney",h),c.bind("blur.maskMoney",j),c.bind("focus.maskMoney",i),c.bind("mask.maskMoney",m))})}};a.fn.maskMoney=function(c){return b[c]?b[c].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof c&&c?void a.error("Method "+c+" does not exist on jQuery.tooltip"):b.init.apply(this,arguments)}}(jQuery);