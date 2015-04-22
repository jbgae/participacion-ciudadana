/**
 *
 * @author jbgae_000
 */
$(function() { 
    var dialog, form,
    name = $("#nombreEmpleado"),
    surname1 = $("#apellido1Empleado"),
    surname2 = $("#apellido2Empleado"),
    address = $("#direccionEmpleado"),
    phone = $("#telefonoEmpleado"),
    email = $("#emailEmpleado"),
    dni = $("#dniEmpleado"),
    pass = $("#passwordEmpleado"),
    passconf = $("#passwordconfirmEmpleado"),
    allFields = $( [] ).add( name ).add(surname1).add(surname2).add(address).add(phone).add(email).add(dni).add(pass).add(passconf),
    tips = $( "#mensaje" );

    function updateTips( t ) {
        tips.text( t ).addClass( "ui-state-highlight" );
        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }
    
    function checkLength( o, n, min, max ) {
        if(min === max){
            if(o.val().length > min || o.val().length < min){
                o.addClass( "ui-state-error" );
                updateTips( "Tamaño de " + n + " debe ser  " + min + " caracteres." );
                return false;
            }
        }
        else if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Tamaño de " + n + " debe estar entre  " + min + " y " + max + " caracteres." );
            return false;
        }
        else {
            return true;
        }
    }
    
     
    function addUser() {
        var valid = true;
        allFields.removeClass( "ui-state-error" );
       /* valid = valid && checkLength( name, "nombre", 3, 20 );
        valid = valid && checkLength( surname1, "primer apellido", 3, 20 );
        valid = valid && checkLength( surname2, "segundo apellido", 3, 20 );
        valid = valid && checkLength( address, "direccion", 3, 30 );
        valid = valid && checkLength( phone, "telefono", 9, 9 );
        valid = valid && checkLength( email, "email", 3, 60 );
        valid = valid && checkLength( dni, "DNI", 9, 9 );
        valid = valid && checkLength( pass, "contraseña", 3, 50 );
        valid = valid && checkLength( passconf, "confirmación de contraseña", 3, 50 );*/
        
        if ( valid ) {
           $.ajax({
                    type: "POST",
                    url: "http://localhost/participacion_ciudadana/empleado/registrarAjax",
                    data: $("#formdata").serialize(),
                    datatype: "text",
                    beforeSend:function(){
                        $('#mensaje').html('<b>El formulario se esta enviando</b>');                        
                    },
                    success:function(res){
                        //alert(res);
                        $("#mensaje").html(res);
                        $('#formdata').each(function(){
                            this.reset();   
                        });
                        
                        if(res === "El empleado se ha registrado correctamente."){
                            dialog.dialog( "close" );
                            location.reload();                        
                        }
                    }                    
            });            
            return false;          
        }
        return valid;
    }
    
    
    dialog = $( "#dialog-form" ).dialog({
                autoOpen: false,
                resizable: true,
                height: 600,
                width: 450,
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
                    "Crear": addUser,
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