<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_vant extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');
    }

	public function index()
	{	           
            $vant = $this->obtener_datos_vant();
            $data['vant'] = $vant;
            
            $this->load->model("Menu_model", "menu");
            $items = $this->menu->all();
            $this->multi_menu->set_items($items);
            $menu = array('menu' => $this->multi_menu->render());
            $this->load->view('Header', $menu);
            $this->load->view('Listar_vant', $data);
            $this->load->view('Footer');
            
	}
       
        private function obtener_datos_vant()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_datos_vant();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
}
