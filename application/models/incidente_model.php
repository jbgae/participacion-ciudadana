<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of incidente_model
 *
 * @author jbgae_000
 */
class Incidente_model extends CI_Model{
    
    var $fechaAlta;
    var $descripcion;
    var $direccion;
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
        $this->direccion = $incidencia[0]->direccion;
        $this->latitud = $incidencia[0]->latitud;
        $this->longitud = $incidencia[0]->longitud;
        $this->IdImagen = $incidencia[0]->IdImagen;
        $this->emailUsuario = $incidencia[0]->emailUsuario;
        $this->IdEstado = $incidencia[0]->IdEstado;
        
        return $this;
    }
    
    public function registrar($idImagen = null){
        $aux = FALSE;
        
        $this->descripcion = $this->input->post("descripcion1");
        if($this->input->post("direccion1") == ""){
            $this->direccion = null;
        }
        else{
            $this->direccion = $this->input->post("direccion1");
        }
        $this->latitud = $this->input->post("latitude");
        $this->longitud = $this->input->post("longitude");
        $this->emailUsuario = $this->session->userdata("email");
        $this->IdImagen = $idImagen;
        $this->IdEstado = "2";
        if($this->db->insert('incidencia', $this)){
            $aux = TRUE;
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
    
    static function existe($id){
        $aux = FALSE;
        
        if($id != ''){
            $query = self::$db->get_where("incidencia", array('Id'=>$id));

            if($query->num_rows() > 0){
                $aux = TRUE;
            }
        }
        return $aux;
    }
}
