<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of usuario_model
 *
 * @author jbgae_000
 */
class Usuario_model extends CI_Model{
    
    var $email;
    var $dni;
    var $nombre;   
    var $apellido1;
    var $apellido2;
    var $direccion;
    var $telefono;
    var $password;
    var $IdPrivilegio;
    var $validado;
    var $numeroIntentos;
    var $fechaUltimoIntento;
    var $fechaUltimoAcceso;   
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    
    //Por defecto inicializamos como ciudadano
    public function inicializar($privilegio = "2", $datos = ""){
        $aux = FALSE;
                
        if($datos == ""){
            $this->email = strtolower($this->input->post('email'));
            $this->dni = $this->input->post('dni');
            $this->nombre = mb_strtolower($this->input->post('nombre'), "UTF-8");
            $this->apellido1 =  mb_strtolower($this->input->post('apellido1'), "UTF-8");
            $this->apellido2 = mb_strtolower($this->input->post('apellido2'), "UTF-8");
            $this->direccion = mb_strtolower($this->input->post('direccion'), "UTF-8");
            $this->telefono = $this->input->post('telefono');
            $this->validado = 0;
            $this->numeroIntentos = 0;
            $this->fechaUltimoIntento = date('Y/m/d h:i:s');
            $this->password = md5($this->input->post('password'));
            $this->IdPrivilegio = $privilegio;
            
            if($this->db->insert('Usuario', $this)){
                $aux = TRUE;
            } 
        }
        else{
            if((!empty($datos))){
                $datos['IdPrivilegio'] = $privilegio;
                if($this->db->insert('usuario', $datos)){
                    $aux = TRUE;
                }
            }
        }
        
        return $aux;
    }
    
    public function actualizar($email, $datos = ''){
        $aux = FALSE;        
        
        if($datos != ''){
            if(!empty($datos) ){
                if($this->db->update('usuario', $datos, array('email'=> $email))){
                    $aux = TRUE;
                }            
            }
        }
        else{
            $this->email = $email;
            $this->validado = 0;
            $this->numeroIntentos = 0;
            $this->fechaUltimoIntento = date('Y/m/d h:i:s');
           

            if($this->db->update('usuario', $this, array('email'=> $email))){
                $aux = TRUE;
            }
        }
        
        return $aux;
    }   
    
    public function datos($email){
        log_message("INFO", "/******FUNCION DATOS**********/");
        log_message("INFO", "email:". $email);
        $query = $this->db->get_where('usuario', array('email' => $email));
        $usuario = $query->result();              
        
        $this->email = $email;
        $this->nombre = $usuario[0]->nombre;
        $this->apellido1 = $usuario[0]->apellido1;
        $this->apellido2 = $usuario[0]->apellido2;
        $this->direccion = $usuario[0]->direccion;
        $this->telefono = $usuario[0]->telefono;
        $this->password = $usuario[0]->password;
        $this->validado = $usuario[0]->validado;
        $this->numeroIntentos = $usuario[0]->numeroIntentos;
        $this->fechaUltimoIntento = $usuario[0]->fechaUltimoIntento;
        $this->IdPrivilegio = $usuario[0]->IdPrivilegio;
    
        return $this;
    }
    
    public function email($email = ''){
        if($email != ''){
            $this->email = $email;
        }
       
        return $this->email;
    }
    
    public function dni($email = ''){
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('dni');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->dni;
            }
        }
       
        return $this->dni;
    }
    
    public function nombre($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('nombre');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->nombre;
            }
        }
        else{
            $aux = $this->nombre;
        }
        
        return $aux;
    }
    
    public function apellido1($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('apellido1');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->apellido1;            
            }
        }
        else{
            $aux = $this->apellido1;
        }    
        
        return $aux;
    }
    
    public function apellido2($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('apellido2');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->apellido2;
            }        
        }
        else{
            $aux = $this->apellido2;
        }
        
        return $aux;
    }
    
    public function direccion($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('direccion');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->direccion;
            }
        }
        else{
            $aux = $this->direccion;
        }
        
        return $aux;
    }
    
    public function telefono($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('telefono');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->telefono;
            }
        }
        else{
            $aux = $this->telefono;
        }
        return $aux;
    }
    
    public function password($email = ''){
        $aux = '';

        if($email != ''){
            if($this->existe($email)){
                $this->db->select('password');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->password;
            }
        }
        else{
            $aux = $this->password;
        }
        
        return $aux;
    }
    
    public function validado($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('validado');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->validado;            
            }
        }
        else{
            $aux = $this->validado;
        }
        
        return $aux;
    }
    
    public function fechaUltimoIntento($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('fechaUltimoIntento');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->fechaUltimoIntento;
            }
        }
        else{
            $aux = $this->fechaUltimoIntento;
        }
        
        return date('d/m/Y H:i:s', strtotime($aux));
    }
    
    public function numeroIntentos($email = ''){
        $aux = '';
        
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('numeroIntentos');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->numeroIntentos;
            }
        }
        else{
            $aux = $this->numeroIntentos;
        }
        
        return $aux;
    }
    
    
    public function fechaUltimoAcceso($email = ''){
        $aux = '';  
        if($email != ''){
            if($this->existe($email)){
                $this->db->select('fechaUltimoAcceso');
                $this->db->from('usuario');
                $this->db->where('email', $email);
                $query = $this->db->get();

                $usuario = $query->result();

                $aux = $usuario[0]->fechaUltimoAcceso;
            }    
        }
        else{
            $aux = $this->fechaUltimoAcceso;
        }
        
        return date('d/m/Y H:i:s', strtotime($aux));
    }
    
    public function permiso($email = ""){
        $aux = "";
        if($email == ""){
            $aux = $this->IdPrivilegio;  
        }
        else{
            $this->db->select('IdPrivilegio');
            $query = $this->db->get_where('usuario', array('email' => $email));
            $privil = $query->result();
            $aux = $privil[0]->IdPrivilegio;      
        }
        
        if($aux != 'ciudadano' || $aux != 'administrador'){
            $this->db->select('Nivel');
            $query = $this->db->get_where('privilegio', array('Id' => $aux));
            $privil = $query->result();
            log_message("INFO","**********************");
            log_message("INFO", $this->db->last_query());
            $aux = $privil[0]->Nivel;
        }
        
        return $aux;
    }
    
    public function login($email, $pass){
        $aux = FALSE;
        
        if($this->existe($email)){
            if(md5($pass) == $this->pass($email)){
                $aux = TRUE; 
            }
        }
       
        return $aux;
    }   
    
    static function existe($email){
        $aux = FALSE;
        
        if($email != ''){
            $query = self::$db->get_where("usuario", array('email'=>$email));

            if($query->num_rows() > 0){
                $aux = TRUE;
            }
        }
        return $aux;
    }
}
