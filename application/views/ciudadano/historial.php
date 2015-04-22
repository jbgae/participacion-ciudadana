<div id="tabla">
    <table id="historial" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Opciones</th>
            </tr>
        </thead> 
        <tbody>
             <?php if(!empty($incidentes)):?>
                <?php foreach($incidentes as $key=>$incidente):?>
                    <tr>
                        <td><?= $incidente->fechaAlta;?></td>                        
                        <td><?= $incidente->usuario;?></td>
                        <td class="center"> 
                        <?php if($incidente->IdEstado == 1):?>
                            <span class="reparado">
                                Reparado
                        <?php elseif($incidente->IdEstado == 2):?>
                            <span class="proceso">
                                Proceso
                        <?php elseif($incidente->IdEstado == 3):?>
                            <span class="rechazado">
                                Rechazado
                        <?php endif;?>
                            </span>    
                        </td>
                        <td><?= $incidente->descripcion?></td>
                        <td>
                            
                            <?php if (file_exists($incidente->rutaImagen)):?>
                                <img src="<?=$incidente->rutaImagen;?>">
                            <?php else:?>
                                <img src="<?= base_url();?>imagenes/1_thumb.jpg">
                            <?php endif;?>    
                        </td>
                        <td class="center">
                            <?php if($this->session->userdata('usuario') == "ciudadano"):?>
                                <?= anchor("ver/incidente/".$incidente->Id,"Editar", array("class"=>"icon tools"));?><br>
                            <?php else:?>
                                <?= anchor("incidente/modificar/".$incidente->Id,"Editar", array("class"=>"icon tools"));?><br>
                            <?php endif;?>    
                            <!-- anchor("#","Eliminar", array("class"=>"icon trash open"));?>-->
                            <?php if($this->session->userdata('usuario') == "administrador"):?>
                                <a href ="#" class="icon trash open" id="<?= $incidente->Id;?>">Eliminar </a>
                            <?php endif;?>    
                        </td>
                        
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
    
    <div id="dialog-confirm" title="Eliminar incidencia">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Esta incidencia será eliminada. ¿Desea continuar?</p>
    </div>
</div>