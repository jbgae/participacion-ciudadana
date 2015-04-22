<br>
<div id ="mapaIncidente"></div>
     
    <div id="visualizaincidencia">
        <hr align="left" width="100%" size="5" noshade>
        <br> 
        <span class="negrita">Id Incidencia :</span> <?= $incidencia->id;?>
        <br>
        <span class="negrita">Email Usuario : </span> <?= $incidencia->emailUsuario;?>
        <br>
        <span class="negrita">Fecha de alta : </span> <?= $incidencia->fechaAlta;?>
        <br>
        <span class="negrita">Descripción : </span>  <?= $incidencia->descripcion;?>
        <br>           
        <span class="negrita">Estado :</span> <?= $estado;?>
        <br>
        <span class="negrita">Área:</span> <?= $area;?>
        <br>
        <span class="negrita">Empleados:</span>
        <br>
        <?php if(!empty($empleados)):?>
            <?php foreach($empleados as $e):?>
                <?=  $e;?>
                <br>
            <?php endforeach;?>
        <?php else:?>
                <?= 'No hay asignado ningún empleado a este proyecto';?>
                <br>
                <label class="izq negrita">Seleccione el/los departamento/s</label>
                <?= form_multiselect('departamentos', $departamentos,'', 'id="my-select" class="my-select"');?>
                <label class="izq negrita">Seleccione el/los empleado/s</label>
                <?= form_multiselect('empleados',$empleados,"",'id="my-select2" class="my-select"');?>
                <?php endif;?>
                <br>
                <span class="negrita">Imagen:</span>
        <br>
        <?php if(@getimagesize($imagen)):?>
            <img src="<?= $imagen;?>" >
        <?php else:?>
            <img src="<?= base_url();?>imagenes/1_thumb.jpg">
        <?php endif;?>
        <hr align="left" width="100%" size="5" noshade>
    </div>    
    
  


<!--<form id= "form2" name="form2" action="guardardatos.php" method="post">  -->
<?= form_open('incidente/modificar/'.$incidencia->id);?>
    
    <!--<input type="text" name="direc" id="direc" value="" placeholder="Cambiar la direccion "  /> -->

    <div><br><br> Modificar estado :  
        <?= form_dropdown('sele_estado', $options, $incidencia->IdEstado);?>
        
    </div>
    <br><br>

    <?php if($this->session->userdata("usuario") == "administrador" || $this->session->userdata("usuario") == "empleado"):?>
        <div id="introducedato" > 
            <span>Describe la modificación realizada: </span>
            <!--<textarea cols="" rows="8" id="descripcion" name="descripcion" placeholder="Describe la modificacion" ></textarea>-->
            <?= form_textarea($textArea);?>
            <span>Fecha de reparación :</span> 
            <!--<input type="date" name="fecharepa" id="fecharepa"  placeholder="dd/mm/aaaa" />-->
            <?= form_input($inputFecha);?>
            <span>Tiempo de reparación: </span>
            <!--<input type="number" id="trepa" name="trepa" placeholder="Tiempo de reparacion / horas" />-->
            <?= form_input($inputTiempo);?>
        </div>
    <?php endif;?>

                   
    <input type="submit" value="Modificar" align="center" class="button">    
    <button type="button" align="right" class="button"> Cancelar </button> 

</form>	   


<div id="resultado"></div>

