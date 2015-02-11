$(document).ready(function() {
    $('#departamento').dataTable( {
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "No se ha encontrado nada",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
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
    $('html>body>div#afui>div#content>div#main>div#tabla>div#departamento_wrapper.dataTables_wrapper.no-footer>div#departamento_filter.dataTables_filter>label>input').attr("placeholder", "Buscar");

} );