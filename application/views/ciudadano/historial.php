<ul class="list">
    <?php if(!empty($incidentes)):?>
        <?php foreach($incidentes as $key=>$incidente):?>
            <li class="divider">
                <strong><?= $key;?></strong>
                <span class="ui-li-count"><?= count($key);?></span>
            </li>
            <li>
                <?= anchor("ver/incidente/$incidente->Id", "<img src=\"$incidente->rutaImagen\">"
                                                        . "<h2>$incidente->usuario</h2>".
                                                        "<p>$incidente->descripcion</p>".
                                                        "<p class=\"ui-li-aside\"><strong>$incidente->estado</strong></p>");?>
            </li>

        <?php endforeach;?>
    <?php else:?>
            <li>Actualmente no hay incidentes registrados</li>
    <?php endif;?>        
</ul>
