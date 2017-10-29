<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');
    }

	public function index()
	{          
            $listadoUsuariosAdmin = $this->obtener_datos_usuarios_admin();
            $data['listadoUsuariosAdmin'] = $listadoUsuariosAdmin;
            
            $this->load->model("Menu_model", "menu");
            $items = $this->menu->all();
            $this->multi_menu->set_items($items);
            $menu = array('menu' => $this->multi_menu->render());
            $this->load->view('Header', $menu);
            $this->load->view('Usuarios_admin', $data);
            $this->load->view('Footer');
            
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
