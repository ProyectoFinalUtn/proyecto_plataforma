<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eliminar_usuario extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'POST':
                    $usuario = $_POST['usuario'];
                    $this->dar_baja_usuario_admin($usuario);
                    break;
            }
	}
      
        private function dar_baja_usuario_admin($usuario)
        {
            try{                
                $this->load->model('Administrador_model');
                $idUsuario = $this->Administrador_model->obtener_id_admin($usuario);
                $perfil = $this->Administrador_model->dar_baja_usuario_admin($idUsuario);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }

}
