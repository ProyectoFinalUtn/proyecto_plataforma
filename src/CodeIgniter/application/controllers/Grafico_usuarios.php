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
                    $usuariosVant = $this->obtener_vants_por_edad();
                    $data = array();
                    foreach ($usuariosVant as $usuarioVant) {
                        $data[] = $usuarioVant;
                    }
                    print json_encode($data);
                    break;
                case 'POST':
                    switch ($_POST['ejeX']):
                        case 'sexo':
                            $usuariosVant = $this->obtener_vants_por_sexo();
                            $data = array();
                            foreach ($usuariosVant as $usuarioVant) {
                                $data[] = $usuarioVant;
                            }
                            print json_encode($data);
                            break;
                        case 'localidad':
                            $usuariosVant = $this->obtener_vants_por_localidad();
                            $data = array();
                            foreach ($usuariosVant as $usuarioVant) {
                                $data[] = $usuarioVant;
                            }
                            print json_encode($data);
                            break;
                        case 'provincia':
                            $usuariosVant = $this->obtener_vants_por_provincia();
                            $data = array();
                            foreach ($usuariosVant as $usuarioVant) {
                                $data[] = $usuarioVant;
                            }
                            print json_encode($data);
                            break;
                        case 'edad':
                            $usuariosVant = $this->obtener_vants_por_edad();
                            $data = array();
                            foreach ($usuariosVant as $usuarioVant) {
                                $data[] = $usuarioVant;
                            }
                            print json_encode($data);
                            break;
                    endswitch;
                    break;
            }
	}
      
        private function obtener_vants_por_edad()
        {
            try{                
                $this->load->model('Usuariovant_model');
                $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_edad();
                return $listadoUsuariosVant;
            }
            catch(Exception $exception){
                
            }
        }

        private function obtener_vants_por_sexo()
        {
            try{                
                $this->load->model('Usuariovant_model');
                $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_sexo();
                return $listadoUsuariosVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_vants_por_localidad()
        {
            try{                
                $this->load->model('Usuariovant_model');
                $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_localidad();
                return $listadoUsuariosVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_vants_por_provincia()
        {
            try{                
                $this->load->model('Usuariovant_model');
                $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_provincia();
                return $listadoUsuariosVant;
            }
            catch(Exception $exception){
                
            }
        }
}
