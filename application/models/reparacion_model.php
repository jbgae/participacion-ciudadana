<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of reparacion_model
 *
 * @author jbgae_000
 */
class Reparacion_model extends CI_Model{
    
    
    var $fechaReparacion;
    var $descripcion;
    var $idIncidencia;
    var $tiempoReparacion;
    var $idImagen;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
}
