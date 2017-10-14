<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_admin extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{          
            $listadoUsuariosAdmin = $this->obtener_datos_usuarios_admin();
            $data['listadoUsuariosAdmin'] = $listadoUsuariosAdmin;
            $this->load->view('Usuarios_admin', $data);
            
	}
        
        private function obtener_datos_usuarios_admin()
        {   
            try{
                $this->load->model('Administrador_model');
                $listadoUsuariosAdmin = $this->Administrador_model->obtener_datos_usuarios_admin();
                return $listadoUsuariosAdmin;
            }
            catch(Exception $exception){
                //$exception->getMessage()
            }
        }
}
