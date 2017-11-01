<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH.'/libraries/REST_Controller.php');
    
    class UsuarioVantController extends REST_Controller
    {    
        public $responseOk;
        public $responseError;
        function __construct()
        {
            // Construct the parent class
            parent::__construct();

            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['perfiles_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['obtener_perfil_por_id_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['obtener_perfil_usuario_post']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['crear_perfil_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['cambiar_perfil_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['login_perfil']['limit'] = 100; // 100 requests per hour per user/key
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
            //$this->inicializa_controller();
        }

        public function obtener_perfil_por_id_get()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/obtener_perfil_por_id/id/1
            $id = $this->get('id');
            if ($id === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 
            }

            $id = (int) $id;     
            
            if ($id <= 0)
            {
                $this->set_mensaje_error('El id es invalido');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $user = NULL;

            try{
                $this->load->model('Usuariovant_model');
                $user = $this->Usuariovant_model->obtener_perfil_por_id($id);
                $this->set_respuesta($user);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        public function login_perfil_post()
        {
            
            if(!$this->post("usuario") || !$this->post("pass"))
            {   
                $this->set_mensaje_error('El usuario o contraseña no pueden ser nulos');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 

            }
            
            $user = $this->post('usuario');
            $pass = $this->post('pass');
            
            try{
                $this->load->model('Usuariovant_model');
                $usuario = $this->Usuariovant_model->login_perfil($user, $pass);
                $this->set_respuesta($usuario);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }        
        
        public function perfiles_get()
        {
           // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/perfiles
           try{
                $this->load->model('Usuariovant_model');
                $perfiles = $this->Usuariovant_model->obtener_perfiles();
                if ($perfiles)
                {
                    $this->set_respuesta($perfiles);
                    $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
                }
                else
                {
                    $this->set_mensaje_error('No se encontraron el usuarios');
                    $this->response($this->responseError, REST_Controller::HTTP_NOT_FOUND);
                }
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        
        private function usuarios_habilitados()
        {
            try{
                $this->load->model('Usuariovant_model');
                $usuarios_habilitados = $this->Usuariovant_model->obtener_usuarios_habilitados();
                return $usuarios_habilitados;
            }
            catch(Exception $exception){
                return [];
            }
        }      

        //crear un nuevo usuario
        //http://localhost/apiRestCodeigniter/api/new_user/X-API-KEY/miapikey
        public function crear_perfil_post()
        {
            try{
                $this->load->model('Usuariovant_model');
                if($this->valida_obligatorios_perfil()){
                    $perfil = $this->genera_array_perfil();
                    $idUsuarioVant = $this->Usuariovant_model->crear_perfil($perfil);
                    $perfil['idUsuarioVant'] = $idUsuarioVant;
                    $this->set_respuesta($perfil);
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
        
        
        public function cambiar_perfil_post()
        {
            try{
                $this->load->model('Usuariovant_model');
                if($this->valida_obligatorios_perfil() === true){
                    $perfil = $this->genera_array_perfil();
                    $this->Usuariovant_model->cambiar_perfil($perfil);
                    $this->set_respuesta($perfil);
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
        
        public function obtener_perfil_usuario_post(){
            if(!$this->post("usuario") || !$this->post("pass"))
            {   
                $this->set_mensaje_error('El usuario o contraseña no pueden ser nulos');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 

            }
            
            $user = $this->post('usuario');
            $pass = $this->post('pass');
            
            try{
                $this->load->model('Usuariovant_model');
                $usuario = $this->Usuariovant_model->login_perfil_encriptado($user, $pass);
                $this->set_respuesta($usuario);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        private function genera_array_perfil(){
            return ['nombre' => $this->post("nombre"), 'apellido' => $this->post("apellido"), 
            'email' => $this->post("email"), 'edad' => $this->post("edad"), 'sexo' => $this->post("sexo"),
            'nombreDePerfil' => $this->post("nombreDePerfil"), 'logueadoEnCad' => false, 
            'fotoPerfil' => $this->post("fotoPerfil"), 'idTipoDocumento' => $this->post("tipoDoc"),
            'nroDocumento' => $this->post("nroDoc"), 'idUsuarioVant' => $this->post("idUsuarioVant"),
            'calle' => $this->post("calle"), 'nro' => $this->post("nro"), 'piso' => $this->post("piso"), 
            'dpto' => $this->post("dpto"), 'provincia' => $this->post("provincia"), 
            'localidad' => $this->post("localidad"), 'telefono' => $this->post("telefono"), 
            //'idPersona' => $this->post("idPersona"),'idPerfil' => $this->post("idPersona"), 
            'usuario' => $this->post("email"), 'pass' => $this->post("pass"), 'fecha_registro' => null];
        }
        
        private function valida_obligatorios_perfil(){
            if($this->post("nombre") && $this->post("apellido") && 
               $this->post("email") && $this->post("pass") && 
               $this->post("nombreDePerfil")){
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
