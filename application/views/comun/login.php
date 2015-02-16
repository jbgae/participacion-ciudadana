
<div class="formGroupHead">Iniciar sesión</div>
<?= form_open('usuario/login', array('id'=>'registroForm'));  ?>        
    <input type="text" name="email" id="email" placeholder="Email">
    <?= form_error('email'); ?>
    <input type="password" name="password" id="password" placeholder="Contraseña">
    <?= form_error('password'); ?>

    <!--<input type="checkbox" name="chck-rememberme" id="chck-rememberme" checked="">
    <label for="chck-rememberme">Recordarme</label>-->


    <?= form_submit($boton);  ?>
    <?= anchor("restablecer", "He olvidado mi contraseña", array("class"=>"button"));?>
<?= form_close(); ?>
<?php if(isset($mensaje)):?>
    <div class="message error"><?= $mensaje;?></div>
<?php endif; ?>

