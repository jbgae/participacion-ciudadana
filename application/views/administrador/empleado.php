<button id="create-user" class="boton-modal">Nuevo empleado</button>

<div id="tabla">
    <table id="empleados" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Departamento</th>
                <th>Opciones</th>
            </tr>
        </thead> 
        <tbody>
            
            <?php if(isset($empleados)):?>
                <?php foreach($empleados as $emp):?>
                    <tr>
                        <td><?= $emp->nombre." ".$emp->apellido1." ".$emp->apellido2;?></td>
                        <td><?= $emp->email;?></td>
                        <td class="center"><?= $emp->telefono;?></td>
                        <td> <?= $emp->departamento;?></td>
                        <td class="center">
                            <?php $aux = str_replace(".com", "%40", $emp->email);?>
                            <a href ="#" class="icon trash open" id="<?= $aux;?>">Eliminar </a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
    
</div>

<div id="dialog-form" title="Nuevo empleado">
    <div id="mensaje">
        <?php if(isset($mensaje)):?>
            <?= $mensaje;?>
        <?php endif;?>
    </div> 
    <form id = "formdata" accept-charset=”utf-8“>
        <fieldset>
            <input type="text" name="nombre" id="nombreEmpleado" placeholder="Nombre" class="text ui-widget-content ui-corner-all">
            <input type="text" name="apellido1" id="apellido1Empleado" placeholder="Primer apellido" class="text ui-widget-content ui-corner-all">
            <input type="text" name="apellido2" id="apellido2Empleado" placeholder="Segundo apellido" class="text ui-widget-content ui-corner-all">
            <input type="text" name="direccion" id="direccionEmpleado" placeholder="Dirección" class="text ui-widget-content ui-corner-all">
            <input type="text" name="telefono" id="telefonoEmpleado" placeholder="Teléfono" class="text ui-widget-content ui-corner-all">
            <input type="text" name="email" id="emailEmpleado" placeholder="Email" class="text ui-widget-content ui-corner-all">
            <input type="text" name="dni" id="dniEmpleado" placeholder="DNI" class="text ui-widget-content ui-corner-all">
            <?= form_dropdown('departamentos',$departamentos);?>
            <input type="password" name="password" id="passwordEmpleado" placeholder="Contraseña" class="text ui-widget-content ui-corner-all">
            <input type="password" name="password-confirm" id="passwordconfirmEmpleado" placeholder="Repita la contraseña" class="text ui-widget-content ui-corner-all">
            
            <!--<textarea  rows="4" cols="18" name="descripcionDepartamento" id="descripcionDepartamento" placeholder="Descripción" class="text ui-widget-content ui-corner-all"></textarea>-->
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
       
</div>

<div id="dialog-confirm" title="Eliminar empleado">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Este empleado será eliminado. ¿Desea continuar?</p>
</div>



