
<button id="create-departamento" class="boton-modal">Nuevo departamento</button>

<div id="tabla">
    <table id="departamento" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Número empleados</th>
                <th>Opciones</th>
            </tr>
        </thead> 
        <tbody>
            <?php if(isset($departamentos)):?>
                <?php foreach($departamentos as $dep):?>
                    <tr>
                        <td><?= $dep->nombre;?></td>
                        <td><?= $dep->descripcion;?></td>
                        <td class="center"><?= $dep->numEmpleados;?></td>
                        <td class="center">
                         <a href ="<?= base_url()."/eliminar/departamento/$dep->idDepartamento"?>" class="icon trash open" id="<?= $dep->idDepartamento;?>">Eliminar </a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
    
</div>

<div id="dialog-form" title="Nuevo departamento">
    <div id="mensaje">
        <?php if(isset($mensaje)):?>
            <?= $mensaje;?>
        <?php endif;?>
    </div> 
    <form id = "formdata" accept-charset=”utf-8“>
        <fieldset>
            <input type="text" name="nombreDepartamento" id="nombreDepartamento" placeholder="Nombre" class="text ui-widget-content ui-corner-all">
            <textarea  rows="4" cols="18" name="descripcionDepartamento" id="descripcionDepartamento" placeholder="Descripción" class="text ui-widget-content ui-corner-all"></textarea>
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
       
</div>

<div id="dialog-confirm" title="Eliminar departamento">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Este departamento será eliminado. ¿Desea continuar?</p>
</div>

