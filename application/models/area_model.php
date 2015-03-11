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
    
    static function areas(){
        self::$db->select("id,nombre");
        $query = self::$db->get('area');        
        $areas = $query->result(); 
        
        return $areas;
    }
}
