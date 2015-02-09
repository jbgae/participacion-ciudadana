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
    
    public function inicializar($idIncidencia, $idImagen = null){
        $aux = FALSE;
        
        $this->fechaReparacion = $this->input->post("fechaReparacion");
        $this->descripcion = $this->input->post("descripcion");
        $this->idIncidencia = $idIncidencia;
        $this->tiempoReparacion = calcularTiempoReparacion();
        $this->idImagen = $idImagen;
        
        if($this->db->insert('departamento', $this)){
            $aux = TRUE;
        } 
        return $aux;
    }
    
    public function datos($idReparacion){
        $query = $this->db->get_where('reparacion', array('Id' => $idReparacion));
        $reparacion = $query->result();              
        
        $this->id = $idReparacion;
        $this->fechaAlta = $reparacion[0]->fechaReparacion;
        $this->descripcion = $reparacion[0]->descripcion;
        $this->direccion = $reparacion[0]->idIncidencia;
        $this->latitud = $reparacion[0]->tiempoReparacion;
        $this->longitud = $reparacion[0]->idImagen;
        
        return $this;
    }
    
    public function eliminar(){
        
    }
}
