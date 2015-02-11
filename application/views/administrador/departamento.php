<div id="dialog-form" title="Create new user">
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
        <!-- Allow form submission with keyboard without duplicating the dialog button -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>
<button id="create-user">Crear nuevo departamento</button>





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
            <tr>
                <td>Jardinería</td>
                <td>Prueba</td>
                <td>20</td>
                <td>Eliminar</td>
            </tr>
            <tr>
                <td>Limpieza</td>
                <td>Prueba2</td>
                <td>30</td>
                <td>Eliminar</td>
            </tr>
            <tr>
                <td>Obras</td>
                <td>Prueba3</td>
                <td>12</td>
                <td>Eliminar</td>
            </tr>
            <tr>
                <td>Bomberos</td>
                <td>Prueba4</td>
                <td>21</td>
                <td>Eliminar</td>
            </tr>
            
        </tbody>
    </table>
</div>