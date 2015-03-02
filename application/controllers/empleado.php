<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

/**
 * Description of empleado
 *
 * @author jbgae_000
 */
class Empleado extends MY_Controller {
    
    public function __construct() {
        parent:: __construct();
        $this->load->model('usuario_model');
        $this->load->model('empleado_model');
        $this->load->model('departamento_model');        
        $this->load->model('imagen_model');
        $this->load->library('form_validation');
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
        $this->form_validation->set_rules('departamentos', 'Departamento', 'trim|required|callback_departamento_check');
        
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
    
    public function departamento_check($str){
        $aux = TRUE; 
        
        if ($str == '0'){
                $this->form_validation->set_message('departamentos_check', 'Debes elegir un  %s');
                $aux = FALSE;
        }
        
        return $aux;
    }
    
    public function registrar(){
        $this->permisos('administrador');
        $this->titulo = "Empleados";
        $this->pagina = "empleado";
        $this->estilo = array("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min", 
                              "//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui",
                              "//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui",
                              "formulario_modal");
        $this->javascript = array("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min",
                                  "datatable",
                                  "//code.jquery.com/ui/1.11.2/jquery-ui",
                                  "formulario_modal_empleado",
                                  "modal");
        $this->carpeta = "administrador";
        
        $empleados = Empleado_model::empleados();
        $emplAux = new Empleado_model;
        foreach($empleados as &$empl){
            $empl->departamento = $emplAux->departamento($empl->email);
        }
        $datos['empleados'] = $empleados;
        
        
        $departamentos = Departamento_model::departamentos();
        $datos['departamentos'] = array("0"=>"-- Departamento --");
        foreach($departamentos as $dep){
            array_push($datos['departamentos'], $dep->nombre);
        }
        
        if($this->_validar()){
            $empleado = new Empleado_model;
            if($empleado->inicializar()){
                $datos['mensaje'] = 'El empleado se ha registrado correctamente.';
            }
            else{
                $datos['mensaje'] = 'El empleado no se ha podido registrar en este mommento.';
            }
        }
        
        $this->mostrar($datos);
    }
    
    public function registrarAjax(){
        
        if($this->_validar()){
            $empleado = new Empleado_model;
            if($empleado->inicializar()){
                echo 'El empleado se ha registrado correctamente.';
            }
            else{               
                echo "esto es una prueba"; 
            }
        }
        else{
            echo validation_errors();
        }
    }
    
    
    /*MIRAR*/
    public function eliminar($email){
        if($email != ''){ 
            $email  = urldecode($email); 
            if(Empleado_model::existe($email)){
                $empleado = new Empleado_model;
                $empleado->datos($email);                
                $empleado->eliminar();
            }
        }
        $this->registrar();
    }
}
