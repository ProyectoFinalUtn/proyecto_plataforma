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
            $provincias = $this->obtener_provincias();
            $data['provincias'] = $provincias;
            $this->load->view('Info_solicitudes', $data);   
	}
               
        private function obtener_solicitudes()
        {
            try
            {
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitudes();
                return $solicitud;
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
