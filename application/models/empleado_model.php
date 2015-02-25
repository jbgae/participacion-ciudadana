<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of empleado_model
 *
 * @author jbgae_000
 */
class Empleado_model extends Usuario_model{
    
    var $emailTrabajador;
    var $idDepartamento;
    
    private static $db;
    
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    public function inicializar(){
        $aux = FALSE;    
   
        $usuario = new Usuario_model(); 
        if($usuario->inicializar('3')){ 
            
            $this->emailTrabajador = $this->input->post("email");
            $this->idDepartamento = $this->input->post("departamentos");
            
            $this->db->set('emailTrabajador', $this->emailTrabajador);
            $this->db->set('idDepartamento', $this->idDepartamento);
            if($this->db->insert('trabajador')){
                $aux = TRUE;
            }
        }
        return $aux;
    }
 
    public function departamento($idEmpleado){
        $aux = "Sin departamento";
        $query = $this->db->get_where("trabajador", array("emailTrabajador"=> $idEmpleado));
        $idDepartamento = $query->result();
        if(!empty($idDepartamento)){
            $query2 = $this->db->get_where("departamento", array("idDepartamento"=> $idDepartamento[0]->idDepartamento));
            $nombre = $query2->result();
             if(!empty($nombre))
                return $nombre[0]->nombre;
             else
                 return $aux;
        }
        else{
            return $aux;
        }       
    }
    
    static function empleados(){
        self::$db->where('idPrivilegio', "3");
        $query = self::$db->get('usuario');
        
        return $query->result();        
    }
    
    
    
}
