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