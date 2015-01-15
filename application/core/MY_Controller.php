<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

    var $pagina = '';
    var $titulo = '';
    var $estilo = '';
    var $javascript = '';
    var $carpeta = '';
    var $menu = '';
    var $submenu = '';
    var $error = '';
    var $exito = '';
    
    public function __construct() {
        parent:: __construct();
        $this->load->library('session');
        $this->load->dbutil();
    }
    
    public function permisos($user){
        if($this->session->userdata('logged_in') == TRUE){ 
            if($user != $this->session->userdata('usuario')){ 
                if($this->session->userdata('usuario') == 'ciudadano'){
                    redirect('login');
                }                
            }
        }
        else{
            redirect('login');
        }
    }    
    
    public function mostrar($datos = ''){
        if($this->_comprobarBD()){
            $this->load->view('plantillas/mantenimiento.php');
        }
        
        else{
             $cabecera = array(
                    'titulo'    =>  $this->titulo,
                    'estilo'    =>  $this->estilo,
                    'javascript'=>  $this->javascript,
                    'nombre'    =>  $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellidos'),
                    'usuario'   =>  $this->session->userdata('usuario'),
                    'carpeta'   =>  $this->carpeta
            );
            
            $this->load->view('plantillas/cabecera.php', $cabecera);
            $this->load->view('plantillas/menu.php');
            $this->load->view("$this->carpeta/$this->pagina.php", $datos);            
            $this->load->view("plantillas/pie.php");
            
        }
    }
    
     
     
     private function _comprobarBD(){
        $aux = FALSE;        

        $tablas   = array('usuario', 'privilegio', 'incidencia', 'reparacion', 'estado');
        
        if ($this->dbutil->database_exists('participacion')){
            foreach($tablas as $tabla){
                if(!$aux){
                    if(!$this->db->table_exists($tabla)){
                        $aux = TRUE;
                        log_message("debug", "La tabla $tabla no se encuentra disponible.");
                    }
                }
            }
        }
        else{
            log_message("debug", "La base de datos no existe.");
        }
        
        return $aux;
    }
    
   
}

?>
