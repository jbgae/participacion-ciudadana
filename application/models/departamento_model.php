<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of departamento_model
 *
 * @author jbgae_000
 */
class Departamento_model extends CI_model{

    var $nombre;
    var $descripcion;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    public function inicializar(){
        $aux = FALSE;
        
        $this->nombre = mb_strtolower($this->input->post("nombreDepartamento"), "UTF-8");
        $this->descripcion = $this->input->post("descripcionDepartamento");
        if($this->db->insert('departamento', $this)){
            $aux = TRUE;
        } 
        return $aux;
    }
    
    public function datos($id){
        $query = $this->db->get_where('departamento', array('Id' => $id));
        $incidencia = $query->result();              
        
        $this->id = $id;
        $this->nombre = $incidencia[0]->nombre;
        $this->descripcion = $incidencia[0]->descripcion;
        
        return $this;
    }
    
    public function eliminar($id){
        $aux = FALSE;
        
        if($id != ''){
            if($this->existe($id)){
                if($this->db->delete('departamento', array('Id' => $id))){
                    $aux = TRUE;
                }
            }
        }
        else{ 
            if($this->existe($this->id)){ 
                if($this->db->delete('departamento', array('Id' => $this->id))){
                    $aux = TRUE;
                }
            }
        }                
                
        return $aux;
    }
    
    static function departamentos(){
        $query = self::$db->get('departamento');
        
        return $query->result();        
    }
    
    static function numeroEmpleados($id){
        self::$db->like('idDepartamento', $id);
        self::$db->from('trabajador');
        return self::$db->count_all_results();
    }
    
    static function empleados($departamento){
       
        $emailEmpleados = array();        
        $empleadoAux = array();
        $result = array();
                
        foreach($departamento as $key=>$dep){
            if($dep != ''){
                self::$db->select("emailTrabajador");
                self::$db->where('idDepartamento', $key+1);
                self::$db->from("trabajador");
                $query = self::$db->get();
                $empleados = $query->result();
                if($query->num_rows() > 0){
                    foreach($empleados as $empl){
                        self::$db->select('nombre, apellido1, apellido2');
                        self::$db->where('email', $empl->emailTrabajador);
                        self::$db->from("usuario");
                        $query2 = self::$db->get();
                        $empleadoAux = $query2->result();
                        $result[$empl->emailTrabajador] = $empleadoAux[0]->nombre. " ". $empleadoAux[0]->apellido1. " ".$empleadoAux[0]->apellido2;
                    }
                }
            }
        }
        
        return $result;
    }
}
