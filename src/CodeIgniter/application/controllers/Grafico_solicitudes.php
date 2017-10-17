<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafico_solicitudes extends MY_Controller
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
                    $listadoSolicitudes = $this->obtener_cantidad_por_fecha();
                    $data = array();
                    foreach ($listadoSolicitudes as $unaSolicitud) {
                        $data[] = $unaSolicitud;
                    }
                    print json_encode($data);
                    break;
                case 'POST':
                    switch ($_POST['ejeX']):
                        case 'fecha':
                            $listadoSolicitudes = $this->obtener_cantidad_por_fecha();
                            $data = array();
                            foreach ($listadoSolicitudes as $unaSolicitud) {
                                $data[] = $unaSolicitud;
                            }
                            print json_encode($data);
                            break;
                        case 'horario':
                            $listadoSolicitudes = $this->obtener_cantidad_por_horario();
                            $data = array();
                            foreach ($listadoSolicitudes as $unaSolicitud) {
                                $data[] = $unaSolicitud;
                            }
                            print json_encode($data);
                            break;
                        case 'marca':
                            $listadoSolicitudes = $this->obtener_cantidad_por_marca();
                            $data = array();
                            foreach ($listadoSolicitudes as $unaSolicitud) {
                                $data[] = $unaSolicitud;
                            }
                            print json_encode($data);
                            break;
                        case 'modelo':
                            $listadoSolicitudes = $this->obtener_cantidad_por_modelo();
                            $data = array();
                            foreach ($listadoSolicitudes as $unaSolicitud) {
                                $data[] = $unaSolicitud;
                            }
                            print json_encode($data);
                            break;
                        case 'estado':
                            $listadoSolicitudes = $this->obtener_cantidad_por_estado();
                            $data = array();
                            foreach ($listadoSolicitudes as $unaSolicitud) {
                                $data[] = $unaSolicitud;
                            }
                            print json_encode($data);
                            break;
                    endswitch;
                    break;
            }
	}
      
        private function obtener_cantidad_por_fecha()
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_fecha();
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_horario()
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_horario();
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_marca()
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_marca();
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_modelo()
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_modelo();
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_estado()
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_estado();
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
}
