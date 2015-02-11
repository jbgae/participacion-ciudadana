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
class Areas extends MY_Controller{
     
    public function __construct() {
        parent:: __construct();
        $this->load->model('incidente_model');
        $this->load->model('usuario_model');
        $this->load->model('imagen_model');
        $this->load->library('form_validation');
    }
    
    public function registrar(){
        $this->permisos('aministrador');
        $this->pagina = "departamento";
        $this->estilo = array("//cdn.datatables.net/1.10.5/css/jquery.dataTables.min", 
                              "//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui",
                              "//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui",
                              "formulario_modal");
        $this->javascript = array("//cdn.datatables.net/1.10.5/js/jquery.dataTables.min",
                                  "datatable",
                                  "code.jquery.com/ui/1.11.2/jquery-ui",
                                  "formulario");
        $this->carpeta = "administrador";
        $this->mostrar();
    }
    
}
