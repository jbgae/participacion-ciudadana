/**
 *
 * @author jbgae_000
 */
$(document).ready(function(){
    var marcadorR = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorR.gif";
    var marcadorV = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorV.gif";
    var marcadorAm = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorAm.gif";
    var marcadorAz = "http://emplea.zz.mu/participacion_ciudadana/css/images/marcadorAz.gif";
    var image;
    var href = document.URL;
    href = href.slice(0, -5);
    href= href.substr(href.lastIndexOf('/') + 1);
    
    $.post("http://localhost/participacion_ciudadana/incidenteAjax/"+href,{ }, function(item){
        
        map = new GMaps({
            div: '#mapaIncidente',
            lat: 36.191361199999996,
            lng: -5.9168119,
            zoom:17,
            disableDefaultUI: true,
            zoomControl: true
        }); 
        
        if(item != "El incidente indicado no existe actualmente"){
            item = JSON.parse(item);
            image = marcadorR;

            if(item.IdEstado === "1"){
                image = marcadorV;
            }
            else if(item.IdEstado === "2"){
                image = marcadorAm;
            }
            
            if (item.latitud != undefined && item.longitud != undefined) {
                markers_data = [];
                markers_data.push({
                    lat : item.latitud,
                    lng : item.longitud,
                    title : item.descripcion,
                    icon: image,
                    infoWindow: {
                        content:"<p>"+item.descripcion+"</p>"
                    }
                });
                map.addMarkers(markers_data);
                map.setCenter(item.latitud, item.longitud);
            }
            
        }
    });
});


