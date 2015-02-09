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

?>
