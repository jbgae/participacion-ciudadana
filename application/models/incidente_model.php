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
        
        return $this;
    }
    
    public function registrar($idImagen = null){
        $aux = FALSE;  
        
        if($idImagen == ""){
            $idImagen = null;
        }
        
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
        $this->descripcion = $this->input->post("descripcion1");
        $this->latitud = $this->input->post("latitude");
        $this->longitud = $this->input->post("longitude");
        $this->emailUsuario = $this->session->userdata("email");
        $this->direccion = null;
        $this->IdEstado = "2";
        if($codigoImagen == ""){
            $this->IdImagen = null;
        }
        else{
            $this->IdImagen = $codigoImagen;
        }
        if($this->db->insert('incidencia', $this)){
            $aux = TRUE;
        }
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
            self::$db->group_by('fechaAlta');
            $query = self::$db->get("incidencia");          
        }
        else{
            self::$db->group_by('fechaAlta');
            $query = self::$db->get("incidencia");            
        }
        
        $incidentes = $query->result();
        
        return $incidentes;
    }
    
    static function incidentesTrabajador($email){
        self::$db->where('emailTrabajador', $email);
        $query = self::$db->get("incidencia-trabajador");
        $incidentes = $query->result();
        
        return $incidentes;
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
}
