<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonas_influencia extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Zonas_influencia_model');
        $this->load->library('Multi_menu');
    }

	public function index()
	{
            $this->load->model("Menu_model", "menu");
            $items = $this->menu->all();
            $this->multi_menu->set_items($items);
            $menu = array('menu' => $this->multi_menu->render());
            $this->load->view('Header', $menu);
            $this->load->view('Zonas_influencia');
            $this->load->view('Footer');
	}
        
        
    public function guardar_zona_influencia()
	{
            $zonas = json_decode($_POST['data'], true);            
            $this->Zonas_influencia_model->guardar_zona($zonas);
	}

	public function eliminar_zona_influencia()
	{
            //$this->Zonas_influencia_model->eliminar_zona($zona);
	}
        
        
}
