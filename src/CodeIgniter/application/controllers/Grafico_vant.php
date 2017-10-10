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
                    $listadoVant = $this->obtener_cantidad_por_peso();
                    $data = array();
                    foreach ($listadoVant as $unVant) {
                        $data[] = $unVant;
                    }
                    print json_encode($data);
                    break;
                case 'POST':
                    switch ($_POST['ejeX']):
                        case 'peso':
                            $listadoVant = $this->obtener_cantidad_por_peso();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;	
                        case 'marca':
                            $listadoVant = $this->obtener_cantidad_por_marca();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'modelo':
                            $listadoVant = $this->obtener_cantidad_por_modelo();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'fabricante':
                            $listadoVant = $this->obtener_cantidad_por_fabric();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'lFab':
                            $listadoVant = $this->obtener_cantidad_por_origen();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'anioFab':
                            $listadoVant = $this->obtener_cantidad_por_anio();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'altMax':
                            $listadoVant = $this->obtener_cantidad_por_altmax();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'velMax':
                            $listadoVant = $this->obtener_cantidad_por_velmax();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'alto':
                            $listadoVant = $this->obtener_cantidad_por_alto();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'ancho':
                            $listadoVant = $this->obtener_cantidad_por_ancho();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'largo':
                            $listadoVant = $this->obtener_cantidad_por_largo();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                        case 'color':
                            $listadoVant = $this->obtener_cantidad_por_color();
                            $data = array();
                            foreach ($listadoVant as $unVant) {
                                $data[] = $unVant;
                            }
                            print json_encode($data);
                            break;
                    endswitch;
                    break;
            }
	}
      
        private function obtener_cantidad_por_peso()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_peso();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_marca()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_marca();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_modelo()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_modelo();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_fabric()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_fabric();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_origen()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_origen();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_anio()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_anio();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_altmax()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_altmax();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_velmax()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_velmax();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_alto()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_alto();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_ancho()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_largo();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_largo()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_largo();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_cantidad_por_color()
        {
            try{                
                $this->load->model('Vant_model');
                $listadoVant = $this->Vant_model->obtener_cantidad_por_color();
                return $listadoVant;
            }
            catch(Exception $exception){
                
            }
        }
  
}
