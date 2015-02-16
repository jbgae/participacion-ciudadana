<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of empleado
 *
 * @author jbgae_000
 */
class Empleado extends CI_Controller {
    
    public function __construct() {
        parent:: __construct();
        $this->load->model('empleado_model');
        $this->load->model('usuario_model');
        $this->load->model('imagen_model');
        $this->load->library('form_validation');
    }
}
