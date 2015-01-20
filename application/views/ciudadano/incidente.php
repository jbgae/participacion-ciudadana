

 <div id="geolocation_map"></div><br>
<div class="formGroupHead"></div>
<?= form_open_multipart('',array('class'=>'form', 'id'=>'incidenteForm'));?>

    <input type="text" name="direccion1" id="direccion" value="" placeholder="Dirección">

    <input type="checkbox" name="chck-position" id="chck-position" checked="">
    <label for="chck-position">Usar mi posición actual</label>
    <br><br>

    <input type="text" name="latitude" id="latitude" placeholder="Latitud">       
    <input type="text" name="longitude" id="longitude" placeholder="Longitud">
    
    <textarea cols="" rows="8" name="descripcion1" id="descripcion1" placeholder="Describe el problema" ></textarea>

    <h3>Imagen</h3>
    <br>
    <input id="radio_1" name="radio_test" value="1" type="radio" checked="true"><label for="radio_1">Tomar foto</label>
    <input id="radio_2" name="radio_test" value="2" type="radio"><label for="radio_2">Subir foto</label>
    <div id="camara">
        <a class="button icon camera"> Tomar foto</a>
    </div>

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
 

