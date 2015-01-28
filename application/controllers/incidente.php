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
        $this->javascript = array("camara","incidente", "gmaps","mapa");
        $this->carpeta = "ciudadano";
        
        $this->mostrar();
    }
    
    public function historial(){
        $this->permisos('ciudadano');
        $this->pagina = "historial";
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
                
                $key =  date("d-m-Y", strtotime($incidente->fechaAlta));
                if(!isset($datos['incidentes'][$key])){
                    $datos['incidentes'][$key] = array();
                }
                $incidenteAux = array(
                    'Id'            => $incidente->Id,
                    'rutaImagen'    => $incidente->rutaImagen,
                    'usuario'       => $incidente->usuario,
                    'descripcion'   => $incidente->descripcion,
                    'estado'        => $incidente->estado
                );
                
                
                array_push($datos['incidentes'][$key], $incidente);
                
            }
        }
        
        
        $this->mostrar($datos);
    }
    
    public function historialAjax(){
        if(!$this->input->is_ajax_request()){
            redirect('404');
        }
        else{
            $incidentes = array();
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

                    $key =  date("d-m-Y", strtotime($incidente->fechaAlta));
                    log_message("INFO", "Fecha=>". $incidente->fechaAlta);
                    if(!isset($incidentes[$key])){
                        $incidentes[$key] = array();
                    }
                    /*$incidenteAux = array(
                        'Id'            => $incidente->Id,
                        'rutaImagen'    => $incidente->rutaImagen,
                        'usuario'       => $incidente->usuario,
                        'descripcion'   => $incidente->descripcion,
                        'estado'        => $incidente->estado
                    */


                    array_push($incidentes[$key], $incidente);

                }
            } 
            
            log_message("INFO", "/****************** HISTORIAL AJAX ***************/");
            foreach($incidentes as $key => $i){
                log_message("INFO", "Fecha=>". $key);
                
            }
            
            echo json_encode($incidentes);
        
        }
        
    }
  
    public function mapa(){
        
        $this->permisos('ciudadano');
        $this->pagina = "mapa";
        $this->carpeta = "ciudadano";
        $this->javascript = array("gmaps","mapa_incidentes");
        $this->estilo = array("mapa");
       
        $this->mostrar();
    }
    
    
    public function cargar(){
        if(!$this->input->is_ajax_request()){
            redirect('404');
        }
        else{
            $incidentes = array();
            if($this->session->userdata('usuario') == "ciudadano"){
                $incidenteAux = Incidente_model::incidentes($this->session->userdata('email'));           
            }
            elseif($this->session->userdata('usuario') == "administrador"){
                $incidenteAux = Incidente_model::incidentes();
            }
            
            if(!empty($incidenteAux)){
                $i = 0;
                foreach($incidenteAux as $inc){
                    $incidentes[$i] = array(
                        'title'=>$inc->fechaAlta,
                        'lat' =>$inc->latitud,
                        'lng' =>$inc->longitud,
                        
                    );
                    $i++;
                }
                
            }
            echo json_encode($incidentes);
        }
    }
    
    
    
    public function verIncidente($id){ 
        $this->permisos('ciudadano');
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
    
    
    
    public function incidenteAjax($id){
        if(!$this->input->is_ajax_request()){
            redirect('404');
        }
        else{
            if(Incidente_model::existe($id)){
                $incidente = new Incidente_model;
                $usuario = new Usuario_model;
                $incidente->datos($id);
                $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
                $incidente->estado = $incidente->estado($incidente->IdEstado);

                echo json_encode($incidente);

            }
            else{
                echo "El incidente indicado no existe actualmente";
            } 
        }
        
    }
}

