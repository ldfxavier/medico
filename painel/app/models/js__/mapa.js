var googlemaps = {};

googlemaps.lista = null;
googlemaps.mapa = null;
googlemaps.markerClusterer = null;
googlemaps.markers = [];
googlemaps.infoWindow = null;

googlemaps.iniciar = function(id, latitude, longitude, zoom, scroll) {
    if(id != undefined){
        var pontos = true;
        if(latitude == undefined){
            latitude = -18.8800397;
            pontos = false;
        }
        if(longitude == undefined) longitude = -47.05878999999999;
        if(zoom == undefined) zoom = 10;
        if(scroll == undefined) scroll = false;

        var latlng = new google.maps.LatLng(latitude, longitude);
        var options = {
            scrollwheel: scroll,
            zoom: zoom,
            center: latlng,
            disableDefaultUI: true,
            panControl: false,
            zoomControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        googlemaps.mapa = new google.maps.Map(document.getElementById(id), options);
        if(pontos) googlemaps.showMarkers(latitude, longitude);
    }
};
$(window).load(function(){
    google.maps.event.addDomListener(window, 'load', googlemaps.iniciar('bloco_mapa_proximo'));
});

googlemaps.showMarkers = function(latitude, longitude){
    var LINK = $('#LINK').val();
    googlemaps.markers = [];

    if (googlemaps.markerClusterer){
        googlemaps.markerClusterer.clearMarkers();
    }

    if(googlemaps.lista){
        googlemaps.infoWindow = new google.maps.InfoWindow();
        google.maps.event.addListener(googlemaps.infoWindow, 'domready', function(){
            var iwOuter = $('.gm-style-iw');
            var iwBackground = iwOuter.prev();
            iwBackground.children(':nth-child(2)').css({'display' : 'none'});
            iwBackground.children(':nth-child(4)').css({'display' : 'none'});
            iwOuter.parent().parent().css({left: '12px', top:'0'});
            iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'display: none !important;'});
            iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'display: none !important;'});
            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

            var iwCloseBtn = iwOuter.next();
            iwCloseBtn.css({
                'width': 20,
                'height': 20,
                'opacity': '1',
                'right': '42px',
                'top': '12px',
                'background': 'url('+LINK+'/images/mapa_fechar.png) no-repeat center center',
                'border-radius': '100%',
            });
            $('img', iwCloseBtn).hide();
            iwCloseBtn.mouseout(function(){
                $(this).css({opacity: '1'});
            });
        });

        var quantidade = googlemaps.lista.length;
        for (var i = 0; i < quantidade; i++) {
            var titulo_texto = googlemaps.lista[i].titulo;
            if (titulo_texto === '') {
                titulo_texto = 'No title';
            }

            var item = document.createElement('DIV');
            var titulo = document.createElement('A');
            titulo.href = googlemaps.lista[i].link;
            titulo.className = 'mapa_titulo';

            item.appendChild(titulo);

            var lat_lng = new google.maps.LatLng(googlemaps.lista[i].latitude, googlemaps.lista[i].longitude);
            var icone = new google.maps.MarkerImage(LINK+'/images/mapa_icone.png', new google.maps.Size(24, 32));

            var marker = new google.maps.Marker({
                'position': lat_lng,
                'icon': icone
            });

            var fn = googlemaps.markerClickFunction(googlemaps.lista[i], lat_lng);
            google.maps.event.addListener(marker, 'click', fn);
            google.maps.event.addDomListener(titulo, 'click', fn);
            googlemaps.markers.push(marker);
        }
        googlemaps.markerClusterer = new MarkerClusterer(googlemaps.mapa, googlemaps.markers, {imagePath: LINK+'/images/mapa_mais_'});
    }

    var usuario_lat_lng = new google.maps.LatLng(latitude, longitude);
    var ususario_icone = new google.maps.MarkerImage(LINK+'/images/mapa_usuario.png', new google.maps.Size(32, 32));

    var usuario_localizacao = new google.maps.Marker({
        'position': usuario_lat_lng,
        'icon': ususario_icone
    });
    usuario_localizacao.setMap(googlemaps.mapa);
    $.loading('hide');
};

