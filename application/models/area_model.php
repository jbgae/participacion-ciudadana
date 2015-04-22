<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of area_model
 *
 * @author jbgae_000
 */
class Area_model extends CI_Model{
    var $nombre;
    var $descripcion;
    var $idImagen;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    public function areaIncidencia($idIncidencia){
        $aux = "";
        $this->db->select('IdArea');
        $this->db->from('incidencia-area');
        $this->db->where('IdIncidencia', $idIncidencia);
        $query = $this->db->get();

        $inc = $query->result();

        //return $inc[0]->IdIncidencia;
        
        if($inc[0]->IdArea > 0 && $inc[0]->IdArea < 9){
            $this->db->select('nombre');
            $this->db->from('area');
            $this->db->where('id', $inc[0]->IdArea);
            $query = $this->db->get();

            $inc = $query->result();
            $aux = $inc[0]->nombre;
        }
        return $aux;
    }
    
    static function areas(){
        self::$db->select("id,nombre");
        $query = self::$db->get('area');        
        $areas = $query->result(); 
        
        return $areas;
    }
}
