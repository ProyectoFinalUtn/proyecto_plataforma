<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');
    
    class ProvinciaController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;
        function __construct()
        {
            parent::__construct();
            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['obtener_provincias_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['obtener_localidades_id_provincia_get']['limit'] = 500; 
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function obtener_provincias_get()
        {               
            try{
                $this->load->model('Provincia_model');
                $provincias = $this->Provincia_model->obtener_provincias();
                $this->set_respuesta($provincias);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function obtener_localidades_id_provincia_get()
        {
            $idProvincia = $this->get('idProvincia');
            if(!$this->es_id_valido($idProvincia)){
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }
            
            try{                
                $this->load->model('Provincia_model');
                $localidades = $this->Provincia_model->obtener_localidades($idProvincia);
                $this->set_respuesta($localidades);
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
        
        private function valida_pedido($id_usuario, $usuario){
            $this->load->model('Usuariovant_model');
            $this->Usuariovant_model->valida_usuario($id_usuario, $usuario);
        }
        
        private function es_id_valido($id_vant){
            if ($id_vant === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                return false;
            }

            $id_vant = (int) $id_vant;     
            
            if ($id_vant <= 0)
            {
                $this->set_mensaje_error('El id es invalido');                
            }
            return true;
        }
    }
?>
