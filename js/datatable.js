/**
 *
 * @author jbgae_000
 */
$(document).ready(function() {
    $('#departamento').dataTable( {
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página.",
            "zeroRecords": "No existe ningún departamento registrado.",
            "info": "Mostrando la página _PAGE_ de _PAGES_.",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrando de _MAX_ total registros)",
            "search":         "",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siquiente",
                "previous":   "Anterior"
            }
        }
        //"scrollX": true
    } );
    $('#historial').dataTable( {
        "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página.",
            "zeroRecords": "No existe ningún incidente registrado.",
            "info": "Mostrando la página _PAGE_ de _PAGES_.",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrando de _MAX_ total registros)",
            "search":         "",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siquiente",
                "previous":   "Anterior"
            }
        }
        //"scrollX": true
    } );
     $('#empleados').dataTable( {
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página.",
            "zeroRecords": "No existe ningún empleado registrado.",
            "info": "Mostrando la página _PAGE_ de _PAGES_.",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrando de _MAX_ total registros)",
            "search":         "",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siquiente",
                "previous":   "Anterior"
            }
        }
        //"scrollX": true
    } );
    $('html>body>div#afui>div#content>div#main>div#tabla>div.dataTables_wrapper.no-footer>div.dataTables_filter>label>input').attr("placeholder", "Buscar");

} );