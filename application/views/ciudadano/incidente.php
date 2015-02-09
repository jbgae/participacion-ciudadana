

 <div id="geolocation_map"></div><br>
<div class="formGroupHead"></div>
<?= form_open_multipart('',array('class'=>'form', 'id'=>'incidenteForm'));?>

    <input type="text" name="direccion1" id="direccion" value="" placeholder="Dirección">

    <input type="checkbox" name="chck-position" id="chck-position" checked="">
    <label for="chck-position">Usar mi posición actual</label>
    <br><br>

    <input type="hidden" name="latitude" id="latitude" placeholder="Latitud">       
    <input type="hidden" name="longitude" id="longitude" placeholder="Longitud">
    
    <textarea cols="" rows="8" name="descripcion1" id="descripcion1" placeholder="Describe el problema" ></textarea>

    <h3>Imagen</h3>
    
    <br>
    <div id="examinar">
        <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" ><br>            
        <input type="button" onclick="uploadFile()" value="Subir imagen" class="button" />
    </div>
    <br>


    <div id="details"></div>
    <div>

    </div>

    <div id="progress"></div>
    
    
          
         
    

<?= form_close();?>
 

