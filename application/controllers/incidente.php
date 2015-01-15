<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of usuario
 *
 * @author jbgae_000
 */
class Incidente extends MY_Controller{
    
    public function __construct() {
        parent:: __construct();
        $this->load->model('incidente_model');
        $this->load->model('usuario_model');
    }
    
    public function registrar(){
        $this->permisos('ciudadano');
        $this->pagina = "incidente";
        $this->carpeta = "ciudadano";
        
        $this->mostrar();
    }
    
    public function historial(){
        $this->permisos('ciudadano');
        $this->pagina = "historial";
        $this->estilo = "";
        $this->javascript = "";
        $this->carpeta = "ciudadano";
        
        $datos['incidentes'] = array();
        if($this->session->userdata('usuario') == "ciudadano"){
            $incidenteAux = Incidente_model::incidentes($this->session->userdata('email'));           
        }
        elseif($this->session->userdata('usuario') == "administrador"){
            $incidenteAux = Incidente_model::incidentes();
        }
        $usuario = new Usuario_model;
        $incidenteAux1 = new Incidente_model;
        if(!empty($incidenteAux)){
            foreach($incidenteAux as $incidente){
                $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
                $incidente->estado = $incidenteAux1->estado($incidente->IdEstado);
                $datos['incidentes'][$incidente->fechaAlta] = $incidente;
            }
        }
         
        $this->mostrar($datos);
    }
    
    
    public function verIncidente($id){ 
        //$this->permisos('ciudadano');
        $this->pagina = "ver_incidente";
        $this->estilo = "incidente";
        $this->javascript = "";
        $this->carpeta = "ciudadano";
        
        $datos = array();
        
        if(Incidente_model::existe($id)){
            $incidente = new Incidente_model;
            $usuario = new Usuario_model;
            $incidente->datos($id);
            $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
            $incidente->estado = $incidente->estado($incidente->IdEstado);
            
            $datos['incidente'] = $incidente;
            
        }
        else{
            $datos['error'] = "El incidente indicado no existe actualmente";
        }
        
        $this->mostrar($datos);
        
    }
    
    /*public function mapa(){
        $this->pagina = "mapa";
        $this->estilo = "mapa";
        $this->javascript = "mapa";
        $this->carpeta = "ciudadano";
        
        $this->mostrar();
    }*/
}

