/**
 *
 * @author jbgae_000
 */
$(document).ready(function(){
    obtenerNotificaciones();

    function obtenerNotificaciones(){
        $.post("http://localhost/participacion_ciudadana/incidente/nuevas",{ }, function(data){
            if(data.incidentes!= 0)
                $.ui.updateBadge("li#historial",data.incidentes,"tr");
        },"json");        
    }
});