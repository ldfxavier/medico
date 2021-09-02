var googlemaps = {};

googlemaps.mapa = null;
googlemaps.markers = [];

googlemaps.iniciar = function(latitude, longitude) {
    var latlng = new google.maps.LatLng(latitude, longitude);
    var options = {
        scrollwheel: false,
        zoom: 14,
        center: latlng,
        disableDefaultUI: true,
        panControl: false,
        zoomControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    googlemaps.mapa = new google.maps.Map(document.getElementById('mapa_convenio'), options);

    var lat_lng = new google.maps.LatLng(latitude, longitude);
    var icone = new google.maps.MarkerImage($('#LINK').val()+'/images/mapa_icone.png', new google.maps.Size(32, 32));

    var marker = new google.maps.Marker({
        'position': lat_lng,
        'icon': icone
    });
    marker.setMap(googlemaps.mapa);
};
$(window).load(function(){
    if($('#mapa_convenio').size() == 1){
        var latitude = $('#but_escolher_endereco').attr('data-latitude');
        var longitude = $('#but_escolher_endereco').attr('data-longitude');
        google.maps.event.addDomListener(window, 'load', googlemaps.iniciar(latitude, longitude));
    }
});

$('#bloco_endereco_lista ul li.lista').click(function(){
    $('#bloco_endereco_lista').stop()
    .animate({opacity:0}, 300, function(){
        $(this).hide();
        $('body').css('overflow-y', 'auto');
    });

    var latitude = $(this).attr('data-latitude');
    var longitude = $(this).attr('data-longitude');
    var texto = $('.endereco_texto', this).text();

    $('#but_escolher_endereco').attr('data-latitude', texto);
    $('#but_escolher_endereco').attr('data-longitude', longitude);
    $('#but_escolher_endereco span').text(texto);

    $('#but_como_chegar').attr('href', 'https://www.google.com.br/maps/dir//'+latitude+', '+longitude);

    googlemaps.iniciar(latitude, longitude);
});
