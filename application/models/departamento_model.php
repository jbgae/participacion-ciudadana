<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of departamento_model
 *
 * @author jbgae_000
 */
class Departamento_model extends CI_model{

    var $nombre;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    public function inicializar(){
        $aux = FALSE;
        
        $this->nombre = $this->input->post("nombreDepartamento");
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
}
