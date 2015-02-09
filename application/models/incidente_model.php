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
    var $rutaImagen;
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
        $this->rutaImagen = $incidencia[0]->rutaImagen;
        $this->emailUsuario = $incidencia[0]->emailUsuario;
        $this->IdEstado = $incidencia[0]->IdEstado;
        
        return $this;
    }
    
    public function registrar(){
        $aux = FALSE;
        $this->load->library('upload');
        if (!empty($_FILES['fileToUpload']['name']))
        {
            $config['upload_path'] = base_url()."imagenes";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';     

            $this->upload->initialize($config);

            if ($this->upload->do_upload('fileToUpload')){
                $config['upload_path'] =  realpath("$path/images/fotos/" );
                $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG|GIF';
                $config['max_size']	= '0';
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                $this->load->library('upload',$config);
            }
            //else{
                //echo $this->upload->display_errors();
              //  return $aux;
            //}
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
