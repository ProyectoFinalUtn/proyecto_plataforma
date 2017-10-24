<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');
    
    class LlamadasRestController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;
        function __construct()
        {
            parent::__construct();
            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['obtener_clima_get']['limit'] = 120; // 120 requests per hour per user/key
            $this->methods['obtener_direccion_get']['limit'] = 120; // 120 requests per hour per user/key
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
            
        }

        public function obtener_clima_get()
        {   
            /*$id_usuario = $this->get('id_usuario');
            $usuario = $this->get('usuario');
            if(!$this->es_id_valido($id_usuario)){
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }*/
            
            try{
                //$this->valida_pedido($id_usuario, $usuario);
                $this->load->model('Llamadasrest_model');
                $clima = $this->Llamadasrest_model->obtener_clima_lon_lat(-34.61, -58.38);
                echo var_dump($clima["weather"][0]["description"]);
                echo var_dump($clima["main"]["temp"]);
                echo var_dump($clima["main"]["pressure"]);
                echo var_dump($clima["main"]["humidity"]);
                echo var_dump($clima["main"]["temp_min"]);
                echo var_dump($clima["main"]["temp_max"]);
                echo var_dump($clima["wind"]["speed"]);
                echo var_dump($clima["wind"]["deg"]);
                /*$this->set_respuesta($clima);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);*/
                
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function obtener_direccion_get()
        {   
            $lon = $this->get('lon');
            $lat = $this->get('lat');
            
            try{
                //$this->valida_pedido($id_usuario, $usuario);
                $this->load->model('Llamadasrest_model');
                $direccion = $this->Llamadasrest_model->obtener_direccion_lon_lat($lat, $lon, "myemail@myserver.com");
                echo var_dump($direccion);
                $this->set_respuesta($direccion);
                //$this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        private function genera_array_solicitud(){
            return ['idSolicitud' => $this->post("idSolicitud"), 'idUsuarioVant' => $this->post("idUsuarioVant"), 
                    'idTipoSolicitud' => $this->post("idTipoSolicitud"), 'idEstadoSolicitud' => $this->post("idEstadoSolicitud"),
                    'latitud' => $this->post("latitud"), 'longitud' => $this->post("longitud"), 'radioVuelo' => $this->post("radioVuelo"),
                    'fecha' => $this->post("fecha"), 'horaVueloDesde' => $this->post("horaVueloDesde"),
                    'horaVueloHasta' => $this->post("horaVueloHasta"), 'vants' => $this->post("vants")];
        }
        
        private function valida_obligatorios_solicitud(){
            if($this->post("idUsuarioVant") && 
               $this->post("longitud") && $this->post("latitud") && 
               $this->post("radioVuelo") && $this->post("fecha") &&
               $this->post("horaVueloDesde") && $this->post("horaVueloHasta") &&
               $this->post("vants")){
               return true;
            }
            return false;
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
        
        private function es_id_valido($id_validar){
            if ($id_validar === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                return false;
            }

            $id_validar = (int) $id_validar;     
            
            if ($id_validar <= 0)
            {
                $this->set_mensaje_error('El id es invalido');                
            }
            return true;
        }
    }
?>
