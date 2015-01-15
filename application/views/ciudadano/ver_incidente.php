<div role="main" class="ui-content" id="main">
    <div>
        <h2><?= $incidente->fechaAlta;?></h2>
        <?php if($this->session->userdata('usuario') == "ciudadano"):?>
            <p class="ui-li-aside"><strong><?= $incidente->estado;?></strong></p>
        <?php elseif($this->session->userdata('usuario') == "administrador"):?>
            <!-- PONER SELECT E INICO FORMULARIO-->
        <?php endif;?>    
    </div>
    
    <div>
        <?php if($incidente->direccion != NULL):?>
            <?= $incidente->direccion;?>
        <?php else:?>
            <!-- PONER MAPA-->
        <?php endif;?>
    </div>

    <div>
        <img src="<?= $incidente->rutaImagen;?>" id ="imagenDescripcion">
        <?= $incidente->descripcion;?>
    </div>
    
    <?php if($this->session->userdata('usuario') == "administrador"):?>
    
    <?php endif;?>
</div>