<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Normativas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');
    }

	public function index()
	{          
            $listadoNormativas = $this->obtener_datos_normativas();
            $data['listadoNormativas'] = $listadoNormativas;
            
            $this->load->model("Menu_model", "menu");
            $items = $this->menu->all();
            $this->multi_menu->set_items($items);
            $menu = array('menu' => $this->multi_menu->render());
            $this->load->view('Header', $menu);
            $this->load->view('Normativas', $data);
            $this->load->view('Footer');
            
	}
        
        private function obtener_datos_normativas()
        {   
            try{
                $this->load->model('Normativa_model');
                $listadoNormativas = $this->Normativa_model->obtener_datos_normativas();
                return $listadoNormativas;
            }
            catch(Exception $exception){
                //$exception->getMessage()
            }
        }
}
