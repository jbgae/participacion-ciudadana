<br>
<div id ="mapaIncidente"></div>
     
    <div id="visualizaincidencia">
        <hr align="left" width="100%" size="5" noshade>
        <br> 
        Id Incidencia : <?= $incidencia->id;?>
        <br>
        Email Usuario :  <?= $incidencia->emailUsuario;?>
        <br>
        Fecha de alta : <?= $incidencia->fechaAlta;?>
        <br>
        Descripción :   <?= $incidencia->descripcion;?>
        <br>           
        Estado : <?= $estado;?>
        <br> 
        <hr align="left" width="100%" size="5" noshade>
    </div>    
    
  


<form id= "form2" name="form2" action="guardardatos.php" method="post">  
    <br><br>  
    <!--<input type="text" name="direc" id="direc" value="" placeholder="Cambiar la direccion "  /> -->

    <div><br><br> Modificar estado :  
        <?= form_dropdown('sele_estado', $options, $incidencia->IdEstado);?>
        
    </div>
    <br><br>

    <?php if($this->session->userdata("usuario") == "administrador" || $this->session->userdata("usuario") == "empleado"):?>
        <div id="introducedato" > 
            Describe la modificacion realizada: 
            <textarea cols="" rows="8" id="descripcion" name="descripcion" placeholder="Describe la modificacion" ></textarea>
            Fecha de reparación : 
            <input type="date" name="fecharepa" id="fecharepa"  placeholder="dd/mm/aaaa" />
            Tiempo de reparación: 
            <input type="number" id="trepa" name="trepa" placeholder="Tiempo de reparacion / horas" />
        </div>
    <?php endif;?>

                   
    <input type="submit" value="Modificar" align="center" class="button">    
    <button type="button" align="right" class="button"> Cancelar </button> 

</form>	   


<div id="resultado"></div>

