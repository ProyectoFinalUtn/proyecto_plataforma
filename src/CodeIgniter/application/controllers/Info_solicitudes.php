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
        /*
        public function test_direccion()
        {
            try
            {
            $solicitud = ['idSolicitud' => 0,
                'idUsuarioVant' => 5, 
                'idTipoSolicitud' => 1,
                'idEstadoSolicitud' => 1,
                'latitud' => '-32.947671',
                'longitud' => '-60.630457',
                'radioVuelo' => 600,
                'fecha' => '2017-12-17',
                'horaVueloDesde' => '21:00:00',
                'horaVueloHasta' => '23:00:00',
                'provincia' => null,
                'localidad' => null,
                'zona_interes' => null,
                'vants' => null];
            $this->load->model('Solicitud_model');
            $id_solicitud = $this->Solicitud_model->crear_solicitud($solicitud);
            $solicitud['idSolicitud'] = $id_solicitud;
            print json_encode($solicitud['idSolicitud']);
            }
            catch(Exception $exception){
                
            }
        }
        */
}
