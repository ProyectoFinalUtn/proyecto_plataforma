<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Normativas extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{          
            $listadoNormativas = $this->obtener_datos_normativas();
            $data['listadoNormativas'] = $listadoNormativas;
            $this->load->view('Normativas', $data);
            
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
