var map;

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
        content: '<input type="checkbox" name="option1" value="Reparadas"> Reparadas<br><input type="checkbox" name="option1" value="En proceso"> En proceso<br><input type="checkbox" name="option1" value="Rechazadas"> Rechazadas<br>',
        style: {
          margin: '5px 5px 5px 5px',
          padding: '10px 10px',
          border: 'solid 1px #717B87',
          background: '#fff'
        },
        events: {
            click: function(){
               // $("<li>",{ html:'prueba'}).appendTo("div#mapa_incidentes>div.gm-style>div");
               
            }
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
                        infoWindow: {
                            content:"<p>"+item.title+"</p>"}
                    });
                }    
            }
        }
        map.addMarkers(markers_data);
    },"json");    
        
});