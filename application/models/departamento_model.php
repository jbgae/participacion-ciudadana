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
}
