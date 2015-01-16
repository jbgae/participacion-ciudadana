$(document).ready(function(){
    $("#direccion").hide();
    $("#chck-position").change(function(){ 
        if($(this).is(':checked')) {
            $("#map-canvas").show();
            $("#direccion").hide();
        }
        else{
            $("#map-canvas").hide();
            $("#direccion").show();
        } 
   });
});

