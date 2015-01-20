$(document).ready(function(){
    $("#direccion").hide();
    $("#examinar").hide();
    $("#chck-position").change(function(){ 
        if($(this).is(':checked')) {
            $("#geolocation_map").show();
            $("#direccion").hide();
        }
        else{
            $("#geolocation_map").hide();
            $("#direccion").show();
        } 
   });
   
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="1"){
            $("#examinar").hide();
            $("#camara").show();
        }
        if($(this).attr("value")=="2"){
            $("#examinar").show();
            $("#camara").hide();
        }
    });
});

