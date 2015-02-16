<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of areas
 *
 * @author jbgae_000
 */
class Departamento extends MY_Controller{
     
    public function __construct() {
        parent:: __construct();
        $this->load->model('incidente_model');
        $this->load->model('usuario_model');
        $this->load->model('departamento_model');
        $this->load->library('form_validation');
    }
    
    private function _validar(){
        $this->form_validation->set_rules("nombreDepartamento"," Nombre departamento","trim|required|min_length[3]|xss_clean");
        $this->form_validation->set_rules("descripcionDepartamento"," Descripción de departamento","trim|required|min_length[3]|xss_clean");
        
        $this->form_validation->set_message('required', '%s no puede estar vac&iacute;o');
        $this->form_validation->set_message('min_length', '%s debe tener mínimo %s caracteres');
        
        return $this->form_validation->run();
    }
    
    public function registrar(){
        $this->permisos('administrador');
        $this->titulo = "Áreas";
        $this->pagina = "departamento";
        $this->estilo = array("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min", 
                              "//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui",
                              "//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui",
                              "formulario_modal");
        $this->javascript = array("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min",
                                  "datatable",
                                  "//code.jquery.com/ui/1.11.2/jquery-ui",
                                  "formulario",
                                  "modal");
        $this->carpeta = "administrador";
        
        $datos = array();
        $departamentos = Departamento_model::departamentos();
        foreach($departamentos as &$dep){
            $dep->numEmpleados = Departamento_model::numeroEmpleados($dep->idDepartamento);
        }
        $datos['departamentos'] = $departamentos;
        
        if($this->_validar()){
            $area = new Departamento_model;
            if($area->inicializar()){
                 $datos['mensaje'] = 'El área se ha registrado correctamente.';
            }
            else{
                 $datos['mensaje'] = 'El área no se ha podido registrar en este mommento.';
            }
            
        }
        $this->mostrar($datos);
    }
    
    public function registrarAjax(){
        log_message("INFO", "/***Registrar AJAX***/");
        if($this->_validar()){
            log_message("INFO", "/***FORMULARIO VALIDO***/");
            $area = new Departamento_model;
            log_message("INFO", "/***CREADA ESTRUCTURA***/");
            if($area->inicializar()){
                log_message("INFO", "/***AREA INICIALIZDA***/");
                echo 'El área se ha registrado correctamente.';
            }
            else{
                log_message("INFO", "/***AREA NO INICIALIZADA***/");
                echo 'El área no se ha podido registrar en este mommento.';
            }
            log_message("INFO", $this->db->last_query());
        }
        else{
            log_message("INFO", "Errores:".validation_errors());
        }
    }
    
}
