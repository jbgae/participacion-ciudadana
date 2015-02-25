/**
 *
 * @author jbgae_000
 */
$(document).ready(function(){
    $("#direccion").hide();
    //$("#examinar").hide();
    $("#chck-position").change(function(){ 
        if($(this).is(':checked')) {
            $("#geolocation_map").fadeIn('slow');
            $("#incidenteForm").css("margin-top", 320);
            $("#direccion").fadeOut('slow');
        }
        else{
            $("#geolocation_map").fadeOut('fast');
            $("#incidenteForm").css("margin-top", 20);
            $("#direccion").show('slow');
        } 
   });
   
});

