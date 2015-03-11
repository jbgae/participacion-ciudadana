/**
 *
 * @author jbgae_000
 */
var map;
var tableId1 = 1; // Reparadas
var tableId2 = 2; // En proceso
var tableId3 = 3;//Rechazadas

var layer1 = new google.maps.FusionTablesLayer(tableId1);
var layer2 = new google.maps.FusionTablesLayer(tableId2);
var layer3 = new google.maps.FusionTablesLayer(tableId3);


$(document).on('click', '.pan-to-marker', function(e) {
    e.preventDefault();

    var position, lat, lng, $index;

    $index = $(this).data('marker-index');

    position = map.markers[$index].getPosition();

    lat = position.lat();
    lng = position.lng();

    map.setCenter(lat, lng);
});

$(document).ready(function(){

    var marcadorR = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorR.gif";
    var marcadorV = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorV.gif";
    var marcadorAm = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorAm.gif";
    var marcadorAz = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorAz.gif";
    var image;

    map = new GMaps({
        div: '#mapa_incidentes',
        lat: 36.191361199999996,
        lng: -5.9168119,
        zoom:15,
        disableDefaultUI: true,
        zoomControl: true
    });

    map.on('marker_added', function (marker) {
        var index = map.markers.indexOf(marker);
        $('#results').append('<li><a href="#" class="pan-to-marker" data-marker-index="' + index + '">' + marker.title + '</a></li>');

        if (index == map.markers.length - 1) {
            map.fitZoom();
        }   
    });

    map.addControl({
        position: 'top_right',
        content: '<div id="checkboxes"><form><input type="checkbox" value="1" id="Reparadas" onClick="mostrado(this.value);" >Reparadas</input><br /><input type="checkbox" value="2" id="En_proceso" onClick="mostrado(this.value);">En proceso</input><br /><input type="checkbox" value="3" id="Rechazada" onClick="mostrado(this.value);">Rechazada</input><br /></form></div>',

        style: {
            margin: '5px',
            padding: '1px 6px',
            border: 'solid 1px #717B87',
            background: '#fff'
        }
    });

    

    $.post("http://localhost/participacion_ciudadana/incidente/historialMapaAjax",{ }, function(res){
        markers_data = [];
        if(res.length > 0){
            for(var i = 0; i < res.length; i++){
                var item = res[i];
                image = marcadorR;

                if(item.IdEstado === "1"){
                    image = marcadorV;
                }
                else if(item.IdEstado === "2"){
                    image = marcadorAm;
                }
                if (item.latitud != undefined && item.longitud != undefined) {
                    markers_data.push({
                        lat : item.latitud,
                        lng : item.longitud,
                        title : item.descripcion,
                        icon: image,
                        infoWindow: {
                            content:"<p>"+item.descripcion+"</p>"
                        }
                    });
                }
            }
        }
        map.addMarkers(markers_data);
    },"json");

});


function mostrado(tableidselections) {
    if (tableidselections == 1){
        if (document.getElementById("Reparadas").checked == true) {
            alert('entra');
        }
        if (document.getElementById("Reparadas").checked == false) {
            alert('no pulsado 1');/*layersetoff*/
        }
    }

    if (tableidselections == 2){
        if (document.getElementById("En_proceso").checked == true) {
            alert('entra2');
        }
        if (document.getElementById("En_proceso").checked == false) {
            alert('no pulsado 2'); /*layersetoff*/
        }
    }

    if (tableidselections == 3){
        if (document.getElementById("Rechazada").checked == true) {
            alert('entra3');
        }

        if (document.getElementById("Rechazada").checked == false) {
            alert('no pulsado 3'); /*layersetoff*/
        }
    }

}