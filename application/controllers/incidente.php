<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

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
        $this->load->model('imagen_model');
        $this->load->library('form_validation');
    }
    
    private function _validar(){
        
        $checked = (isset($_POST['chck-position']))? true:false;
        
        if($checked){
            $this->form_validation->set_rules('latitude', 'Latitud', 'trim|xss_clean');        
            $this->form_validation->set_rules('longitude', 'Longitud', 'trim|xss_clean');  
        }
        else{
            $this->form_validation->set_rules('direccion1', 'Dirección', 'trim|required|min_length[3]|xss_clean');
        }
             
        $this->form_validation->set_rules('descripcion1', 'Longitud', 'trim|required|xss_clean');        

        /*if (empty($_FILES['fileToUpload']['name'])){
            $this->form_validation->set_rules('fileToUpload', 'La foto', 'required');
        }*/
        
        $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');        
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        
        return $this->form_validation->run();
        
    }
    
    public function registrar(){
        $this->permisos('ciudadano');
        $this->pagina = "incidente";
        $this->javascript = array("camara","incidente", "gmaps","mapa");
        $this->carpeta = "ciudadano";
        
        $datos['boton'] = array(            
            "id"=>"btn-submit",
            "class"=>"button",
            'name'=>'button', 
            'value'=>'Registrar incidente'
        );
        
        if($this->_validar()){
            $codigoImagen = "";
            if (!empty($_FILES['fileToUpload']['name'])){
                $imagen = new Imagen_model;
                $imagen->inicializar();
                $codigoImagen = $imagen->codigo();
                log_message("info","Codigo de imagen: $codigoImagen");
            }
            $incidente = new Incidente_model;
            $aux = FALSE;
            if($codigoImagen == ""){
                $aux = $incidente->registrar();
            }
            else{
                $aux = $incidente->registrar($codigoImagen);
            }
            if($aux){
                $datos['mensaje'] = "La incidencia se ha registrado satisfactoriamente";
            }
        }
        
        $this->mostrar($datos);
    }
    
    public function registrarAjax(){
        
        if($this->_validar()){
            $incidente = new Incidente_model;
            if($incidente->registrar()){
                $mensaje = "El incidente se ha registrado con éxito";
                echo '<div class="text-success">'.$mensaje.'</div>';
            }
            else{
                $error = 'No se ha podido registrar el incidente en este momento';
                echo '<div class="text-error">'.$error.'</div>';
            }
        }
        else{
            $error = json_encode(validation_errors());
            $error = str_replace('"', "", $error);
            $error = str_replace('<\/span>\n', "", $error);                 
            $error = str_replace('<\/p>\n', "", $error);
            
            echo '<div class="text-error">'.$error.'</div>';
        }
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
        $imagen = new Imagen_model;
        
        if(!empty($incidenteAux)){
            foreach($incidenteAux as $incidente){
                $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
                $incidente->estado = $incidenteAux1->estado($incidente->IdEstado);
                
                $incidente->rutaImagen = $imagen->ruta($incidente->IdImagen);
                
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
    
    public function historialAjax($email, $user){
        /*if(!$this->input->is_ajax_request()){
            redirect('404');
        }
        else{*/
            $incidentes = array();
            if($user == "ciudadano"){
                $incidenteAux = Incidente_model::incidentes($email);           
            }
            elseif($user == "administrador"){
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
        
       // }
        
    }
  
    public function mapa(){
        
        $this->permisos('ciudadano');
        $this->pagina = "mapa";
        $this->carpeta = "ciudadano";
        $this->javascript = array("gmaps","mapa_incidentes");
        $this->estilo = array("mapa");
       
        $this->mostrar();
    }
    
    
    public function cargar($email = "", $user =""){
        
        if($email == ""){
            $email = $this->session->userdata('email');
        }
        if($user == ""){
            $user = $this->session->userdata('usuario');
        }
       
        $incidentes = array();
        if($user == "ciudadano"){
            $incidenteAux = Incidente_model::incidentes($email);           
        }
        elseif($user == "administrador"){
            $incidenteAux = Incidente_model::incidentes();
        }

        if(!empty($incidenteAux)){
            $i = 0;
            foreach($incidenteAux as $inc){
                $incidentes[$i] = array(
                    'title'=>$inc->fechaAlta,
                    'lat' =>$inc->latitud,
                    'lng' =>$inc->longitud,
                    //  'tipo'=>$inc->tipo
                );
                $i++;
            }
            /**** CARGAR MAPA ****/
   //         log_message("INFO", "lat-> ".$incidentes[$i]['lat']. " long-> ".$incidentes[$i]['long']);

        }
        echo json_encode($incidentes);
       
    }
    
    
    
    public function verIncidente($id){ 
        $this->permisos('ciudadano');
        $this->pagina = "ver_incidente";
        $this->estilo = "incidente";
        $this->javascript = "";
        $this->carpeta = "ciudadano";
        
        $datos = array();
        
        if(Incidente_model::existe($id)){
            
            $imagen = new Imagen_model;
            $incidente = new Incidente_model;
            $usuario = new Usuario_model;
            $incidente->datos($id);
            $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
            $incidente->estado = $incidente->estado($incidente->IdEstado);
            $incidente->rutaImagen = $incidente->rutaImagen = $imagen->ruta($incidente->IdImagen);
            
            $datos['incidente'] = $incidente;
            
        }
        else{
            $datos['error'] = "El incidente indicado no existe actualmente";
        }
        
        $this->mostrar($datos);
        
    }
    
    
    
    public function incidenteAjax($id){
        /*if(!$this->input->is_ajax_request()){
            redirect('404');
        }
        else{*/
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
        //}
        
    }
}

