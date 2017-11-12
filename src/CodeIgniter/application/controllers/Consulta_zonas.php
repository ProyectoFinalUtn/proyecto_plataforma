<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');
    
    class Consulta_zonas extends REST_Controller
    {    
        public $responseOk;
        public $responseError;
        function __construct()
        {
            // Construct the parent class
            parent::__construct();

            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['en_zona_temporal_post']['limit'] = 500; // 500 requests per hour per user/key            
            $this->methods['buscar_zonas_temporales_post']['limit'] = 500; // 500 requests per hour per user/key            
            $this->methods['en_zona_influencia_post']['limit'] = 500; // 500 requests per hour per user/key    
            $this->methods['buscar_zonas_segregadas_post']['limit'] = 500; // 500 requests per hour per user/key    
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
            //$this->inicializa_controller();
        }

        public function en_zona_temporal_post()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/ConsultaZonas/en_zona_temporal/
            // parametros del post = {long:'-6498248.352740000',lat:'-4109603.99000000',rad:'1000'}
            //Recibe lat, long y una radio, de estar en una zona retorna las zonas intersectadas y nombre caso contrario NULL.                   
            $area = file_get_contents('php://input');
            $area = json_decode($area, TRUE);                     
            try{
                $this->load->model('Zonas_temporales_model');                
                $zonas = $this->Zonas_temporales_model->get_zona_within_radius($area);
                $this->set_respuesta($zonas);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        public function buscar_zonas_temporales_post()
        {
            $data = array();          
            $data = json_decode($this->post("data"), TRUE);
            $zonas = NULL;
            try{
                $this->load->model('Zonas_temporales_model');                
                $zonas = $this->Zonas_temporales_model->buscar_zonas($data);
                $this->set_respuesta($zonas);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }        

        public function en_zona_influencia_post()
        {
            $area = file_get_contents('php://input');
            $area = json_decode($area, TRUE);                     
            try{
                $this->load->model('Zonas_influencia_model');                
                $zonas = $this->Zonas_influencia_model->get_zona_influencia($area);
                $this->set_respuesta($zonas);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        public function buscar_zonas_influencia_post()
        {
            $zonas = NULL;
            try{
                $this->load->model('Zonas_influencia_model');                
                $zonas = $this->Zonas_influencia_model->buscar_zonas();
                $this->set_respuesta($zonas);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }        

        public function buscar_zonas_segregadas_post()
        {
            $area = file_get_contents('php://input');
            $area = json_decode($area, TRUE);                     
            try{  
                $this->load->model('Zonas_influencia_model'); 
                $zonas_influencia = $this->Zonas_influencia_model->get_zona_influencia($area);
                $zonas_temporales = array();
                if(count($zonas_influencia) == 0){
                    $this->load->model('Zonas_temporales_model');   
                    $zonas_temporales = $this->Zonas_temporales_model->get_zona_within_radius($area);
                }
                $zonas_segregadas = array("zonas_influencia"=> $zonas_influencia, "zonas_temporales"=> $zonas_temporales );
                $this->set_respuesta($zonas_segregadas);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        } 

        private function set_mensaje_error($mensaje)
        {
            $this->responseError['message']= $mensaje;
        }

        private function set_respuesta($respuesta)
        {
            $this->responseOk['response']= $respuesta;
        }
    }
?>
