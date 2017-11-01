<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');

    class NormativaController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;

        function __construct()
        {
            parent::__construct();
            $this->methods['obtener_datos_normativas_get']['limit'] = 500; // 500 reque
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function obtener_datos_normativas_get()
        {   
            try{
                $this->load->model('Normativa_model');
                $listadoNormativas = $this->Normativa_model->obtener_normativas();
                $normativas = array();
                foreach($listadoNormativas as $normativa){                                
                    $normativa["contenido_html"] = substr($normativa["contenido_html"], strpos($normativa["contenido_html"], '<p'));
                    $normativa["contenido_html"] = substr($normativa["contenido_html"], 0, strpos($normativa["contenido_html"], 'body') - 2);
                    str_replace($normativa["contenido_html"], '&nbsp;', "");
                    $normativas[] = $normativa;
                }
                $this->set_respuesta($normativas);
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
