            <nav>
                <ul class="list">
                    <?php if($this->session->userdata("usuario")!= 'ciudadano' && $this->session->userdata('usuario')!= 'administrador'):?>
                        <?php if ($this->uri->segment(1)=="login"):?>           
                            <li class="divider">Menu</li>

                            <li><?= anchor('login', "Iniciar sesión");?></li>
                            <li><?= anchor('registrar', "Registrarse");?></li>
            
                        <?php elseif($this->uri->segment(1)=="registrar") :?>           
                            <li class="divider">Menu</li>

                            <li><?= anchor('login', "Iniciar sesión");?></li>
                            <li><?= anchor('registrar', "Registrarse");?></li>

                        <?php else:?>
                            <li class="divider">Menu</li>

                            <li><?= anchor('login', "Iniciar sesión");?></li>
                            <li><?= anchor('registrar', "Registrarse");?></li>

                        <?php endif;?>
                    <?php elseif($this->session->userdata("usuario")== 'ciudadano'):?>
                        <li class="divider">Menu</li>

                        <li><?= anchor('incidente', "Registrar incidente");?></li>
                        <li><?= anchor('historial', "Historial");?></li>
                        <li><?= anchor('cerrar', "Salir");?></li>

                    <?php elseif($this->session->userdata("usuario")== 'administrador'):?>
                        <li class="divider">Menu</li>

                        <li><?= anchor('incidente', "Registrar incidente");?></li>
                        <li><?= anchor('historial', "Historial");?></li>
                        <li><?= anchor('cerrar', "Salir");?></li>

                    <?php endif;?>
                    
                </ul>
            </nav>
        



