<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_solicitudes extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	
            /*
             * Los que traen mas de uno devuelven un array como este:
             * array (size=1)
                0 => 
                  array (size=12)
                    'idSolicitud' => string '2' (length=1)
                    'idUsuarioVant' => string '61' (length=2)
                    'idTipoSolicitud' => string '1' (length=1)
                    'idUsuarioAprobador' => null
                    'idEstadoSolicitud' => string '1' (length=1)
                    'descripcionEstadoSolicitud' => string 'CREADA' (length=6)
                    'latitud' => string '-34.60389' (length=9)
                    'longitud' => string '-58.37056' (length=9)
                    'radioVuelo' => string '10' (length=2)
                    'fecha' => string '27/09/2017' (length=10)
                    'horaVueloDesde' => string '13:00:00' (length=8)
                    'horaVueloHasta' => string '15:00:00' (length=8)
             *
             * Los que traen uno solo los devuelve tipo objeto
             * $solicitud->idSolicitud
             * $solicitud->idUsuarioVant
             * $solicitud->...
             * La idea es tener un controller por vista, y un modelo por cada Tabla o grupos de tablas asociados a la misma funcion
             * Por ejemplo para solicitudes de excepcion todo lo que se le pegue a la base de datos iria en solicitud model
             */
            
            $solicitudes = $this->obtener_solicitudes_actualizadas();
            $data['solicitudes'] = $solicitudes;
            $this->load->view('Listar_solicitudes', $data);
            
	}
               
        private function obtener_solicitudes_actualizadas()
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitudes_actualizadas();
                return $solicitud;
            }
            catch(Exception $exception){
                
            }
        }
        
}
