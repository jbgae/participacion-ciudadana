<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of trabajador_model
 *
 * @author jbgae_000
 */
class Trabajador_model extends Usuario_model{
    
    private static $db;
    
    public function __construct() {
        parent::__construct();        
        self::$db = &get_instance()->db;
    }
    
    
    
}
