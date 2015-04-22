<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of incidente_model
 *
 * @author jbgae_000
 */
class Incidente_model extends CI_Model{
    
    var $fechaAlta;
    var $descripcion;
    var $latitud;
    var $longitud;
    var $IdImagen;
    var $emailUsuario;
    var $IdEstado;
    var $direccion;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    
    public function datos($id){
        
        
        $query = $this->db->get_where('incidencia', array('Id' => $id));
        $incidencia = $query->result();              
        
        $this->id = $id;
        $this->fechaAlta = $incidencia[0]->fechaAlta;
        $this->descripcion = $incidencia[0]->descripcion;
        //$this->direccion = $incidencia[0]->direccion;
        $this->latitud = $incidencia[0]->latitud;
        $this->longitud = $incidencia[0]->longitud;
        $this->IdImagen = $incidencia[0]->IdImagen;
        $this->emailUsuario = $incidencia[0]->emailUsuario;
        $this->IdEstado = $incidencia[0]->IdEstado;
        $this->direccion = $incidencia[0]->direccion;
        
        return $this;
    }
    
    public function email($id){
        $this->db->select('emailUsuario');
        $this->db->from('incidencia');
        $this->db->where('Id', $id);
        $query = $this->db->get();

        $inc = $query->result();

        return $inc[0]->emailUsuario;
    }
    
    public function imagen($id){
        $this->db->select('IdImagen');
        $this->db->from('incidencia');
        $this->db->where('Id', $id);
        $query = $this->db->get();

        $inc = $query->result();

        return $inc[0]->IdImagen;
    }
    
    public function registrar($idImagen = null){
        $aux = FALSE;  
        
        if($idImagen == ""){
            $idImagen = null;
        }
        
        log_message("INFO", "Registrar incidencia");
        log_message("INFO", "Dirección");
        log_message("INFO", $this->input->post("direccion"));
        
        $this->descripcion = $this->input->post("descripcion1");
        $this->latitud = $this->input->post("latitude");
        $this->longitud = $this->input->post("longitude");
       
        
        /*SUBIR*/
        if($this->input->post("email")!= ""){
            $this->emailUsuario = $this->input->post("email");
        }
        else{
            $this->emailUsuario = $this->session->userdata("email");
        }
        $this->IdImagen = $idImagen;
        $this->IdEstado = "2";
        if($this->db->insert('incidencia', $this)){
            $aux = TRUE;
            $codigo = $this->db->insert_id();            
            /**********************/
            $this->db->set('idIncidencia', $codigo);
            $this->db->set('idArea', $this->input->post('areas'));
            if($this->db->insert('incidencia-area')){
                $aux = TRUE;
                /**********************/
                $deps = $this->input->post("departamentos");
                if(!is_array($deps)){
                    $this->db->set('idIncidencia', $codigo);
                    $this->db->set('idDepartamento', $deps); 
                    if($this->db->insert('incidencia-departamento')){
                        $aux = TRUE;
                    }
                    else{
                        $aux = FALSE;
                    }
                    $emps = $this->input->post("empleados");
                    if(!is_array($emps)){
                        $this->db->set('idIncidencia', $codigo);
                        $this->db->set('emailTrabajador', $emps);
                        if($this->db->insert('incidencia-trabajador')){
                            $aux = TRUE;
                        }
                        else{
                            $aux = FALSE;
                        }                        
                    }
                    else{
                        foreach($emps as $empl){                            
                            $this->db->set('idIncidencia', $codigo);
                            $this->db->set('emailTrabajador', $empl);
                            if($this->db->insert('incidencia-trabajador')){
                                $aux = TRUE;
                            }
                            else{
                                $aux = FALSE;
                            }
                        }
                    }
                }
                else{
                    foreach($deps as $departamento){
                        $this->db->set('idIncidencia', $codigo);
                        $this->db->set('idDepartamento', $departamento);
                        if($this->db->insert('incidencia-departamento')){
                            $aux = TRUE;
                            /***********************/
                            $emps = $this->input->post("empleados");
                            if(!is_array($emps)){
                                $this->db->set('idIncidencia', $codigo);
                                $this->db->set('emailTrabajador', $emps);
                                if($this->db->insert('incidencia-trabajador')){
                                    $aux = TRUE;
                                }
                                else{
                                    $aux = FALSE;
                                }                        
                            }
                            else{
                                foreach($emps as $empl){                            
                                    $this->db->set('idIncidencia', $codigo);
                                    $this->db->set('emailTrabajador', $empl);
                                    if($this->db->insert('incidencia-trabajador')){
                                        $aux = TRUE;
                                    }
                                    else{
                                        $aux = FALSE;
                                    }
                                }
                            }
                        }
                        else{
                            $aux = FALSE;
                        }
                    }
                }
            }
            else{
                $aux = FALSE;
            }
        }
        else{
            $aux = FALSE;
        }
        
        return $aux;
    }
    
