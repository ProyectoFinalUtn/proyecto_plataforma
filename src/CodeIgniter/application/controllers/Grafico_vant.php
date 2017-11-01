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
                    $fecha_desde = '';
                    $fecha_hasta = '';
                    $provincia = '0';
                    $localidad = '0';
                    $listadoVant = $this->obtener_cantidad_por_peso($fecha_desde, $fecha_hasta, $provincia, $localidad);
                    $data = array();
                    foreach ($listadoVant as $unVant) {
                        $data[] = $unVant;
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
                            case 'peso':
                                $listadoVant = $this->obtener_cantidad_por_peso($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;	
                            case 'marca':
                                $listadoVant = $this->obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'modelo':
                                $listadoVant = $this->obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'fabricante':
                                $listadoVant = $this->obtener_cantidad_por_fabric($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'lFab':
                                $listadoVant = $this->obtener_cantidad_por_origen($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'anioFab':
                                $listadoVant = $this->obtener_cantidad_por_anio($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'altMax':
                                $listadoVant = $this->obtener_cantidad_por_altmax($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'velMax':
                                $listadoVant = $this->obtener_cantidad_por_velmax($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'alto':
                                $listadoVant = $this->obtener_cantidad_por_alto($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'ancho':
                                $listadoVant = $this->obtener_cantidad_por_ancho($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'largo':
                                $listadoVant = $this->obtener_cantidad_por_largo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                            case 'color':
                                $listadoVant = $this->obtener_cantidad_por_color($fecha_desde, $fecha_hasta, $provincia, $localidad);
                                break;
                        endswitch;
                        $data = array();
                        foreach ($listadoVant as $unVant) {
                            $data[] = $unVant;
                        }
                        print json_encode($data);
                    }
                    break;
            }
	}
      
        private function obtener_cantidad_por_peso($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_peso($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_fabric($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_fabric($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_origen($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_origen($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_anio($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_anio($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_altmax($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_altmax($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_velmax($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_velmax($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_alto($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_alto($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_ancho($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_ancho($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_largo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_largo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_color($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_color($fecha_desde, $fecha_hasta, $provincia, $localidad);
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
  
}
