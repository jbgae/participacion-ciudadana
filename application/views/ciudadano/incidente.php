<!-- MAPA-->
<div id="geolocation_map"></div><br>

<!--FORMULARIO-->
<div class="formGroupHead"></div>
<?= form_open_multipart('incidente/registrar',array('class'=>'form', 'id'=>'incidenteForm'));?>

    <!--<input type="text" name="direccion1" id="direccion" value="" placeholder="Dirección">
    <input type="checkbox" name="chck-position" id="chck-position" checked="">
    <label for="chck-position">Usar mi posición actual</label>-->
    <br>
        <?= form_dropdown('areas', $areas);?>
    <br>
    <?php if($this->session->userdata("usuario") == "administrador"):?>
        <label>Seleccione el/los departamento/s</label>
        <?= form_multiselect('departamentos', $departamentos,'', 'id="my-select" class="my-select"');?>
        <label>Seleccione el/los empleado/s</label>
        <?= form_multiselect('empleados',$empleados,"",'id="my-select2" class="my-select"');?>
    <?php endif;?>
    
    <br>

    <input type="hidden" name="latitude" id="latitude" placeholder="Latitud">       
    <input type="hidden" name="longitude" id="longitude" placeholder="Longitud">
    
    <textarea cols="" rows="8" name="descripcion1" id="descripcion1" placeholder="Describe el problema" ></textarea>

    <h3>Imagen</h3>
    
    <br>
    
    <input type="file" name="fileToUpload" id="fileToUpload"><br>            
    <?= form_submit($boton);?>
    
    <br>


    <div id="details"><?= validation_errors();?></div>
    
    <?php if (isset($mensaje)):?>
        <div id="progress"><?= $mensaje;?></div>
    <?php endif;?>    
<?= form_close();?>
 

