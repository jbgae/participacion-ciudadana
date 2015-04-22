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
        $this->load->model('departamento_model');
        $this->load->model('area_model');
        $this->load->library('form_validation');
        $this->load->library('My_PHPMailer');
        $this->load->helper('directory');
    }
    
    private function _validar(){
          
        $this->form_validation->set_rules('latitude', 'Latitud', 'trim|xss_clean');        
        $this->form_validation->set_rules('longitude', 'Longitud', 'trim|xss_clean');               
        $this->form_validation->set_rules('descripcion1', 'Longitud', 'trim|required|xss_clean');        

        /*if (empty($_FILES['fileToUpload']['name'])){
            $this->form_validation->set_rules('fileToUpload', 'La foto', 'required');
        }*/
        
        $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');        
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        
        return $this->form_validation->run();
        
    }
    
    private function _validarModificar(){
        $this->form_validation->set_rules('descripcion','required|trim|xss_clean');
        $this->form_validation->set_rules('fecharepa','required|trim|xss_clean');
        $this->form_validation->set_rules('trepa','required|trim|xss_clean|callback_checkDateFormat');
        
         $this->form_validation->set_message('required', '%s no puede estar vacio');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');        
        $this->form_validation->set_message('xss_clean', ' %s no es válido');
        
        return $this->form_validation->run();
    }
    
    function checkDateFormat($date) {
        if (preg_match("/[0-31]{2}\/[0-12]{2}\/[0-9]{4}/", $date)) {
            if(checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4))){
                return true;
            }
            else{
                return false;
            }
        } 
        else {
            return false;
        }
    } 
    
    public function registrar(){
        $this->permisos('ciudadano');
        $this->pagina = "incidente";
        $this->javascript = array("jquery.multi-select","select","incidente", "gmaps","mapa");
        $this->estilo = array("select");
        $this->carpeta = "ciudadano";
        
        $datos['boton'] = array(            
            "id"=>"btn-submit",
            "class"=>"button",
            'name'=>'button', 
            'value'=>'Registrar incidente'
        );
        
        $areas = Area_model::areas();
        $datos['areas'] = array("0"=>"-- Seleccione el área --");
        foreach($areas as $area){
            array_push($datos['areas'], $area->nombre);
        }
        
        $departamentos = Departamento_model::departamentos();
        $datos['departamentos'] = array();
        foreach($departamentos as $dep){
            array_push($datos['departamentos'], $dep->nombre);
        }
        
        $datos['empleados'] = array();
        
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
                $emps = $this->input->post("empleados");
                
                if(!is_array($emps)){
                    $datosEmail = array(
                        'direccion' => '',
                        'nombre'    => 'Ayuntamiento de Barbate',
                        'asunto'    => 'Asignación incidencia',
                        'texto'     => 'Se le ha asignado una incidencia',
                        'destino' => $emps
                    );  
                    //Enviamos email de confirmación
                    $this->my_phpmailer->Enviar($datosEmail); 
                }
                else{
                    foreach($emps as $empl){ 
                        $datosEmail = array(
                            'direccion' => '',
                            'nombre'    => 'Ayuntamiento de Barbate',
                            'asunto'    => 'Asignación incidencia',
                            'texto'     => 'Se le ha asignado una incidencia',
                            'destino' => $empl
                        );  
                        //Enviamos email de confirmación
                        $this->my_phpmailer->Enviar($datosEmail); 
                    } 
                }
                $datos['mensaje'] = "La incidencia se ha registrado satisfactoriamente";
            }
        }
        
        $this->mostrar($datos);
    }
    
    public function registrarAjax($fecha){
        log_message("INFO", "Entra en registrar ajax");
        
        $codigoImagen = "";
        foreach($_POST as $key => $value){
            log_message("INFO", "key--->".$key);
            log_message("INFO", "value--->".$value);
        }

        if($_POST["nombreFoto"] != ""){ 
            log_message("INFO", "Entra en nombreFoto");
            $imagen = new Imagen_model;
            $codigoImagen = $imagen->registrarAjax($fecha);
        }
        $incidente = new Incidente_model;
        if($incidente->registrarAjax($codigoImagen)){
            log_message("INFO", "Entra en registrar incidente ajax");
            /*$mensaje = "El incidente se ha registrado con éxito";
            echo '<div class="text-success">'.$mensaje.'</div>';*/
            echo TRUE;
        }
        else{
           /* $error = 'No se ha podido registrar el incidente en este momento';
            echo '<div class="text-error">'.$error.'</div>';*/
            echo FALSE;
        }
    } 
    
   
    
    public function historial(){
        $this->permisos('ciudadano');
        $this->titulo = "Historial";
        $this->pagina = "historial";
        $this->carpeta = "ciudadano";
        $this->estilo = array("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min", 
                              "//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui",
                              "//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui",
                              "formulario_modal");
        $this->javascript = array("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min",
                                  "datatable",
                                  "//code.jquery.com/ui/1.11.2/jquery-ui", 
                                  "modal");
        
        $datos['incidentes'] = array();
        log_message("INFO", "== INCIDENCIAS EMPLEADOS ==".$this->session->userdata('usuario'));
        if($this->session->userdata('usuario') == "ciudadano"){
            $incidenteAux = Incidente_model::incidentes($this->session->userdata('email'));             
        }
        elseif($this->session->userdata('usuario') == "empleado"){
            //$i = new Incidente_model;
            $incidenteAux = Incidente_model::incidentesTrabajador($this->session->userdata('email'));
            /*$aux = array();
            foreach($incidenteAux as $inc){
                array_push($aux, $i->datos($inc));
            }
            $incidenteAux = $aux;*/
        }
        elseif($this->session->userdata('usuario') == "administrador"){
            $incidenteAux = Incidente_model::incidentes();
        }
        $usuario = new Usuario_model;
        $incidenteAux1 = new Incidente_model;
        $imagen = new Imagen_model;
        
        if(!empty($incidenteAux)){
            if(is_array($incidenteAux)){
                foreach($incidenteAux as $incidente){
                    if(is_array($incidente)){
                        log_message("INFO", "Es un array  ".print_r($incidente,1));
                        foreach($incidente as $i){
                            log_message("INFO", "Es un array  ".print_r($i,1));
                            if(Incidente_model::existe($i->idIncidencia)){
                                $incidenteAux2 = new Incidente_model;
                                $incidenteAux2->datos($i->idIncidencia);
                                $incidenteAux2->usuario = $usuario->nombre($incidenteAux2->email($i->idIncidencia))." ".$usuario->apellido1($incidenteAux2->email($i->idIncidencia))." ".$usuario->apellido2($incidenteAux2->email($i->idIncidencia)) ;
                                //$incidenteAux2->estado =  $incidenteAux1->estado($incidenteAux2->estado($incidente->idIncidencia));
                                $incidenteAux2->rutaImagen = $imagen->ruta($incidenteAux1->imagen($i->idIncidencia));
                                $incidenteAux2->Id = $i->idIncidencia;
                                array_push($datos['incidentes'], $incidenteAux2);
                            }
                        }
                        
                        /*$incidenteAux2 = new Incidente_model;
                        $incidenteAux2->datos($incidente->idIncidencia);
                        $incidenteAux2->usuario = $usuario->nombre($incidenteAux2->email($incidente->idIncidencia))." ".$usuario->apellido1($incidenteAux2->email($incidente->idIncidencia))." ".$usuario->apellido2($incidenteAux2->email($incidente->idIncidencia)) ;
                        //$incidenteAux2->estado =  $incidenteAux1->estado($incidenteAux2->estado($incidente->idIncidencia));
                        $incidenteAux2->rutaImagen = $imagen->ruta($incidenteAux1->imagen($incidente->idIncidencia));
                        $incidenteAux2->Id = $incidente->idIncidencia;
                        array_push($datos['incidentes'], $incidenteAux2);*/
                    }
                    else if(is_object($incidente)){
                        foreach($incidente as $i){
                            log_message("INFO", $i);
                        }                        
                        $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
                        $incidente->estado = $incidenteAux1->estado($incidente->IdEstado);                
                        $incidente->rutaImagen = $imagen->ruta($incidente->IdImagen);
                        
                        array_push($datos['incidentes'], $incidente);
                    }
                }                
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
            else{
                $incidenteAux = Incidente_model::incidentes();
            }
            $usuario = new Usuario_model;
            $incidenteAux1 = new Incidente_model;
            $imagen = new Imagen_model;

            if(!empty($incidenteAux)){
                foreach($incidenteAux as $incidente){
                    $incidente->usuario = ucfirst($usuario->nombre($incidente->emailUsuario)).' '. ucfirst($usuario->apellido1($incidente->emailUsuario)). ' '. ucfirst($usuario->apellido2($incidente->emailUsuario));
                    $incidente->estado = $incidenteAux1->estado($incidente->IdEstado);
                    $incidente->rutaImagen = $imagen->ruta($incidente->IdImagen);
                    $file_name = basename($incidente->rutaImagen);
                    if(!file_exists(FCPATH."imagenes/$file_name")){
                        log_message("INFO", FCPATH."imagenes/$file_name");
                        $incidente->rutaImagen = "http://www.aytobarbate.es/participacion_ciudadana/imagenes/1_thumb.jpg";
                    }
                    
                    $key =  date("d-m-Y", strtotime($incidente->fechaAlta));
                    log_message("INFO", "Fecha=>". $incidente->fechaAlta);
                    if(!isset($incidentes[$key])){
                        $incidentes[$key] = array();
                    }
                    
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
    
    public function historialMapaAjax($email = "", $user=""){
        $incidentes = array();
        if($user == "ciudadano"){
            $incidenteAux = Incidente_model::incidentes($email);           
        }
        else{
            $incidenteAux = Incidente_model::incidentes();
        }
        
        $usuario = new Usuario_model;
        $incidenteAux1 = new Incidente_model;
        if(!empty($incidenteAux)){
            foreach($incidenteAux as $incidente){
                $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
                $incidente->estado = $incidenteAux1->estado($incidente->IdEstado);
                array_push($incidentes, $incidente);
            }
        }
        echo json_encode($incidentes);
    }
  
    public function mapa(){
        
        $this->permisos('ciudadano');
        $this->titulo = "Historial mapa";
        $this->pagina = "mapa";
        $this->carpeta = "ciudadano";
        $this->javascript = array("gmaps","mapa_incidentes");
        $this->estilo = array("mapa");
       
        $this->mostrar();
    }
    
    
    public function cargar($email = "", $user = ""){
        log_message("INFO", " Cargar: Email--> ".$email);
        if($email == ""){
            $email = $this->session->userdata('email');
        }
        if($user == ""){
            $user = $this->session->userdata('usuario');
        }
        if($email == null || $email == "null"){
            $user = "administrador";
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
                    'est' =>$inc->IdEstado
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
        log_message("INFO", "Incidente--->".$id);
        $imagen = new Imagen_model;
        if(Incidente_model::existe($id)){
            $incidente = new Incidente_model;
            $area = new Area_model;
            $usuario = new Usuario_model;
            $incidente->datos($id);
            $incidente->usuario = $usuario->nombre($incidente->emailUsuario).' '. $usuario->apellido1($incidente->emailUsuario). ' '.$usuario->apellido2($incidente->emailUsuario);
            $incidente->estado = $incidente->estado($incidente->IdEstado);
            $incidente->rutaImagen = $imagen->ruta($incidente->IdImagen);
            $incidente->area = $area->areaIncidencia($id);

            echo json_encode($incidente);

        }
        else{
            echo "El incidente indicado no existe actualmente";
        } 
        //}
        
    }
    
    public function modificar($id){
        
        $this->permisos("administrador");
        
        $this->estilo = array("mapa");
        $this->pagina = "modificar_incidente";
        $this->javascript = array("gmaps","jquery.multi-select","select","incidente","mapaIncidente");
        $this->estilo = array("select");
        $this->carpeta = "administrador";
        
        if(Incidente_model::existe($id)){
            
            $incidente = new Incidente_model;
            $imagen = new Imagen_model;
            $aux = $incidente->datos($id);
            $datos['options'] = array("0"=>"- - Elige estado - -","1"=>"Reparado","2"=>"Proceso","3"=>"Rechazado");
            $datos['estado'] = $incidente->estado($incidente->IdEstado);
            $datos['area'] = $incidente->area($id);
            $datos['empleados'] = $incidente->empleados($id);
            $departamentos = Departamento_model::departamentos();
            $datos['departamentos'] = array();
            foreach($departamentos as $dep){
                array_push($datos['departamentos'], $dep->nombre);
            }
            
            if($incidente->IdImagen != NULL){
                $datos['imagen'] = $imagen->ruta($incidente->IdImagen);
            }
            else{
                $datos['imagen'] = base_url()."imagenes/1_thumb.jpg";
            }
            $datos['incidencia'] = $aux; 
            
            $query = $this->db->get_where('reparacion', array('IdIncidencia' => $id));
            $count = $query->num_rows();
            
            $datos['textArea'] = array( 
              'name'        => 'descripcion',
              'id'          => 'descripcion',
              'rows'        => '8'
            );
            
            $datos['inputFecha'] = array( 
              'name'        => 'fecharepa',
              'id'          => 'fecharepa',
              'placeholder' => 'dd/mm/aaaa'  
            );
            
            $datos['inputTiempo'] = array( 
              'name'        => 'trepa',
              'id'          => 'trepa',
              'placeholder' => 'Tiempo de reparacion / horas'  
            );
            
            if($count != 0){
                $result = $query->result();
                $datos['textArea']['value'] = $result[0]->descripcion; 
                $datos['inputFecha']['value'] = $result[0]->fechaReparacion; 
                $datos['inputTiempo']['value'] = $result[0]->tiempoReparacion; 
            }
            
            if($this->_validarModificar()){
                if($incidente->actualizar()){
                    
                }
                else{
                    
                }
            }
            
           /* if($this->_validarModificar()){
                if($incidente->actualizar()){
                    
                }
                else{
                    
                }
            }*/
            
        }
        else{
            show_404();
        }
        
        $this->mostrar($datos);
    }
    
    /*public function nuevas(){
        $notificaciones = array();
        $notificaciones['incidentes'] = Incidente_model::incidenteUsuario($this->session->userdata('email'),$this->session->userdata("usuario"), $this->session->userdata('ultimoAcceso'));
        //echo $this->session->userdata('email');
        echo json_encode($notificaciones);
        
    }*/
    
    public function subirImagen($fecha){
        log_message("INFO", "Entra en subir imagen");
        foreach($_FILES as $file){
            log_message("INFO",$file['name']); 
        }
        
        if(isset($_FILES['myFile'])){
            $uploadfile = $_SERVER['DOCUMENT_ROOT']."/participacion_ciudadana/imagenes/$fecha".$_FILES["myFile"]["name"];
            $trozos = explode(".", $_FILES["myFile"]["name"]); 
            
            
            if(count($trozos) != 1){
                move_uploaded_file($_FILES["myFile"]["tmp_name"], $uploadfile);
            }
            else{
                move_uploaded_file($_FILES["myFile"]["tmp_name"], $uploadfile.".jpg");
            }
        }
        else if(isset($_FILES['Filedata'])){
            log_message("INFO", "----FILE----");
            $uploadfile = $_SERVER['DOCUMENT_ROOT']."/participacion_ciudadana/imagenes/$fecha".$_FILES["Filedata"]["name"];
            move_uploaded_file($_FILES["Filedata"]["tmp_name"], $uploadfile);
        }
    }
    
    public function redimensionar(){
        $carpeta = "./imagenes/";
        log_message("INFO", "La carpeta es: ". $carpeta);
        $fotos = directory_map($carpeta);
        foreach($fotos as $foto){
            log_message("INFO", "foto->".$foto);
            $config['image_library'] = 'gd2';
            $config['source_image'] = realpath($carpeta.$foto);
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['new_image']=realpath($carpeta);
            $config['width'] = 200;
            $config['height'] = 200;
            $this->image_lib->initialize($config);
            if(!$this->image_lib->resize()){
                log_message('error', "Error imagen:".$this->image_lib->display_errors());
            }
        }
    }
}

