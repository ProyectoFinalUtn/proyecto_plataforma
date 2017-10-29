<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nueva_normativa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');
    }

	public function index()
	{
            if(isset($_POST['Guardar'])){
                $normativaNueva = [
                    "descripcion" => $_POST['descripcion'],
                    "fecha_desde" => $_POST['fecha_desde'],
                    "fecha_hasta" => $_POST['fecha_hasta'],
                    "contenido" => $_POST['contenido'],
                    "contenido_html" => $_POST['contenido_html']
                    ];

                $this->guardar_normativa($normativaNueva);
            }
            else {
                $this->load->model("Menu_model", "menu");
                $items = $this->menu->all();
                $this->multi_menu->set_items($items);
                $menu = array('menu' => $this->multi_menu->render());
                $this->load->view('Header', $menu);
                $this->load->view('Nueva_normativa');
                $this->load->view('Footer');
            }
	}
               
        private function guardar_normativa($normativaNueva)
        {
            try{                
                $this->load->model('Normativa_model');
                $id_normativa = $this->Normativa_model->guardar_normativa($normativaNueva);
                return $id_normativa;
            }
            catch(Exception $exception){
                
            }
        }
        
}
