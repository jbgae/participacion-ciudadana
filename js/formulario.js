$(function() {
    var dialog, form,
    name = $("#nombreDepartamento"),
    description = $("#descripcionDepartamento"),    
    allFields = $( [] ).add( name ).add(description),
    tips = $( "#mensaje" );

    function updateTips( t ) {
        tips.text( t ).addClass( "ui-state-highlight" );
        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }
    
    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Tamaño de " + n + " debe estar entre  " + min + " y " + max + " caracteres." );
            return false;
        }
        else {
            return true;
        }
    }
   
    function addArea() {
        var valid = true;
        allFields.removeClass( "ui-state-error" );
        valid = valid && checkLength( name, "nombre", 3, 16 );
        valid = valid && checkLength( description, "descripcion", 6, 80 );
        if ( valid ) {
           $.ajax({
                    type: "POST",
                    url: "http://localhost/participacion_ciudadana/areas/registrarAjax",
                    data: $("#formdata").serialize(),
                    datatype: "text",
                    beforeSend:function(){
                        $('#mensaje').html('<b>El formulario se esta enviando</b>');
                        
                    },
                    success:function(res){ 
                        $("#mensaje").html(res);
                        $('#formdata').each(function(){
                            this.reset();   
                        });
                        dialog.dialog( "close" );
                        location.reload();
                        
                    }
                    
            });
            
           return false;
          
        }
        return valid;
    }
    
    
    dialog = $( "#dialog-form" ).dialog({
                autoOpen: false,
                resizable: false,
                height: 430,
                width: 250,
                modal: true,
                show: {
                    effect: "blind",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                },
                icons: { primary: null, secondary: null },
                buttons: {
                    "Crear": addArea,
                    Cancelar: function() {
                        dialog.dialog( "close" );
                    }
                },
                close: function() {
                    form[ 0 ].reset();
                    allFields.removeClass( "ui-state-error" );
                }
    });
            
    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addArea();
    });
    
    $( "#create-user" ).button().on( "click", function() {
        dialog.dialog( "open" );
    });
   
});