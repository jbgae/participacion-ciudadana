<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['loginAjax'] = "usuario/loginAjax";
$route['registrarAjax'] = "usuario/registrarAjax";
$route['historialAjax/(:any)/(:any)'] = "incidente/historialAjax/$1/$2";
$route['incidenteAjax/(:any)'] = "incidente/incidenteAjax/$1";
$route['cargar'] = "incidente/cargar";
$route['departamentos'] = "areas/registrar";
$route['mapa'] = "incidente/mapa";
$route['validar/(:any)'] = "usuario/validar/$1";
$route['historial'] = "incidente/historial";
$route['incidente'] = "incidente/registrar";
$route['restablecer'] = "usuario/password";
$route['login'] = "usuario/login";
$route['registrar'] = "usuario/registrar";

$route['ciudadano'] = "incidente/registrar";
$route['administrador'] = "incidente/registrar";
$route['ver/incidente/(:any)'] = "incidente/verIncidente/$1";
$route['cerrar'] = "usuario/cerrar";
$route['default_controller'] = "usuario/login";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */