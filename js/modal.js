/**
 *
 * @author jbgae_000
 */
$(document).ready(function(){
    
    $( "#dialog-confirm" ).dialog({
        autoOpen:false,
        resizable: false,
        height:170,
        modal: true,
        buttons: {
            "Eliminar": function() {
                $( this ).dialog( "close" );
            },
            "Cancelar": function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $( ".open" ).click(function() {
        $( "#dialog-confirm" ).dialog( "open" );
    });
});