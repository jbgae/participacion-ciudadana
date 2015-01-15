<div role="main" class="ui-content">
    <?= form_open("restablecer");?>    
        <h3>Nueva contraseña</h3>
        <label for="email">Introduzca su email</label>
        <input type="text" name="email" id="email" value="">
        <?= form_error('email');?>        
        <?= form_submit($boton);?>
        <?php if(isset($errorUsuario)):?>
            <div class="message error"><?= $errorUsuario;?></div>
        <?php endif;?>
        <?php if(isset($mensaje)):?>
            <div class="message success"><?= $mensaje;?></div>
        <?php endif;?>
    <?= form_close();?>
</div>