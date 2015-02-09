<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of imagen_model
 *
 * @author jbgae_000
 */
class Imagen_model extends CI_Model{
   
    var $ruta;
    var $nombre;
    var $extension;
    
    private static $db;
        
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
        $this->load->library('image_lib');
        $this->load->helper('file');
    }
    
    public function inicializar(){
        $aux = FALSE;
        $path = getcwd();
        log_message("info", "/*************Inicializar imagen*************/");
        if(!is_dir(realpath("$path/imagenes"))){           
            mkdir("$path/archivos/imagenes", 0755);     
        }   
        $config['upload_path'] =  realpath("$path/imagenes/");
        $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG|GIF';
        $config['max_size']	= '0';
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $this->load->library('upload',$config);

        if ($this->upload->do_upload('fileToUpload')){ 
            log_message('info','Archivo subido con éxito');
            $archivo = $this->upload->data();     
            $config['image_library'] = 'gd2';
            //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
            $config['source_image'] = realpath("$path/imagenes/".$archivo['file_name'] );
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
            if(!is_dir(realpath("$path/imagenes/"))){           
                mkdir("$path/imagenes/", 0755);     
            }
            $config['new_image']=realpath("$path/imagenes/" );
            $config['width'] = 200;
            $config['height'] = 200;
            $this->image_lib->initialize($config);
            if(!$this->image_lib->resize())
                log_message('error', "Error imagen:".$this->image_lib->display_errors());
            $this->image_lib->clear();
            unlink(realpath("$path/imagenes/".$archivo['file_name'] ));

            $this->ruta = base_url().'imagenes/'.$archivo['raw_name'].'_thumb'.$archivo['file_ext'];
            $this->nombre = $archivo['raw_name'];
            $this->extension = $archivo['file_ext'];

            if($this->db->insert('imagen', $this)){
                $aux = TRUE;
            }
        }
        else{
            log_message('error', "Error imagen 2:".$this->upload->display_errors());
        }
        
        return $aux;        
    }
    
    public function datos($codigo){        
        $query = $this->db->get_where('imagen', array('idImagen'=>$codigo));
        $archivo = $query->result();

        $this->idImagen = $codigo;
        $this->ruta = $archivo[0]->ruta;
        $this->nombre = $archivo[0]->nombre; 
        $this->extension = $archivo[0]->extension; 
               
        return $this;            
    }
    
    
    public function codigo(){
        return $this->db->insert_id();
    }
    
    
    public function ruta($codigo = ''){
        $aux = '';
        
        if($codigo != ''){
            if($this->existe($codigo)){
                $this->db->select('ruta');
                $this->db->from('imagen');
                $this->db->where('idImagen', $codigo);
                $query = $this->db->get();

                $archivo = $query->result();

                $aux = $archivo[0]->ruta;
            }
        }
        else{
            $aux = $this->ruta;
        }
        
        return $aux;
    }
    
    
    public function nombre($codigo = ''){
        $aux = '';
        
        if($codigo != ''){
            if($this->existe($codigo)){
                $this->db->select('nombre');
                $this->db->from('imagen');
                $this->db->where('idImagen', $codigo);
                $query = $this->db->get();

                $archivo = $query->result();

                $aux = $archivo[0]->nombre;
            }
        }
        else{
            $aux = $this->nombre;
        }
        
        return $aux;
    }
    
    public function extension($codigo = ''){
        $aux = '';
        
        if($codigo != ''){
            if($this->existe($codigo)){
                $this->db->select('extension');
                $this->db->from('imagen');
                $this->db->where('idImagen', $codigo);
                $query = $this->db->get();

                $archivo = $query->result();

                $aux = $archivo[0]->extension;
            }
        }
        else{
            $aux = $this->extension;
        }
        
        return $aux;
    }
    
    static function existe($codigo){
        $aux = FALSE;
  
        $query = self::$db->get_where('imagen', array('idImagen'=>$codigo));
        
        if($query->num_rows() > 0){
            $aux = TRUE;
        }
        
        return $aux;
    }
    
    public function eliminar($codigo = ''){
        $aux = FALSE;
        
        if($codigo != ''){
            $codigoAux = $codigo;
        }
        else{
            $codigoAux = $this->idImagen;
        }
        
         
        if($this->existe($codigoAux)){
            $path = getcwd();
            $archivo = $this->datos($codigoAux);
            $ruta = str_replace('http://localhost/participacion_ciudadana', realpath($path),$archivo->ruta());
            $ruta = str_replace('/', DIRECTORY_SEPARATOR, $ruta);

            if(file_exists($ruta)){ 
                if(substr($ruta, -1) != '/'){
                    if(unlink($ruta) && $this->db->delete('imagen', array('idImagen' => $codigoAux))){
                        $aux = TRUE;
                    }
                }                    
            }
            else{                    
                if($this->db->delete('imagen', array('idImagen' => $codigoAux))){
                    $aux = TRUE;
                }
            }
        }
        
        return $aux;
    }
}
