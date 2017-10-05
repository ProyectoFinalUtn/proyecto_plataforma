<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_usuarios extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	           
            $usuariosVant = $this->obtener_usuarios_vant();
            $data['usuariosVant'] = $usuariosVant;
            $this->load->view('Listar_usuarios', $data);
            
	}
       
        private function obtener_usuarios_vant()
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
