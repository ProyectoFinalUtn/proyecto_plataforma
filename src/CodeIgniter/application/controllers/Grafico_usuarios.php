<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafico_usuarios extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $usuariosVant = $this->obtener_datos_usuarios();
                    $data = array();
                    foreach ($usuariosVant as $usuarioVant) {
                        $data[] = $usuarioVant;
                    }
                    print json_encode($data);
                    break;
            }
	}
       
        private function obtener_datos_usuarios()
        {
            try{                
                $this->load->model('Usuariovant_model');
                $listadoUsuariosVant = $this->Usuariovant_model->obtener_perfiles();
                return $listadoUsuariosVant;
            }
            catch(Exception $exception){
                
            }
        }
        
}
