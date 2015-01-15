    <?php if(isset($mensaje)):?>
        <?= $mensaje;?>
    <?php endif;?>
    
    <div class="formGroupHead">Registrar</div>
       
    <?= form_open("registrar");?>
        
        
        <input type="text" name="nombre" id="nombre" value="" placeholder="Nombre">
        <?= form_error('nombre'); ?>
        
        
        <input type="text" name="apellido1" id="apellido1" value="" placeholder="Primer apellido">
        <?= form_error('email'); ?>
        
        
        <input type="text" name="apellido2" id="apellido1" value="" placeholder="Segundo apellido">
        <?= form_error('apellido2'); ?>
        
        
        <input type="email" name="email" id="email" value="" placeholder="Email">
        <?= form_error('email'); ?>
        
        
        <input type="text" name="direccion" id="direccion" value="" placeholder="Dirección">
        <?= form_error('direccion'); ?>
        
        
        <input type="tel" name="telefono" id="telefono" value="" placeholder="Teléfono">
        <?= form_error('telefono'); ?>
        
        
        <input type="password" name="password" id="txt-password" value="" placeholder="Contraseña">
        <?= form_error('password'); ?>
        
        
        <input type="password" name="password-confirm" id="password-confirm" value="" placeholder="Confirmar contraseña">
        <?= form_error('password-confirm'); ?>
        
       <?= form_submit($boton);  ?>
    <?= form_close();?>
	        
</div>