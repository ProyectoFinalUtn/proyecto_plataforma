<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');
    
    class SolicitudExController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;
        function __construct()
        {
            parent::__construct();
            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['solicitudes_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['solicitud_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['crear_solicitud_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['cambiar_solicitud_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function solicitudes_get()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/obtener_perfil_por_id/id/1
            $id_usuario = $this->get('id_usuario');
            $usuario = $this->get('usuario');
            if ($id_usuario === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }

            $id_usuario = (int) $id_usuario;     
            
            if ($id_usuario <= 0)
            {
                $this->set_mensaje_error('El id es invalido');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
            
            try{
                $this->load->model('Usuariovant_model');
                $user = $this->Usuariovant_model->obtener_perfil_por_id($id_usuario);
                if($user->usuario != $usuario){
                    throw new Exception("Solo puede obtener los vants del usuario");  
                }
                if (count($user) <= 0) {
                    throw new Exception("El usuario referenciado no existe en el sistema");               
                }
                $this->load->model('Solicitud_model');
                $solicitudes = $this->Solicitud_model->obtener_solicitudes_por_usuario($id_usuario);
                $this->set_respuesta($solicitudes);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function solicitud_get()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/obtener_perfil_por_id/id/1
            $id_solicitud = $this->get('id_usuario');
            $usuario = $this->get('usuario');
            if ($id_solicitud === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }

            $id_solicitud = (int) $id_solicitud;     
            
            if ($id_solicitud <= 0)
            {
                $this->set_mensaje_error('El id es invalido');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
            
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitud_por_id($id_solicitud);
                if($solicitud){
                    if($solicitud->usuario != $usuario){
                        throw new Exception("Solo puede obtener los vants del usuario");  
                    }
                }
                $this->set_respuesta($solicitud);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function crear_solicitud_post()
        {
            try{
                $this->load->model('Solicitud_model');
                if($this->valida_obligatorios_solicitud()){
                    $solicitud = $this->genera_array_solicitud();
                    $idSolicitud = $this->Solicitud_model->crear_solicitud($solicitud);
                    $solicitud['idSolicitud'] = $idSolicitud;
                    $this->set_respuesta($solicitud);
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
        
        
        public function cambiar_solicitud_post()
        {
            try{
                $this->load->model('Usuariovant_model');
                if($this->valida_obligatorios_perfil() === true){
                    $solicitud = $this->genera_array_solicitud();
                    $this->Solicitud_model->cambiar_solicitud($solicitud);
                    $this->set_respuesta($solicitud);
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
        
        private function genera_array_solicitud(){
            return ['idSolicitud' => $this->post("idSolicitud"), 'idUsuarioVant' => $this->post("idUsuarioVant"), 
            'latitud' => $this->post("latitud"), 'longitud' => $this->post("longitud"), 'radio_vuelo' => $this->post("radio_vuelo"),
            'fecha_hora_vuelo' => $this->post("fecha_hora_vuelo"), 'vants' => $this->post("vants")];
        }
        
        private function valida_obligatorios_solicitud(){
            if($this->post("idUsuarioVant") && $this->post("latitud") && 
               $this->post("longitud") && $this->post("radio_vuelo") && 
               $this->post("fecha_hora_vuelo") && $this->post("vants")){
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
    }
?>
