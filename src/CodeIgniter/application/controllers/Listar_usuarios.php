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
            $provincias = $this->obtener_provincias();
            $data['provincias'] = $provincias;
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
        
        private function obtener_provincias()
        {
            try
            {
                $this->load->model('Provincia_model');
                $provincias = $this->Provincia_model->obtener_provincias();
                return $provincias;
            }
            catch(Exception $exception){
                
            }
        }
        
        public function obtener_localidades()
        {
            try
            {
                $provincia = $_POST['provincia'];
                $this->load->model('Provincia_model');
                $localidades = $this->Provincia_model->obtener_localidades($provincia);
                print json_encode($localidades);
            }
            catch(Exception $exception){
                
            }
        }
        
}
