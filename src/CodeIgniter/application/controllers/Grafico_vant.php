<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafico_vant extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $vants = $this->obtener_datos_vant();
                    $data = array();
                    foreach ($vants as $vant) {
                        $data[] = $vant;
                    }
                    print json_encode($data);
                    break;
            }
	}
       
        private function obtener_datos_vant()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant= $this->Vant_model->obtener_datos_vant();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
}
