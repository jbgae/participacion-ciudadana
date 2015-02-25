/**
 *
 * @author jbgae_000
 */
var map;
$(document).ready(function(){ 
    
   var image = "http://localhost/participacion_ciudadana/css/images/marcadorR.gif";
    
    var map = new GMaps({
        el: '#geolocation_map',
        lat: 36.191361199999996,
        lng: -5.9168119,
        zoom:16,
        disableDefaultUI: true,
        zoomControl: true
    });
    
    GMaps.geolocate({
        success: function(position){
            map.setCenter(position.coords.latitude, position.coords.longitude);
            var ll  = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var m = map.addMarker({
                position:ll,
                draggable:true,
                icon: image,
                infoWindow: {
                  content: 'Posición de la incidencia.'
                }
            });
            $("input[id=latitude]").val(position.coords.latitude);
            $("input[id=longitude]").val(position.coords.longitude);

            google.maps.event.addListener(m, 'dragend', function(ev){
                ll = m.getPosition();                
                $("input[id=latitude]").val(ll.lat());
                $("input[id=longitude]").val(ll.lng());
            });
        },
        error: function(error){
            alert('La geolocalización ha fallado: '+error.message);
        },
        not_supported: function(){
            alert("La geolocalizaci\u00f3n no está soportada");
        }
    });

});

