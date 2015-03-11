/**
 *
 * @author jbgae_000
 */
$(document).ready(function(){
    $('.my-select').multiSelect({});
    
    var selected=[];
    $("#my-select").change(function() {
        $("#my-select :selected").each(function() {      
            selected[$(this).val()]=$(this).text();
        });     
        $.post("http://localhost/participacion_ciudadana/departamento/ajax",{departamentos: selected}, function(data){
            res = JSON.parse(data);
            
            for(var key in res){
                $('#my-select2').multiSelect('addOption', { value: key, text: res[key], index: 0 });                    
            }
        });
    });
});