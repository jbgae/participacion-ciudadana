<div class="formGroupHead">Registrar</div>
    <?= form_open("registrar");?>
        <input type="text" name="nombre" id="nombre" value="" placeholder="Nombre">
        <?= form_error('nombre'); ?>
     
        <input type="text" name="apellido1" id="apellido1" value="" placeholder="Primer apellido">
        <?= form_error('apellido1'); ?>
   
        <input type="text" name="apellido2" id="apellido2" value="" placeholder="Segundo apellido">
        <?= form_error('apellido2'); ?>

        <input type="email" name="email" id="email" value="" placeholder="Email">
        <?= form_error('email'); ?>
        
        <input type="text" name="dni" id="dni" value="" placeholder="DNI">
        <?= form_error('dni'); ?>
        
        <input type="text" name="direccion" id="direccion" value="" placeholder="Dirección">
        <?= form_error('direccion'); ?>
        
        <input type="tel" name="telefono" id="telefono" value="" placeholder="Teléfono">
        <?= form_error('telefono'); ?>
     
        <input type="password" name="password" id="txt-password" value="" placeholder="Contraseña">
        <?= form_error('password'); ?>
        
        <input type="password" name="password-confirm" id="password-confirm" value="" placeholder="Confirmar contraseña">
        <?= form_error('password-confirm'); ?>
        
        <?php if(isset($mensaje)):?>
            <?= $mensaje;?>
        <?php endif;?>
        
       <?= form_submit($boton);  ?>
    <?= form_close();?>
      
</div>

