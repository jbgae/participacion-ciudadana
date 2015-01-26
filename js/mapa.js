var map;
$(document).ready(function(){
  var map = new GMaps({
    el: '#geolocation_map',
    lat: 36.191361199999996,
    lng: -5.9168119,
    zoom:16
  });
  GMaps.geolocate({
    success: function(position){
      map.setCenter(position.coords.latitude, position.coords.longitude);
      $("input[id=latitude]").val(position.coords.latitude);
      $("input[id=longitude]").val(position.coords.longitude);
      map.addMarker({
        lat: position.coords.latitude,
        lng: position.coords.longitude,
        title: 'Estas aquí.',
        infoWindow: {
          content: 'Estas aquí.'
        }
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