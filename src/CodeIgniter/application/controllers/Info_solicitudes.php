<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_solicitudes extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{          
            $solicitudes = $this->obtener_solicitudes();
            $data['solicitudes'] = $solicitudes;
            $this->load->view('Info_solicitudes', $data);   
	}
               
        private function obtener_solicitudes()
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitudes();
                return $solicitud;
            }
            catch(Exception $exception){
                
            }
        }
        
}
