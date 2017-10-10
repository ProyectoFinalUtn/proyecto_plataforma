<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_vant extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	           
            $vant = $this->obtener_datos_vant();
            $data['vant'] = $vant;
            $this->load->view('Listar_vant', $data);
            
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
