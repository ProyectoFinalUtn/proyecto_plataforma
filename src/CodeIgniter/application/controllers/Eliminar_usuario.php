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
                    
                    break;
            }
	}
      
        private function dar_baja_usuario_admin($idUsuario)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->dar_baja_usuario_admin($idUsuario);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }

}
