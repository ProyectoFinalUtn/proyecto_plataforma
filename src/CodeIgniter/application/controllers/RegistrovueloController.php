<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');

    class RegistrovueloController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;

        function __construct()
        {
            parent::__construct();
            $this->methods['guardar_vuelo_usuario_post']['limit'] = 500; // 500 reque
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function guardar_vuelo_post()
        {   
            try{
                $this->load->model('Registrovuelo_model');
                if($this->valida_obligatorios_vuelo()){
                    $vuelo = $this->genera_array_vuelo();
                    $idVuelo = $this->Registrovuelo_model->guardar_vuelo($vuelo);
                    $vuelo['idVuelo'] = $idVuelo;
                    $this->set_respuesta($vuelo);
                    $this->set_response($this->responseOk, REST_Controller::HTTP_CREATED);
                }else{
                    $this->set_mensaje_error('Verifique los campos enviados');
                    $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
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
        
        private function genera_array_vuelo(){
            return ['idUsuarioVant' => $this->post("idUsuarioVant"), 'latitud' => $this->post("latitud"), 
                    'longitud' => $this->post("longitud"), 'provincia' => null, 'localidad' => null, 'zona_interes' => null, 'fecha_vuelo' => null];
        }
        
        private function valida_obligatorios_vuelo(){
            if($this->post("latitud") && $this->post("longitud")){
               return true;
            }
            return false;
        }
    }
?>
