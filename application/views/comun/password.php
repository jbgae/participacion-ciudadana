
    <?= form_open("restablecer");?>
    <br>
        <h3>Nueva contraseña</h3>
        <br>
        <input type="text" name="email" id="email" value="" placeholder="Introduzca su email">
        <?= form_error('email');?>        
        <?= form_submit($boton);?>
        <?php if(isset($errorUsuario)):?>
            <div class="message error"><?= $errorUsuario;?></div>
        <?php endif;?>
        <?php if(isset($mensaje)):?>
            <div class="message success"><?= $mensaje;?></div>
        <?php endif;?>
    <?= form_close();?>
