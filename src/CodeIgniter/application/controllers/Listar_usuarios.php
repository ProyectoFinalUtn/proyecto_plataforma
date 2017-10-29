<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_usuarios extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');
    }

	public function index()
	{	           
            $usuariosVant = $this->obtener_usuarios_vant();
            $data['usuariosVant'] = $usuariosVant;
            $provincias = $this->obtener_provincias();
            $data['provincias'] = $provincias;
            
            $this->load->model("Menu_model", "menu");
            $items = $this->menu->all();
            $this->multi_menu->set_items($items);
            $menu = array('menu' => $this->multi_menu->render());
            $this->load->view('Header', $menu);
            $this->load->view('Listar_usuarios', $data);
            $this->load->view('Footer');
            
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
