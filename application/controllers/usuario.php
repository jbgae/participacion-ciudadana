<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of usuario
 *
 * @author jbgae_000
 */
class Usuario extends MY_Controller{
    
    public function __construct() {
        parent:: __construct();     
        $this->load->library('My_PHPMailer');
        $this->load->model('usuario_model');  
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters("<div class='message error'><div ></div> <p class='ui-icon-alert'>","</p></div>");    
   
    }
    
     /*Reglas de validación del formulario de iniciar sesión*/
    private function _validarSesion(){
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|valid_email|xss_clean|callback_existeUsuario|callback_confirmarPassword|callback_numeroIntentos|callback_usuarioValidado');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[6]|xss_clean');        
        $this->form_validation->set_message('existeUsuario', 'No existe ningún usuario con el email indicado.');
        $this->form_validation->set_message('usuarioValidado', 'El email introducido no esta validado.');
        $this->form_validation->set_message('numeroIntentos', 'La cuenta esta bloqueada temporalmente.');
        $this->form_validation->set_message('confirmarPassword', 'El email o la contraseña son incorrectas.');        
        $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');
        $this->form_validation->set_message('valid_email', '%s no es válido');
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        
        return $this->form_validation->run();
    }
    
    private function _validar(){
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('apellido1', 'Primer Apellido', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('apellido2', 'Segundo Apellido', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|valid_email|xss_clean|is_unique[usuario.email]');
        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'trim|required|exact_length[9]|numeric|xss_clean');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password-confirm', 'Contraseña', 'trim|required|min_length[6]|xss_clean|matches[password]');
        
        //Establecemos los mensajes de error del formulario
        $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');
        $this->form_validation->set_message('valid_email', '%s no es válido');
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        $this->form_validation->set_message('exact_length', '%s debe tener %s caracteres');
        $this->form_validation->set_message('numeric', '%s debe contener dígitos');
        $this->form_validation->set_message('is_unique', '%s ya esta registrado');
        $this->form_validation->set_message('matches', 'Las contraseñas no coinciden');
        
        return $this->form_validation->run();
    }
    
    /*Callbacks para validación de formulario de inicio de sesión */
    public function existeUsuario($email){ 
        log_message("INFO", "/*FUNCION EXISTE USUARIO*/");
        $aux = FALSE;
        if(Usuario_model::existe($email)){
            $aux = TRUE;
            log_message("INFO",$email ."-> EXISTE");
        }
        
        return $aux;
    }
    
    public function usuarioValidado($email){
        log_message("INFO", "/*FUNCION USUARIO VALIDADO*/");
        $usuario =  new Usuario_model;
        log_message("INFO", $email ."->". $usuario->validado($email));
        return $usuario->validado($email);
    }
    
    public function numeroIntentos($email){
        $aux = FALSE;
        $usuario = new Usuario_model;
        
        log_message("INFO", "/*FUNCION NUMERO INTENTOS*/");
        
        $fecha_esp = str_replace("/", "-", $usuario->fechaUltimoIntento($email));
        $fecha1 =  strtotime($fecha_esp); 
        $fecha2 = strtotime(date('Y/m/d H:i:s'));
        $resultado = $fecha2 - $fecha1;
        
        $horas = $resultado / 60 / 60;
        
        if($usuario->numeroIntentos($email) <= 3){
            $aux =TRUE;
        }      
        else if($usuario->numeroIntentos($email) > 3 && $horas >= 2){
            $act = array('Email' => $email, 'NumeroIntentos' => 0);
            $usuario->actualizar($email, $act);
            $aux = TRUE;
        }
       
        log_message("INFO", $email ."->". $usuario->numeroIntentos($email)." intentos");            
        return $aux;        
    }
    
    public function confirmarPassword($email){
        
        log_message("INFO", "/*FUNCION CONFIRMAR PASSWORD*/");
        
        $aux = Usuario_model::existe($email);
        log_message("INFO", $aux);
        if($aux){log_message("INFO", $email ."-> existe usuario password");
            $usuario = new Usuario_model;
            if(md5($this->input->post('password')) != $usuario->password($email)){
                $act = array(
                    'Email' => $email,
                    'NumeroIntentos' => $usuario->numeroIntentos($email) + 1, 
                    'FechaUltimoIntento' => date('Y/m/d H:i:s')
                );
                $usuario->actualizar($email,$act);
                $aux = FALSE; 
                log_message("INFO", $email ."-> password NO confirmada");
            }
            else{
                log_message("INFO", $email ."-> password confirmada"); 
            }
        }
        return $aux;
    }
    
    
    
    public function login(){              
        $this->pagina = "login";
        $this->carpeta = "comun";
        
         
        $boton = array(            
            "id"=>"btn-submit",
            "class"=>"button",
            'name'=>'button', 
            'value'=>'Enviar'
        );
        $datos['boton'] = $boton;
        
        log_message("INFO", "comenzamos la validacion");
        $email = $this->input->post('email');
        if($this->_validarSesion()){
            log_message("INFO", "sesion validada");
            log_message("INFO",$this->input->post('email'));
            $usuario = new Usuario_model;
            $usuario->datos($email);   
            log_message("INFO",$this->db->last_query());
            log_message("INFO", "datos usuario leidos");
            $ultimoAcceso = $usuario->fechaUltimoAcceso();
            $act = array(
                'Email' => $email,
                'NumeroIntentos' => 0,
                'FechaUltimoAcceso' => date('Y/m/d H:i:s')
            );
            $usuario->actualizar($email, $act);
            log_message("INFO", "datos usuario actualizados");
            $datosUsuario = array(
                'nombre'    => $usuario->nombre(),
                'apellidos' => $usuario->apellido1() .' '. $usuario->apellido2(),
                'email'     => $email,
                'usuario'   => $usuario->permiso(),
                'ultimoAcceso' => $ultimoAcceso,
                'logged_in' => TRUE
            );                

            $this->session->set_userdata($datosUsuario);
            log_message("INFO", " SESION CREADA");
            switch ($usuario->permiso()) {
                case 'administrador':
                        //header("Location:".base_url()."/administrador");
                        redirect("administrador");
                        break;
                case 'ciudadano':
                        //header("Location:".base_url()."/ciudadano");
                        redirect("ciudadano");
                        break;                             
            }             
        }
        $this->mostrar($datos);
        
    }
    
    public function cerrar(){
        $this->session->unset_userdata('ultimoAcceso');
        $this->session->unset_userdata('usuario');
        
        $this->session->sess_destroy();
        redirect('login');
    }
    
   
    public function bloqueada(){
        $this->pagina = "bloqueada";
        $this->carpeta = "comun";
        
        $this->mostrar();
    }
    
    public function registrar(){
        $this->pagina = "registrar";
        $this->carpeta = "comun";
        
        $datos['boton'] = array( 'class'=> 'button', 'name'=>'button', 'id' => 'boton_cliente', 'value'=>"Enviar");
        
        if($this->_validar()){
            $usuario = new Usuario_model;
            if($usuario->inicializar()){
                $datosEmail = array(
                        'direccion' => '',
                        'nombre'    => 'Ayuntamiento de Barbate',
                        'asunto'    => 'Confirmación proceso registro',
                        'texto'     => 'Para emprezar a usar la app Participación ciudadana usted necesita activar su dirección de e-mail. Se hace por razones de seguridad.  
                                    Por favor, siga el siguiente enlace o acceda al enlace copiando y pegándolo en el navegador web:<br> 
                                    <a href="' . base_url() . 'validar/' . urlencode($this->input->post('email')) . ' "> ' . base_url() . 'privado/validar/' . urlencode($this->input->post('email')) . '</a>',
                        'destino' => strtolower($this->input->post('email'))
                );  
                //Enviamos email de confirmación
                $this->my_phpmailer->Enviar($datosEmail); 
                                
                $datos['mensaje'] = '<div class="message success">Se ha enviado un email a su dirección de correo electrónico para confirmar el proceso de registro.</div>';
                           }            
            else{
                $datos['mensaje'] = '<div class="message error">El proceso de registro no se ha realizado satisfactoriamente, por favor inténtelo de nuevo más tarde </div>';
            }           
        }
                
        $this->mostrar($datos);
    }
    
     public function validar($email){ 
        $this->pagina = 'mensaje';
        $this->carpeta= "comun";
               
        $email  = urldecode($email);
                
        if(Usuario_model::existe($email)){
            $usuario = new Usuario_model();
            $usuario->datos($email);            
            $act = array('Validado' => 1);
            $usuario->actualizar($email,$act);
            
            $datos['mensaje'] = '<div class="message success">
                                        Se ha validado correctamente su cuenta.
                    </div>';
        }
        else{
            $datos['mensaje'] = '<div class="message error">                    
                    El proceso de validación no se ha realizado satisfactoriamente,
                    por favor inténtelo de nuevo más tarde
                    </div>';
        }   
        
        $this->mostrar($datos);
    }
    
    public function password(){
        $this->pagina = "password";
        $this->carpeta = "comun";
        
        $datos['boton'] = array( 'name' => 'button', 'id' => 'boton_restablecer', 'value' => 'Enviar',"class"=>"ui-btn ui-btn-b ui-corner-all mc-top-margin-1-5");     
         
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|valid_email|xss_clean');
        
        $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');
        $this->form_validation->set_message('valid_email', '%s no es válido');
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        
        if($this->form_validation->run() == TRUE){
            if(!(Usuario_model::existe($this->input->post('email')))){
                $datos['errorUsuario'] = 'El email introducido no existe';
            }
            else{
                $cliente = new Usuario_model;
                if($usuario->validado($this->input->post('email'))){
                    //Generamos nueva contraseña 
                    $str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                    $cad = "";
                    for($i=0;$i<7;$i++) {
                        $cad .= substr($str,rand(0,62),1);
                    }
                    $pass = array('Pass' => md5($cad));

                    $cliente->actualizar($this->input->post('email'),$pass);

                    //Creamos los datos del email y lo mandamos
                    $datosEmail = array(
                            'direccion' => 'emplea.barbate@gmail.com',
                            'nombre'    => 'Ayuntamiento Barbate',
                            'asunto'    => 'Ayuntamiento Barbate: Modificación Contraseña',
                            'texto'     => '<FONT FACE="arial" SIZE=4>
                                        La nueva contraseña es:' . $cad . 
                                        '<br><br>
                                        La presente información se envía únicamente para la persona a la que va dirigida y puede contener información de carácter confidencial 
                                        o privilegiada. Cualquier modificación, retransmisión, difusión u otro uso de 
                                        esta información por personas o entidades distintas a la persona a la que va dirigida está prohibida. Si usted lo ha recibido por error 
                                        por favor contacte con el remitente y borre el mensaje de cualquier ordenador. ',
                            'destino' => strtolower($this->input->post('email'))
                    );  
                    $this->my_phpmailer->Enviar($datosEmail); 

                    $datos['mensaje'] = "Se le ha enviado una nueva contraseña a su dirección de correo electrónico"; 
                }
                else{
                    $datos['errorUsuario'] = 'El email introducido no está validado';
                }
            }
            
        }
        $this->mostrar($datos);
        
        $this->mostrar($datos);
    }
    
    
}