    public function registrarAjax($codigoImagen = ""){
        $aux = FALSE;
        
        foreach($_POST as $post){
            log_message("INFO", '$_POST->'.$post);
        }
        $this->direccion = $this->input->post("direccion");
        $this->descripcion = $this->input->post("descripcion1");
        $this->latitud = $this->input->post("latitude");
        $this->longitud = $this->input->post("longitude");
        $this->emailUsuario = $this->input->post("email");
        if($this->direccion == ""){
            $this->direccion = null;
        }
        $this->IdEstado = "2";
        if($codigoImagen == ""){
            $this->IdImagen = null;
        }
        else{
            $this->IdImagen = $codigoImagen;
        }
        if($this->db->insert('incidencia', $this)){
            $aux = TRUE;
             $codigo = $this->db->insert_id();            
            /**********************/
            $this->db->set('idIncidencia', $codigo);
            $this->db->set('idArea', $this->input->post('areas'));
            if($this->db->insert('incidencia-area')){
                $aux = TRUE;                
            }
        }
        
        return $aux;
    }
    
    public function estado($id = ""){
        $aux = "";        
        
        if($id != ""){
            $this->db->select("Estado");
            $this->db->where("Id", $id);
            $this->db->from("estado");

            $query = $this->db->get();

            $estado = $query->result();
            $aux = $estado[0]->Estado;
        }        
        
        return $aux;
    }
    
    
    public function area($id = ""){
        $aux = "";        
        
        if($id != ""){
            $this->db->select("IdArea");
            $this->db->where("IdIncidencia", $id);
            $this->db->from("incidencia-area");

            $query = $this->db->get();

            $estado = $query->result();
            $aux = $estado[0]->IdArea;
            
            $this->db->select("nombre");
            $this->db->where("id", $aux);
            $this->db->from("area");

            $query = $this->db->get();

            $estado = $query->result();
            $aux = $estado[0]->nombre;
        }        
        
        return $aux;
    }
    
    public function idImagen($id = ""){
        $aux = "";        
        
        if($id != ""){
            $this->db->select("IdImagen");
            $this->db->where("Id", $id);
            $this->db->from("incidencia");

            $query = $this->db->get();

            $estado = $query->result();
            $aux = $estado[0]->IdImagen;
        }
        
        return $aux;
    }
    
    
    
    static function incidentes($email = ""){
        if($email != ''){
            self::$db->where('emailUsuario', $email);
            self::$db->order_by('fechaAlta', 'desc');
            self::$db->group_by('fechaAlta');            
            $query = self::$db->get("incidencia");          
        }
        else{
            self::$db->order_by('fechaAlta', 'desc');
            self::$db->group_by('fechaAlta');
            $query = self::$db->get("incidencia");            
        }
        
        $incidentes = $query->result();
        
        return $incidentes;
    }
    
