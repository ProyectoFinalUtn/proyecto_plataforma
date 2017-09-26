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
            $this->methods['obtener_solicitud_id_usuario_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['obtener_solicitudes_usuario_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['guardar_solicitud_post']['limit'] = 500; // 100 requests per hour per user/key
            $this->methods['modificar_solicitud_post']['limit'] = 500;
            $this->methods['eliminar_solicitud_post']['limit'] = 500;// 100 requests per hour per user/key
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function obtener_solicitudes_usuario_get()
        {   
            $id_usuario = $this->get('id_usuario');
            $usuario = $this->get('usuario');
            if(!$this->es_id_valido($id_usuario)){
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }
            
            try{
                $this->valida_pedido($id_usuario, $usuario);
                $this->load->model('Solicitud_model');
                $solicitudes = $this->Solicitud_model->obtener_solicitud_por_usuario($id_usuario);
                $this->set_respuesta($solicitudes);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function obtener_solicitud_id_usuario_get()
        {
            $id_solicitud = $this->get('idSolicitud');
            $usuario = $this->get('usuario');
            if(!$this->es_id_valido($id_solicitud)){
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }
            
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitud_por_id($id_solicitud);
                if($solicitud){
                    $this->valida_pedido($solicitud->idUsuarioVant, $usuario);
                }
                $this->set_respuesta($solicitud);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function guardar_solicitud_post()
        {
            try{
                $this->load->model('Solicitud_model');
                if($this->valida_obligatorios_solicitud()){
                    $solicitud = $this->genera_array_solicitud();
                    $id_solicitud = $this->Solicitud_model->crear_solicitud($solicitud);
                    $solicitud['idSolicitud'] = $id_solicitud;
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
        
        
        public function modificar_solicitud_post()
        {
            try{                
                if($this->valida_obligatorios_solicitud() === true){
                    $this->load->model('Solicitud_model');
                    $solicitud= $this->genera_array_solicitud();
                    $idSolicitud = $this->Solicitud_model->cambiar_solicitud($solicitud);
                    $solicitud["idSolicitud"] = $idSolicitud;
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
        
        public function eliminar_solicitud_post()
        {
            $id_solicitud = $this->post("solicitud")["idSolicitud"];
            $usuario = $this->post('usuario');
            if(!$this->es_id_valido($id_solicitud)){
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }
            
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitud_por_id($id_solicitud);
                if($solicitud){
                    $this->valida_pedido($solicitud->idUsuarioVant, str_replace("@", "", $usuario));
                }
                $this->Solicitud_model->eliminar_solicitud($id_solicitud);
                $this->set_respuesta($solicitud);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
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
                    'fechaHoraVuelo' => $this->post("fechaHoraVuelo"), 'vants' => $this->post("vants")];
        }
        
        private function valida_obligatorios_solicitud(){
            if($this->post("idSolicitud") && $this->post("idUsuarioVant") && 
               $this->post("longitud") && $this->post("radioVuelo") && 
               $this->post("latitud") && $this->post("longitud") &&
               $this->post("radioVuelo") && $this->post("fechaHoraVuelo") &&
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