googlemaps.markerClickFunction = function(dado, latlng) {
    var LINK = $('#LINK').val();
    return function(e) {
        e.cancelBubble = true;
        e.returnValue = false;
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
        var titulo = dado.titulo;
        var link = dado.link;
        var imagem = dado.imagem;
        var latitude = dado.latitude;
        var longitude = dado.longitude;

        var infoHtml = '<div id="iw-container" class="bloco_mapa_descricao">'+
            '<figure style="background-image: url('+imagem+')"><a class="acessar" href="'+link+'" data-ajuda="Clique para acessar parceiro"></a></figure>'+
            '<a class="rota" href="https://www.google.com.br/maps/dir//'+latitude+', '+longitude+'" target="_blank"><i></i>COMO CHEGAR</a>'+
        '</div>';

        googlemaps.infoWindow.setContent(infoHtml);
        googlemaps.infoWindow.setPosition(latlng);
        googlemaps.infoWindow.open(googlemaps.mapa);
    };
};

function localizacao(){
	if(navigator.geolocation){
		return navigator.geolocation.getCurrentPosition(posicao, erro);
	}else {
        erro_suporte();
    }
}
localizacao();

function posicao(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    $('#form_busca_mapa input[name=latitude]').val(latitude);
    $('#form_busca_mapa input[name=longitude]').val(longitude);
    $('#form_busca_mapa input[name=local]').val('');
    buscar();
}
var busca_pontos = function(link, latitude, longitude, raio){
    $.post(link, {
        latitude:latitude,
        longitude:longitude,
        raio:raio
    }, function(resposta){
        if(resposta.erro == false){
            googlemaps.lista = resposta.lista;
            google.maps.event.addDomListener(window, 'load', googlemaps.iniciar('bloco_mapa_proximo', latitude, longitude, 10, true));
        }else {
            erro_busca();
            mapa_zerar();
        }
        $.loading('hide');
    }, 'json');
}
var buscar = function(){
    $.loading('show');
    $('.erro_busca').hide();
    var LINK = $('#LINK').val();
    var link = $('#form_busca_mapa').attr('action');
    var latitude = $('#form_busca_mapa input[name=latitude]').val();
    var longitude = $('#form_busca_mapa input[name=longitude]').val();
    var local = $('#form_busca_mapa input[name=local]').val();
    var raio = $('#form_busca_mapa select[name=raio]').val();

    if(local != ''){
        $.post(LINK+'/api/geolocalizacao', {
            local:local
        }, function(resposta){
            if(resposta.erro == false){
                $('#form_busca_mapa input[name=latitude]').val(resposta.latitude);
                $('#form_busca_mapa input[name=longitude]').val(resposta.longitude);
                busca_pontos(link, resposta.latitude, resposta.longitude, raio);
            }else {
                $.loading('hide');
                erro_busca();
                mapa_zerar();
            }
        }, 'json');
    }else {
        busca_pontos(link, latitude, longitude, raio);
    }
}

$('body').on('click', '#but_mapa_buscar', function(){
    $('#bloco_convenio_mapa .bloco_erro_permissao').hide();
    if($('#form_busca_mapa input[name=local]').val() == ''){
        $.alerta({
            titulo:'Campo obrigatório!',
            texto:'Digite um local para sua busca.'
        });
    }else {
        buscar();
    }
    return false;
});

var mapa_zerar = function(){
    var latitude = $('#form_busca_mapa input[name=latitude]').val() || -18.8800397;
    var longitude = $('#form_busca_mapa input[name=longitude]').val() || -47.05878999999999;
    google.maps.event.addDomListener(window, 'load', googlemaps.iniciar('bloco_mapa_proximo', latitude, longitude));
}

var erro_busca = function(){
    $('#bloco_convenio_mapa .bloco_erro_permissao').hide();
    $('#erro_busca').show();
}
var erro_suporte = function(){
    console.log('suporte');
}
var erro_localizacao = function(){
    $('#bloco_convenio_mapa .bloco_erro_permissao').hide();
    $('#erro_busca').show();
}
var erro_permissao = function(){
    $('#bloco_convenio_mapa .bloco_erro_permissao').hide();
    $('#erro_permissao').show();
}
var erro_indisponivel = function(){
    console.log('indisponivel');
}
var erro_outros = function(){
    console.log('outros');
}

$('body').on('click', '#but_meu_local', function(){
    localizacao();
    return false;
});

function erro(error){
    $.loading('hide');
	switch(error.code){
		case error.PERMISSION_DENIED:
			erro_permissao();
		break;
		case error.POSITION_UNAVAILABLE:
			erro_indisponivel();
		break;
		case error.TIMEOUT:
			erro_outros();
		break;
		case error.UNKNOWN_ERROR:
			erro_outros();
		break;
	}
}
