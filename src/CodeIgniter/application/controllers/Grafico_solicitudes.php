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
                    $fecha_desde = '2017-01-01';
                    $fecha_hasta = '2018-01-01';
                    $provincia = '3';
                    $localidad = '0';
                    $listadoSolicitudes = $this->obtener_cantidad_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                    $data = array();
                    foreach ($listadoSolicitudes as $unaSolicitud) {
                        $data[] = $unaSolicitud;
                    }
                    print json_encode($data);
                    break;
                case 'POST':
                    if(isset($_POST['ejeX'])) {
                        $fecha_desde = $_POST['filtro_desde'];
                        $fecha_hasta = $_POST['filtro_hasta'];
                        $provincia = $_POST['filtro_provincia'];
                        $localidad = $_POST['filtro_localidad'];
                        switch ($_POST['ejeX']):
                            case 'fecha':
                                $listadoSolicitudes = $this->obtener_cantidad_por_fecha($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'horario':
                                $listadoSolicitudes = $this->obtener_cantidad_por_horario($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'marca':
                                $listadoSolicitudes = $this->obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'modelo':
                                $listadoSolicitudes = $this->obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'estado':
                                $listadoSolicitudes = $this->obtener_cantidad_por_estado($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'momento':
                                $listadoSolicitudes = $this->obtener_cantidad_por_momento($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'mes':
                                $listadoSolicitudes = $this->obtener_cantidad_por_mes($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'dia':
                                $listadoSolicitudes = $this->obtener_cantidad_por_dia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'provincia':
                                $listadoSolicitudes = $this->obtener_cantidad_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'localidad':
                                $listadoSolicitudes = $this->obtener_cantidad_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'zona_interes':
                                $listadoSolicitudes = $this->obtener_cantidad_por_zona_interes($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                        endswitch;
                        $data = array();
                        foreach ($listadoSolicitudes as $unaSolicitud) {
                            $data[] = $unaSolicitud;
                        }
                        print json_encode($data);
                    }
                    break;
            }
	}
      
        private function obtener_cantidad_por_fecha($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_fecha($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_horario($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_horario($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_estado($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_estado($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_momento($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_momento($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_mes($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_mes($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_dia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_dia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_zona_interes($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{
                $this->load->model('Solicitud_model');
                $listadoSolicitudes = $this->Solicitud_model->obtener_cantidad_por_zona_interes($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoSolicitudes;
            }
            catch(Exception $exception){
                
            }
        }
        
}