    static function incidentesTrabajador($email){
        //self::$db->where('emailTrabajador', $email);
        //$query = self::$db->get("incidencia-trabajador");
        //$query = self::$db->query("SELECT * FROM incidencia, incidencia-trabajador WHERE incidencia.Id LIKE (SELECT IdIncidencia FROM incidencia-trabajador WHERE emailTrabajador LIKE $email )");
        //self::$db->where('emailTrabajador', $email);
        //$query = self::$db->get("incidencia-trabajador"); 
        //$ids = $query->result();
        
        self::$db->where("emailTrabajador", $email);
        self::$db->from("incidencia-trabajador");

        $query = self::$db->get();

        $emails = $query->result();
        $aux = array();
        foreach($emails as $id){            
            log_message("INFO", "id->$id->idIncidencia");
            //$query = self::$db->query("SELECT * FROM incidencia WHERE Id = '$id->idIncidencia'");
            self::$db->where("Id", $id->idIncidencia);
            self::$db->from("incidencia");
            $i = $query->result();

            $query = self::$db->get();
            array_push($aux, $i); 
        }
        
        return $aux;
    }


    static function existe($id){
        $aux = FALSE;
        log_message("INFO", "PRUEBA--------------".$id);
        if($id != ''){
            $query = self::$db->get_where("incidencia", array('Id'=>$id));

            if($query->num_rows() > 0){
                $aux = TRUE;
            }
        }
        return $aux;
    }
    
    
    
    static function incidenteUsuario($email,$tipo, $fecha){
        log_message("INFO", "incidentes->>>>>>>>>>>>>>>".$tipo);
        if($tipo != ""){
            if($tipo == "administrador"){
                self::$db->select('incidencia.Id, incidencia-trabajador.idIncidencia');
                self::$db->from('incidencia, incidencia-trabajador');
                self::$db->where('incidencia.Id = incidencia-trabajador.idIncidencia');
                self::$db->where('incidencia.fechaAlta >=',date('Y-m-d',$fecha));
                self::$db->where('incidencia-trabajador.emailUsuario',$email);

            }        
            else if($tipo == "empleado"){
                self::$db->select('Id');
                self::$db->from('incidencia');
                self::$db->where('fechaAlta >=',date('Y-m-d', $fecha)); 
            }
            else{

            }

            $query = self::$db->db->get();
            $evento = $query->result();

            return count($evento);
        }
        else{
            return 0; 
        }       
        
    }
    
    public function empleados($id){
        $aux = array();
        
        $this->db->select("emailTrabajador");
        $this->db->where("IdIncidencia", $id);
        $this->db->from("incidencia-trabajador");

        $query = $this->db->get();

        $emails = $query->result();
        
        if(!empty($emails)){
            foreach($emails as $email){
                $this->db->select("nombre, apellido1, apellido2");
                $this->db->where("email", $email->emailTrabajador);
                $this->db->from("usuario");
                $query = $this->db->get();
                
                $nomb = $query->result();
                
                $name = $nomb[0]->nombre ." ". $nomb[0]->apellido1 . " " . $nomb[0]->apellido2; 
                
                array_push($aux, $name);
            }            
        }
        
        return $aux;
    }
    
    public function actualizar($id){
        $aux = FALSE;        
        
        $this->IdEstado = $this->input->post('sele_estado');

        if($this->db->update('incidencia', $this, array('Codigo'=> $id))){
            $aux = TRUE;
            
            $query = $this->db->get_where('reparacion', array('IdIncidencia' => $id));
            $count = $query->num_rows();
            
            $data = array(
                "descripcion"  => $this->input->post("descripcion"),
                "IdIncidencia" => $id,
                "tiempoReparacion" => $this->input->post("trepa"),
                "fechaReparacion" => $this->input->post("fecharepa")
            );
            
            if($count == 0){
                $this->db->insert('reparacion', $data);
            }
            else{
                $this->db->where('IdIncidencia', $id);
                $this->db->update('reparacion', $data); 
            }
        }        
        
        return $aux;
    }
    
}
