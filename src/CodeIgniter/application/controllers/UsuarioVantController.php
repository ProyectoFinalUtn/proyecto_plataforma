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
            $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['user_by_id_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['crear_perfil_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['login_get']['limit'] = 100; // 100 requests per hour per user/key
            $this->responseError = ['status' => FALSE, 'message' => ''];
            $this->responseOk = ['status' => TRUE, 'response' => NULL, 'message' => ''];
        }

        public function user_by_id_get()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/user_by_id/id/1
            $users = [
                ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
                ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
                ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
            ];

            $id = $this->get('id');
            if ($id === NULL)
            {   
                $this->set_mensaje_error('El id no puede ser nulo');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 

            }

            $id = (int) $id;        
            // Validate the id.
            if ($id <= 0)
            {
                $this->set_mensaje_error('El id es invalido');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $user = NULL;

            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    if (isset($value['id']) && $value['id'] === $id)
                    {
                        $user = $value;
                    }
                }
            }

            if (!empty($user))
            {
                $this->set_respuesta($user);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_mensaje_error('No se encontró el usuario');
                $this->response($this->responseError, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        
        public function login_get()
        {
            $usuario = $this->get('usuario');
            $pass = $this->get('pass');
            if (($usuario === NULL) || ($pass === NULL))
            {   
                $this->set_mensaje_error('El usuario o contraseña no pueden ser nulos');
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST); 

            }
            
            try{
                $this->load->model('Usuariovant_model');
                $usuario = $this->login_user->crear_perfil($usuario, $pass);
                $this->set_respuesta($usuario);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            catch(Exception $exception){
                $this->set_mensaje_error($exception->getMessage());
                $this->response($this->responseError, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        public function users_get()
        {
            // Ejemplo de como llamarlo http://localhost/proyecto_plataforma_web/UsuarioVantController/users
            $users = [
                ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
                ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
                ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
            ];

            if ($users)
            {
                $this->set_respuesta($users);
                $this->set_response($this->responseOk, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->set_mensaje_error('No se encontraron el usuarios');
                $this->response($this->responseError, REST_Controller::HTTP_NOT_FOUND);
            }
        }

        public function users_post()
        {
            // $this->some_model->update_user( ... );
            $message = [
                'id' => 100, // Automatically generated by the model
                'name' => $this->post('name'),
                'email' => $this->post('email'),
                'message' => 'Added a resource'
            ];

            $this->set_response($message, REST_Controller::HTTP_CREATED);
        }

        //crear un nuevo usuario
        //http://localhost/apiRestCodeigniter/api/new_user/X-API-KEY/miapikey
        public function crear_perfil_post()
        {
            try{
                $this->load->model('Usuariovant_model');
                if($this->post("nombre") && $this->post("apellido") && 
                   $this->post("email") && $this->post("edad") && $this->post("pass") && 
                   $this->post("nombreDePerfil") && $this->post("fotoPerfil")){
                    $perfil = ['nombre' => $this->post("nombre"), 'apellido' => $this->post("apellido"), 
                               'email' => $this->post("email"), 'edad' => $this->post("edad"),
                               'nombreDePerfil' => $this->post("nombreDePerfil"), 'logueadoEnCad' => false, 
                               'fotoPerfil' => $this->post("fotoPerfil"), 'tipoDoc' => $this->post("tipoDoc"),
                               'nroDoc' => $this->post("nroDoc"), 'passCad' => $this->post("pass")];
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
                if($this->post("nombre") && $this->post("apellido") && 
                   $this->post("email") && $this->post("edad") && $this->post("pass") && 
                   $this->post("nombreDePerfil") && $this->post("fotoPerfil")&& 
                   $this->post("idUsuarioVant") && $this->post("idPersona")&& 
                   $this->post("idPerfil")){
                    $perfil = ['nombre' => $this->post("nombre"), 'apellido' => $this->post("apellido"), 
                               'email' => $this->post("email"), 'edad' => $this->post("edad"),
                               'nombreDePerfil' => $this->post("nombreDePerfil"), 'logueadoEnCad' => false, 
                               'fotoPerfil' => $this->post("fotoPerfil"), 'tipoDoc' => $this->post("tipoDoc"),
                               'nroDoc' => $this->post("nroDoc"), 'idUsuarioVant' => $this->post("idUsuarioVant"), 
                               'idPersona' => $this->post("idPersona"),'idPerfil' => $this->post("idPersona"), 
                               'passCad' => $this->post("pass")];
                    $idUsuarioVant = $this->Usuariovant_model->cambiar_perfil($perfil);
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