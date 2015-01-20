<ul class="list">
    <?php if(!empty($incidentes)):?>
        <?php foreach($incidentes as $key=>$incidente):?>
            <li class="divider">
                <strong><?= $key;?></strong>
                <span class="ui-li-count"><?= count($incidente);?></span>
            </li>
            <?php foreach ($incidente as $incidenteAux):?>
            <li>
                
                <?= anchor("ver/incidente/$incidenteAux->Id", "<img src=\"$incidenteAux->rutaImagen\">"
                                                        . "<h2>$incidenteAux->usuario</h2>".
                                                        "<p>$incidenteAux->descripcion</p>".
                                                        "<p class=\"ui-li-aside\"><strong>$incidenteAux->estado</strong></p>");?>
            </li>
            <?php endforeach;?>
        <?php endforeach;?>
    <?php else:?>
            <li>Actualmente no hay incidentes registrados</li>
    <?php endif;?>        
</ul>

