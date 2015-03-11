<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

/**
 * Description of area
 *
 * @author jbgae_000
 */
class Area extends MY_Controller {
    
    public function __construct() {
        parent:: __construct();
        $this->load->model('area_model');
    }
    
    public function areaAjax(){
        $areas = Area_model::areas();
        foreach($areas as $area){
            echo $area->nombre. ' '. $area->id;
            echo '<br>';
        }
       
        echo json_encode($areas);
    }
}
