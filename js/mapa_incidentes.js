/**
 * Geolocation
 
 var map;
$(document).ready(function(){
  var map = new GMaps({
    el: '#mapa_incidentes',
    lat: 36.191361199999996,
    lng: -5.9168119,
    zoom:15
  });
  GMaps.geolocate({
    success: function(position){
      map.setCenter(position.coords.latitude, position.coords.longitude);
      map.addMarker({
        lat: position.coords.latitude,
        lng: position.coords.longitude,
        title: 'You are here.',
        infoWindow: {
          content: 'You are here!'
        }
      });
    },
    error: function(error){
      alert('Geolocation failed: '+error.message);
    },
    not_supported: function(){
      alert("Your browser does not support geolocation");
    }
  });
});
*/

var map;

    /*function loadResults (data) {
      var items, markers_data = [];
      alert(data);
      if (data.venues.length > 0) {
        items = data.venues;

        for (var i = 0; i < items.length; i++) {
          var item = items[i];

          if (item.location.lat != undefined && item.location.lng != undefined) {
            
            
            markers_data.push({
              lat : item.location.lat,
              lng : item.location.lng,
              title : item.name,
              icon : {
                size : new google.maps.Size(32, 32),
                
              }
            });
          }
        }
      }

      map.addMarkers(markers_data);
    }
    */

   

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
     
      map = new GMaps({
        div: '#mapa_incidentes',
        lat: 36.191361199999996,
        lng: -5.9168119,
        zoom:15
      });

      map.on('marker_added', function (marker) {
        var index = map.markers.indexOf(marker);
        $('#results').append('<li><a href="#" class="pan-to-marker" data-marker-index="' + index + '">' + marker.title + '</a></li>');

        if (index == map.markers.length - 1) {
          map.fitZoom();
        }
      });
       
        
    $.post("http://localhost/participacion_ciudadana/incidente/cargar",{ }, function(data){
        markers_data = [];
        if(data.length > 0){
            for(var i = 0; i < data.length; i++){
                var item = data[i];
                if (item.lat != undefined && item.lng != undefined) {
                    
                    markers_data.push({
                        lat : item.lat,
                        lng : item.lng,
                        title : item.name,
                        
                    });
                }    
            }
        }
        map.addMarkers(markers_data);
    },"json");    
        
});