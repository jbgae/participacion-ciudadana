
<div id="map-canvas"></div><br>
        <div class="formGroupHead"></div>
        <?= form_open_multipart('',array('class'=>'form', 'id'=>'incidenteForm'));?>
        
            <label for="latitude">Latitud</label>
            <input type="text" name="latitude" id="latitude">            
            <br>
            <label for="longitude">Longitud</label>
            <input type="text" name="longitude" id="longitude">            
            <br>
            
            <input type="checkbox" name="chck-position" id="chck-position" checked="">
            <label for="chck-position">Usar mi posición actual</label>
            <br>
            
            <div id="direccion">
                <label for="direccion1">Introduzca la dirección</label>
                <input type="text" name="direccion1" id="direccion1" value="">
            </div>
            <div id="descripcion">
                <label for="descripcion1">Describe el problema</label>
                <textarea cols="50" rows="" name="descripcion1" id="descripcion1"></textarea>
            </div>
            
            <div>
                <label for="fileToUpload">Toma o seleccione una foto</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera">
            </div>
 
            <div id="details"></div>
            <div>
                <input type="button" onclick="uploadFile()" value="Upload" class="ui-btn ui-btn-b ui-corner-all mc-top-margin-1-5" />
            </div>
 
            <div id="progress"></div>
         
        <?= form_close();?>
 

